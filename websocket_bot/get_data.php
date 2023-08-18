<?php
    header("Access-Control-Allow-Origin: https://baocsn.com");
    $servername = 'almalinux-s-2vcpu-4gb-intel-sgp1-01';
    $username = "kbhnftgroupvncom"; // Tên người dùng cơ sở dữ liệu
    $password = "ghfjt!#gfjg1fdjk"; // Mật khẩu cơ sở dữ liệu
    $dbname = "kbhnftgroupvncom"; // Tên cơ sở dữ liệu

    // Kết nối đến cơ sở dữ liệu
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    
    // Kiểm tra kết nối
    if (!$conn) {
        die("Kết nối không thành công: " . mysqli_connect_error());
    }
    
    // Thực hiện truy vấn SQL để lấy dữ liệu từ bảng message
    $sql = "SELECT * FROM message_from_bot ORDER BY created_at DESC LIMIT 100";
    $result = mysqli_query($conn, $sql);
    
    // Tạo một mảng để lưu trữ dữ liệu
    $data = array();
    
    // Lặp qua các dòng kết quả và thêm chúng vào mảng
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    
    // Trả về dữ liệu dưới dạng JSON
    echo json_encode($data);
    
    // Đóng kết nối đến cơ sở dữ liệu
    mysqli_close($conn);
?>