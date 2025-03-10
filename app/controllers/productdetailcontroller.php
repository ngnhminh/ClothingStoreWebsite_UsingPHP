<!-- <?php
require_once 'db.php'; // Gọi kết nối database

function getDetailProducts($masp, $mau_id, $limit = 999) {
    global $conn; // Dùng biến $conn từ database.php

    $stmt = $conn->prepare("SELECT *
    FROM sanpham
    INNER JOIN mausanpham ON sanpham.masp = mausanpham.masp
    INNER JOIN mau ON mausanpham.mau_id = mau.mau_id
    INNER JOIN hinhanh ON hinhanh.mau_id = mau.mau_id
    INNER JOIN kichco ON kichco.mau_id = mau.mau_id
    WHERE sanpham.masp = :masp AND mau.mau_id = :mau_id
    LIMIT :limit;");
    
    // Gán giá trị cho placeholders
    $stmt->bindValue(':masp', $masp, PDO::PARAM_INT);
    $stmt->bindValue(':mau_id', $mau_id, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?> -->
