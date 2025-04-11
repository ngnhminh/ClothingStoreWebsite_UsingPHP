<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"  href="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/css/productdetailshirt.css">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2&display=swap" rel="stylesheet">
    <title>Product Detail</title>
</head>
<body>
    <header>
        <?php require 'header.php'; ?>
    </header>
    <main>
    <div class="product-container">
        <div class="product-image" id="product-image">
            <img src="/public/assets/images/shirt.png" alt="Product Image">
        </div>
        <div class="product-details">
            <h2>Distressed Double Knee Denim Pants Brown</h2>
            <div id="sizenlike">
                <span id="numberofsize">Size:</span><p class="sold-out">SẮP HẾT HÀNG</p>
                <button id="likebtn">
                    <img src="/public/assets/images/love.svg" id="loveicon">Yêu thích
                </button>
            </div>
            <div class="size-options">
                <button>S</button>
                <button>M</button>
                <button>L</button>
                <button>XL</button>
                <button>XXL</button>
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
            
            <table class="size-chart">
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
            
            <table class="size-chart" id="size-chart-pants" style="display: none">
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

            <button class="add-to-cart">Thêm vào giỏ hàng</button>
            <button class="buy-now">Mua ngay</button>
           
        </div>
    </div>
    
           <div class="related--products">
            <h3>Related Products</h3>
            <div class="related-products">
                <button class="related-button left">‹</button>
                <div class="product-item">
                    <img src="/public/assets/images/shirt.png" alt="Related Product">
                    <p class="short">Quần</p>
                    <p>200.000đ</p>
                </div>
                
                <div class="product-item">
                    <img src="/public/assets/images/shirt.png" alt="Related Product">
                    <p class="short">Quần</p>
                    <p>200.000đ</p>
                </div>
                <div class="product-item">
                    <img src="/public/assets/images/shirt.png" alt="Related Product">
                    <p class="short">Quần</p>
                    <p>200.000đ</p>
                </div>
                <div class="product-item">
                    <img src="/public/assets/images/shirt.png" alt="Related Product">
                    <p class="short">Quần</p>
                    <p>200.000đ</p>
                </div> 
                <button class="related-button right">›</button>
             </div>
        </div>
        </main>
    <footer>
        <?php require 'footer.php'; ?>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/js/productdetailshirt.js"></script>
</body>
</html>
