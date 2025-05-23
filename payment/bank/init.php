<?php
ob_start();
session_start();
include("../../admin/inc/config.php");
include("../../admin/inc/functions.php");

if (!isset($_POST['payment_method']) || empty($_POST['payment_method'])) {
    header('Location: ../../checkout.php');
    exit;
}

$payment_date = date('Y-m-d H:i:s');
$payment_id = time();

// Kiểm tra xem người dùng có nhập địa chỉ mới không
if (!empty($_POST['use_different_address']) && $_POST['use_different_address'] == '1') {
    $customer_name = trim($_POST['new_cust_name']);
    $customer_phone = trim($_POST['new_cust_phone']);
    $customer_province = (int)$_POST['new_cust_province'];
    $customer_address = trim($_POST['new_cust_address']);

    // Nếu bạn cần lưu những thông tin này vào session hoặc database cho đơn hàng thì xử lý ở đây
} else {
    // Dùng địa chỉ hiện tại trong session
    $customer_name = $_SESSION['customer']['cust_name'];
    $customer_phone = $_SESSION['customer']['cust_phone'];
    $customer_province = $_SESSION['customer']['cust_country'];
    $customer_address = $_SESSION['customer']['cust_address'];
}

// Thêm email nếu cần, hoặc các thông tin khác từ session
$customer_email = $_SESSION['customer']['cust_email'] ?? '';

// Chèn dữ liệu thanh toán vào bảng tbl_payment (bạn cần thêm các trường mới nếu muốn lưu địa chỉ chi tiết)
// Nếu bạn chưa có trường cho địa chỉ chi tiết trong bảng tbl_payment, bạn có thể thêm 1 trường riêng để lưu địa chỉ (nên thêm trong database)
// Nếu không, bạn có thể lưu chung trong payment hoặc order (tùy cấu trúc db)

$statement = $pdo->prepare("INSERT INTO tbl_payment (
    customer_id,
    customer_name,
    customer_email,
    payment_date,
    txnid, 
    paid_amount,
    bank_transaction_info,
    payment_method,
    payment_status,
    shipping_status,
    payment_id,
    shipping_name,
    shipping_phone,
    shipping_province,
    shipping_address
) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

$statement->execute([
    $_SESSION['customer']['cust_id'],
    $customer_name,
    $customer_email,
    $payment_date,
    '',
    $_POST['amount'],
    '',
    $_POST['payment_method'],
    'Pending',
    'Pending',
    $payment_id,
    $customer_name,       // shipping_name (có thể khác customer_name nếu nhập địa chỉ mới)
    $customer_phone,      // shipping_phone
    $customer_province,    // shipping_province (int)
    $customer_address     // shipping_address
]);

// Build cart arrays
$fields = [
    'cart_p_id', 'cart_p_name', 'cart_size_name',
    'cart_color_name', 'cart_p_qty', 'cart_p_current_price'
];
foreach ($fields as $field) {
    ${'arr_' . $field} = array_values($_SESSION[$field] ?? []);
}

// Update order & stock
$statement = $pdo->prepare("SELECT p_id, p_qty FROM tbl_product");
$statement->execute();
$product_stock = $statement->fetchAll(PDO::FETCH_KEY_PAIR);

foreach ($arr_cart_p_id as $i => $product_id) {
    $statement = $pdo->prepare("INSERT INTO tbl_order (
        product_id, product_name, size, color, quantity, unit_price, payment_id
    ) VALUES (?,?,?,?,?,?,?)");

    $statement->execute([
        $product_id,
        $arr_cart_p_name[$i],
        $arr_cart_size_name[$i],
        $arr_cart_color_name[$i],
        $arr_cart_p_qty[$i],
        $arr_cart_p_current_price[$i],
        $payment_id
    ]);

    // Update stock
    if (isset($product_stock[$product_id])) {
        $new_qty = $product_stock[$product_id] - $arr_cart_p_qty[$i];
        $update = $pdo->prepare("UPDATE tbl_product SET p_qty=? WHERE p_id=?");
        $update->execute([$new_qty, $product_id]);
    }
}

// Clear cart
foreach ($fields as $field) {
    unset($_SESSION[$field]);
}

header('Location: ../../payment_success.php');
exit;
