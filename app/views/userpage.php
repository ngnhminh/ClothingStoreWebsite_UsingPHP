<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/public/assets/css/userpage.css">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2&display=swap" rel="stylesheet">
    <title>Trang hàng</title>
</head>
<body>
    <header>
        <?php require 'header.php'; ?>
    </header>
    <main>
    <main class="infoproduct_container">
        <h2 id="userpage-title">Danh sách sản phẩm yêu thích</h2><br> 
        <div class="wishlist">
            <table>
                <!-- Tiêu đề sản phẩm yêu thích -->
                <thead>
                    <tr id="fav-product-navbar">
                        <th>Sản phẩm</th>
                        <th>Giá</th>
                    </tr>
                    <tr id="history-product-navbar">
                        <th style="width: 40%">Đơn hàng</th>
                        <th style="text-align: center; width: 20%">Số lượng</th>
                        <th style=" width: 30%">Giá tiền</th>
                    </tr>
                </thead>
                <tbody class="user-productlist-container">
                    <tr class="fav-product">
                        <td>
                            <img src="/public/assets/images/shirt.png" alt="Pants">
                            <span class="break-word">Distressed Double Knee Denim Pants Brown</span>
                        </td>
                        <td class="flex-container">
                            <strong>250.000đ</strong>
                            <button class="userpage-btn">Mua ngay</button>
                            <i class="fa-solid fa-trash"></i>
                        </td>
                    </tr>
                    <tr class="fav-product">
                        <td>
                            <img src="/public/assets/images/shirt.png" alt="Pants">
                            <span>Distressed Double Knee Denim Pants Brown</span>
                        </td>
                        <td class="flex-container">
                            <strong>250.000đ</strong>
                            <button class="userpage-btn">Mua ngay</button>
                            <i class="fa-solid fa-trash"></i>
                        </td>
                    </tr>
                    <tr class="purchased-order">
                        <td>
                            <span>Distressed Double Knee Denim Pants Brown</span>
                        </td>
                        <td id="number_of_product">
                            <strong>1</strong>
                        </td>
                        <td class="flex-container">
                            <strong>250.000đ</strong>
                            <button class="userpage-btn">Đơn hàng</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Thông tin người dùng -->
        <aside class="user-info-box">
            <h3>Thông tin</h3>
            <p><strong>User:</strong> Dumamay</p>
            <p><strong>Name:</strong> Ditmedoiv</p>
            <p><strong>Password:</strong> vaillonhbatday</p>
            <p><strong>Phone:</strong> 0868622326</p>
            <p><strong>Email:</strong> abcxyz@gmail.com</p>
            <p><strong>Điểm tích lũy:</strong> 24</p>
            <button class="change-password">Change password</button>
            <button value="1" class="order-history" id="userpage-button" onclick="ChangeTitle()">Lịch sử mua hàng</button>
        </aside>
    </main>
    <footer>
        <?php require 'footer.php'; ?>
    </footer>
    <script src="/public/assets/js/userpage.js"></script>
</body>