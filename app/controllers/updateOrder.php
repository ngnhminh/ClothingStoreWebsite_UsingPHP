<?php
// Kết nối database
include __DIR__ . '/../../config/db.php'; // hoặc đường dẫn phù hợp đến file kết nối DB

// Nhận dữ liệu từ fetch
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['orderId']) || !isset($data['status'])) {
    echo json_encode(['success' => false, 'message' => 'Thiếu dữ liệu']);
    exit;
}

$orderId = $data['orderId'];
$status = $data['status'];

// Chuyển trạng thái từ chuỗi thành số (nếu cần thiết)
$statusCode = 0; // mặc định: Chờ xử lý
if ($status === "Đã xử lý") {
    $statusCode = 1;
} else if ($status === "Đã hủy") {
    $statusCode = 0;
}

try {
    $stmt = $conn->prepare("UPDATE hoadon SET trangthai = ? WHERE id = ?");
    $stmt->execute([$statusCode, $orderId]);

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
