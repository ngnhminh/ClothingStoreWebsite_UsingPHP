<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/public/assets/css/login.css">
    <link rel="stylesheet"  href="/public/assets/css/styles.css">

    <link href="https://fonts.googleapis.com/css2?family=Baloo+2&display=swap" rel="stylesheet">
    <title>Product Detail</title>
</head>
<body>
    <header>
        <?php require 'header.php'; ?>
    </header>
    <main>  

    <div class="product-container-shoes">
    <div class="product-images-shoes">
        <img src="/View/images/jeans.jpg" alt="Hình 1">
        <img src="/View/images/jeans.jpg" alt="Hình 2">
        <img src="/View/images/jeans.jpg" alt="Hình 3">
        <img src="/View/images/jeans.jpg" alt="Hình 4">
    </div>
    <div class="product-main-image">
        <img src="/View/images/jeans.jpg" alt="Sản phẩm chính">
    </div>
    <div class="product-details-shoes">
        <h2>Nike Pegasus Plus</h2>
        <p>Nike Pegasus Plus mang đến trải nghiệm chạy bộ đỉnh cao với thiết kế năng động và công nghệ hiện đại. Được trang bị ZoomX Foam 
            siêu nhẹ, đôi giày giúp tối ưu hóa khả năng hoàn trả năng lượng, mang lại cảm giác êm ái và bứt tốc vượt trội.</p>
        <h3>Color</h3>
        <div class="color-options">
            <img src="color1.jpg" alt="Màu 1">
            <img src="color2.jpg" alt="Màu 2">
            <img src="color3.jpg" alt="Màu 3">
        </div>
        <h3>Size</h3>
        <div class="size-options">
            <button>40</button>
            <button>41</button>
            <button>42</button>
            <button>43</button>
            <button>44</button>
        </div>

        <p>Phần upper được làm từ chất liệu Flyknit co giãn, ôm sát bàn 
            chân một cách thoải mái, đảm bảo sự linh hoạt khi di chuyển. Đế ngoài có độ bám cao, giúp bạn tự tin trên mọi cung đường.</p>
        <button class="add-to-cart-shoes">Thêm vào giỏ hàng</button>
        <button class="buy-now-shoes">Mua ngay</button>
    </div>
</div>
<div class="re-prod">
<h2 class="related-title-shoes">Các sản phẩm tương tự</h2>
<div class="related-products-container-shoes">
    <button class="related-button left">&#10094;</button>
    <div class="related-products-shoes">
        <div class="product-item-shoes">
            <img src="/View/images/jeans.jpg" alt="Quần 1">
            <p>Quần</p>
            <p>200.000đ</p>
        </div>
        <div class="product-item">
            <img src="/View/images/jeans.jpg" alt="Quần 2">
            <p>Quần</p>
            <p>200.000đ</p>
        </div>
        <div class="product-item">
            <img src="/View/images/jeans.jpg" alt="Quần 3">
            <p>Quần</p>
            <p>200.000đ</p>
        </div>
    </div>
    
    <button class="related-button-shoes right">&#10095;</button>
</div>
</div>
</main>
    <footer>
        <?php require 'footer.php'; ?>
    </footer>
</body>
</html>
