<?php
include $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';
function getAllProducts() {
    global $conn; 
    $sql = "SELECT * 
            FROM hinhanh h1
            JOIN (
                SELECT sanpham.tensp, sanpham.id, hinhanh.mau_sanpham_id, sanpham.maloai_id, loaisanpham.tenloai, sanpham.gia, MIN(hinhanh.mahinhanh) AS min_id
                FROM hinhanh 
                INNER JOIN mausanpham ON hinhanh.mau_sanpham_id = mausanpham.id
                INNER JOIN sanpham ON sanpham.id = mausanpham.masp_id
                INNER JOIN loaisanpham ON loaisanpham.maloai = sanpham.maloai_id
                WHERE sanpham.matinhtrang = 1
                GROUP BY sanpham.id, hinhanh.mau_sanpham_id, sanpham.maloai_id
            ) h2 ON h1.mahinhanh = h2.min_id";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Lỗi truy vấn: " . mysqli_error($conn));
    }
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function getAllProductsBlocked() {
    global $conn; 
    $sql = "SELECT * 
            FROM hinhanh h1
            JOIN (
                SELECT sanpham.tensp, sanpham.id, hinhanh.mau_sanpham_id, sanpham.maloai_id, loaisanpham.tenloai, sanpham.gia, MIN(hinhanh.mahinhanh) AS min_id
                FROM hinhanh 
                INNER JOIN mausanpham ON hinhanh.mau_sanpham_id = mausanpham.id
                INNER JOIN sanpham ON sanpham.id = mausanpham.masp_id
                INNER JOIN loaisanpham ON loaisanpham.maloai = sanpham.maloai_id
                WHERE sanpham.matinhtrang = 0
                GROUP BY sanpham.id, hinhanh.mau_sanpham_id, sanpham.maloai_id
            ) h2 ON h1.mahinhanh = h2.min_id";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Lỗi truy vấn: " . mysqli_error($conn));
    }
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

//TRuy vấn lấy sản phẩm qua loại
function getAllByType($loaisanpham) {
    global $conn; // Sử dụng kết nối MySQLi
    $sql = "SELECT * 
            FROM hinhanh h1
            JOIN (
                SELECT sanpham.tensp, sanpham.id, hinhanh.mau_sanpham_id, sanpham.maloai_id, loaisanpham.tenloai, sanpham.mota, MIN(hinhanh.mahinhanh) AS min_id
                FROM hinhanh 
                INNER JOIN mausanpham ON hinhanh.mau_sanpham_id = mausanpham.id
                INNER JOIN sanpham ON sanpham.id = mausanpham.masp_id
                INNER JOIN loaisanpham ON loaisanpham.maloai = sanpham.maloai_id
                WHERE loaisanpham.tenloai = ? AND sanpham.matinhtrang = 1
                GROUP BY sanpham.id, hinhanh.mau_sanpham_id, sanpham.maloai_id
            ) h2 ON h1.mahinhanh = h2.min_id";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die("Lỗi chuẩn bị truy vấn: " . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmt, "s", $loaisanpham);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $data;
}

