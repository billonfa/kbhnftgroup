<?php

?>
<!DOCTYPE html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="robots" content="noindex,nofollow">
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>KBH GROUP - PHÒNG CHAT KÈO</title>

    <!-- Google Nunito font -->
    <link href="dist/css/font.css" rel="stylesheet" />
    <link rel="stylesheet" href="styles2.css">
    <link href="dist/css/data-aos.css" rel="stylesheet">
    <script src="dist/js/feather-icon.js"></script>
    <style>
        
        :root {
            --body-bg: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            --msger-bg: #fff;
            --border: 2px solid #ddd;
            --left-msg-bg: #ececec;
            --right-msg-bg: #579ffb;
        }
        
        html {
            box-sizing: border-box;
        }

        *,
        *:before,
        *:after {
            margin: 0;
            padding: 0;
            box-sizing: inherit;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 1vh;
            background-image: var(--body-bg);
            font-family: Helvetica, sans-serif;
        }

        .msger {
            display: flex;
            flex-flow: column wrap;
            justify-content: space-between;
            width: 100%;
            border: var(--border);
            border-radius: 5px;
            background: var(--msger-bg);
            box-shadow: 0 15px 15px -5px rgba(0, 0, 0, 0.2);
        }

        .msger-header {
            display: flex;
            padding: 10px;
            border-top: var(--border);
            background: #da2345;
            font-size: 1em;
            position: sticky;
            top: 0px;
        }

        .msg-forward {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 600;
            margin-bottom: 10px;
            padding-top: -14px;
            font-size: 13px;
        }

        .msger-chat {
            flex: 1;
        }

        .msger-chat::-webkit-scrollbar {
            width: 6px;
        }

        .msger-chat::-webkit-scrollbar-track {
            background: #ddd;
        }

        .msger-chat::-webkit-scrollbar-thumb {
            background: #bdbdbd;
        }

        .msg {
            display: flex;
            align-items: flex-end;
            margin-bottom: 10px;
            margin-left: 10px;
        }

        .msg-img {
            width: 35px;
            height: 35px;
            margin-right: 10px;
            background: #ddd;
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            border-radius: 50%;
        }

        .msg-bubble {
            width: max-content;
            padding: 15px;
            border-radius: 15px;
            background: var(--left-msg-bg);
            max-width: 70%;
        }

        .msg-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .msg-info-name {
            margin-right: 10px;
            font-weight: bold;
            color: #1189cf;
        }

        .msg-info-time {
            font-size: 0.75em;
        }

        .left-msg .msg-bubble {
            border-bottom-left-radius: 0;
        }

        .right-msg {
            flex-direction: row-reverse;
        }

        .right-msg .msg-bubble {
            background: var(--right-msg-bg);
            color: #fff;
            border-bottom-right-radius: 0;
        }

        .right-msg .msg-img {
            margin: 0 0 0 10px;
        }

        .msger-inputarea {
            display: flex;
            padding: 10px;
            border-top: var(--border);
            background: #eee;
            position: sticky;
            bottom: 0px;
            font-size: 1.25em;
        }

        .msger-inputarea * {
            padding: 10px;
            border: none;
            border-radius: 3px;
            font-size: 1em;
        }

        .msger-input {
            flex: 1;
            background: #ddd;
        }

        .msger-send-btn_b {
            background: #da2345;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.23s;
            margin: 0px auto;
            width: 100%;
            padding: 5px;
            z-index: 10;
        }

        .msger-chat {
            background-color: #fcfcfe;
            background-image: url("dist/media/svg/background_message.svg");
        }
        a {
            text-decoration: none;
        }
        /* Ẩn thanh cuộn ngang và dọc trong iframe */
        iframe {
            overflow: hidden;
        }

        /* Tùy chỉnh kiểu dáng thanh cuộn (tuỳ chọn) */
        ::-webkit-scrollbar {
            width: 0em;
        }

        /* Định nghĩa keyframes cho animation */
        @keyframes hienRoDan {
            0% { opacity: 0; } /* Tỷ lệ mờ bằng 0% (ẩn) */
            100% { opacity: 1; } /* Tỷ lệ mờ bằng 100% (hoàn toàn hiển thị) */
        }

        /* Áp dụng animation cho thẻ div có class là "messages" */
        .new_message {
            animation-name: hienRoDan; /* Sử dụng keyframes đã định nghĩa */
            animation-duration: 1s; /* Thời gian thực hiện animation là 1 giây */
        }
        @media (max-width: 500px) {
            .msg-bubble {
                max-width: 325px;
            }
        }
        
    </style>
</head>

<body>

    <section class="msger">
        <header class="msger-header">
            <div class="msger-send-btn_b">
                <div>KBH GROUP - PHÒNG CHAT KÈO </div>
                <div style="margin-top: 5px; font-size: 12px"><i><span id="member_online"><?php echo mt_rand(10, 99) ?></span> THÀNH VIÊN ĐANG ONLINE</i></div>
            </div>
        </header>
        <main class="msger-chat" id="message">
            <div class="msg left-msg">
                <div class="msg-img" style="background-image: url(#)"></div>

                <div class="msg-bubble">
                    <div class="msg-info">
                        <div class="msg-info-name">BOT</div>
                        <div class="msg-info-time">12:45</div>
                    </div>

                    <div class="msg-text">
                        Hi, welcome to KBH Chat! 😄
                    </div>
                </div>
            </div>
        </main>
        <div class="msger-inputarea">
            <a href="https://t.me/thuytien06" target="_blank" class="msger-send-btn_b" style="text-align:center">Click để Nhắn tin vào Nhóm kèo Vip Miễn Phí</a>
        </div>
    </section>

    <div class="modal">
        <div class="modal-content">
            <span class="modal-close" style="">&times;</span>
            <img src=""/>
        </div>
    </div>

    <script src="dist/js/pusher2.min.js"></script>
    <script src="dist/js/data-aos2.js"></script>
    <script src="dist/js/event6.js"></script>
    <script>feather.replace()</script>
</body>

