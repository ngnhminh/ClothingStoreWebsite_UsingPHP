<?php
include __DIR__ . '\..\..\config\db.php';
header('Content-Type: application/json');

$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

$email = $data['email'] ?? null;
$password = $data['password'] ?? null;

if (!$email || !$password) {
    echo json_encode([
        'success' => false,
        'message' => 'Thiếu email hoặc mật khẩu'
    ]);
    exit;
}

$users = getUserByEmailAndPassword($email, $password);

if (!empty($users)) {
    echo json_encode([
        'success' => true,
        'user' => $users[0]
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Sai tài khoản hoặc mật khẩu'
    ]);
}

function getUserByEmailAndPassword($username, $password) {
    global $conn; 
    $sql = "SELECT * 
            FROM taikhoan
            WHERE tentaikhoan = ? AND matkhau = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die("Lỗi chuẩn bị truy vấn: " . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $data;
}

?>

