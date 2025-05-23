<?php
require_once('admin/inc/config.php'); // hoặc file kết nối PDO của bạn
if (!isset($_GET['mcat_id']) || !is_numeric($_GET['mcat_id'])) exit;

$mcat_id = $_GET['mcat_id'];
$stmt = $pdo->prepare("SELECT * FROM tbl_end_category WHERE mcat_id = ? ORDER BY ecat_name ASC");
$stmt->execute([$mcat_id]);
echo '<option value="">-- Tất cả --</option>';
foreach ($stmt as $row) {
    echo '<option value="'.$row['ecat_id'].'">'.$row['ecat_name'].'</option>';
}
