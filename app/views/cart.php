<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/css/shared.css">
    <link rel="stylesheet" type="text/css" href="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/css/cart.css">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
                    <img src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/images/empty_cart.png" alt="Lỗi hiển thị">
                    <p>Chưa có sản phẩm trong giỏ hàng của bạn</p>
                    <button class="continue-btn">Tiếp tục mua sắm</button>
                </div>
            </div>
        </div>
        <div class="cart-wrapper" id="cart-wrapper">
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
                    <tbody id="cart-item-list">
                        <tr>
                            <td class="product-info">
                                <img src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/images/shirt.png" alt="Quần">
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
                                <img src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/images/shirt.png" alt="Quần">
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
                <div class="cart-total">
                    Tổng: <span id="total-price">0₫</span>
                </div>
                <button class="checkout-btn" id="checkout-btn">Thanh toán</button>
                <button class="continue-btn" id="continue-btn">Tiếp tục mua sắm</button>
            </div>
        </div>
    </main>
    <footer>
        <?php require 'footer.php'; ?>
    </footer>
    <script src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/js/cart.js"></script>
</body>
</html>