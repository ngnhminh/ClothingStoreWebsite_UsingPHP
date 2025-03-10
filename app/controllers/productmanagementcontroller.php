<?php
require_once('D:\Workspace\PHP Projects\ClothingStore\config\db.php');// Gọi kết nối database

function getAllProducts() {
    global $conn; // Dùng biến $conn từ database.php

    $stmt = $conn->prepare("SELECT *
                            FROM hinhanh h1
                            JOIN (
                                SELECT masp, mau_id, MIN(mahinhanh) AS min_id
                                FROM hinhanh
                                GROUP BY masp, mau_id
                            ) h2 ON h1.mahinhanh = h2.min_id 
                            INNER JOIN sanpham ON sanpham.masp = h1.masp;");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllByType($loaisanpham) {
    global $conn; // Dùng biến $conn từ database.php
    $stmt = $conn->prepare("SELECT *
                            FROM hinhanh h1
                            JOIN (
                                SELECT masp, mau_id, MIN(mahinhanh) AS min_id
                                FROM hinhanh
                                GROUP BY masp, mau_id
                            ) h2 ON h1.mahinhanh = h2.min_id 
                            INNER JOIN sanpham ON sanpham.masp = h1.masp
                            INNER JOIN loaisanpham ON sanpham.maloai = loaisanpham.maloai
                            WHERE loaisanpham.tenloai = :loaisanpham");

    $stmt->bindValue(':loaisanpham', $loaisanpham, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
