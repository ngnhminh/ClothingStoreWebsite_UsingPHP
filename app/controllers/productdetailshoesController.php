<?php
include __DIR__ . '/../../config/db.php';
header('Content-Type: application/json');

// Lấy dữ liệu từ request (POST hoặc GET)
$data = json_decode(file_get_contents("php://input"), true) ?? [];
$action = $data['action'] ?? ($_GET['action'] ?? '');
$id = $data["id"] ?? ($_GET["id"] ?? null);
$maloai = $data["maloai"] ?? ($_GET["maloai"] ?? null);
$mamau = $data["mamau"] ?? ($_GET["mamau"] ?? null);
$masp = $data["masp"] ?? ($_GET["masp"] ?? null);
$matk = $data["matk"] ?? ($_GET["matk"] ?? null);

switch ($action) {
    case 'getProductDetail':
        $productdetail = getProductdetail($id);
        $productdetailInform = getProductDetailInform($id);
        $productdetailSize = getProductSizeInform($id);
        $getProductColor = getProductColor($id);
        $getSizeOfProductColor = getSizeOfProductColor($id, $mamau);
        $getImageOfProductByColor = getImageOfProductByColor($mamau, $id);
        $dsspcungloai = getAllByType($maloai, $id);

        if (!empty($productdetail) && !empty($productdetailSize)) {
            echo json_encode([
                'success' => true,
                'product' => $productdetail[0],
                'productdetailInform' => $productdetailInform,
                'productDetailSize' => $productdetailSize,
                'getSizeOfProductColor' => $getSizeOfProductColor,
                'getProductColor' => $getProductColor,
                'getImageOfProductByColor' => $getImageOfProductByColor,
                'dsspcungloai' => $dsspcungloai
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Lấy thông tin thất bại'
            ]);
        }
        break;

    case 'getProductColors':
        echo json_encode(getProductColor($id));
        break;

    case 'getProductSizes':
        echo json_encode(getProductSizeInform($id));
        break;

    case 'getProductImagesByColor':
        echo json_encode(getImageOfProductByColor($mamau, $id));
        break;

    case 'getSizesByColor':
        echo json_encode(getSizeOfProductColor($id, $mamau));
        break;

    case 'getRelatedProducts':
        echo json_encode(getAllByType($maloai, $id));
        break;

    case 'addFavProduct':
        $success = addFavProduct($masp, $matk);
        echo json_encode([
            'success' => $success,
            'message' => $success ? 'Đã thêm vào danh sách yêu thích' : 'Sản phẩm đã tồn tại trong danh sách'
        ]);
        break;

    case 'isAlreadyFav':
        $success = isAlreadyFav($masp, $matk);
        echo json_encode([
            'success' => $success,
            'message' => $success ? 'Đã thêm vào danh sách yêu thích' : 'Sản phẩm đã tồn tại trong danh sách'
        ]);
        break;
        
    default:
        echo json_encode([
            'success' => false,
            'message' => 'Không tìm thấy hành động phù hợp'
        ]);
        break;
}

exit;

function getProductdetail($id){
    global $conn;
    $sql = "SELECT * 
            FROM hinhanh h1
            JOIN (
                SELECT sanpham.tensp, sanpham.id, sanpham.maloai_id, loaisanpham.tenloai, sanpham.gia, sanpham.mota, sanpham.giamgia,
                    MIN(hinhanh.mahinhanh) AS min_id
                FROM hinhanh 
                INNER JOIN mausanpham ON hinhanh.mau_sanpham_id = mausanpham.id
                INNER JOIN sanpham ON sanpham.id = mausanpham.masp_id
                INNER JOIN loaisanpham ON loaisanpham.maloai = sanpham.maloai_id
                WHERE sanpham.matinhtrang = 1 AND sanpham.id = ?
                GROUP BY sanpham.id, sanpham.maloai_id
            ) h2 ON h1.mahinhanh = h2.min_id;";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $data;
}

