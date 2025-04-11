<?php
include $_SERVER['DOCUMENT_ROOT'] . '/ClothingStoreWebsite_UsingPHP/config/db.php';



 function getProducts() {
    global $conn; // Sử dụng kết nối từ config.php

    $query = "SELECT 
    s.id, 
    s.tensp, 
    s.gia, 
    h.duongdananh 
FROM sanpham s
INNER JOIN mausanpham m ON s.id = m.id
INNER JOIN hinhanh h ON m.mau_id = h.mau_sanpham_id";



    $result = $conn->query($query);

    $products = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }

    return $products;
}

 function getProductsbyprice($order = 'DESC') {
    global $conn;

    $query = "SELECT s.id, s.tensp, s.gia, h.duongdananh 
              FROM sanpham s
              INNER JOIN mausanpham m ON s.id = m.masp_id
              INNER JOIN hinhanh h ON m.mau_id = h.mau_sanpham_id
              ORDER BY s.gia $order"; // Sắp xếp theo giá

    $result = $conn->query($query);

    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    return $products;
}

function getProductsByFilter($order = 'DESC', $maloai_id = null) {
    global $conn;

    $query = "SELECT * 
        FROM hinhanh h1
        JOIN (
            SELECT sanpham.tensp, sanpham.id, sanpham.maloai_id, loaisanpham.tenloai, sanpham.gia, 
                MIN(hinhanh.mahinhanh) AS min_id
            FROM hinhanh 
            INNER JOIN mausanpham ON hinhanh.mau_sanpham_id = mausanpham.id
            INNER JOIN sanpham ON sanpham.id = mausanpham.masp_id
            INNER JOIN loaisanpham ON loaisanpham.maloai = sanpham.maloai_id
            WHERE sanpham.matinhtrang = 1";

    // Thêm điều kiện lọc loại sản phẩm
    if ($maloai_id) {
        $query .= " AND sanpham.maloai_id = ?";
    }

    $query .= " GROUP BY sanpham.id, sanpham.maloai_id
        ) h2 ON h1.mahinhanh = h2.min_id
        ORDER BY h2.gia $order";

    $stmt = $conn->prepare($query);

    if ($maloai_id) {
        $stmt->bind_param("i", $maloai_id);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    return $products;
}


?>