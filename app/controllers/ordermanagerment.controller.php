<?php
include(__DIR__ . "/../../config/db.php");

// Hàm Lấy Danh Sách Đơn Hàng
function getOrders() {
    global $conn;
    $sql = "SELECT orders.* FROM orders 
            ORDER BY orders.order_date DESC";
    $result = $conn->query($sql);
    return $result;
}

// Hàm lấy chi tiết đơn hàng
function getOrderDetails($order_id) {
    global $conn;

    $sql = "
        SELECT 
            o.order_id,
            kh.tenkh AS customer_name,
            sp.tensp AS product_name,
            sp.gia AS product_price,
            od.soluong,
            od.size,
            (sp.gia * od.soluong) AS total_price,
            od.discount,
            od.shipping_fee,
            od.payment_method,
            o.order_status
        FROM order_details od
        JOIN orders o ON od.order_id = o.order_id
        JOIN khachhang kh ON o.customer_id = kh.makh
        JOIN sanpham sp ON od.product_id = sp.id
        WHERE o.order_id = ?
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
// Kiểm tra nếu có yêu cầu lấy dữ liệu từ AJAX
if (isset($_GET['order_id'])) {
    $order_id = intval($_GET['order_id']);
    echo json_encode(getOrderDetails($order_id));
    exit();
}

// Hàm Cập Nhật Trạng Thái Đơn Hàng
function updateOrderStatus($order_id, $status) {
    global $conn;
    $sql = "UPDATE orders SET order_status = ? WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $order_id);
    return $stmt->execute();
}
// Hàm Hủy Đơn Hàng
function cancelOrder($order_id) {
    return updateOrderStatus($order_id, "Đã hủy");
}

// Hàm Khôi Phục Đơn Hàng
function restoreOrder($order_id) {
    return updateOrderStatus($order_id, "Chưa xử lý");
}

// Xử lý AJAX cập nhật trạng thái đơn hàng
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["order_id"]) && isset($_POST["status"])) {
    $order_id = $_POST["order_id"];
    $status = $_POST["status"];
    echo json_encode(["success" => updateOrderStatus($order_id, $status)]);
    exit;
}

?>
