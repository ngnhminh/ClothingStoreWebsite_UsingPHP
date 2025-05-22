<?php
require_once('header.php');

if (isset($_GET['id'])) {
    $product_id = (int)$_GET['id'];

    $statement = $pdo->prepare("UPDATE tbl_product SET p_is_active = 1 WHERE p_id = ?");
    $statement->execute([$product_id]);

    header("Location: product.php?message=Product_activated_successfully");
    exit;
} else {
    header("Location: product.php");
    exit;
}
?>
