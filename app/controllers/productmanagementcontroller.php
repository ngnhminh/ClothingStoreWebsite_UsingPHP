<?php
require_once('D:\Workspace\PHP Projects\ClothingStore\config\db.php');// Gọi kết nối database

function getAllProducts() {
    global $conn; 
    $sql = "SELECT *
            FROM hinhanh h1
            JOIN (
                SELECT masp, mau_id, MIN(mahinhanh) AS min_id
                FROM hinhanh
                GROUP BY masp, mau_id
            ) h2 ON h1.mahinhanh = h2.min_id 
            INNER JOIN sanpham ON sanpham.masp = h1.masp";

    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Lỗi truy vấn: " . mysqli_error($conn));
    }
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function getAllByType($loaisanpham) {
    global $conn; // Sử dụng kết nối MySQLi
    $sql = "SELECT * 
            FROM hinhanh h1
            JOIN (
                SELECT masp, mau_id, MIN(mahinhanh) AS min_id
                FROM hinhanh
                GROUP BY masp, mau_id
            ) h2 ON h1.mahinhanh = h2.min_id 
            INNER JOIN sanpham ON sanpham.masp = h1.masp
            INNER JOIN loaisanpham ON sanpham.maloai = loaisanpham.maloai
            WHERE loaisanpham.tenloai = ?";
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



if (isset($_GET['function'])) {
    $functionName = $_GET['function'];
    $params = isset($_GET['params']) ? explode(',', $_GET['params']) : []; // Lấy danh sách tham số

    if (function_exists($functionName)) {
        echo "Tồn tại hàm";
    } else {
        echo "Hàm không tồn tại!";
    }
}
?>
