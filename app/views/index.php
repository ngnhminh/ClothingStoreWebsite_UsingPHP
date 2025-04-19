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
                <img src="https://file.hstatic.net/200000525243/file/atelier-1.jpg" style="width:100%" alt="Lỗi hiển thị">
            </div>

            <div class="mySlides fade">
                <img src="https://file.hstatic.net/200000525243/file/nam2_1920x960.jpg" style="width:100%" alt="Lỗi hiển thị">
            </div>

            <div class="mySlides fade">
                <img src="https://theme.hstatic.net/200000037048/1001083096/14/slideshow_1.jpg?v=964" style="width:100%" alt="Lỗi hiển thị">
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
                                    <div class="product-new">New</div>
                                    <button class="product-cart"><i class="fa-solid fa-cart-plus"></i></button>
                                    <a class="image-resize">
                                        <img class="image-loop" src="https://product.hstatic.net/200000525243/product/image_den_1_ao-polo-nam-atelier-2401002_21f6daaabe864428b363e1acef40c447_1024x1024.jpg" />
                                    </a>
                                </div>
                                <div class="product-detail">
                                    <div class="box-product-detail">
                                        <h3 class="product-name">Áo Polo Nam Atelier Ninomaxx 2401002</h3>
                                        <div class="box-product-prices">
                                            <p class="product-price">
                                                <span>1,199,000₫</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="product-block-container">
                            <div class="product-block">
                                <div class="product-img">
                                    <div class="product-new">New</div>
                                    <button class="product-cart"><i class="fa-solid fa-cart-plus"></i></button>
                                    <a class="image-resize">
                                        <img class="image-loop" src="https://product.hstatic.net/200000525243/product/image_den_1_ao-polo-nam-atelier-2401002_21f6daaabe864428b363e1acef40c447_1024x1024.jpg" />
                                    </a>
                                </div>
                                <div class="product-detail">
                                    <div class="box-product-detail">
                                        <h3 class="product-name">Áo Polo Nam Atelier Ninomaxx 2401002</h3>
                                        <div class="box-product-prices">
                                            <p class="product-price">
                                                <span>1,199,000₫</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="product-block-container">
                            <div class="product-block">
                                <div class="product-img">
                                    <div class="product-new">New</div>
                                    <button class="product-cart"><i class="fa-solid fa-cart-plus"></i></button>
                                    <a class="image-resize">
                                        <img class="image-loop" src="https://product.hstatic.net/200000525243/product/image_den_1_ao-polo-nam-atelier-2401002_21f6daaabe864428b363e1acef40c447_1024x1024.jpg" />
                                    </a>
                                </div>
                                <div class="product-detail">
                                    <div class="box-product-detail">
                                        <h3 class="product-name">Áo Polo Nam Atelier Ninomaxx 2401002</h3>
                                        <div class="box-product-prices">
                                            <p class="product-price">
                                                <span>1,199,000₫</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="product-block-container">
                            <div class="product-block">
                                <div class="product-img">
                                    <div class="product-new">New</div>
                                    <button class="product-cart"><i class="fa-solid fa-cart-plus"></i></button>
                                    <a class="image-resize">
                                        <img class="image-loop" src="https://product.hstatic.net/200000525243/product/image_den_1_ao-polo-nam-atelier-2401002_21f6daaabe864428b363e1acef40c447_1024x1024.jpg" />
                                    </a>
                                </div>
                                <div class="product-detail">
                                    <div class="box-product-detail">
                                        <h3 class="product-name">Áo Polo Nam Atelier Ninomaxx 2401002</h3>
                                        <div class="box-product-prices">
                                            <p class="product-price">
                                                <span>1,199,000₫</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-block-container">
                            <div class="product-block">
                                <div class="product-img">
                                    <div class="product-new">New</div>
                                    <button class="product-cart"><i class="fa-solid fa-cart-plus"></i></button>
                                    <a class="image-resize">
                                        <img class="image-loop" src="https://product.hstatic.net/200000525243/product/image_den_1_ao-polo-nam-atelier-2401002_21f6daaabe864428b363e1acef40c447_1024x1024.jpg" />
                                    </a>
                                </div>
                                <div class="product-detail">
                                    <div class="box-product-detail">
                                        <h3 class="product-name">Áo Polo Nam Atelier Ninomaxx 2401002</h3>
                                        <div class="box-product-prices">
                                            <p class="product-price">
                                                <span>1,199,000₫</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-block-container">
                            <div class="product-block">
                                <div class="product-img">
                                    <div class="product-new">New</div>
                                    <button class="product-cart"><i class="fa-solid fa-cart-plus"></i></button>
                                    <a class="image-resize">
                                        <img class="image-loop" src="https://product.hstatic.net/200000525243/product/image_den_1_ao-polo-nam-atelier-2401002_21f6daaabe864428b363e1acef40c447_1024x1024.jpg" />
                                    </a>
                                </div>
                                <div class="product-detail">
                                    <div class="box-product-detail">
                                        <h3 class="product-name">Áo Polo Nam Atelier Ninomaxx 2401002</h3>
                                        <div class="box-product-prices">
                                            <p class="product-price">
                                                <span>1,199,000₫</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-block-container">
                            <div class="product-block">
                                <div class="product-img">
                                    <div class="product-new">New</div>
                                    <button class="product-cart"><i class="fa-solid fa-cart-plus"></i></button>
                                    <a class="image-resize">
                                        <img class="image-loop" src="https://product.hstatic.net/200000525243/product/image_den_1_ao-polo-nam-atelier-2401002_21f6daaabe864428b363e1acef40c447_1024x1024.jpg" />
                                    </a>
                                </div>
                                <div class="product-detail">
                                    <div class="box-product-detail">
                                        <h3 class="product-name">Áo Polo Nam Atelier Ninomaxx 2401002</h3>
                                        <div class="box-product-prices">
                                            <p class="product-price">
                                                <span>1,199,000₫</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-block-container">
                            <div class="product-block">
                                <div class="product-img">
                                <div class="product-new">New</div>
                                <button class="product-cart"><i class="fa-solid fa-cart-plus"></i></button>    
                                <a class="image-resize">
                                        <img class="image-loop" src="https://product.hstatic.net/200000525243/product/image_den_1_ao-polo-nam-atelier-2401002_21f6daaabe864428b363e1acef40c447_1024x1024.jpg" />
                                    </a>
                                </div>
                                <div class="product-detail">
                                    <div class="box-product-detail">
                                        <h3 class="product-name">Áo Polo Nam Atelier Ninomaxx 2401002</h3>
                                        <div class="box-product-prices">
                                            <p class="product-price">
                                                <span>1,199,000₫</span>
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

        <div class="section-discount">
            <div class="container-fluid">
                <div class="section-head">
                    <h2 class="section-title-container">
                        <a class="section-title">Sản phẩm đang giảm giá</a>
                    </h2>
                </div>
                <div class="section-content">
                    <div class="content-product-lists">
                        <div class="product-block-container">
                            <div class="product-block">
                                <div class="product-img">
                                    <div class="product-sale">-17%</div>
                                    <button class="product-cart"><i class="fa-solid fa-cart-plus"></i></button>
                                    <a class="image-resize">
                                        <img class="image-loop" src="https://product.hstatic.net/200000525243/product/image-den-1-ao-so-mi-nam-n-m-2406002_05c85f00879843e3a3eea6bbbc565890_1024x1024.jpg" />
                                    </a>
                                </div>
                                
                                <div class="product-detail">
                                    <div class="box-product-detail">
                                        <h3 class="product-name">Áo Sơ Mi Nam N&M 2406002</h3>
                                        <div class="box-product-prices">
                                            <p class="product-price">
                                                <span class="discount-price">1,000,000₫</span>
                                                <span class="origin-price">1,199,000₫</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="product-block-container">
                            <div class="product-block">
                                <div class="product-img">
                                    <div class="product-sale">-17%</div>
                                    <button class="product-cart"><i class="fa-solid fa-cart-plus"></i></button>
                                    <a class="image-resize">
                                        <img class="image-loop" src="https://product.hstatic.net/200000525243/product/image-den-1-ao-so-mi-nam-n-m-2406002_05c85f00879843e3a3eea6bbbc565890_1024x1024.jpg" />
                                    </a>
                                </div>
                                <div class="product-detail">
                                    <div class="box-product-detail">
                                        <h3 class="product-name">Áo Sơ Mi Nam N&M 2406002</h3>
                                        <div class="box-product-prices">
                                            <p class="product-price">
                                                <span class="discount-price">1,000,000₫</span>
                                                <span class="origin-price">1,199,000₫</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="product-block-container">
                            <div class="product-block">
                                <div class="product-img">
                                    <div class="product-sale">-17%</div>
                                    <button class="product-cart"><i class="fa-solid fa-cart-plus"></i></button>
                                    <a class="image-resize">
                                        <img class="image-loop" src="https://product.hstatic.net/200000525243/product/image-den-1-ao-so-mi-nam-n-m-2406002_05c85f00879843e3a3eea6bbbc565890_1024x1024.jpg" />
                                    </a>
                                </div>
                                <div class="product-detail">
                                    <div class="box-product-detail">
                                        <h3 class="product-name">Áo Sơ Mi Nam N&M 2406002</h3>
                                        <div class="box-product-prices">
                                            <p class="product-price">
                                                <span class="discount-price">1,000,000₫</span>
                                                <span class="origin-price">1,199,000₫</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="product-block-container">
                            <div class="product-block">
                                <div class="product-img">
                                    <div class="product-sale">-17%</div>
                                    <button class="product-cart"><i class="fa-solid fa-cart-plus"></i></button>
                                    <a class="image-resize">
                                        <img class="image-loop" src="https://product.hstatic.net/200000525243/product/image-den-1-ao-so-mi-nam-n-m-2406002_05c85f00879843e3a3eea6bbbc565890_1024x1024.jpg" />
                                    </a>
                                </div>
                                <div class="product-detail">
                                    <div class="box-product-detail">
                                        <h3 class="product-name">Áo Sơ Mi Nam N&M 2406002</h3>
                                        <div class="box-product-prices">
                                            <p class="product-price">
                                                <span class="discount-price">1,000,000₫</span>
                                                <span class="origin-price">1,199,000₫</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-block-container">
                            <div class="product-block">
                                <div class="product-img">
                                    <div class="product-sale">-17%</div>
                                    <button class="product-cart"><i class="fa-solid fa-cart-plus"></i></button>
                                    <a class="image-resize">
                                        <img class="image-loop" src="https://product.hstatic.net/200000525243/product/image-den-1-ao-so-mi-nam-n-m-2406002_05c85f00879843e3a3eea6bbbc565890_1024x1024.jpg" />
                                    </a>
                                </div>
                                <div class="product-detail">
                                    <div class="box-product-detail">
                                        <h3 class="product-name">Áo Sơ Mi Nam N&M 2406002</h3>
                                        <div class="box-product-prices">
                                            <p class="product-price">
                                                <span class="discount-price">1,000,000₫</span>
                                                <span class="origin-price">1,199,000₫</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-block-container">
                            <div class="product-block">
                                <div class="product-img">
                                    <div class="product-sale">-17%</div>
                                    <button class="product-cart"><i class="fa-solid fa-cart-plus"></i></button>
                                    <a class="image-resize">
                                        <img class="image-loop" src="https://product.hstatic.net/200000525243/product/image-den-1-ao-so-mi-nam-n-m-2406002_05c85f00879843e3a3eea6bbbc565890_1024x1024.jpg" />
                                    </a>
                                </div>
                                <div class="product-detail">
                                    <div class="box-product-detail">
                                        <h3 class="product-name">Áo Sơ Mi Nam N&M 2406002</h3>
                                        <div class="box-product-prices">
                                            <p class="product-price">
                                                <span class="discount-price">1,000,000₫</span>
                                                <span class="origin-price">1,199,000₫</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-block-container">
                            <div class="product-block">
                                <div class="product-img">
                                    <div class="product-sale">-17%</div>
                                    <button class="product-cart"><i class="fa-solid fa-cart-plus"></i></button>
                                    <a class="image-resize">
                                        <img class="image-loop" src="https://product.hstatic.net/200000525243/product/image-den-1-ao-so-mi-nam-n-m-2406002_05c85f00879843e3a3eea6bbbc565890_1024x1024.jpg" />
                                    </a>
                                </div>
                                <div class="product-detail">
                                    <div class="box-product-detail">
                                        <h3 class="product-name">Áo Sơ Mi Nam N&M 2406002</h3>
                                        <div class="box-product-prices">
                                            <p class="product-price">
                                                <span class="discount-price">1,000,000₫</span>
                                                <span class="origin-price">1,199,000₫</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-block-container">
                            <div class="product-block">
                                <div class="product-img">
                                    <div class="product-sale">-17%</div>
                                    <button class="product-cart"><i class="fa-solid fa-cart-plus"></i></button>
                                    <a class="image-resize">
                                        <img class="image-loop" src="https://product.hstatic.net/200000525243/product/image-den-1-ao-so-mi-nam-n-m-2406002_05c85f00879843e3a3eea6bbbc565890_1024x1024.jpg" />
                                    </a>
                                </div>
                                <div class="product-detail">
                                    <div class="box-product-detail">
                                        <h3 class="product-name">Áo Sơ Mi Nam N&M 2406002</h3>
                                        <div class="box-product-prices">
                                            <p class="product-price">
                                                <span class="discount-price">1,000,000₫</span>
                                                <span class="origin-price">1,199,000₫</span>
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

    </main>

    <?php require 'footer.php'; ?>
    
    <script src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/js/index.js"></script>
    <script src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/js/header.js"></script>
</body>
    <script>
        function goToUserPage() {
            let user = JSON.parse(localStorage.getItem("user"));
            window.addEventListener('userUpdated', function() {
                let userUpdated = JSON.parse(localStorage.getItem("user"));
                console.log("Thông tin người dùng đã được cập nhật:", userUpdated);
                user = userUpdated; // Cập nhật lại biến user toàn cục với dữ liệu mới
            });
            if (user) {
                window.location.href = "userpage.php"; // Chuyển đến trang người dùng nếu có thông tin người dùng
            } else {
                alert("Vui lòng đăng nhập!"); // Thông báo khi chưa đăng nhập
            }
        }
    </script>

</html>