<?php
include $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';
function getAllProducts() {
    global $conn; 
    $sql = "SELECT * 
            FROM hinhanh h1
            JOIN (
                SELECT sanpham.tensp, sanpham.id, sanpham.maloai_id, loaisanpham.tenloai, sanpham.gia, 
                    MIN(hinhanh.mahinhanh) AS min_id
                FROM hinhanh 
                INNER JOIN mausanpham ON hinhanh.mau_sanpham_id = mausanpham.id
                INNER JOIN sanpham ON sanpham.id = mausanpham.masp_id
                INNER JOIN loaisanpham ON loaisanpham.maloai = sanpham.maloai_id
                WHERE sanpham.matinhtrang = 1
                GROUP BY sanpham.id, sanpham.maloai_id
            ) h2 ON h1.mahinhanh = h2.min_id;";
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
                SELECT sanpham.tensp, sanpham.id, sanpham.maloai_id, loaisanpham.tenloai, sanpham.gia, 
                    MIN(hinhanh.mahinhanh) AS min_id
                FROM hinhanh 
                INNER JOIN mausanpham ON hinhanh.mau_sanpham_id = mausanpham.id
                INNER JOIN sanpham ON sanpham.id = mausanpham.masp_id
                INNER JOIN loaisanpham ON loaisanpham.maloai = sanpham.maloai_id
                WHERE sanpham.matinhtrang = 0
                GROUP BY sanpham.id, sanpham.maloai_id
            ) h2 ON h1.mahinhanh = h2.min_id;";
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
                SELECT sanpham.tensp, sanpham.id, sanpham.maloai_id, loaisanpham.tenloai, sanpham.mota, 
                    MIN(hinhanh.mahinhanh) AS min_id
                FROM hinhanh 
                INNER JOIN mausanpham ON hinhanh.mau_sanpham_id = mausanpham.id
                INNER JOIN sanpham ON sanpham.id = mausanpham.masp_id
                INNER JOIN loaisanpham ON loaisanpham.maloai = sanpham.maloai_id
                WHERE loaisanpham.tenloai = ? AND sanpham.matinhtrang = 1
                GROUP BY sanpham.id, sanpham.maloai_id
            ) h2 ON h1.mahinhanh = h2.min_id;";
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
                SELECT sanpham.tensp, sanpham.id, sanpham.maloai_id, loaisanpham.tenloai, 
                    sanpham.gia, sanpham.matinhtrang, sanpham.nsx, MIN(hinhanh.mahinhanh) AS min_id
                FROM hinhanh 
                INNER JOIN mausanpham ON hinhanh.mau_sanpham_id = mausanpham.id
                INNER JOIN sanpham ON sanpham.id = mausanpham.masp_id
                INNER JOIN loaisanpham ON loaisanpham.maloai = sanpham.maloai_id
                WHERE sanpham.id = ?
                GROUP BY sanpham.id, sanpham.maloai_id
            ) h2 ON h1.mahinhanh = h2.min_id;";
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

function addColorOfProduct($mamau, $masp_id) {
    global $conn; // Sử dụng kết nối MySQLi

    if (!$masp_id || !is_numeric($masp_id)) {
        return ["success" => false, "error" => "ID sản phẩm không hợp lệ"];
    }

    error_log("Thêm màu: mamau = $mamau, masp_id = $masp_id");

    // Kiểm tra xem sản phẩm có tồn tại không
    $checkProductSql = "SELECT id FROM sanpham WHERE id = ?";
    $checkProductStmt = mysqli_prepare($conn, $checkProductSql);
    mysqli_stmt_bind_param($checkProductStmt, "i", $masp_id);
    mysqli_stmt_execute($checkProductStmt);
    mysqli_stmt_store_result($checkProductStmt);

    if (mysqli_stmt_num_rows($checkProductStmt) == 0) {
        mysqli_stmt_close($checkProductStmt);
        return ["success" => false, "error" => "ID sản phẩm không tồn tại"];
    }
    mysqli_stmt_close($checkProductStmt);

    // Kiểm tra màu đã tồn tại chưa
    $checkSql = "SELECT id FROM mau WHERE mamau = ?";
    $checkStmt = mysqli_prepare($conn, $checkSql);
    mysqli_stmt_bind_param($checkStmt, "s", $mamau);
    mysqli_stmt_execute($checkStmt);
    mysqli_stmt_store_result($checkStmt);

    if (mysqli_stmt_num_rows($checkStmt) > 0) {
        mysqli_stmt_bind_result($checkStmt, $newMauId);
        mysqli_stmt_fetch($checkStmt);
        mysqli_stmt_close($checkStmt);
    } else {
        mysqli_stmt_close($checkStmt);

        // Thêm màu mới vào bảng `mau`
        $sql = "INSERT INTO mau (mamau) VALUES (?)";
        $stmt = mysqli_prepare($conn, $sql);

        if (!$stmt) {
            return ["success" => false, "error" => "Lỗi chuẩn bị truy vấn 1: " . mysqli_error($conn)];
        }

        mysqli_stmt_bind_param($stmt, "s", $mamau);
        $success = mysqli_stmt_execute($stmt);

        if (!$success) {
            error_log("Lỗi khi thêm vào mau: " . mysqli_error($conn));
            mysqli_stmt_close($stmt);
            return ["success" => false, "error" => "Lỗi khi thêm vào `mau`: " . mysqli_error($conn)];
        }

        $newMauId = mysqli_insert_id($conn);
        mysqli_stmt_close($stmt);
    }

    error_log("Màu mới thêm có ID: $newMauId");

    // Thêm vào bảng `mausanpham`
    $sql2 = "INSERT INTO mausanpham (masp_id, mau_id) VALUES (?, ?)";
    $stmt2 = mysqli_prepare($conn, $sql2);

    if (!$stmt2) {
        return ["success" => false, "error" => "Lỗi chuẩn bị truy vấn 2: " . mysqli_error($conn)];
    }

    mysqli_stmt_bind_param($stmt2, "ii", $masp_id, $newMauId);
    $success2 = mysqli_stmt_execute($stmt2);
    mysqli_stmt_close($stmt2);

    if (!$success2) {
        error_log("Lỗi khi thêm vào mausanpham: " . mysqli_error($conn));
        return ["success" => false, "error" => "Lỗi khi thêm vào `mausanpham`: " . mysqli_error($conn)];
    }

    $newMauCuaSanPhamId = mysqli_insert_id($conn);
    error_log("Thêm vào mausanpham thành công!");

    return ["success" => true, "new_mau_id" => $newMauId, "mau_san_pham_id" => $newMauCuaSanPhamId];
}




