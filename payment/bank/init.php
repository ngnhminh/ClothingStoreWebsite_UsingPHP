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
    payment_id
) VALUES (?,?,?,?,?,?,?,?,?,?,?)");

$statement->execute([
    $_SESSION['customer']['cust_id'],
    $_SESSION['customer']['cust_name'],
    $_SESSION['customer']['cust_email'],
    $payment_date,
    '',
    $_POST['amount'],
    '',
    $_POST['payment_method'],
    'Pending',
    'Pending',
    $payment_id
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
