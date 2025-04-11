<?php
include __DIR__ . "/../../../config/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ request
    $voucher_name = $_POST["voucher_name"] ?? "";
    $quantity = $_POST["quantity"] ?? 0;
    $voucher_code = $_POST["voucher_code"] ?? "";
  
    // Kiểm tra dữ liệu hợp lệ
    if (empty($voucher_name) && empty($voucher_code)  && $quantity <= 0) {
        echo "Lỗi: Vui lòng nhập đầy đủ thông tin hợp lệ.";
        exit;
    }

    // Chèn vào database
    $stmt = $conn->prepare("INSERT INTO magiamgia (tenma, soluong, codegiamgia) VALUES (?, ?, ? )");
    $stmt->bind_param("sis", $voucher_name, $quantity, $voucher_code);
    

    if ($stmt->execute()) {
        echo "Tên mã: $voucher_name<br>";
        echo "Số lượng: $quantity<br>";
        echo "Mã giảm giá: $voucher_code<br>";
        echo "Tiền giảm: $discount<br>";
        echo "Thêm voucher thành công!";
    } else {
        echo "Lỗi khi thêm voucher: " . $stmt->error;
    }

    $stmt->close();
}

mysqli_close($conn);
?>
