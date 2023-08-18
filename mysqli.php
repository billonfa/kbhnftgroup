<?php
// Info Database
$servername = 'almalinux-s-2vcpu-4gb-intel-sgp1-01';
$username = "kbhnftgroupvncom"; // Tên người dùng cơ sở dữ liệu
$password = "ghfjt!#gfjg1fdjk"; // Mật khẩu cơ sở dữ liệu
$dbname = "kbhnftgroupvncom"; // Tên cơ sở dữ liệu
// Replace YOUR_BOT_TOKEN_HERE with your bot token
$botToken = '6041088278:AAFaY9ZUGBJdV-YED0ptcX2jyleteUaDHS8';
$groupId = '-1001827490491'; // Cơm khô cá mặn
$groupId_nhan  =[ // ID Group bot đọc tin nhắn
    '-863133949',
];

$webhookContent = file_get_contents("php://input");
$update = json_decode($webhookContent, true);

if (isset($update["message"])) {
    $message = $update["message"];
    $chatId = $message["chat"]["id"]; //ID Bot nhận (Từ group chat, hoặc từ người dùng)
    $messageId = $message["message_id"];  // ID số thứ tự Message
    $replyToMessage = $message["reply_to_message"];  // ID lấy được khi reply
    $replyUser = $replyToMessage["from"];
    $idReplyUser = $replyUser['id'];
    $text = $message['text'];
    $userId = $message['from']['id'];
    $replyToMessageId = $message["message_id"];

    if (isset($message["forward_from"])) {
        if($chatId == $groupId) { 
            try {
                forward($message);
            }
            catch (Exception $e) {
                $forwardResponse = $e->getMessage();
                $forwardResponse = 'Lỗi forward';
                $replyToMessageId = $message["message_id"];
                sendMessage($botToken, $chatId, $forwardResponse, $replyToMessageId);
            }
        }
    }
    
    if (strpos($text, 'check') === 0) {
        if($chatId == $groupId) {
            $id_check = trim(str_replace("check", "", $text));
            $id_check = str_replace(" ", "", $id_check);

            $id_customer = trim(str_replace("check", "", $text));
            $id_customer = str_replace(" ", "", $id_customer);
            $forwardResponse = "Hội viên này chưa có UID Telegram trên dữ liệu khách hàng.";
            try {
                // Tạo kết nối
                $conn = new mysqli($servername, $username, $password, $dbname);
                $sql = "SELECT * FROM customers WHERE telegram='$id_check'";
                $result = $conn->query($sql);
                // Kiểm tra và xử lý kết quả
                if ($result->num_rows > 0) {
                    $forwardResponse = '';
                    // Lặp qua từng dòng dữ liệu
                    while ($row = $result->fetch_assoc()) {
                        $date = $row['ngay_tim_ve'];
                        $mg = $row['ID_mg'];
                        $bv = $row['tai_khoan_bv'];
                        $gc = $row['ghi_chu_mxh'];
                        $support_id = $row['nhan_vien'];

                        $sql_support = "SELECT * FROM users WHERE id='$support_id' LIMIT 1";
                        $result_support = mysqli_query($conn, $sql_support);
                        $support_name = '';
                        if (mysqli_num_rows($result_support) > 0) {
                            // Lấy dữ liệu đầu tiên từ kết quả
                            $row_support = mysqli_fetch_assoc($result_support);
                            // In ra dữ liệu
                            $support_name = $row_support["username"];
                        }
                        $forwardResponse = $forwardResponse . "Ngày tìm về: $date \nKhách của: $support_name\nMg: $mg\nBongvip: $bv\nGhi chú: $gc \n\n" ;
                    }
                }
                // Đóng kết nối
                $conn->close();
            }
            catch (Exception $e) {
                $forwardResponse = "Lỗi: " . $e->getMessage();
            }
            sendMessage($botToken, $groupId, $forwardResponse, $replyToMessageId);
        }
    }

    if(isset($message['forward_sender_name']) && empty($message['forward_from'])) {
        if($chatId == $groupId) {
            try {
                $forwardResponse = "Khách đang ẩn UID, tương tác tra uid từ bot sau đó gõ lệnh “check tênuid” để tìm dữ liệu nhé";
                $replyToMessageId = $message["message_id"];
            }
            catch (Exception $e) {
                $forwardResponse = "Lỗi khi Forward ẩn UID: " . $e->getMessage();
            }
            sendMessage($botToken, $groupId, $forwardResponse, $replyToMessageId);
        }
    }
}