//TRuy vấn lấy số lượng và size sản phẩm qua idproduct
function getProductSizeInform($masp){
    global $conn; // Sử dụng kết nối MySQLi
    $sql = "SELECT * FROM sanpham 
            INNER JOIN mausanpham ON sanpham.id = mausanpham.masp_id
            INNER JOIN kichco ON kichco.mau_sanpham_id = mausanpham.id
            WHERE sanpham.id= ?
            ORDER BY kichco.kichco_id ASC";
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

function getProductInform($masp){
    global $conn; // Sử dụng kết nối MySQLi
    $sql = "SELECT * 
            FROM hinhanh h1
            JOIN (
                SELECT sanpham.tensp, sanpham.id, hinhanh.mau_sanpham_id, sanpham.maloai_id, loaisanpham.tenloai, sanpham.gia, sanpham.matinhtrang, MIN(hinhanh.mahinhanh) AS min_id
                FROM hinhanh 
                INNER JOIN mausanpham ON hinhanh.mau_sanpham_id = mausanpham.id
                INNER JOIN sanpham ON sanpham.id = mausanpham.masp_id
                INNER JOIN loaisanpham ON loaisanpham.maloai = sanpham.maloai_id
                WHERE sanpham.id= ?
                GROUP BY sanpham.id, hinhanh.mau_sanpham_id, sanpham.maloai_id
            ) h2 ON h1.mahinhanh = h2.min_id";
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
// i - số nguyên, s - chuỗi, d - số thực, b - nhị phân

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

function getProductDescription($masp){
    global $conn; // Sử dụng kết nối MySQLi
    $sql = "SELECT * from sanpham
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

function getTypeOfProduct($masp){
    global $conn; // Sử dụng kết nối MySQLi
    $sql = "SELECT * FROM loaisanpham
            INNER JOIN sanpham 
            ON sanpham.maloai_id = loaisanpham.maloai
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
            INNER JOIN mausanpham ON mau.mau_id = mausanpham.mau_id
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
            INNER JOIN mau ON mau.mau_id = mausanpham.mau_id
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

function getSizeName($masp){
    global $conn; // Sử dụng kết nối MySQLi
    $sql = "SELECT kichco.tenkichco, MIN(kichco.kichco_id) as kichco_id
            FROM sanpham 
            INNER JOIN mausanpham ON sanpham.id = mausanpham.masp_id
            INNER JOIN kichco ON kichco.mau_sanpham_id = mausanpham.id
            WHERE sanpham.id = ?
            GROUP BY kichco.tenkichco
            ORDER BY kichco_id ASC;";
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

function updateStatusProduct($matinhtrang, $masp){
    global $conn; // Sử dụng kết nối MySQLi
    $sql = "UPDATE sanpham 
            SET matinhtrang = ?
            WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die(json_encode(["error" => "Lỗi chuẩn bị truy vấn: " . mysqli_error($conn)]));
    }
    mysqli_stmt_bind_param($stmt, "ii", $matinhtrang, $masp);
    $success = mysqli_stmt_execute($stmt);

    // Kiểm tra số dòng bị ảnh hưởng
    $affectedRows = mysqli_stmt_affected_rows($stmt);
    mysqli_stmt_close($stmt);
    if ($success) {
        return ["success" => true, "affected_rows" => $affectedRows];
    } else {
        return ["success" => false, "error" => mysqli_error($conn)];
    }
}

function updateProduct($gia, $mota, $masp){
    global $conn; // Sử dụng kết nối MySQLi
    $sql = "UPDATE sanpham 
            SET gia = ?, mota = ? 
            WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die(json_encode(["error" => "Lỗi chuẩn bị truy vấn: " . mysqli_error($conn)]));
    }
    
    mysqli_stmt_bind_param($stmt, "isi", $gia, $mota, $masp);
    $success = mysqli_stmt_execute($stmt);

    $affectedRows = mysqli_stmt_affected_rows($stmt);
    mysqli_stmt_close($stmt);

    if ($success) {
        return ["success" => true, "affected_rows" => $affectedRows];
    } else {
        return ["success" => false, "error" => mysqli_error($conn)];
    }
}

function updateProductDetail($masp, $chitiet){
    global $conn; // Sử dụng kết nối MySQLi
    $sql = "INSERT INTO chitietsanpham(masp_id, chitiet) VALUES(?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die(json_encode(["error" => "Lỗi chuẩn bị truy vấn: " . mysqli_error($conn)]));
    }
    
    mysqli_stmt_bind_param($stmt, "is", $masp, $chitiet);
    $success = mysqli_stmt_execute($stmt);

    $affectedRows = mysqli_stmt_affected_rows($stmt);
    mysqli_stmt_close($stmt);

    if ($success) {
        return ["success" => true, "affected_rows" => $affectedRows];
    } else {
        return ["success" => false, "error" => mysqli_error($conn)];
    }
}

function deleteProductDetail($id){
    global $conn; // Sử dụng kết nối MySQLi
    $sql = "DELETE FROM chitietsanpham WHERE id=?";

    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die(json_encode(["error" => "Lỗi chuẩn bị truy vấn: " . mysqli_error($conn)]));
    }
    
    mysqli_stmt_bind_param($stmt, "i", $id);
    $success = mysqli_stmt_execute($stmt);

    $affectedRows = mysqli_stmt_affected_rows($stmt);
    mysqli_stmt_close($stmt);

    if ($success) {
        return ["success" => true, "affected_rows" => $affectedRows];
    } else {
        return ["success" => false, "error" => mysqli_error($conn)];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['function']) && isset($data['params']) && is_array($data['params'])) {
        $functionName = $data['function'];
        $params = $data['params'];

        // Chỉ cho phép gọi các hàm hợp lệ
        $allowedFunctions = [
            "getTypeOfProduct",
            "getProductDescription",
            "updateProduct",
            "getProductSizeInform",
            "getProductInform",
            "getProductDetailInform",
            "getProductColor",
            "getSizeOfProductColor",
            "getSizeName",
            "getAllByType",
            "getAllProducts",
            "getAllProductsBlocked",
            "updateStatusProduct",
            "updateProductDetail",
            "deleteProductDetail"
        ];

        if (in_array($functionName, $allowedFunctions) && function_exists($functionName)) {
            $result = call_user_func_array($functionName, $params);
            echo json_encode($result);
        } else {
            echo json_encode(["error" => "Hàm không tồn tại hoặc không được phép!"]);
        }
    } else {
        echo json_encode(["error" => "Thiếu function hoặc params không hợp lệ"]);
    }
}


?>
