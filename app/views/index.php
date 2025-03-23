<?php
require_once '../../config/db.php';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="/public/assets/css/index.css">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2&display=swap" rel="stylesheet">
    <title>Trang chủ</title>
</head>
<body>
    <header>
        <?php require 'header.php'; ?>
    </header>
    <main>
        <div class="slideshow-container">
            <div class="mySlides fade">
                <img src="/public/assets/images/img_nature_wide.jpg" style="width:100%" alt="Lỗi hiển thị">
            </div>

            <div class="mySlides fade">
                <img src="/public/assets/images/img_lights_wide.jpg" style="width:100%" alt="Lỗi hiển thị">
            </div>

            <div class="mySlides fade">
                <img src="/public/assets/images/img_nature_wide.jpg" style="width:100%" alt="Lỗi hiển thị">
            </div>

            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>
        </div>
        <br>

        <div style="text-align:center">
            <span class="dot" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
            <span class="dot" onclick="currentSlide(3)"></span>
        </div>

        <div class="newproduct_container">
            <div class="text-section">
                <h2>New products</h2>
                <p>Pick your own trendiest styles</p>
                <button id="watchmore_button">Watch more</button>
            </div>
            <div class="product_grid">
                <div class="product">
                    <img src="/public/assets/images/image3.png" alt="Lỗi hiển thị">
                </div>
                <div class="product">
                    <img src="/public/assets/images/image3.png" alt="Lỗi hiển thị">
                </div>
                <div class="product">
                    <img src="/public/assets/images/image3.png" alt="Lỗi hiển thị">
                </div>
                <div class="product">
                    <img src="/public/assets/images/image3.png" alt="Lỗi hiển thị">
                </div>
            </div>
        </div>

        <div class="banner_pic">
            <div>
                <img src="/public/assets/images/signup_panel.jpg" alt="Lỗi hiển thị">
            </div>
        </div>

        <!-- lưới menu hình ảnh -->
        <div class="image-grid">
            <div class="image-item">
                <img src="/public/assets/images/shirts.png" alt="Lỗi hiển thị">
                <p>Shirts</p>
            </div>
            <div class="image-item">
                <img src="/public/assets/images/glasses.png" alt="Lỗi hiển thị">
                <p>Glasses</p>
            </div>
            <div class="image-item">
                <img src="/public/assets/images/shoes.png" alt="Lỗi hiển thị">
                <p>Shoes</p>
            </div>
            <div class="image-item">
                <img src="/public/assets/images/pants.png" alt="Lỗi hiển thị">
                <p>Pants</p>
            </div>
        </div>

        <div class="banner_pic">
            <div>
                <img src="/public/assets/images/signup_panel.jpg" alt="Lỗi hiển thị">
            </div>
        </div>

        <div class="banner_pic">
            <div>
                <img src="/public/assets/images/signup_panel.jpg" alt="Lỗi hiển thị">
            </div>
        </div>
    </main>
    <footer>
        <?php require 'footer.php'; ?>
    </footer>
    <script src="/public/assets/js/index.js"></script>
</body>
</html>