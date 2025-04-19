<?php
include(__DIR__ . "/../../config/db.php");

// Hàm Lấy Danh Sách Đơn Hàng
function getOrders() {
    global $conn;
    $sql = "SELECT hoadon.* FROM hoadon 
            ORDER BY hoadon.ngay DESC";
    $result = $conn->query($sql);
    return $result;
}

// Hàm lấy chi tiết đơn hàng
function getOrderDetails($order_id) {
    global $conn;

    $sql = "
        SELECT *
        FROM chitiethoadon
        INNER JOIN hoadon ON chitiethoadon.mahoadon = hoadon.id
        INNER JOIN khachhang ON khachhang.makh = hoadon.makh
        INNER JOIN sanpham ON sanpham.id = chitiethoadon.masp
        WHERE chitiethoadon.mahoadon = ?
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $orderDetails = [];
    while ($row = $result->fetch_assoc()) {
        $orderDetails[] = $row;
    }

    return $orderDetails;
}


if (isset($_GET['order_id'])) {
    $order_id = intval($_GET['order_id']);
    
    // Truy vấn lấy thông tin chi tiết đơn hàng
    $sql = "
            SELECT 
            chitiethoadon.soluong,
            chitiethoadon.size,
            chitiethoadon.masp,
            chitiethoadon.mahoadon,
            chitiethoadon.mau,
            chitiethoadon.gia,
            hoadon.tongtien,
            hoadon.makh,
            chitiethoadon.masp,
            hoadon.ngay,
            hoadon.diachi,
            hoadon.ghichu,
            hoadon.trangthai,
            hoadon.soluong,
            hoadon.giamgia,
            hoadon.diemdasudung,
            khachhang.hoten,
            khachhang.sdt,
            hoadon.tamtinh,
            sanpham.tensp
        FROM chitiethoadon
        INNER JOIN hoadon ON chitiethoadon.mahoadon = hoadon.id
        INNER JOIN khachhang ON khachhang.makh = hoadon.makh
        INNER JOIN sanpham ON sanpham.id = chitiethoadon.masp
        WHERE chitiethoadon.mahoadon = ?;
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $orderDetails = [];
    while ($row = $result->fetch_assoc()) {
        $orderDetails[] = $row;
    }

    // Trả về JSON
    header("Content-Type: application/json");
    echo json_encode($orderDetails);
}

?>
