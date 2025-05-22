<?php
require_once('inc/config.php'); // Kết nối db, tùy file của bạn

if (isset($_GET['ajax']) && $_GET['ajax'] == 1 && isset($_GET['id'])) {
    $payment_id = intval($_GET['id']);

    // Lấy thông tin đơn hàng theo payment_id
    $statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE payment_id = ?");
    $statement->execute([$payment_id]);
    $payment = $statement->fetch(PDO::FETCH_ASSOC);

    if (!$payment) {
        echo "<p>Đơn hàng không tồn tại.</p>";
        exit;
    }

    // Lấy danh sách sản phẩm trong đơn
    $statement = $pdo->prepare("SELECT * FROM tbl_order WHERE payment_id = ?");
    $statement->execute([$payment_id]);
    $orders = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Hiển thị chi tiết đơn hàng (bạn có thể tùy chỉnh theo thiết kế)
    ?>
    <h4>Thông tin đơn hàng #<?php echo htmlspecialchars($payment['payment_id']); ?></h4>
    <p><strong>Khách hàng:</strong> <?php echo htmlspecialchars($payment['customer_name']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($payment['customer_email']); ?></p>
    <p><strong>Ngày đặt:</strong> <?php echo htmlspecialchars($payment['payment_date']); ?></p>
    <p><strong>Phương thức thanh toán:</strong> <?php echo htmlspecialchars($payment['payment_method']); ?></p>
    <p><strong>Trạng thái thanh toán:</strong> <?php echo htmlspecialchars($payment['payment_status']); ?></p>
    <p><strong>Trạng thái giao hàng:</strong> <?php echo htmlspecialchars($payment['shipping_status']); ?></p>
    <hr>
    <h5>Sản phẩm trong đơn:</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Tên sản phẩm</th>
                <th>Size</th>
                <th>Màu</th>
                <th>Số lượng</th>
                <th>Giá</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $index => $item): ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                    <td><?php echo htmlspecialchars($item['size']); ?></td>
                    <td><?php echo htmlspecialchars($item['color']); ?></td>
                    <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                    <td><?php echo number_format($item['unit_price'],0,',','.').' ₫'; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <p><strong>Tổng thanh toán:</strong> <?php echo number_format($payment['paid_amount'],0,',','.').' ₫'; ?></p>
    <?php
    exit; // chỉ trả nội dung chi tiết, không load thêm phần header/footer
}
?>

<!-- Phần này nếu bạn muốn có giao diện full khi mở file order-detail.php trực tiếp -->
