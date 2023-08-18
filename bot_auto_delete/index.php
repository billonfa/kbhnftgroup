<?php
// https://api.telegram.org/bot5800137854:AAHWebVL_1VtILaTAKozPSfzCaJjyJda-z0/setWebhook?url=https://kbh.nftgroupvn.com/bot_auto_delete/index.php
$token = '5800137854:AAHWebVL_1VtILaTAKozPSfzCaJjyJda-z0';
$api_url = "https://api.telegram.org/bot$token/";
$id_group_nhan = '-801205839';
// Xử lý webhook
$update = file_get_contents('php://input');
$update_data = json_decode($update, true);

if (isset($update_data['message'])) {
    $chat_id = $update_data['message']['chat']['id'];
    $message_text = $update_data['message']['text'];

    // Xử lý logic và tạo nội dung tin nhắn muốn gửi lại

    // Gửi lại tin nhắn cho người dùng
    auto_delete($update_data);
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
    $message_photo = $update_data['message']['photo'];
    $animation = $update_data['message']['animation'];
    $new_chat_participant = $update_data['message']['new_chat_participant'];
    $left_chat_participant = $update_data['message']['left_chat_participant'];
    if (empty($message_text) && empty($message_photo) && empty($animation)) {
        $delete_message_url = $api_url . "deleteMessage?chat_id=" . $chat_id . "&message_id=" . $message_id;
        $response = file_get_contents($delete_message_url);
        $json_response = json_decode($response, true);
        return $json_response['ok'];
    }
}
?>
