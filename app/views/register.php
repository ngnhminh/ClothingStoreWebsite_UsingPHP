<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/css/register.css">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2&display=swap" rel="stylesheet">
    <title>Đăng kí</title>
</head>
<body>
    <header>
        <?php require 'header.php'; ?>
    </header>
    <main>
        <div class="signup-container">
            <div  id="background_image">
                <img src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/images/background2.jpg" alt="Lỗi hiển thị">
            </div>
            <div class="signup-box">
                <h2>Đăng Ký</h2>
                <form id="register-form" action="signup.php" method="post">
                    <label for="fullname">Họ và tên</label>
                    <input type="text" id="fullname" name="fullname" required>

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                    
                    <label for="user">Tài khoản</label>
                    <input type="text" id="user" name="user" required>

                    <label for="phone">Số điện thoại</label>
                    <input type="text" id="phone" name="phone" required>

                    <label for="password">Mật khẩu</label>
                    <input type="password" id="password" name="password" required>

                    <label for="confirm_password">Xác nhận mật khẩu</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>

                    <button type="submit" class="signup-button">Đăng Ký</button>
                    <button type="button" class="facebook-signup">Đăng ký với Facebook</button>
                </form>
                <a href="login.php">Đã có tài khoản? Đăng nhập</a>
            </div>
        </div>
    </main>
    <footer>
        <?php require 'footer.php'; ?>
    </footer>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/js/register.js"></script>
</body>
</html>