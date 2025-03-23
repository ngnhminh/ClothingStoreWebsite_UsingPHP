<?php
$servername = "localhost";
$username = "root";
$password = "1234";
$database = "clothing_store";

// Kết nối MySQLi
$conn = mysqli_connect($servername, $username, $password, $database);

// Kiểm tra kết nối
if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}
?>
