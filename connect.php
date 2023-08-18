<?php
    $servername = 'almalinux-s-2vcpu-4gb-intel-sgp1-01';
    $username = "kbhnftgroupvncom"; // Tên người dùng cơ sở dữ liệu
    $password = "ghfjt!#gfjg1fdjk"; // Mật khẩu cơ sở dữ liệu
    $dbname = "kbhnftgroupvncom"; // Tên cơ sở dữ liệu
    $conn = new mysqli($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Kết nối không thành công: " . mysqli_connect_error());
    }
    
?>