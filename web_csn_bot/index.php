<?php

$token = '6383439591:AAG94HfWBB6XPJ-rYI0VtWKRv9wWhsfWo4Q';
$api_url = "https://api.telegram.org/bot$token/";
$group_doc = [
    '-1001931706051',
];
// Xử lý webhook
$update = file_get_contents('php://input');
$update_data = json_decode($update, true);
// https://api.telegram.org/bot5904585115:AAFn6NR0NdmxC2JGK9RZb9mBkO6uEZzAqKc/setWebhook?url=https://kbh.nftgroupvn.com/web_csn_bot/index.php
// https://api.telegram.org/bot5904585115:AAFn6NR0NdmxC2JGK9RZb9mBkO6uEZzAqKc/getUpdates

// https://api.telegram.org/bot6383439591:AAG94HfWBB6XPJ-rYI0VtWKRv9wWhsfWo4Q/setWebhook?url=https://kbh.nftgroupvn.com/web_csn_bot/index.php bot chính
// https://api.telegram.org/bot6383439591:AAG94HfWBB6XPJ-rYI0VtWKRv9wWhsfWo4Q/getUpdates
// Pusher
require __DIR__ . '/vendor/autoload.php';

if (isset($update_data['message'])) {
    $chat_id = $update_data['message']['chat']['id'];
    foreach($group_doc as $key_group => $value) {
        if($chat_id == $value) {
            $message_text = $update_data['message']['text'];
            // Xử lý logic và tạo nội dung tin nhắn muốn gửi lại
            event_websocket($update_data);
        }
    }
    
}

function send_message($chat_id, $message) {
    global $api_url;
    $send_message_url = $api_url . "sendMessage";
    $data = array(
        'chat_id' => $chat_id,
        'text' => $message
    );
    $options = array(
        'http' => array(
            'method' => 'POST',
            'header' => 'Content-Type: application/x-www-form-urlencoded',
            'content' => http_build_query($data)
        )
    );
    $context = stream_context_create($options);
    $result = file_get_contents($send_message_url, false, $context);
    return $result;
}

function auto_delete ($update_data)
{
    global $api_url;
    $chat_id = $update_data['message']['chat']['id'];
    $message_id = $update_data['message']['message_id'];
    $message_text = $update_data['message']['text'];
    if (empty($message_text)) {
        $delete_message_url = $api_url . "deleteMessage?chat_id=" . $chat_id . "&message_id=" . $message_id;
        $response = file_get_contents($delete_message_url);
        $json_response = json_decode($response, true);
        return $json_response['ok'];
    }
}

function event_websocket ($update_data) {
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $message_text = $update_data['message']['text'];
    $firstName = $update_data['message']['from']['first_name'];
    $lastName = $update_data['message']['from']['last_name'];
    $name_user = $firstName . " " . $lastName;
    $timestamp = $update_data['message']['date'];
    $date = date("Y-m-d H:i:s", $timestamp);

    $photo_send = null;
    if(isset($update_data['message']['photo'])) {
        $photo = end($update_data['message']['photo']);
        $photo_id = $photo['file_id'];
        $url_photo = getPhotoPath($photo_id);
        $photo_send = 'assets/photo/' . $photo_id . '.jpg';
        $message_text = $update_data['message']['caption'];
        savePhoto($url_photo, $photo_id);
    }    
    $forward_from = null;
    if (isset($update_data['message']['forward_from']) )  {
        $forward_from = get_name_forward($update_data);
    }
    $url_gif = null;
    if(isset($update_data['message']['document'])) {
        $file_id = $update_data['message']['document']['file_id'];
        $url_gif = get_gif($file_id);
    }
    $url_sticker = null;
    if(isset($update_data['message']['sticker'])) {
        $file_id = $update_data['message']['sticker']['thumbnail']['file_id'];
        $url_sticker = get_sticker($file_id);
    }
    $name_user = json_encode($name_user);
    $message_text = json_encode($message_text);
    $servername = 'almalinux-s-2vcpu-4gb-intel-sgp1-01';
    $username = "kbhnftgroupvncom"; // Tên người dùng cơ sở dữ liệu
    $password = "ghfjt!#gfjg1fdjk"; // Mật khẩu cơ sở dữ liệu
    $dbname = "kbhnftgroupvncom"; // Tên cơ sở dữ liệu

    try {
        // Tạo kết nối đến cơ sở dữ liệu sử dụng PDO
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // Thiết lập chế độ báo lỗi
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO message_from_bot_casino (name, content, avatar_url, photo, forward_from, gif, sticker) VALUES (:name, :content, :avatar, :photo, :forward_from, :gif, :sticker)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $name_user);
        $stmt->bindParam(':content', $message_text);
        $stmt->bindParam(':avatar', get_url_avatar($update_data));
        $stmt->bindParam(':photo', $photo_send);
        $stmt->bindParam(':forward_from', $forward_from);
        $stmt->bindParam(':gif', $url_gif);
        $stmt->bindParam(':sticker', $url_sticker);
        $stmt->execute();

        $conn = null;
        // send_message($update_data['message']['chat']['id'], 'ok');
    } catch(PDOException $e) {
        echo $e->getMessage();
        // send_message($update_data['message']['chat']['id'], $e->getMessage());
    }

    $pusher = new Pusher\Pusher(
        "53d916e1cb5d74805c3a", // key
        "6585169e26a4296b787e", // secret
        "1637385", //app_id
        array('cluster' => 'mt1')
    );
    
    $pusher->trigger('my-channel', 'chat_casino', array(
                                                            'message' => $message_text,
                                                            'name' => $name_user,
                                                            'hour_minutes' => $date,
                                                            'avatar_url' => get_url_avatar($update_data),
                                                            'message_img' => $photo_send,
                                                            'forward_from' => $forward_from,
                                                            'url_gif' => $url_gif,
                                                            'sticker' => $url_sticker,
                                                            ));
}

