<?php
require_once('config/db.php'); // Gọi kết nối database

function checkDatabaseConnection() {
    global $conn; // Dùng biến $conn từ db.phpwe
    try {
        // Thử thực hiện một truy vấn đơn giản
        $stmt = $conn->query("SELECT 1");
        return $stmt !== false;
    } catch (PDOException $e) {
        return false; // Trả về false nếu có lỗi
    }
}

// Test thử xem kết nối có hoạt động không
if (checkDatabaseConnection()) {
    echo "✅ Kết nối đến database thành công!";
} else {
    echo "❌ Lỗi kết nối đến database!";
}
?>
