<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Product Detail</title>
</head>
<body>
    <header>
        <?php require 'header.php'; ?>
    </header>
    <main>
    <div class="product-container">
        <div class="product-image" id="product-image">
            <img src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/images/shirt.png" alt="Product Image">
        </div>
        <div class="product-details", >
            <div id="product-name">
                <h2>Distressed Double Knee Denim Pants Brown</h2>
                <p class="product-price">
                    <span class="old-price" id="old-price">200.000đ</span>
                    <span class="discount" id="discount">-20%</span>
                    <span class="new-price"  id="new-price">100.000đ</span>
                </p>
            </div>
            <div id="sizenlike">
                <span id="numberofsize">Size:</span><p id="almost-sold-out">SẮP HẾT HÀNG</p><p id="sold-out">HẾT HÀNG</p><p id="instock">CÒN HÀNG</p>
                <button id="likebtn">
                    <img src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/images/love.svg" id="loveicon">Yêu thích
                </button>
            </div>
            <div class="size-options" id="size-options">
                <!-- <button>S</button>
                <button>M</button>
                <button>L</button>
                <button>XL</button>
                <button>XXL</button> -->
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
            
            <table class="size-chart" id="size-chart-shirts">
                <tr>
                    <th>Size</th>
                    <th>Waist</th>
                    <th>Hip</th>
                    <th>Length</th>
                </tr>
                <tr>
                    <td>S</td>
                    <td>68 cm</td>
                    <td>47 cm</td>
                    <td>63 cm</td>
                </tr>
                <tr>
                    <td>M</td>
                    <td>72 cm</td>
                    <td>50 cm</td>
                    <td>62 cm</td>
                </tr>
                <tr>
                    <td>L</td>
                    <td>76 cm</td>
                    <td>53 cm</td>
                    <td>66 cm</td>
                </tr>
                <tr>
                    <td>XL</td>
                    <td>76 cm</td>
                    <td>56 cm</td>
                    <td>69 cm</td>
                </tr>
                <tr>
                    <td>XXL</td>
                    <td>76 cm</td>
                    <td>59 cm</td>
                    <td>76 cm</td>
                </tr>
            </table>
            
            <table class="size-chart" id="size-chart-pants">
                <tr>
                    <th>Size</th>
                    <th>Waist</th>
                    <th>Hip</th>
                    <th>Length</th>
                </tr>
                <tr>
                    <td>26</td>
                    <td>68 cm</td>
                    <td>92 cm</td>
                    <td>100 cm</td>
                </tr>
                <tr>
                    <td>28</td>
                    <td>72 cm</td>
                    <td>96 cm</td>
                    <td>102 cm</td>
                </tr>
                <tr>
                    <td>30</td>
                    <td>76 cm</td>
                    <td>100 cm</td>
                    <td>104 cm</td>
                </tr>
            </table>

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
    <footer>
        <?php require 'footer.php'; ?>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/js/productdetailshirt.js"></script>
    <link rel="stylesheet"  href="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/css/productdetailshirt.css">
    <script src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/js/header.js"></script>
    <script>
        function goToUserPage() {
            const user = JSON.parse(localStorage.getItem("user"));
            if (user) {
                window.location.href = "userpage.php";
            } else {
                alert("Vui lÃ²ng Ä‘Äƒng nháº­p!");
            }
        }
    </script>
</body>
</html>