function getProductDetailInform($masp){
    global $conn; // Sử dụng kết nối MySQLi
    $sql = "SELECT chitietsanpham.chitiet, chitietsanpham.id from sanpham
            INNER JOIN chitietsanpham ON sanpham.id = chitietsanpham.masp_id
            WHERE sanpham.id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die("Lỗi chuẩn bị truy vấn: " . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmt, "s", $masp);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $data;
}

function getProductSizeInform($masp){
    global $conn; // Sử dụng kết nối MySQLi
    $sql = "SELECT * from tenkichco 
            INNER JOIN sanpham ON tenkichco.loaisanpham_id = sanpham.maloai_id
            WHERE sanpham.id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die("Lỗi chuẩn bị truy vấn: " . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmt, "s", $masp);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $data;
}

function getProductColor($masp){
    global $conn; // Sử dụng kết nối MySQLi
    $sql = "SELECT * from mau
            INNER JOIN mausanpham ON mau.id = mausanpham.mau_id
            WHERE mausanpham.masp_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die("Lỗi chuẩn bị truy vấn: " . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmt, "s", $masp);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $data;
}

function getSizeOfProductColor($masp, $mamau){
    global $conn; // Sử dụng kết nối MySQLi
    $sql = "SELECT * FROM sanpham 
            INNER JOIN mausanpham ON sanpham.id = mausanpham.masp_id
            INNER JOIN kichco ON kichco.mau_sanpham_id = mausanpham.id
            INNER JOIN mau ON mau.id = mausanpham.mau_id
            WHERE sanpham.id = ? AND mau.mamau = ?
            ORDER BY kichco.kichco_id ASC";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die("Lỗi chuẩn bị truy vấn: " . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmt, "ss", $masp, $mamau);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $data;
}

function getImageOfProductByColor($mamau, $masp_id){
    global $conn; // Sử dụng kết nối MySQLi
    $sql = "SELECT * from hinhanh 
            INNER JOIN mausanpham ON hinhanh.mau_sanpham_id = mausanpham.id
            INNER JOIN mau ON mausanpham.mau_id = mau.id
            WHERE mau.mamau = ? && mausanpham.masp_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die(json_encode(["error" => "Lỗi chuẩn bị truy vấn: " . mysqli_error($conn)]));
    }
    
    mysqli_stmt_bind_param($stmt, "si", $mamau, $masp_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $data;
}

function getAllByType($loaisanpham, $masp) {
    global $conn; // Sử dụng kết nối MySQLi
    $sql = "SELECT * 
            FROM hinhanh h1
            JOIN (
                SELECT sanpham.tensp, sanpham.id, sanpham.maloai_id, loaisanpham.tenloai, sanpham.mota, sanpham.gia, sanpham.giamgia,
                    MIN(hinhanh.mahinhanh) AS min_id
                FROM hinhanh 
                INNER JOIN mausanpham ON hinhanh.mau_sanpham_id = mausanpham.id
                INNER JOIN sanpham ON sanpham.id = mausanpham.masp_id
                INNER JOIN loaisanpham ON loaisanpham.maloai = sanpham.maloai_id
                WHERE sanpham.maloai_id = ? AND sanpham.matinhtrang = 1 AND sanpham.id != ?
                GROUP BY sanpham.id, sanpham.maloai_id
            ) h2 ON h1.mahinhanh = h2.min_id;";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die("Lỗi chuẩn bị truy vấn: " . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmt, "ii", $loaisanpham, $masp);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $data;
}

function isAlreadyFav($masp, $matk) {
    global $conn;
    $sql = "SELECT 1 FROM danhsachyeuthich WHERE masp = ? AND matk = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $masp, $matk);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $exists = mysqli_stmt_num_rows($stmt) > 0;
    mysqli_stmt_close($stmt);
    return $exists;
}

function addFavProduct($masp, $matk) {
    if (isAlreadyFav($masp, $matk)) return false;

    global $conn;
    $sql = "INSERT INTO danhsachyeuthich (masp, matk) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) return false;
    mysqli_stmt_bind_param($stmt, "ii", $masp, $matk);
    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $success;
}

?>