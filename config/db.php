<?php
$servername = "localhost";
$username = "root";
$password = "abcABC12@";
$database = "clothing_store";

// Kết nối MySQLi
$conn = mysqli_connect($servername, $username, $password, $database);

// Kiểm tra kết nối
if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}
?>
