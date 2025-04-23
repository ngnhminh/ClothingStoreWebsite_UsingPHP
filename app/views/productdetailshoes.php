<!DOCTYPE html>
<html lang="vi">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css2?family=Baloo+2&display=swap" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link href="https://fonts.googleapis.com/css2?family=Baloo+2&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/css/productdetailshoes.css">
        <title>Product Detail</title>
    </head>
    <body>
        <header>
            <?php require 'header.php'; ?>
        </header>
        <main>  
            <div class="product-container-shoes">
                <div class="product-images-shoes" id="product-images-shoes">
                    <img src="/public/assets/images/shoes5.png" alt="Hình 1">
                    <img src="/public/assets/images/shoes5.png" alt="Hình 2">
                    <img src="/public/assets/images/shoes5.png" alt="Hình 3">
                    <img src="/public/assets/images/shoes5.png" alt="Hình 4">
                </div>
                <div class="product-main-image" id="product-main-image">
                    <img src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/images/shoes5.png" alt="Sản phẩm chính">
                </div>
                <div class="product-details-shoes">
                    <div id="product-name">
                        <h2>Nike Pegasus Plus</h2>
                    </div>
                    <div id="description">
                        <p>Take responsive cushioning to the next level with the Pegasus Plus. It energizes your ride with full-length support...</p>
                    </div>
                    <h3>Color</h3>
                    <div class="color-options" id="color-options">
                    </div>
                    <div id="sizenlike">
                        <span id="numberofsize">Size:</span><p id="almost-sold-out">SẮP HẾT HÀNG</p><p id="sold-out">HẾT HÀNG</p><p id="instock">CÒN HÀNG</p>
                        <button id="likebtn">
                            <img src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/images/love.svg" id="loveicon">Yêu thích
                        </button>
                    </div>
                    <div class="size-options" id="size-options">
                        <!-- <button>40</button>
                        <button>41</button>
                        <button>42</button>
                        <button>43</button>
                        <button>44</button> -->
                    </div>
                    <h3>Product Details:</h3>
                    <ul class="product-inform" id="product-inform">
                        <!-- <li>Size: 26, 28, 30, 32, 34, 36</li>
                        <li>Material: Cotton Twill</li>
                        <li>Baggy Fit</li>
                        <li>Distressed design</li>
                        <li>Front printed details</li>
                        <li>Small leather patch sewn on the back</li> -->
                    </ul>
                    <button class="add-to-cart" id="add-to-cart">Thêm vào giỏ hàng</button>
                    <button class="buy-now" id="buy-now">Mua ngay</button>
                </div>
            </div>

            <div class="related--products">
                <h3>Related Products</h3>
                <div class="related-products-wrapper">
                    <button class="related-button left">‹</button>
                    <div class="related-products" id="related-products"></div>
                    <button class="related-button right">›</button>
                </div>
            </div>
        </main>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/js/productdetailshoes.js"></script>
        <script src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/js/header.js"></script>
        <script>
            function goToUserPage() {
                let user = JSON.parse(localStorage.getItem("user"));
                window.addEventListener('userUpdated', function() {
                    let userUpdated = JSON.parse(localStorage.getItem("user"));
                    console.log("Thông tin người dùng đã được cập nhật:", userUpdated);
                    user = userUpdated; // Cập nhật lại biến user toàn cục với dữ liệu mới
                });
                if (user) {
                    window.location.href = "userpage.php";
                } else {
                    alert("Vui lòng đăng nhập!");
                }
            }
        </script>
        <footer>
            <?php require 'footer.php'; ?>
        </footer>
    </body>
</html>
