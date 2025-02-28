<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/public/assets/css/shared.css">
    <link rel="stylesheet" type="text/css" href="/public/assets/css/cart.css">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2&display=swap" rel="stylesheet">
    <title>Giỏ hàng</title>
</head>
<body>
    <header>
        <?php require 'header.php'; ?>
    </header>
    <main>
        <h2 class="pagetitle">CART</h2>
        <div class="cart_container">
            <div id="empty_cart">
                <img src="/public/assets/images/empty_cart.png" alt="Lỗi hiển thị">
                <p>Chưa có sản phẩm trong giỏ hàng của bạn</p>
                <button>Tiếp tục mua sắm</button>
            </div>
        </div>
    </main>
    <footer>
        <?php require 'footer.php'; ?>
    </footer>
</body>
</html>