<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/public/assets/css/productpage.css">
    <link rel="stylesheet"  href="/public/assets/css/styles.css">

    <link href="https://fonts.googleapis.com/css2?family=Baloo+2&display=swap" rel="stylesheet">
    <title>Khuyen Mai</title>
</head>
<body>
    <header>
        <?php require 'header.php'; ?>
    </header>
    <main>
<div class="container">
    <h1>Quản lý khuyến mãi</h1>
    <div class="toolbar">
        <div class="categories">
            <button>Áo (25)</button>
            <button>Quần (25)</button>
            <button>Kính (25)</button>
            <button>Giày (25)</button>
            <button>Kho voucher</button>
        </div>
        <div class="search-bar">
            <button>Sản phẩm giảm giá</button>
            <input type="text" placeholder="Nhập tên sản phẩm">
        </div>
        <button class="add-voucher">+ Thêm voucher</button>
    </div>
    <div class="products">
        <div class="product">
            <img src="/View/images/jeans.jpg" alt="Shirt">
            <p>Distressed Double Knee Denim Pants Brown</p>
            <p class="old-price">200.000đ</p>
            <p class="discount">100.000đ -20%</p>
        </div>
        <div class="product">
            <img src="/View/images/jeans.jpg" alt="Shirt">
            <p>Distressed Double Knee Denim Pants Brown</p>
            <p class="old-price">200.000đ</p>
            <p class="discount">100.000đ -20%</p>
        </div>
        <div class="product">
            <img src="/View/images/jeans.jpg" alt="Shirt">
            <p>Distressed Double Knee Denim Pants Brown</p>
            <p class="old-price">200.000đ</p>
            <p class="discount">100.000đ -20%</p>
        </div>
        <div class="product">
            <img src="/View/images/jeans.jpg" alt="Shirt">
            <p>Distressed Double Knee Denim Pants Brown</p>
            <p class="old-price">200.000đ</p>
            <p class="discount">100.000đ -20%</p>
        </div>
        <div class="product">
            <img src="/View/images/jeans.jpg" alt="Shirt">
            <p>Distressed Double Knee Denim Pants Brown</p>
            <p class="old-price">200.000đ</p>
            <p class="discount">100.000đ -20%</p>
        </div>
        <div class="product">
            <img src="/View/images/jeans.jpg" alt="Shirt">
            <p>Distressed Double Knee Denim Pants Brown</p>
            <p class="old-price">200.000đ</p>
            <p class="discount">100.000đ -20%</p>
        </div>
    </div>
</div>
</main>
    <footer>
        <?php require 'footer.php'; ?>
    </footer>
</body>
</html>
