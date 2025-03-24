<?php
include(__DIR__ . "/../../config/db.php");



// Hàm Lấy Danh Sách Đơn Hàng
function getOrders() {
    global $conn;
    $sql = "SELECT hoadon.* FROM hoadon 
            ORDER BY hoadon.ngay_dat DESC";
    $result = $conn->query($sql);
    return $result;
}

// Hàm lấy chi tiết đơn hàng
function getOrderDetails($order_id) {
    global $conn;

    $sql = "
        SELECT 
            hd.id,
            kh.hoten AS customer_name,
            sp.tensp AS product_name,
            sp.gia AS product_price,
            chitiet_hd.soluong,
            chitiet_hd.size,
            (sp.gia * chitiet_hd.soluong) AS total_price,
            chitiet_hd.phuongthucthanhtoan,
            hd.order_status
        FROM chitiethoadon chitiet_hd
        JOIN hoadon hd ON chitiet_hd.id_hoadon = hd.id
        JOIN khachhang kh ON hd.id_khachhang = kh.makh
        JOIN sanpham sp ON chitiet_hd.id_sanpham = sp.id
        WHERE hd.id = ?
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
            hd.id,
            kh.hoten AS customer_name,
            sp.tensp AS product_name,
            sp.gia AS product_price,
            chitiet_hd.soluong,
            chitiet_hd.size,
            (sp.gia * chitiet_hd.soluong) AS total_price,
            chitiet_hd.phuongthucthanhtoan,
            hd.status
        FROM chitiethoadon chitiet_hd
        JOIN hoadon hd ON chitiet_hd.id_hoadon = hd.id
        JOIN khachhang kh ON hd.id_khachhang = kh.makh
        JOIN sanpham sp ON chitiet_hd.id_sanpham = sp.id
        WHERE hd.id = ?
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
