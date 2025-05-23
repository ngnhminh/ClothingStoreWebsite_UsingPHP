<?php
require_once('admin/inc/config.php'); // hoặc file kết nối PDO của bạn
if (!isset($_GET['tcat_id']) || !is_numeric($_GET['tcat_id'])) exit;

$tcat_id = $_GET['tcat_id'];
$stmt = $pdo->prepare("SELECT * FROM tbl_mid_category WHERE tcat_id = ? ORDER BY mcat_name ASC");
$stmt->execute([$tcat_id]);
echo '<option value="">-- Tất cả --</option>';
foreach ($stmt as $row) {
    echo '<option value="'.$row['mcat_id'].'">'.$row['mcat_name'].'</option>';
}
