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
        <div id="empty-cart" style="display:none">
            <div class="cart_container">
                <div id="empty_cart">
                    <img src="/public/assets/images/empty_cart.png" alt="Lỗi hiển thị">
                    <p>Chưa có sản phẩm trong giỏ hàng của bạn</p>
                    <button>Tiếp tục mua sắm</button>
                </div>
            </div>
        </div>
        <div class="cart-wrapper">
            <!-- Ô chứa sản phẩm -->
            <div id="having-cart">
                <!-- Nội dung giỏ hàng -->
                <table>
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Giá</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="product-info">
                                <img src="/public/assets/images/shirt.png" alt="Quần">
                                <div>
                                    <span>Distressed Double Knee Denim Pants Brown</span>
                                </div>
                            </td>
                            <td>
                                <button class="qty-btn">−</button>
                                <input type="text" value="1" class="qty-input">
                                <button class="qty-btn">+</button>
                            </td>
                            <td class="price">250.000đ <i class="fas fa-trash-alt delete-icon"></i></tdclass>
                        </tr>

                        <tr>
                            <td class="product-info">
                                <img src="/public/assets/images/shirt.png" alt="Quần">
                                <div>
                                    <span>Distressed Double Knee Denim Pants Brown</span>
                                </div>
                            </td>
                            <td>
                                <button class="qty-btn">−</button>
                                <input type="text" value="1" class="qty-input">
                                <button class="qty-btn">+</button>
                            </td>
                            <td class="price">250.000đ <i class="fas fa-trash-alt delete-icon"></i></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Ô thông tin thanh toán -->
            <div class="checkout">
                <div id="total-money-in-cart">
                    <h3>Tổng tiền</h3>
                    <p><strong>500.000đ</strong></p>
                </div>
                <button class="checkout-btn">Thanh toán</button>
                <button class="continue-btn">Tiếp tục mua sắm</button>
            </div>
        </div>
    </main>
    <footer>
        <?php require 'footer.php'; ?>
    </footer>
</body>
</html>