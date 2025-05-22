<?php require_once('header.php'); ?>

<?php
// Preventing the direct access of this page.
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_end_category WHERE ecat_id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	}
}
?>

<?php
$p_ids = [];

// Lấy tất cả product thuộc end category
$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE ecat_id=?");
$statement->execute(array($_REQUEST['id']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
	$p_ids[] = $row['p_id'];
}

if (!empty($p_ids)) {
	foreach ($p_ids as $p_id) {

		// Lấy ảnh đại diện và xóa nếu tồn tại
		$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=?");
		$statement->execute(array($p_id));
		$product = $statement->fetch(PDO::FETCH_ASSOC);
		if ($product && !empty($product['p_featured_photo']) && file_exists('../assets/uploads/'.$product['p_featured_photo'])) {
			unlink('../assets/uploads/'.$product['p_featured_photo']);
		}

		// Lấy ảnh khác của sản phẩm và xóa nếu tồn tại
		$statement = $pdo->prepare("SELECT * FROM tbl_product_photo WHERE p_id=?");
		$statement->execute(array($p_id));
		$photos = $statement->fetchAll(PDO::FETCH_ASSOC);
		foreach ($photos as $photo) {
			if (!empty($photo['photo']) && file_exists('../assets/uploads/product_photos/'.$photo['photo'])) {
				unlink('../assets/uploads/product_photos/'.$photo['photo']);
			}
		}

		// Xóa dữ liệu liên quan trong các bảng
		$statement = $pdo->prepare("DELETE FROM tbl_product WHERE p_id=?");
		$statement->execute(array($p_id));

		$statement = $pdo->prepare("DELETE FROM tbl_product_photo WHERE p_id=?");
		$statement->execute(array($p_id));

		$statement = $pdo->prepare("DELETE FROM tbl_product_size WHERE p_id=?");
		$statement->execute(array($p_id));

		$statement = $pdo->prepare("DELETE FROM tbl_product_color WHERE p_id=?");
		$statement->execute(array($p_id));

		$statement = $pdo->prepare("DELETE FROM tbl_rating WHERE p_id=?");
		$statement->execute(array($p_id));

		// Xóa thanh toán và đơn hàng liên quan sản phẩm
		$statement = $pdo->prepare("SELECT * FROM tbl_order WHERE product_id=?");
		$statement->execute(array($p_id));
		$orders = $statement->fetchAll(PDO::FETCH_ASSOC);
		foreach ($orders as $order) {
			$statement1 = $pdo->prepare("DELETE FROM tbl_payment WHERE payment_id=?");
			$statement1->execute(array($order['payment_id']));
		}

		$statement = $pdo->prepare("DELETE FROM tbl_order WHERE product_id=?");
		$statement->execute(array($p_id));
	}
}

// Xóa end category
$statement = $pdo->prepare("DELETE FROM tbl_end_category WHERE ecat_id=?");
$statement->execute(array($_REQUEST['id']));

header('location: end-category.php');
exit;
?>
