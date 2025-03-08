<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"  href="/public/assets/css/admin/khuyenmaipage.css">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2&display=swap" rel="stylesheet">
    <title>Voucher</title>
</head>
<body>
    <aside class="sidebar">
        <img id="logo_img" src="/public/assets/images/logo.png" alt="Lỗi hình ảnh không thể hiển thị"></a>
        <ul class="menu-admin">
            <a href="dashboard.php"><li>📊 Dashboard</li></a>
            <a href="productmanagement.php"><li>📦 Quản lý sản phẩm</li></a>
            <a href="ordermanagement.php"><li>📜 Quản lý đơn hàng</li></a>
            <a href="customermanagement.php"><li>👥 Quản lý khách hàng</li></a>
            <a href="khuyenmaipage.php"><li>🎟️ Quản lý khuyến mãi</li></a>
            <a href="historypage.php"><li>📈 Lịch sử</li></a>
        </ul>
    </aside>
    <div class="productlist-container">
        <div class="header">
            Quản lý Khuyến mãi 
            <button class="add-voucher-voucher" id="add-voucher-voucher">+ Thêm voucher</button>
        </div>
        
        <div class="toolbar-voucher">
            <button>Áo (25)</button>
            <button>Quần (25)</button>
            <button>Kính (25)</button>
            <button>Giày (25)</button>
            <button>SP giảm giá</button>
            <button id="storage">Tất cả</button>
            <button id="voucherstorage">Kho voucher</button>
            <input type="text" placeholder="Nhập tên sản phẩm">
        </div>

        <div class="product-list" id="product-list">
            <div class="product">
            <div class="product-thumbnail">
                    <div class="product-thumbnail_wrapper">
                        <img class="product-thumbnail__image" src="/public/assets/images/shirt.png" alt="Áo thun" />
                    </div>
                </div>
                <p>Distressed Double Knee Denim Pants Brown</p>
                <span><del>500.000đ</del><span id="percent_discount">-20%</span></span>
                <span>300.000đ</span>
            </div>
            <div class="product">
                <div class="product-thumbnail">
                    <div class="product-thumbnail_wrapper">
                        <img class="product-thumbnail__image" src="/public/assets/images/shirt.png" alt="Áo thun" />
                    </div>
                </div>
                <p>Distressed Double Knee Denim Pants Brown</p>
            </div>
            <div class="product">
            <div class="product-thumbnail">
                    <div class="product-thumbnail_wrapper">
                        <img class="product-thumbnail__image" src="/public/assets/images/shirt.png" alt="Áo thun" />
                    </div>
                </div>
                <p>Distressed Double Knee Denim Pants Brown</p>
            </div>
            <div class="product">
            <div class="product-thumbnail">
                    <div class="product-thumbnail_wrapper">
                        <img class="product-thumbnail__image" src="/public/assets/images/shirt.png" alt="Áo thun" />
                    </div>
                </div>
                <p>Distressed Double Knee Denim Pants Brown</p>
            </div>
        </div>
        <div class="discount-modal"><?php require 'khuyenmaiadd.php'; ?></div>
    </div>
    <div class="voucher-container">
        <table class="voucher-table">
            <thead>
                <tr>
                    <th>Mã voucher</th>
                    <th>Tên voucher</th>
                    <th>Số lượng</th>
                    <th>Tình trạng</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>VTG69898k</td>
                    <td>Vui tết </td>
                    <td>100</td>
                    <td>Còn</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="discount-modal"><?php require 'voucheradd.php'; ?></div>
    <script src="/public/assets/js/admin/khuyenmaipage.js"></script>
</body>
</html>