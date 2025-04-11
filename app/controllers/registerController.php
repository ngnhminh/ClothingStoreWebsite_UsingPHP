<?php
include __DIR__ . '/../../config/db.php';
header('Content-Type: application/json');

$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

// Lấy dữ liệu
$fullname = $data['fullname'] ?? null;
$email = $data['email'] ?? null;
$username = $data['username'] ?? null;
$phone = $data['phone'] ?? null;
$password = $data['password'] ?? null;

// Nếu chỉ có username, kiểm tra tài khoản đã tồn tại chưa
if ($username && !$fullname && !$email && !$phone && !$password) {
    $users = getUserByUsername($username);
    if (!empty($users)) {
        echo json_encode([
            'success' => true,
            'user' => $users[0]
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Tài khoản chưa tồn tại'
        ]);
    }
    exit;
}

// Nếu là tạo tài khoản mới
if (!$fullname || !$email || !$username || !$phone || !$password) {
    echo json_encode([
        'success' => false,
        'message' => 'Thiếu thông tin'
    ]);
    exit;
}

$created = createUserAndCustomer($fullname, $email, $username, $phone, $password);
if ($created) {
    echo json_encode([
        'success' => true,
        'message' => 'Tạo tài khoản thành công'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Tạo tài khoản thất bại'
    ]);
}

// Hàm kiểm tra username tồn tại
function getUserByUsername($username) {
    global $conn;
    $sql = "SELECT * FROM taikhoan WHERE tentaikhoan = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $data;
}

// Hàm tạo tài khoản
function createUserAndCustomer($fullname, $email, $username, $phone, $password) {
    global $conn;

    // Bước 1: Thêm khách hàng vào bảng khachhang
    $sql_kh = "INSERT INTO khachhang (hoten, sdt, email) VALUES (?, ?, ?)";
    $stmt_kh = mysqli_prepare($conn, $sql_kh);
    if (!$stmt_kh) return false;

    mysqli_stmt_bind_param($stmt_kh, "sss", $fullname, $phone, $email);
    $success_kh = mysqli_stmt_execute($stmt_kh);
    if (!$success_kh) return false;

    $makh = mysqli_insert_id($conn); // Lấy mã khách hàng vừa tạo
    mysqli_stmt_close($stmt_kh);

    // Bước 2: Thêm tài khoản vào bảng taikhoan
    $sql_tk = "INSERT INTO taikhoan (tentaikhoan, matkhau, diemtichluy, makh) VALUES (?, ?, 0, ?)";
    $stmt_tk = mysqli_prepare($conn, $sql_tk);
    if (!$stmt_tk) return false;

    mysqli_stmt_bind_param($stmt_tk, "ssi", $username, $password, $makh);
    $success_tk = mysqli_stmt_execute($stmt_tk);
    mysqli_stmt_close($stmt_tk);

    return $success_tk;
}


?>
