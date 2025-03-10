<?php
include $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';



$sql = "SELECT * FROM sanpham";
$result = mysqli_query($conn, $sql);
echo "Kết Nối Thành Công";

while ($row = mysqli_fetch_assoc($result)) {
    echo "Tên sản phẩm: " . $row['ten_sanpham'] . "<br>";
  
}
?>
