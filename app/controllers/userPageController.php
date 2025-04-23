<?php
include __DIR__ . '/../../config/db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
$action = $data['action'] ?? ($_GET['action'] ?? '');

switch ($action) {
    case 'changePassword':
        $matkhau = $data["matkhau"] ?? null;
        $matk = $data["matk"] ?? null;
        $success = changePassword($matkhau, $matk);
        echo json_encode(["success" => $success]);
        break;

    case 'getHoaDonByMatk':
        $matk = $_GET["matk"] ?? null;
        $getHoaDonByMatk = getHoaDonByMatk($matk);
        echo json_encode([
            'success' => !empty($getHoaDonByMatk),
            'getHoaDonByMatk' => $getHoaDonByMatk ?? null
        ]);
        break;

    case 'getSanPhamYeuThichByMatk':
        $matk = $_GET["matk"] ?? null;
        $getSanPhamYeuThichByMatk = getSanPhamYeuThichByMatk($matk);
        echo json_encode([
            'success' => !empty($getSanPhamYeuThichByMatk),
            'getSanPhamYeuThichByMatk' => $getSanPhamYeuThichByMatk ?? null
        ]);
        break;

    case 'deleteSanPhamYeuThich':
        $matk = $data["matk"] ?? null;
        $masp = $data["masp"] ?? null;
        $success = deleteSanPhamYeuThich($matk, $masp);
        echo json_encode(["success" => $success]);
        break;

    case 'getChiTietHoaDonByMaHoaDon':
        $mahoadon = $_GET["orderid"] ?? null;
        $getChiTietHoaDonByMaHoaDon = getChiTietHoaDonByMaHoaDon($mahoadon);
        echo json_encode([
            'success' => !empty($getChiTietHoaDonByMaHoaDon),
            'getChiTietHoaDonByMaHoaDon' => $getChiTietHoaDonByMaHoaDon ?? null
        ]);
        break;

    default:
        echo json_encode(["success" => false, "message" => "Action không hợp lệ"]);
        break;
}

function changePassword($matkhau, $matk)
{
    global $conn;
    if (!$matkhau || !$matk) return false;

    // Nếu muốn mã hóa mật khẩu:
    // $matkhau = password_hash($matkhau, PASSWORD_DEFAULT);

    $sql = "UPDATE taikhoan SET matkhau = ? WHERE matk = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) return false;

    mysqli_stmt_bind_param($stmt, "si", $matkhau, $matk);
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $result;
}

function getHoaDonByMatk($matk)
{
    global $conn;
    $sql = "SELECT * 
            FROM hoadon 
            INNER JOIN khachhang ON hoadon.makh = khachhang.makh
            INNER JOIN taikhoan ON taikhoan.makh = khachhang.makh
            WHERE taikhoan.matk = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) die("Lỗi chuẩn bị truy vấn: " . mysqli_error($conn));
    mysqli_stmt_bind_param($stmt, "i", $matk);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $data;
}

function getSanPhamYeuThichByMatk($matk)
{
    global $conn;
    $sql = "SELECT * 
            FROM hinhanh h1
            JOIN (
                SELECT sanpham.tensp, sanpham.id, sanpham.maloai_id, loaisanpham.tenloai, sanpham.gia, sanpham.giamgia,
                    MIN(hinhanh.mahinhanh) AS min_id
                FROM hinhanh 
                INNER JOIN mausanpham ON hinhanh.mau_sanpham_id = mausanpham.id
                INNER JOIN sanpham ON sanpham.id = mausanpham.masp_id
                INNER JOIN loaisanpham ON loaisanpham.maloai = sanpham.maloai_id
                INNER JOIN danhsachyeuthich ON danhsachyeuthich.masp = sanpham.id
                WHERE danhsachyeuthich.matk = ?
                GROUP BY sanpham.id, sanpham.maloai_id
            ) h2 ON h1.mahinhanh = h2.min_id;";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) die("Lỗi chuẩn bị truy vấn: " . mysqli_error($conn));
    mysqli_stmt_bind_param($stmt, "i", $matk);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $data;
}

function getChiTietHoaDonByMaHoaDon($mahoadon)
{
    global $conn;
    $sql = "SELECT h2.*, h1.duongdananh, cthd.soluong, cthd.size, hd.*
            FROM hinhanh h1
            JOIN (
                SELECT sanpham.tensp, sanpham.id, sanpham.maloai_id, loaisanpham.tenloai, sanpham.gia, sanpham.giamgia,
                    MIN(hinhanh.mahinhanh) AS min_id
                FROM hinhanh 
                INNER JOIN mausanpham ON hinhanh.mau_sanpham_id = mausanpham.id
                INNER JOIN sanpham ON sanpham.id = mausanpham.masp_id
                INNER JOIN loaisanpham ON loaisanpham.maloai = sanpham.maloai_id
                INNER JOIN chitiethoadon ON chitiethoadon.masp = sanpham.id
                WHERE chitiethoadon.mahoadon = ?
                GROUP BY sanpham.id, sanpham.maloai_id, sanpham.tensp, sanpham.gia, sanpham.giamgia, loaisanpham.tenloai
            ) h2 ON h1.mahinhanh = h2.min_id
            JOIN chitiethoadon cthd ON h2.id = cthd.masp AND cthd.mahoadon = ?
            JOIN hoadon hd ON cthd.mahoadon = hd.id;";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) die("Lỗi chuẩn bị truy vấn: " . mysqli_error($conn));
    mysqli_stmt_bind_param($stmt, "ii", $mahoadon, $mahoadon);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $data;
}

function deleteSanPhamYeuThich($matk, $masp)
{
    global $conn;
    $sql = "DELETE FROM danhsachyeuthich
            WHERE matk = ? AND masp = ?;
            ";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) die("Lỗi chuẩn bị truy vấn: " . mysqli_error($conn));
    mysqli_stmt_bind_param($stmt, "ii", $matk, $masp);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $result;
}
