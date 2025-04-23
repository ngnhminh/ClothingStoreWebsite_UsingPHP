<link rel="stylesheet" href="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/css/header.css">

<div class="header">
    <a href="index.php">
        <img id="logo_img" src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/images/logo.png" alt="Lỗi hình ảnh không thể hiển thị"></a>
    </a>
    <!--Ô chứa menu-->
    <nav class="menu">
        <a href="index.php">Trang chủ</a>
        <a href="productpage.php">Tất cả sản phẩm</a>
        <a href="#">Giới thiệu</a>
        <a href="#">Liên hệ</a>
    </nav>

    <!-- Ô chứa nút đăng kí và đăng nhập -->
    <div id="dangkivadangnhap">
        <div id="user-info" style="display: none;">
            <div id="in4-container" onclick="goToUserPage()"><span>Xin chào, </span><span id="welcome-text"></span></div>
            <button class="button" onclick="logout()">Đăng xuất</button>
        </div>
        <div id="auth-buttons">
            <button class="button" onclick="window.location.href='register.php'">Đăng kí</button>
            <button class="button" onclick="window.location.href='login.php'">Đăng nhập</button>
        </div>
        <a href="userpage.php"><i id="cart_icon" class="fa-solid fa-user"></i></a>
        <a href="cart.php">
            <i id="cart_icon" class="fa-solid fa-bag-shopping"></i>
            <span class="cart_number">0</span>
        </a>
    </div>
</div>
<script src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/js/header.js"></script>
</body>

</html>