function addSizeOfProduct($tenkichco, $soluong, $mau_sanpham_id){
    global $conn; // Sử dụng kết nối MySQLi
    $sql = "INSERT INTO kichco(tenkichco, soluong, mau_sanpham_id) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die(json_encode(["error" => "Lỗi chuẩn bị truy vấn: " . mysqli_error($conn)]));
    }
    
    mysqli_stmt_bind_param($stmt, "sii", $tenkichco, $soluong, $mau_sanpham_id);
    $success = mysqli_stmt_execute($stmt);

    $affectedRows = mysqli_stmt_affected_rows($stmt);
    mysqli_stmt_close($stmt);

    if ($success) {
        return ["success" => true, "affected_rows" => $affectedRows];
    } else {
        return ["success" => false, "error" => mysqli_error($conn)];
    }
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

function addImageOfProduct($duongdananh, $mau_sanpham_id){
    global $conn; // Sử dụng kết nối MySQLi
    $sql = "INSERT INTO hinhanh(duongdananh, mau_sanpham_id) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die(json_encode(["error" => "Lỗi chuẩn bị truy vấn: " . mysqli_error($conn)]));
    }
    
    mysqli_stmt_bind_param($stmt, "si", $duongdananh, $mau_sanpham_id);
    $success = mysqli_stmt_execute($stmt);

    $affectedRows = mysqli_stmt_affected_rows($stmt);
    mysqli_stmt_close($stmt);

    if ($success) {
        return ["success" => true, "affected_rows" => $affectedRows];
    } else {
        return ["success" => false, "error" => mysqli_error($conn)];
    }
}

function deleteProductImage($mahinhanh){
    global $conn; // Sử dụng kết nối MySQLi
    $sql = "DELETE FROM hinhanh WHERE mahinhanh=?";

    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die(json_encode(["error" => "Lỗi chuẩn bị truy vấn: " . mysqli_error($conn)]));
    }
    
    mysqli_stmt_bind_param($stmt, "i", $mahinhanh);
    $success = mysqli_stmt_execute($stmt);

    $affectedRows = mysqli_stmt_affected_rows($stmt);
    mysqli_stmt_close($stmt);

    if ($success) {
        return ["success" => true, "affected_rows" => $affectedRows];
    } else {
        return ["success" => false, "error" => mysqli_error($conn)];
    }
}

function getMauSanPhamId($masp_id, $mamau){
    global $conn; // Sử dụng kết nối MySQLi
    $sql = "SELECT mausanpham.id from mausanpham
            INNER JOIN mau ON mau.id = mausanpham.mau_id
            WHERE mausanpham.masp_id = ? AND mau.mamau = ?";

    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die(json_encode(["error" => "Lỗi chuẩn bị truy vấn: " . mysqli_error($conn)]));
    }
    
    mysqli_stmt_bind_param($stmt, "is", $masp_id, $mamau);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $data;
}

function getSanPhamByName($tensanpham){
    global $conn; // Sử dụng kết nối MySQLi
    $sql = "SELECT * 
            FROM hinhanh h1
            JOIN (
                SELECT sanpham.tensp, sanpham.id, sanpham.maloai_id, loaisanpham.tenloai, sanpham.gia, 
                    MIN(hinhanh.mahinhanh) AS min_id
                FROM hinhanh 
                INNER JOIN mausanpham ON hinhanh.mau_sanpham_id = mausanpham.id
                INNER JOIN sanpham ON sanpham.id = mausanpham.masp_id
                INNER JOIN loaisanpham ON loaisanpham.maloai = sanpham.maloai_id
                WHERE sanpham.tensp LIKE ?
                GROUP BY sanpham.id, sanpham.maloai_id
            ) h2 ON h1.mahinhanh = h2.min_id;";

    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die(json_encode(["error" => "Lỗi chuẩn bị truy vấn: " . mysqli_error($conn)]));
    }
    
    $searchParam = "%{$tensanpham}%"; //Kiếm gần đúng cho thêm % vào
    mysqli_stmt_bind_param($stmt, "s", $searchParam);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $data;
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
            "deleteProductDetail",
            "addColorOfProduct",
            "addSizeOfProduct",
            "getImageOfProductByColor",
            "deleteProductImage",
            "getMauSanPhamId",
            "addImageOfProduct",
            "getSanPhamByName"
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
