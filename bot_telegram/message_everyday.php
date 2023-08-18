<?php
        sleep(60);
        date_default_timezone_set('Asia/Ho_Chi_Minh');

        $servername = gethostname();
        $username = "kbhnftgroupvncom";
        $password = "ghfjt!#gfjg1fdjk";
        $dbname = "kbhnftgroupvncom";

        $newday = getdate();
        $hours = $newday['hours'];
        $minutes = $newday['minutes'];
        $seconds = $newday['seconds'];
        $token = "5963312880:AAFMhcTdpOCzCuQhsQjhNqaA07ToBU2pTXc";
        $api_url = "https://api.telegram.org/bot" . $token;
        $chat_id = [
            -1001638679413, // NFT - KÈO BÓNG BẢO HIỂM (1)
            -1001660395878, // NFT - CSN KIM CƯƠNG (2)
            -1001505060227, //KBH - KÈO BÓNG BẢO HIỂM (3)
            -1001931706051, //MG CASINO KIM CƯƠNG (4)
            -1001603519099, //KBH - HỌC CHƠI GIAO LƯU (5)
            -1001947676554, // MG (6)
            -1001832257366, //Bong vip
            // -1001908140636, // Mg188
        ]; 
        //Time 1
        $time1 = ($hours == 8 && $minutes == 59); // Gửi cron lúc 9h
        $time2 = ($hours == 14 && $minutes == 59); // Gửi cron lúc 15h
        $time3 = ($hours == 17 && $minutes == 59); // Gửi cron lúc 18h
        $time4 = ($hours == 22 && $minutes == 59); // Gửi cron lúc 23h
        
        //Time 2
        $time5 = ($hours == 9 && $minutes == 59); // Gửi cron lúc 10h
        $time6 = ($hours == 18 && $minutes == 59); // Gửi cron lúc 19h
        $time7 = ($hours == 21 && $minutes == 59); // Gửi cron lúc 22h
    
        //Time kqxs
        $time_kqxsmb = ($hours == 18 && $minutes == 47);
        $time_kqxsmt = ($hours == 17 && $minutes == 42);
        $time_kqxsmn = ($hours == 16 && $minutes == 52);

        if($time1 || $time2 || $time3 || $time4) {
            $group_time1_chatid_01 = [
                $chat_id[2],
                $chat_id[3],
                $chat_id[5],
            ];
            // Nội dung tin nhắn
            $messageText_01 = '💎 Anh em nào thấy Telegram đang sử dụng tiếng Anh thì bấm "VIỆT HÓA" bên dưới để chuyển sang Tiếng Việt cho dễ sử dụng.' .
            "\n💎 Kèm theo là bảo mật Telegram như hình hướng dẫn bên trên để tránh bị thêm vào những Nhóm lừa đảo!" .
            "\n💎 Nếu có bất kỳ thắc mắc gì về Trang chơi cũng như Nhóm chơi Anh em có thể nhắn về Thủy Tiên bên dưới để được hỗ trợ nhé!";
            // Đường dẫn tới file hình ảnh
            $photoPath_01 = 'photo/Bao-mat-telegram.jpg';
            // Text của nút bấm
            $buttonText_01 = 'VIỆT HÓA 🇻🇳';
            $buttonText2_01 = 'NT THỦY TIÊN';
            // URL API của Telegram
            $apiUrl_01 = "https://api.telegram.org/bot$token/";
            // Tạo mảng inline keyboard
            $inlineKeyboard_01 = array(
                array(
                    array(
                        'text' => $buttonText_01,
                        'url' => 'https://t.me/setlanguage/abcxyz'
                    ),
                    array(
                        'text' => $buttonText2_01,
                        'url' => 'https://t.me/thuytien06'
                    )
                )
            );
            // Chuyển đổi mảng inline keyboard thành chuỗi JSON
            $inlineKeyboardEncoded_01 = json_encode(array('inline_keyboard' => $inlineKeyboard_01));
            foreach($group_time1_chatid_01 as $key_groupchatid => $value_time1_chatid_01) {
                // Gửi tin nhắn và hình ảnh
                $url_01 = $apiUrl_01 . 'sendPhoto';
                $postFields_01 = array('chat_id' => $value_time1_chatid_01, 'photo' => new CURLFile(realpath($photoPath_01)), 'caption' => $messageText_01, 'reply_markup' => $inlineKeyboardEncoded_01);
                $ch_01 = curl_init();
                curl_setopt($ch_01, CURLOPT_URL, $url_01);
                curl_setopt($ch_01, CURLOPT_POST, 1);
                curl_setopt($ch_01, CURLOPT_POSTFIELDS, $postFields_01);
                curl_setopt($ch_01, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch_01, CURLOPT_SSL_VERIFYPEER, false);
                $result_01 = curl_exec($ch_01);
                if($result_01) {
                    echo "Gửi tin nhắn cho $value_time1_chatid_01 thành công" . "\n";
                }
                else {
                    echo "Gửi tin nhắn cho $value_time1_chatid_01 thất bại";
                }
                curl_close($ch_01);
            }
    
            $group_time1_chatid_02 = [
                $chat_id[0],
                $chat_id[1],
                $chat_id[4],
                $chat_id[6],
            ];
            $messageText_02 = '💎 Anh em nào thấy Telegram đang sử dụng tiếng Anh thì bấm "VIỆT HÓA" bên dưới để chuyển sang Tiếng Việt cho dễ sử dụng.' .
            "\n💎 Kèm theo là bảo mật Telegram như hình hướng dẫn bên trên để tránh bị thêm vào những Nhóm lừa đảo!" .
            "\n💎 Nếu có bất kỳ thắc mắc gì về Trang chơi cũng như Nhóm chơi Anh em có thể nhắn về Thủy Tiên bên dưới để được hỗ trợ nhé!";
            // Đường dẫn tới file hình ảnh
            $photoPath_02 = 'photo/huong-dan-telegram-bongvip.jpg';
            $buttonText_02 = 'VIỆT HÓA 🇻🇳';
            $buttonText2_02 = 'NT THỦY TIÊN';
            $apiUrl_02 = "https://api.telegram.org/bot$token/";
            $inlineKeyboard_02 = array(
                array(
                    array(
                        'text' => $buttonText_02,
                        'url' => 'https://t.me/setlanguage/abcxyz'
                    ),
                    array(
                        'text' => $buttonText2_02,
                        'url' => 'https://t.me/thuytien06'
                    )
                )
            );
            $inlineKeyboardEncoded_02 = json_encode(array('inline_keyboard' => $inlineKeyboard_02));
            foreach($group_time1_chatid_02 as $key_groupchatid_02 => $value_time1_chatid_02) {
                // Gửi tin nhắn và hình ảnh
                $url_02 = $apiUrl_02 . 'sendPhoto';
                $postFields_02 = array('chat_id' => $value_time1_chatid_02, 'photo' => new CURLFile(realpath($photoPath_02)), 'caption' => $messageText_02, 'reply_markup' => $inlineKeyboardEncoded_02);
                $ch_02 = curl_init();
                curl_setopt($ch_02, CURLOPT_URL, $url_02);
                curl_setopt($ch_02, CURLOPT_POST, 1);
                curl_setopt($ch_02, CURLOPT_POSTFIELDS, $postFields_02);
                curl_setopt($ch_02, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch_02, CURLOPT_SSL_VERIFYPEER, false);
                $result_02 = curl_exec($ch_02);
                if($result_02) {
                    echo "Gửi tin nhắn cho $value_time1_chatid_02 thành công";
                }
                else {
                    echo "Gửi tin nhắn cho $value_time1_chatid_02 thất bại";
                }
                curl_close($ch_02);
            }
        }
        

        if($time5 || $time6 || $time7) {
            if (isset($_SERVER['HTTP_COOKIE'])) {
                $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
                foreach($cookies as $cookie) {
                    $parts = explode('=', $cookie);
                    $name = trim($parts[0]);
                    setcookie($name, '', time() - 3600, '/');
                }
            }
            $group_time1_chatid_03 = [
                $chat_id[2],
                $chat_id[5],
            ];
            // Nội dung tin nhắn
            $messageText_03 = '✅ Để Nhóm ngày một chất lượng và phát triển hơn, anh em đọc qua quy định Nhóm nhé !
            ❌ Nếu phát hiện các tình trạng dụ dỗ, lôi kéo, xin lộc,... kể trên Anh em nhắn tin ngay về cho Thủy Tiên để xử lý nhé!';
            // Đường dẫn tới file hình ảnh
            $photoPath_03 = 'photo/noi-quy-nhom-mg188.png';
            // Text của nút bấm
            $buttonText2_03 = 'NHẮN THỦY TIÊN';
            // URL API của Telegram
            $apiUrl_03 = "https://api.telegram.org/bot$token/";
            // Tạo mảng inline keyboard
            $inlineKeyboard_03 = array(
                array(
                    array(
                        'text' => $buttonText2_03,
                        'url' => 'https://t.me/thuytien06'
                    )
                )
            );
            // Chuyển đổi mảng inline keyboard thành chuỗi JSON
            $inlineKeyboardEncoded_03 = json_encode(array('inline_keyboard' => $inlineKeyboard_03));
            foreach($group_time1_chatid_03 as $key_groupchatid_03 => $value_time1_chatid_03) {
                // Gửi tin nhắn và hình ảnh
                $url_03 = $apiUrl_03 . 'sendPhoto';
                $postFields_03 = array('chat_id' => $value_time1_chatid_03, 'photo' => new CURLFile(realpath($photoPath_03)), 'caption' => $messageText_03, 'reply_markup' => $inlineKeyboardEncoded_03);
                $ch_03 = curl_init();
                curl_setopt($ch_03, CURLOPT_URL, $url_03);
                curl_setopt($ch_03, CURLOPT_POST, 1);
                curl_setopt($ch_03, CURLOPT_POSTFIELDS, $postFields_03);
                curl_setopt($ch_03, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch_03, CURLOPT_SSL_VERIFYPEER, false);
                $result_03 = curl_exec($ch_03);
                if($result_03) {
                    echo "Gửi tin nhắn cho $value_time1_chatid_03 thành công";
                }
                else {
                    echo "Gửi tin nhắn cho $value_time1_chatid_03 thất bại";
                }
                curl_close($ch_03);
            }


            $group_time1_chatid_04 = [
                $chat_id[0],
                $chat_id[6],
            ];
            $messageText_04 = '💎 Anh em lưu ý đọc kỹ Nội quy Nhóm chơi để tránh bị kích nhé !
            ❌ Nếu phát hiện các tình trạng dụ dỗ, lôi kéo, xin lộc,... kể trên Anh em nhắn tin ngay về cho Thủy Tiên để xử lý nhé!';
            // Đường dẫn tới file hình ảnh
            $photoPath_04 = 'photo/noi-quy-nhom-bongvip.png';
            $buttonText2_04 = 'NHẮN THỦY TIÊN';
            $apiUrl_04 = "https://api.telegram.org/bot$token/";
            $inlineKeyboard_04 = array(
                array(
                    array(
                        'text' => $buttonText2_04,
                        'url' => 'https://t.me/thuytien06'
                    )
                )
            );
            $inlineKeyboardEncoded_04 = json_encode(array('inline_keyboard' => $inlineKeyboard_04));
            foreach($group_time1_chatid_04 as $key_groupchatid_04 => $value_time1_chatid_04) {
                // Gửi tin nhắn và hình ảnh
                $url_04 = $apiUrl_04 . 'sendPhoto';
                $postFields_04 = array('chat_id' => $value_time1_chatid_04, 'photo' => new CURLFile(realpath($photoPath_04)), 'caption' => $messageText_04, 'reply_markup' => $inlineKeyboardEncoded_04);
                $ch_04 = curl_init();
                curl_setopt($ch_04, CURLOPT_URL, $url_04);
                curl_setopt($ch_04, CURLOPT_POST, 1);
                curl_setopt($ch_04, CURLOPT_POSTFIELDS, $postFields_04);
                curl_setopt($ch_04, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch_04, CURLOPT_SSL_VERIFYPEER, false);
                $result_04 = curl_exec($ch_04);
                if($result_04) {
                    echo "Gửi tin nhắn cho $value_time1_chatid_04 thành công";
                }
                else {
                    echo "Gửi tin nhắn cho $value_time1_chatid_04 thất bại";
                }
                curl_close($ch_04);
            }
        }

        //Cron gửi kqxs miền Bắc 18:47
        if($time_kqxsmb) { 
            $conn = new mysqli($servername, $username, $password, $dbname);
            // Kiểm tra kết nối
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $date = $newday['year'] . "-" . $newday['mon'] . "-" .$newday['mday'];
            $sql = "SELECT * FROM data_xskt_mb WHERE created_at = '$date'";
            $result = $conn->query($sql);
            $text_show = "KQ xổ số miền Bắc ngày ";
            
            // Tạo mảng chứa dữ liệu
            $data = array();
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    array_push($data, $row);
                }
            }
            foreach($data as $key_data => $value) {
                $chuoi_thoi_gian = $value['created_at'];
                $ngay_thang_nam = date("Y-m-d", strtotime($chuoi_thoi_gian));
                $text_show = $text_show . $ngay_thang_nam . "\n";
                $value['g7'] = json_decode($value['g7']);
                $value['g6'] = json_decode($value['g6']);
                $value['g5'] = json_decode($value['g5']);
                $value['g4'] = json_decode($value['g4']);
                $value['g3'] = json_decode($value['g3']);
                $value['g2'] = json_decode($value['g2']);
                
                $new_i7 = 'G7: ';
                $new_i6 = 'G6: ';
                $new_i5 = 'G5: ';
                $new_i4 = 'G4: ';
                $new_i3 = 'G3: ';
                $new_i2 = 'G2: ';
            
                foreach($value['g7'] as $key_g7 => $item_g7) {
                    $new_i7 = $new_i7 . $item_g7 . " ";
                }
                foreach($value['g6'] as $key_g6 => $item_g6) {
                    $new_i6 = $new_i6 . $item_g6 . " ";
                }
                foreach($value['g5'] as $key_g5 => $item_g5) {
                    $new_i5 = $new_i5 . $item_g5 . " ";
                }
                foreach($value['g4'] as $key_g4 => $item_g4) {
                    $new_i4 = $new_i4 . $item_g4 . " ";
                }
                foreach($value['g3'] as $key_g3 => $item_g3) {
                    $new_i3 = $new_i3 . $item_g3 . " ";
                }
                foreach($value['g2'] as $key_g2 => $item_g2) {
                    $new_i2 = $new_i2 . $item_g2 . " ";
                }
                $value['g1'] = "G1: " . $value['g1'];
                $value['gdb'] = "GDB: " .$value['gdb'];
                $text_show = $text_show . $new_i7. "\n" . $new_i6. "\n" . $new_i5. "\n" . $new_i4. "\n" . $new_i3. "\n" . $new_i2. "\n" .$value['g1']. "\n" . $value['gdb']  ;
                }

            foreach($chat_id as $key_chatid => $value_chatid) {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type:multipart/form-data"));
                curl_setopt($ch, CURLOPT_URL, $api_url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                $result = curl_exec($ch);
                curl_close($ch);
                $update = json_decode(file_get_contents("php://input"), TRUE);
                $data = http_build_query([
                        'text' => $text_show,
                        'chat_id' => $value_chatid
                    ]);
                file_get_contents($api_url . "/sendMessage?{$data}");
            }
            mysqli_close($conn);
        }
