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
        $giamgia = $data['giamgia'] ?? null;
        $diemdasudung = $data['diemdasudung'] ?? null;
        $tamtinh = $data['tamtinh'] ?? null;
        $tenmagiamgia = $data['tenmagiamgia'] ?? null;
        $magiamgiaId = $data['magiamgiaId'] ?? null;
        $createOrder = createOrderAndOrderDetail($ngay, $tongtien, $makh, $dssanpham, $diachi, $ghichu, $soluong, $giamgia, $diemdasudung, $tamtinh, $tenmagiamgia, $magiamgiaId);
        echo json_encode([
            'success' => $createOrder
        ]);
        break;
    
    case 'updatePoint':
        $matk = $data["matk"] ?? null;
        $point = $data['point'] ?? null;
        $updatePoint = updatePoint($matk, $point);
        echo json_encode([
            'success' => $updatePoint
        ]);
        break;
    
    case 'getUser':
        $matk = $data["matk"] ?? null;
        $getUser = getUser($matk);
        echo json_encode([
            'success' => !empty($getUser),
            'getUser' => $getUser[0] ?? null
        ]);
        break;

    case 'getProductSizeInform':
        $masp = $data["masp"] ?? null;
        $tenkichco = $data["tenkichco"] ?? null;
        $getProductSizeInform = getProductSizeInform($masp, $tenkichco);
        echo json_encode([
            'success' => !empty($getProductSizeInform),
            'getProductSizeInform' => $getProductSizeInform[0] ?? []
        ]);
        break;

    case 'getProductSizeInformShoes':
        $masp = $_GET["masp"] ?? null;
        $tenkichco = $_GET["tenkichco"] ?? null;
        $mamau = $_GET["mamau"] ?? null;
        $getProductSizeInformShoes = getProductSizeInformShoes($masp, $tenkichco, $mamau);
        echo json_encode([
            'success' => !empty($getProductSizeInformShoes),
            'getProductSizeInformShoes' => $getProductSizeInformShoes[0] ?? []
        ]);
        break;

    case 'updateProductSizeInform':
        $masp = $data["masp"] ?? null;
        $tenkichco = $data['tenkichco'] ?? null;
        $quantity = $data['quantity'] ?? null;
        $totalQuantity = $data['totalQuantity'] ?? null;
        $newQuantity = $totalQuantity - $quantity;
        $success = updateProductSizeInform($masp, $tenkichco, $newQuantity);
        echo json_encode([
            'success' => $success
        ]);
        break;
    
    case 'updateProductSizeInformShoes':
        $masp = $data["masp"] ?? null;
        $tenkichco = $data['tenkichco'] ?? null;
        $quantity = $data['quantity'] ?? null;
        $totalQuantity = $data['totalQuantity'] ?? null;
        $mamau = $data['mamau'] ?? null;
        $newQuantity = $totalQuantity - $quantity;
        $success = updateProductSizeInformShoes($masp, $tenkichco, $newQuantity, $mamau);
        echo json_encode([
            'success' => $success
        ]);
        break;

    case 'getCodeGiamGiaById':
        $id = $data["id"] ?? null;
        $magiamgia = getCodeGiamGiaById($id);
        echo json_encode([
            'success' => !empty($magiamgia),
            'getCodeGiamGiaById' => $magiamgia[0] ?? []
        ]);
        break;

    case 'updateCodeGiamGia':
        $id = $data["id"] ?? null;
        $soluong = $data["soluong"] ?? null;
        $updateCodeGiamGia = updateCodeGiamGia($id, $soluong);
        echo json_encode([
            'success' => $updateCodeGiamGia
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

function updateCodeGiamGia($id, $soluong){
    global $conn;
    $sql_kh = "UPDATE magiamgia
               SET soluong = ?
               WHERE id = ?";
    $stmt_kh = mysqli_prepare($conn, $sql_kh);
    if ($stmt_kh) {
        mysqli_stmt_bind_param($stmt_kh, "ii",$soluong, $id);
        if (mysqli_stmt_execute($stmt_kh)) {
            mysqli_stmt_close($stmt_kh);
            return true;
        }
        mysqli_stmt_close($stmt_kh);
    }
    return false;
}

function getCodeGiamGiaById($id){
    global $conn;
    $sql = "SELECT * from magiamgia WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) die("Lỗi chuẩn bị truy vấn: " . mysqli_error($conn));
    mysqli_stmt_bind_param($stmt, "i", $id);
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

function createOrderAndOrderDetail($ngay, $tongtien, $makh, $dssanpham, $diachi, $ghichu, $soluong, $giamgia, $diemdasudung, $tamtinh, $tenmagiamgia, $magiamgiaId) {
    global $conn;
    $sql_hd = "INSERT INTO hoadon (ngay, tongtien, makh, diachi, ghichu, soluong, giamgia, diemdasudung, tamtinh, trangthai, tenmagiamgia, magiamgiaId) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 0, ?, ?)";
    $stmt_hd = mysqli_prepare($conn, $sql_hd);
    if (!$stmt_hd) return false;
    mysqli_stmt_bind_param($stmt_hd, "siissiiiisi", $ngay, $tongtien, $makh, $diachi, $ghichu, $soluong, $giamgia, $diemdasudung, $tamtinh, $tenmagiamgia, $magiamgiaId);
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

function updatePoint($matk, $point) {
    global $conn;
    $sql_kh = "UPDATE taikhoan
               SET diemtichluy = ?
               WHERE matk = ?";
    $stmt_kh = mysqli_prepare($conn, $sql_kh);
    if ($stmt_kh) {
        mysqli_stmt_bind_param($stmt_kh, "ii", $point, $matk);
        if (mysqli_stmt_execute($stmt_kh)) {
            mysqli_stmt_close($stmt_kh);
            return true;
        }
        mysqli_stmt_close($stmt_kh);
    }
    return false;
}

function getUser($matk){
    global $conn; 
    $sql = "SELECT * 
            FROM taikhoan 
            INNER JOIN khachhang ON taikhoan.makh = khachhang.makh
            WHERE taikhoan.matk = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die("Lỗi chuẩn bị truy vấn: " . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmt, "i", $matk);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $data;
}

function getProductSizeInform($masp, $tenkichco){
    global $conn; // Sử dụng kết nối MySQLi
    $sql = "SELECT * FROM sanpham 
            INNER JOIN mausanpham ON sanpham.id = mausanpham.masp_id
            INNER JOIN kichco ON kichco.mau_sanpham_id = mausanpham.id
            WHERE sanpham.id= ? AND kichco.tenkichco = ?
            ORDER BY kichco.kichco_id ASC";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die("Lỗi chuẩn bị truy vấn: " . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmt, "is", $masp, $tenkichco);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $data;
}

function getProductSizeInformShoes($masp, $mamau, $tenkichco){
    global $conn; // Sử dụng kết nối MySQLi
    $sql = "SELECT * FROM sanpham 
            INNER JOIN mausanpham ON sanpham.id = mausanpham.masp_id
            INNER JOIN kichco ON kichco.mau_sanpham_id = mausanpham.id
            INNER JOIN mau ON mau.id = mausanpham.mau_id
            WHERE sanpham.id = ? AND mau.mamau = ? AND kichco.tenkichco = ?
            ORDER BY kichco.kichco_id ASC";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die("Lỗi chuẩn bị truy vấn: " . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmt, "iss", $masp, $mamau, $tenkichco);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $data;
}

function updateProductSizeInform($masp, $tenkichco, $newsoluong) {
    global $conn;
    $sql = "UPDATE kichco 
            INNER JOIN mausanpham ON kichco.mau_sanpham_id = mausanpham.id
            INNER JOIN sanpham ON mausanpham.masp_id = sanpham.id
            SET kichco.soluong = ?
            WHERE sanpham.id = ? AND kichco.tenkichco = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die("Lỗi chuẩn bị truy vấn: " . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmt, "iis", $newsoluong, $masp, $tenkichco);
    mysqli_stmt_execute($stmt);
    $affected = mysqli_stmt_affected_rows($stmt);
    mysqli_stmt_close($stmt);
    return $affected > 0;
}


function updateProductSizeInformShoes($masp, $tenkichco, $newsoluong, $mamau) {
    global $conn;
    $sql = "UPDATE kichco
            INNER JOIN mausanpham ON kichco.mau_sanpham_id = mausanpham.id
            INNER JOIN sanpham ON mausanpham.masp_id = sanpham.id
            INNER JOIN mau ON mau.id = mausanpham.mau_id
            SET kichco.soluong = ?
            WHERE sanpham.id = ? AND kichco.tenkichco = ? AND mau.mamau = ?";
    
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die("Lỗi chuẩn bị truy vấn: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "iiss", $newsoluong, $masp, $tenkichco, $mamau);
    mysqli_stmt_execute($stmt);
    $affected = mysqli_stmt_affected_rows($stmt);
    mysqli_stmt_close($stmt);

    return $affected > 0;
}

?>
