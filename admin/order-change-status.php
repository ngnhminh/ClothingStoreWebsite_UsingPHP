<?php 
require_once('header.php'); // nếu cần session hoặc config, hoặc thay bằng include config.php

if( !isset($_REQUEST['id']) || !isset($_REQUEST['task']) ) {
	header('location: logout.php');
	exit;
}

$allowed_status = ['Pending', 'Completed', 'Cancelled'];
$task = $_REQUEST['task'];
$id = (int)$_REQUEST['id'];

if (!in_array($task, $allowed_status)) {
    header('location: logout.php');
    exit;
}

// Kiểm tra tồn tại id trong database
$statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE id=?");
$statement->execute([$id]);
$total = $statement->rowCount();

if( $total == 0 ) {
	header('location: logout.php');
	exit;
}

// Cập nhật trạng thái
$statement = $pdo->prepare("UPDATE tbl_payment SET payment_status=? WHERE id=?");
$statement->execute([$task, $id]);

header('location: order.php');
exit;
?>
