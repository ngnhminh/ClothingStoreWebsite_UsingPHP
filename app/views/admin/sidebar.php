<?php
    $current_page = basename($_SERVER['PHP_SELF']);
?>

<link rel="stylesheet" href="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/css/admin/sidebar.css">

<aside class="sidebar">
    <a href="dashboard.php">
        <img id="logo_img" src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/images/logo.png" alt="Lỗi hình ảnh không thể hiển thị" />
    </a>
    <ul class="menu-admin">
        <li class="<?= ($current_page == 'dashboard.php') ? 'active' : '' ?>">
            <a href="dashboard.php">📊 Dashboard</a>
        </li>
        <li class="<?= ($current_page == 'productmanagement.php') ? 'active' : '' ?>">
            <a href="productmanagement.php">📦 Quản lý sản phẩm</a>
        </li>
        <li class="<?= ($current_page == 'ordermanagement.php') ? 'active' : '' ?>">
            <a href="ordermanagement.php">📜 Quản lý đơn hàng</a>
        </li>
        <li class="<?= ($current_page == 'customermanagement.php') ? 'active' : '' ?>">
            <a href="customermanagement.php">👥 Quản lý khách hàng</a>
        </li>
        <li class="<?= ($current_page == 'khuyenmaipage.php') ? 'active' : '' ?>">
            <a href="khuyenmaipage.php">🎟️ Quản lý khuyến mãi</a>
        </li>
        <li class="<?= ($current_page == 'historypage.php') ? 'active' : '' ?>">
            <a href="historypage.php">📈 Lịch sử</a>
        </li>
    </ul>
</aside>