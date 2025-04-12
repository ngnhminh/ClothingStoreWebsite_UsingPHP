<?php
require_once '../../config/db.php';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/css/index.css">
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
                <img src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/images/img_nature_wide.jpg" style="width:100%" alt="Lỗi hiển thị">
            </div>

            <div class="mySlides fade">
                <img src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/images/img_lights_wide.jpg" style="width:100%" alt="Lỗi hiển thị">
            </div>

            <div class="mySlides fade">
                <img src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/images/img_nature_wide.jpg" style="width:100%" alt="Lỗi hiển thị">
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

        <!-- <div class="newproduct_container">
            <div class="text-section">
                <h2>New products</h2>
                <p>Pick your own trendiest styles</p>
                <button id="watchmore_button">Watch more</button>
            </div>
            <div class="product_grid">
                <div class="product">
                    <img src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/images/image3.png" alt="Lỗi hiển thị">
                </div>
                <div class="product">
                    <img src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/images/image3.png" alt="Lỗi hiển thị">
                </div>
                <div class="product">
                    <img src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/images/image3.png" alt="Lỗi hiển thị">
                </div>
                <div class="product">
                    <img src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/images/image3.png" alt="Lỗi hiển thị">
                </div>
            </div>
        </div> -->

        <div class="section-arrival">
            <div class="container-fluid">
                <div class="section-head">
                    <h2 class="section-title-container">
                        <a class="section-title">Sản phẩm mới nhất</a>
                    </h2>
                </div>
                <div class="section-content">
                    <div class="content-product-lists">
                        <div class="product-block-container">
                            <div class="product-block">
                                <div class="product-img">
                                    <a class="image-resize">
                                        <img class="image-loop" src="https://product.hstatic.net/200000037048/product/3bae9d3051bae1e4b8ab_d0127535fc2b4159adb98f51124fe081.jpg" />
                                    </a>
                                </div>
                                <div class="product-detail">
                                    <div class="box-product-detail">
                                        <h3 class="product-name">Đầm 8 mảnh zipper tím nhạt</h3>
                                        <div class="box-product-prices">
                                            <p class="product-price">
                                                <span>1,199,000đ</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="product-block-container">
                            <div class="product-block">
                                <div class="product-img">
                                    <a class="image-resize">
                                        <img class="image-loop" src="https://product.hstatic.net/200000037048/product/3bae9d3051bae1e4b8ab_d0127535fc2b4159adb98f51124fe081.jpg" />
                                    </a>
                                </div>
                                <div class="product-detail">
                                    <div class="box-product-detail">
                                        <h3 class="product-name">Đầm 8 mảnh zipper tím nhạt</h3>
                                        <div class="box-product-prices">
                                            <p class="product-price">
                                                <span>1,199,000đ</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="product-block-container">
                            <div class="product-block">
                                <div class="product-img">
                                    <a class="image-resize">
                                        <img class="image-loop" src="https://product.hstatic.net/200000037048/product/3bae9d3051bae1e4b8ab_d0127535fc2b4159adb98f51124fe081.jpg" />
                                    </a>
                                </div>
                                <div class="product-detail">
                                    <div class="box-product-detail">
                                        <h3 class="product-name">Đầm 8 mảnh zipper tím nhạt</h3>
                                        <div class="box-product-prices">
                                            <p class="product-price">
                                                <span>1,199,000đ</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="product-block-container">
                            <div class="product-block">
                                <div class="product-img">
                                    <a class="image-resize">
                                        <img class="image-loop" src="https://product.hstatic.net/200000037048/product/3bae9d3051bae1e4b8ab_d0127535fc2b4159adb98f51124fe081.jpg" />
                                    </a>
                                </div>
                                <div class="product-detail">
                                    <div class="box-product-detail">
                                        <h3 class="product-name">Đầm 8 mảnh zipper tím nhạt</h3>
                                        <div class="box-product-prices">
                                            <p class="product-price">
                                                <span>1,199,000đ</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-block-container">
                            <div class="product-block">
                                <div class="product-img">
                                    <a class="image-resize">
                                        <img class="image-loop" src="https://product.hstatic.net/200000037048/product/3bae9d3051bae1e4b8ab_d0127535fc2b4159adb98f51124fe081.jpg" />
                                    </a>
                                </div>
                                <div class="product-detail">
                                    <div class="box-product-detail">
                                        <h3 class="product-name">Đầm 8 mảnh zipper tím nhạt</h3>
                                        <div class="box-product-prices">
                                            <p class="product-price">
                                                <span>1,199,000đ</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-block-container">
                            <div class="product-block">
                                <div class="product-img">
                                    <a class="image-resize">
                                        <img class="image-loop" src="https://product.hstatic.net/200000037048/product/3bae9d3051bae1e4b8ab_d0127535fc2b4159adb98f51124fe081.jpg" />
                                    </a>
                                </div>
                                <div class="product-detail">
                                    <div class="box-product-detail">
                                        <h3 class="product-name">Đầm 8 mảnh zipper tím nhạt</h3>
                                        <div class="box-product-prices">
                                            <p class="product-price">
                                                <span>1,199,000đ</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-block-container">
                            <div class="product-block">
                                <div class="product-img">
                                    <a class="image-resize">
                                        <img class="image-loop" src="https://product.hstatic.net/200000037048/product/3bae9d3051bae1e4b8ab_d0127535fc2b4159adb98f51124fe081.jpg" />
                                    </a>
                                </div>
                                <div class="product-detail">
                                    <div class="box-product-detail">
                                        <h3 class="product-name">Đầm 8 mảnh zipper tím nhạt</h3>
                                        <div class="box-product-prices">
                                            <p class="product-price">
                                                <span>1,199,000đ</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-block-container">
                            <div class="product-block">
                                <div class="product-img">
                                    <a class="image-resize">
                                        <img class="image-loop" src="https://product.hstatic.net/200000037048/product/3bae9d3051bae1e4b8ab_d0127535fc2b4159adb98f51124fe081.jpg" />
                                    </a>
                                </div>
                                <div class="product-detail">
                                    <div class="box-product-detail">
                                        <h3 class="product-name">Đầm 8 mảnh zipper tím nhạt</h3>
                                        <div class="box-product-prices">
                                            <p class="product-price">
                                                <span>1,199,000đ</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="section-more">
                        <a class="more-button">Xem tất cả</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="banner_pic">
            <div>
                <img src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/images/signup_panel.jpg" alt="Lỗi hiển thị">
            </div>
        </div>

        <!-- lưới menu hình ảnh -->
        <div class="image-grid">
            <div class="image-item">
                <img src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/images/shirts.png" alt="Lỗi hiển thị">
                <p>Shirts</p>
            </div>
            <div class="image-item">
                <img src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/images/glasses.png" alt="Lỗi hiển thị">
                <p>Glasses</p>
            </div>
            <div class="image-item">
                <img src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/images/shoes.png" alt="Lỗi hiển thị">
                <p>Shoes</p>
            </div>
            <div class="image-item">
                <img src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/images/pants.png" alt="Lỗi hiển thị">
                <p>Pants</p>
            </div>
        </div>

        <div class="banner_pic">
            <div>
                <img src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/images/signup_panel.jpg" alt="Lỗi hiển thị">
            </div>
        </div>

        <div class="banner_pic">
            <div>
                <img src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/images/signup_panel.jpg" alt="Lỗi hiển thị">
            </div>
        </div>
    </main>
    <footer>
        <?php require 'footer.php'; ?>
    </footer>
    <script src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/js/index.js"></script>
</body>
</html>