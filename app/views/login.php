<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/css/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Đăng kí</title>
</head>

<body>
    <?php require 'header.php'; ?>
    <main>
        <div class="login-container">
            <div id="background_image">
                <img src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/images/background.jpg" alt="Lỗi hiển thị">
            </div>
            <div class="login-box">
                <h2>Đăng nhập</h2>
                <form id="login-form" action="login.php" method="post">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" required>

                    <label for="password">Mật khẩu</label>
                    <input type="password" id="password" name="password" required>

                    <button type="submit" class="login-button">Đăng nhập</button>
                </form>
                <a href="register.php">Tạo tài khoản</a>
                <a href="forgot_password.php">Quên mật khẩu?</a>
            </div>
        </div>
    </main>

    <?php require 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/js/login.js"></script>

</body>

</html>