<?php
include $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';
function getAllProducts() {
    global $conn; 
    $sql = "SELECT * 
            FROM hinhanh h1
            JOIN (
                SELECT sanpham.tensp, sanpham.masp, hinhanh.mau_sanpham_id, sanpham.maloai_id, loaisanpham.tenloai, sanpham.gia, MIN(hinhanh.mahinhanh) AS min_id
                FROM hinhanh 
                INNER JOIN mausanpham ON hinhanh.mau_sanpham_id = mausanpham.id
                INNER JOIN sanpham ON sanpham.masp = mausanpham.masp_id
                INNER JOIN loaisanpham ON loaisanpham.maloai = sanpham.maloai_id
                GROUP BY sanpham.masp, hinhanh.mau_sanpham_id, sanpham.maloai_id
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
                SELECT sanpham.tensp, sanpham.masp, hinhanh.mau_sanpham_id, sanpham.maloai_id, loaisanpham.tenloai, MIN(hinhanh.mahinhanh) AS min_id
                FROM hinhanh 
                INNER JOIN mausanpham ON hinhanh.mau_sanpham_id = mausanpham.id
                INNER JOIN sanpham ON sanpham.masp = mausanpham.masp_id
                INNER JOIN loaisanpham ON loaisanpham.maloai = sanpham.maloai_id
                WHERE loaisanpham.tenloai = ?
                GROUP BY sanpham.masp, hinhanh.mau_sanpham_id, sanpham.maloai_id
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
            INNER JOIN mausanpham ON sanpham.masp = mausanpham.masp_id
            INNER JOIN kichco ON kichco.mau_sanpham_id = mausanpham.id
            WHERE sanpham.masp= ?
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
                SELECT sanpham.tensp, sanpham.masp, hinhanh.mau_sanpham_id, sanpham.maloai_id, loaisanpham.tenloai, sanpham.gia, MIN(hinhanh.mahinhanh) AS min_id
                FROM hinhanh 
                INNER JOIN mausanpham ON hinhanh.mau_sanpham_id = mausanpham.id
                INNER JOIN sanpham ON sanpham.masp = mausanpham.masp_id
                INNER JOIN loaisanpham ON loaisanpham.maloai = sanpham.maloai_id
                WHERE sanpham.masp= ?
                GROUP BY sanpham.masp, hinhanh.mau_sanpham_id, sanpham.maloai_id
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

if (isset($_GET['function'])) {
    $functionName = $_GET['function'];
    $params = isset($_GET['params']) ? explode(',', $_GET['params']) : []; // Lấy danh sách tham số

    if (function_exists($functionName)) {
        $result = call_user_func_array($functionName, $params); // Gọi hàm với tham số
        echo json_encode($result);
    } else {
        echo "Hàm không tồn tại!";
    }
}
?>