function get_url_avatar ($update) {
    global $token;
    // Lấy thông tin về tin nhắn được gửi trong nhóm chat
    $message = $update['message'];
    $user = $message['from'];
    $user_id = $user['id'];

    // Lấy danh sách ảnh đại diện của người dùng
    $url = "https://api.telegram.org/bot$token/getUserProfilePhotos?user_id=$user_id&limit=1";
    $response = file_get_contents($url);
    $response = json_decode($response, true);

    if ($response['result']['total_count'] > 0) {
    // Lấy đường dẫn URL để tải xuống ảnh đại diện đầu tiên
    $file_id = $response['result']['photos'][0][0]['file_id'];
    $url = "https://api.telegram.org/bot$token/getFile?file_id=$file_id";
    $response = file_get_contents($url);
    $response = json_decode($response, true);
    $file_path = $response['result']['file_path'];
    $file_url = "https://api.telegram.org/file/bot$token/$file_path";

    return savePhoto($file_url, $file_id);
    }
}

function getPhotoPath($photo_id) {
    global $token;
    $url = "https://api.telegram.org/bot$token/getFile?file_id=$photo_id";
    $file_info = json_decode(file_get_contents($url), true);
    $file_path = $file_info['result']['file_path'];
    return "https://api.telegram.org/file/bot$token/$file_path";
}

// Hàm lưu trữ ảnh vào thư mục trên server
function savePhoto($url, $file_name) {
    $img = file_get_contents($url);
    file_put_contents('assets/photo/' . $file_name . '.jpg', $img);
    $photo = 'assets/photo/' . $file_name . '.jpg';
    return $photo;
}

function get_name_forward($update_data) {
    $firstName = $update_data['message']['forward_from']['first_name'];
    $lastName = $update_data['message']['forward_from']['last_name'];
    $name = $firstName . ' ' . $lastName;
    return $name;
}

function get_gif($file_id) {
    global $token;
    $url = "https://api.telegram.org/bot$token/getFile?file_id=$file_id";
    // Gửi yêu cầu đến API của Telegram
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    // Phân tích phản hồi JSON
    $data = json_decode($response, true);
    if ($data['ok'] && isset($data['result']['file_path'])) {
        // Tạo URL để tải xuống tệp
        $fileUrl = 'https://api.telegram.org/file/bot' . $token . '/' . $data['result']['file_path'];
        $filePath = 'assets/gif/' . $file_id . '.mp4';
        // Tải xuống tệp và lưu vào đường dẫn được chỉ định
        file_put_contents($filePath, file_get_contents($fileUrl));
    }
    return $filePath;
}

function get_sticker($file_id) {
    global $token;
    $url_get_sticker = "https://api.telegram.org/bot$token/getFile?file_id=$file_id";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url_get_sticker);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    // Phân tích phản hồi JSON
    $data = json_decode($response, true);
    if ($data['ok'] && isset($data['result']['file_path'])) {
        $file_path = $data['result']['file_path'];
        $fileUrl = "https://api.telegram.org/file/bot$token/$file_path";
        $filePath = 'assets/' . $data['result']['file_path'];
        // Tải xuống tệp và lưu vào đường dẫn được chỉ định
        file_put_contents($filePath, file_get_contents($fileUrl));
    }
    return $filePath;
}
?>