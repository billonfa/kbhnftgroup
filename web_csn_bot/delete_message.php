<?php
delete_old_data();
function delete_old_data()
{
    $servername = 'almalinux-s-2vcpu-4gb-intel-sgp1-01';
    $username = "kbhnftgroupvncom"; // Tên người dùng cơ sở dữ liệu
    $password = "ghfjt!#gfjg1fdjk"; // Mật khẩu cơ sở dữ liệu
    $dbname = "kbhnftgroupvncom"; // Tên cơ sở dữ liệu
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Xóa dữ liệu cũ
    $tableName = "message_from_bot_casino";
    $keepLatestRecords = 500;

    $deleteSql = "DELETE FROM $tableName WHERE id NOT IN (
        SELECT id FROM (
            SELECT id FROM $tableName ORDER BY id DESC LIMIT $keepLatestRecords
        ) sub
    )";
    $stmt = $conn->prepare($deleteSql);
    $stmt->execute();
}
?>