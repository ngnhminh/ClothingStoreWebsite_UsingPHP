<?php
include __DIR__ . '/../../config/db.php';
header('Content-Type: application/json');

$id = $_GET["id"] ?? null;

$productdetail = getProductdetail($id);
if (!empty($productdetail)) {
    echo json_encode([
        'success' => true,
        'product' => $productdetail[0]
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Lấy thông tin thất bại'
    ]);
}
exit;

function getProductdetail($id){
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
?>