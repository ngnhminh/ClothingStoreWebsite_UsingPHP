<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/public/assets/css/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2&display=swap" rel="stylesheet">
    <title>Đăng kí</title>
</head>
<body>
    <header>
        <?php require 'header.php'; ?>
    </header>
    <main>
        <div class="login-container">
            <div  id="background_image">
                <img src="/public/assets/images/background.jpg" alt="Lỗi hiển thị">
            </div>
            <div class="login-box">
                <h2>Đăng nhập</h2>
                <form action="login.php" method="post">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                    <label for="password">Mật khẩu</label>
                    <input type="password" id="password" name="password" required>
                    <button type="submit" class="login-button">Đăng nhập</button>
                    <button type="button" class="facebook-login">Tiếp tục với Facebook</button>
                </form>
                <a href="register.php">Tạo tài khoản</a>
                <a href="forgot_password.php">Quên mật khẩu?</a>
            </div>
        </div>
    </main>
    <footer>
        <?php require 'footer.php'; ?>
    </footer>
</body>
</html>