function sendMessage($token, $chatId, $response, $replyToMessageId = null) {
    $apiUrl = "https://api.telegram.org/bot$token/sendMessage";

    // Tạo một mảng chứa thông tin tin nhắn cần gửi
    $data = array(
        'chat_id' => $chatId,
        'text' => $response,
        'reply_to_message_id' => $replyToMessageId
    );

    // Sử dụng cURL để gửi tin nhắn thông qua API của Telegram
    $options = array(
        'http' => array(
            'method'  => 'POST',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($apiUrl, false, $context);

    // Kiểm tra kết quả gửi tin nhắn
    if ($result === false) {
        $error = 'Lỗi không xác định';
        $url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chatId . "&text=".urlencode($error);
        file_get_contents($url);
    }
}

function getChatAdministrators($token, $chatId) {
    $url = "https://api.telegram.org/bot" . $token . "/getChatAdministrators?chat_id=" . $chatId;
    $response = file_get_contents($url);
    return json_decode($response, true)["result"];
}

function forward($message) {
    global $servername;
    global $username;
    global $password;
    global $dbname;
    global $botToken;
    global $groupId;
    global $groupId_nhan;

    $chatId = $message["chat"]["id"];
    $forwardUser = $message["forward_from"];
    $forwardUserId = $forwardUser["id"];
    $forwardUserFirstName = $forwardUser["first_name"];
    $forwardUserLastName = isset($forwardUser["last_name"]) ? $forwardUser["last_name"] : "";

    $content = '';
    if($chatId == $groupId) {
        try {
            // Tạo kết nối
            $conn = new mysqli($servername, $username, $password, $dbname);
            $content = get_user_database($forwardUserId, $conn);
            // Đóng kết nối
            $conn->close();
        }
        catch (Exception $e) {
            $content = 'Lỗi database';
            echo "Lỗi: " . $e->getMessage();
        }
        $forwardResponse = "UID của người chuyển tiếp: " . $forwardUserId . "\nTên Telegram: $forwardUserFirstName $forwardUserLastName \n$content";
        $replyToMessageId = $message["message_id"];
        sendMessage($botToken, $chatId, $forwardResponse, $replyToMessageId);
        die();
    }
    foreach($groupId_nhan as $key => $id_expect) {
        if ($chatId == $id_expect) {
            die();
        }
    }
    $forwardResponse = "UID của người chuyển tiếp: " . $forwardUserId . "\nTên Telegram: $forwardUserFirstName $forwardUserLastName \n$content";
    $replyToMessageId = $message["message_id"];
    sendMessage($botToken, $chatId, $forwardResponse, $replyToMessageId);
}

function get_user_database($forwardUserId, $conn) {
    
    // Truy vấn để lấy id từ bảng "customers"
    $sql = "SELECT * FROM customers WHERE telegram='$forwardUserId'";
    $result = $conn->query($sql);
    // Kiểm tra và xử lý kết quả
    if ($result->num_rows > 0) {
        // Lặp qua từng dòng dữ liệu
        $content = '';
        while ($row = $result->fetch_assoc()) {
            $date = $row['ngay_tim_ve'];
            $mg = $row['ID_mg'];
            $bv = $row['tai_khoan_bv'];
            $gc = $row['ghi_chu_mxh'];
            $support_id = $row['nhan_vien'];

            $sql_support = "SELECT * FROM users WHERE id='$support_id' LIMIT 1";
            $result_support = mysqli_query($conn, $sql_support);
            $support_name = '';
            if (mysqli_num_rows($result_support) > 0) {
                // Lấy dữ liệu đầu tiên từ kết quả
                $row_support = mysqli_fetch_assoc($result_support);
                // In ra dữ liệu
                $support_name = $row_support["username"];
            }
            $content = $content . "Ngày tìm về: $date \nKhách của: $support_name\nMg: $mg\nBongvip: $bv\nGhi chú: $gc \n\n";
        }
        return $content;
    }
    return "Hội viên này chưa có UID Telegram trên dữ liệu khách hàng.";
    
}

function get_admin_group($botToken, $groupId_nhan, $update) {
    $from_id = $update['message']['from']['id'];
    foreach($groupId_nhan as $key_group => $groupId) {
        $admin = file_get_contents('https://api.telegram.org/bot'.$botToken.'/getChatAdministrators?chat_id='.$groupId);
        $admin = json_decode($admin)->result;
        $isAdmin = false;
        foreach($admin as $key => $a) {
            $id = $a->user->id;
            if($id == $from_id) {
                $isAdmin = true;
                return $isAdmin = true;
            }
        }
    }
}

function get_admin_database($conn, $update) {
    $admin_id = $update['message']['from']['id'];
    // Truy vấn để lấy id từ bảng "admin"
    $sql_admin = "SELECT id FROM admin WHERE id='$admin_id'";
    $result_admin = $conn->query($sql_admin);
    return $result_admin->num_rows;
}