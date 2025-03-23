<?php
include $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';

$masp = $_POST["masp"];  // Lấy ID sản phẩm từ form
$giamgia = $_POST["giamgia"]; // Lấy % giảm giá

// Kiểm tra dữ liệu đầu vào
if (empty($masp) && empty($giamgia)) {
    die("Vui lòng nhập đầy đủ thông tin!");
}

// Kiểm tra sản phẩm có tồn tại không
$sql_check = "SELECT gia FROM sanpham WHERE id = ?";
$stmt = $conn->prepare($sql_check);
$stmt->bind_param("i", $masp);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    die("Sản phẩm không tồn tại!");
}

$giaGoc = $row['gia'];  // Lấy giá gốc của sản phẩm

// Thêm % giảm giá vào sản phẩm
$sql_update_discount = "UPDATE sanpham SET giamgia = ? WHERE id = ?";
$stmt = $conn->prepare($sql_update_discount);
$stmt->bind_param("ii", $giamgia, $masp);
$stmt->execute();

// Tính giá mới sau khi giảm
$giaSauGiam = $giaGoc - ($giaGoc * ($giamgia / 100));

// Cập nhật giá mới vào bảng sản phẩm
$sql_update_price = "UPDATE sanpham SET gia = ? WHERE id = ?";
$stmt = $conn->prepare($sql_update_price);
$stmt->bind_param("ii", $giaSauGiam, $masp);

if ($stmt->execute()) {
    echo "Khuyến mãi đã áp dụng! Giá mới: " . number_format($giaSauGiam) . " VND";
} else {
    echo "Lỗi khi cập nhật giá!";
}

// Đóng kết nối
$conn->close();
header("Location: /app/views/admin/khuyenmaipage.php"); 
exit();
?>
