<?php
// Bật CORS
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");

// Xử lý request OPTIONS (preflight request)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Kiểm tra phương thức
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["success" => false, "message" => "Phương thức không hợp lệ!"]);
    exit();
}

// Kiểm tra có file được gửi lên không
if (!isset($_FILES["file"])) {
    echo json_encode(["success" => false, "message" => "Không có file nào được gửi!"]);
    exit();
}

// Tạo thư mục nếu chưa có
$uploadDir = __DIR__ . "/uploads/";  
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$fileName = basename($_FILES["file"]["name"]);
$targetPath = $uploadDir . $fileName;

// Kiểm tra và lưu file
if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetPath)) {
    echo json_encode(["success" => true, "message" => "Upload thành công!", "path" => "/uploads/" . $fileName]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Lỗi khi upload file!",
        "error" => error_get_last()
    ]);
}
?>
