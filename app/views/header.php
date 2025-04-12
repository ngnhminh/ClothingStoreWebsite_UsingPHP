<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/css/header.css">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/js/header.js"></script>
</head>
<body>
    <div class="header">
        <img id="logo_img" src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/images/logo.png" alt="Lỗi hình ảnh không thể hiển thị"></a>
 
        <!--Ô chứa menu-->
        <nav class="menu">
            <a href="index.php">Trang chủ</a>
            <a href="productpage.php">Thời trang<i id="dropdown_icon" class="fa-solid fa-angle-down"></i></a>
            <a href="productpage.php">Áo<i id="dropdown_icon" class="fa-solid fa-angle-down"></i></a>
            <a href="productpage.php">Quần<i id="dropdown_icon" class="fa-solid fa-angle-down"></i></a>
            <a href="productpage.php">Giày<i id="dropdown_icon" class="fa-solid fa-angle-down"></i></a>
            <a href="productpage.php">Kính<i id="dropdown_icon" class="fa-solid fa-angle-down"></i></a>
            <a href="/pages/services.php">Giới thiệu</a>
            <a href="/pages/contact.php">Liên hệ</a>
        </nav>

        <!-- Ô chứa nút đăng kí và đăng nhập -->
        <div id="dangkivadangnhap">
            <div id="user-info" style="display: none;">
                <span>Xin chào,</span><span id="welcome-text"></span>
                <button class="button" onclick="logout()">Đăng xuất</button>
            </div>
            <!-- <div id="auth-buttons">
                <button class="button" onclick="window.location.href='register.php'">Đăng kí</button>
                <button class="button" onclick="window.location.href='login.php'">Đăng nhập</button>
            </div> -->
            <a href="#"><i id="cart_icon" class="fa-solid fa-magnifying-glass"></i></a>
            <a href="#"><i id="cart_icon" class="fa-solid fa-user"></i></a>
            <a href="cart.php">
                <i id="cart_icon" class="fa-solid fa-bag-shopping"></i>
                <span class="cart_number">0</span>
            </a>
        </div>
    </div>
</body>