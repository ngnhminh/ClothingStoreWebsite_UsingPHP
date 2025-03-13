<?php
include $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';



 function getProducts() {
    global $conn; // Sử dụng kết nối từ config.php

    $query = "SELECT 
    s.masp, 
    s.tensp, 
    s.gia, 
    h.duongdananh 
FROM sanpham s
INNER JOIN mausanpham m ON s.masp = m.masp_id
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

    $query = "SELECT s.masp, s.tensp, s.gia, h.duongdananh 
              FROM sanpham s
              INNER JOIN mausanpham m ON s.masp = m.masp_id
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

    // Câu lệnh SQL có điều kiện lọc theo loại nếu có
    $query = "SELECT s.masp, s.tensp, s.gia, h.duongdananh 
              FROM sanpham s
              INNER JOIN mausanpham m ON s.masp = m.masp_id
              INNER JOIN hinhanh h ON m.mau_id = h.mau_sanpham_id";

    if ($maloai_id) {
        $query .= " WHERE s.maloai_id = ?";
    }

    $query .= " ORDER BY s.gia $order";

    // Sử dụng Prepared Statement để tránh SQL Injection
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