<?php
include __DIR__ . '/../../config/db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
$action = $data['action'] ?? ($_GET['action'] ?? '');

switch ($action) {
    case 'getCodeGiamGia':
        $magiamgia = $_GET["magiamgia"] ?? null;
        $getCodeGiamGia = getCodeGiamGia($magiamgia);
        echo json_encode([
            'success' => !empty($getCodeGiamGia),
            'getCodeGiamGia' => $getCodeGiamGia[0] ?? null
        ]);
        break;

    case 'getEmail':
        $email = $_GET["email"] ?? null;
        $getEmail = getEmailByEmail($email);
        echo json_encode([
            'success' => !empty($getEmail),
            'getEmail' => $getEmail[0] ?? null
        ]);
        break;

    case 'createCustomer':
        $hoten = $data["hoten"] ?? null;
        $sdt = $data["sdt"] ?? null;
        $emailpost = $data["email"] ?? null;
        $newIdCustomer = createCustomer($hoten, $sdt, $emailpost);
        echo json_encode([
            'success' => !!$newIdCustomer,
            'newCustomerId' => $newIdCustomer
        ]);
        break;

    case 'createOrder':
        $ngay = $data["ngay"] ?? null;
        $tongtien = $data["tongtien"] ?? null;
        $makh = $data["makh"] ?? null;
        $dssanpham = $data['dssanpham'] ?? [];
        $diachi = $data['diachi'] ?? null;
        $ghichu = $data['ghichu'] ?? null;
        $soluong = $data['soluong'] ?? null;
        $createOrder = createOrderAndOrderDetail($ngay, $tongtien, $makh, $dssanpham, $diachi, $ghichu, $soluong);
        echo json_encode([
            'success' => $createOrder
        ]);
        break;

    default:
        echo json_encode([
            'success' => false,
            'message' => 'Hành động không hợp lệ'
        ]);
        break;
}
exit;

function getCodeGiamGia($magiamgia){
    global $conn;
    $sql = "SELECT * from magiamgia WHERE codegiamgia = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) die("Lỗi chuẩn bị truy vấn: " . mysqli_error($conn));
    mysqli_stmt_bind_param($stmt, "s", $magiamgia);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $data;
}

function getEmailByEmail($email){
    global $conn;
    $sql = "SELECT * from khachhang WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) die("Lỗi chuẩn bị truy vấn: " . mysqli_error($conn));
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $data;
}

function createCustomer($fullname, $phone, $email) {
    global $conn;
    $sql_kh = "INSERT INTO khachhang (hoten, sdt, email) VALUES (?, ?, ?)";
    $stmt_kh = mysqli_prepare($conn, $sql_kh);
    if ($stmt_kh) {
        mysqli_stmt_bind_param($stmt_kh, "sss", $fullname, $phone, $email);
        if (mysqli_stmt_execute($stmt_kh)) {
            $newCustomerId = mysqli_insert_id($conn);
            mysqli_stmt_close($stmt_kh);
            return $newCustomerId;
        }
        mysqli_stmt_close($stmt_kh);
    }
    return false;
}

function createOrderAndOrderDetail($ngay, $tongtien, $makh, $dssanpham, $diachi, $ghichu, $soluong) {
    global $conn;
    $sql_hd = "INSERT INTO hoadon (ngay, tongtien, makh, diachi, ghichu, soluong) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_hd = mysqli_prepare($conn, $sql_hd);
    if (!$stmt_hd) return false;
    mysqli_stmt_bind_param($stmt_hd, "siissi", $ngay, $tongtien, $makh, $diachi, $ghichu, $soluong);
    if (!mysqli_stmt_execute($stmt_hd)) {
        mysqli_stmt_close($stmt_hd);
        return false;
    }
    $mahd = mysqli_insert_id($conn);
    mysqli_stmt_close($stmt_hd);

    foreach ($dssanpham as $sp) {
        $masp = $sp['id'];
        $soluong = $sp['quantity'];
        $gia = $sp['gia'] - ($sp['gia'] * $sp['giamgia']);
        $size = $sp['size'];
        $mau = $sp['mamau'] ?? '';
        $sql_cthd = "INSERT INTO chitiethoadon (masp, soluong, gia, size, mau, mahoadon) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_cthd = mysqli_prepare($conn, $sql_cthd);
        if (!$stmt_cthd) continue;
        mysqli_stmt_bind_param($stmt_cthd, "iiissi", $masp, $soluong, $gia, $size, $mau, $mahd);
        mysqli_stmt_execute($stmt_cthd);
        mysqli_stmt_close($stmt_cthd);
    }
    return true;
}
