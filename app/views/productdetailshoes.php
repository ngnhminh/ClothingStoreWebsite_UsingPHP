<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/public/assets/css/productdetailshoes.css">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2&display=swap" rel="stylesheet">
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
            <img src="/View/images/shoe1.jpg" alt="Hình 1">
            <img src="/View/images/shoe2.jpg" alt="Hình 2">
            <img src="/View/images/shoe3.jpg" alt="Hình 3">
            <img src="/View/images/shoe4.jpg" alt="Hình 4">
        </div>
        <div class="product-main-image">
            <img src="/View/images/shoe-main.jpg" alt="Sản phẩm chính">
        </div>
        <div class="product-details-shoes">
            <h2>Nike Pegasus Plus</h2>
            <p>Take responsive cushioning to the next level with the Pegasus Plus. It energizes your ride with full-length support...</p>
            <h3>Color</h3>
            <div class="color-options">
                <img src="/View/images/color1.jpg" alt="Màu 1">
                <img src="/View/images/color2.jpg" alt="Màu 2">
                <img src="/View/images/color3.jpg" alt="Màu 3">
            </div>
            <h3>Size</h3>
            <div class="size-options">
                <button>40</button>
                <button>41</button>
                <button>42</button>
                <button>43</button>
                <button>44</button>
            </div>
            <button class="add-to-cart-shoes">Thêm vào giỏ hàng</button>
            <button class="buy-now-shoes">Mua ngay</button>
        </div>
    </div>

<div class="re-prod">
<h2 class="related-title-shoes">Các sản phẩm tương tự</h2>
<div class="related-products-container-shoes">
    <button class="related-button-shoes left">&#10094;</button>
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
