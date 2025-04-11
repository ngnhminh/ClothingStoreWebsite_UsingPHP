<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/css/productdetailshoes.css">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2&display=swap" rel="stylesheet">

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
            <img src="/public/assets/images/shoes5.png" alt="Hình 1">
            <img src="/public/assets/images/shoes5.png" alt="Hình 2">
            <img src="/public/assets/images/shoes5.png" alt="Hình 3">
            <img src="/public/assets/images/shoes5.png" alt="Hình 4">
        </div>
        <div class="product-main-image">
            <img src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/images/shoes5.png" alt="Sản phẩm chính">
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
            <div id="sizenlike">
                <span id="numberofsize">Size:</span><p class="sold-out">SẮP HẾT HÀNG</p>
                <button id="likebtn">
                    <img src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/images/love.svg" id="loveicon">Yêu thích
                </button>
            </div>
            <h3>Size</h3>
            <div class="size-options">
                <button>40</button>
                <button>41</button>
                <button>42</button>
                <button>43</button>
                <button>44</button>
            </div>
            <h3>Product Details:</h3>
            <ul class="product-inform">
                <li>Size: 26, 28, 30, 32, 34, 36</li>
                <li>Material: Cotton Twill</li>
                <li>Baggy Fit</li>
                <li>Distressed design</li>
                <li>Front printed details</li>
                <li>Small leather patch sewn on the back</li>
            </ul>
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
<script src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/js/productdetailshirt.js"></script>

<footer>
    <?php require 'footer.php'; ?>
</footer>
</body>
</html>
