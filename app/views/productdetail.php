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
    <div class="product-container">
        <div class="product-image">
            <img src="/View/images/jeans.jpg" alt="Product Image">
        </div>
        <div class="product-details">
            <h2>Distressed Double Knee Denim Pants Brown</h2>
            <p class="sold-out">SẮP HẾT HÀNG</p>
            <div class="size-options">
                <button>26</button>
                <button>28</button>
                <button>30</button>
                <button>32</button>
                <button>34</button>
            </div>
            <h3>Product Details:</h3>
            <ul>
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
            
            <button class="add-to-cart">Thêm vào giỏ hàng</button>
            <button class="buy-now">Mua ngay</button>
           
        </div>
    </div>
    
           <div class="related--products">
            <h3>Related Products</h3>
            <div class="related-products">
                <button class="related-button left">‹</button>
                <div class="product-item">
                    <img src="/View/images/jeans.jpg" alt="Related Product">
                    <p class="short">Quần</p>
                    <p>200.000đ</p>
                </div>
                
                <div class="product-item">
                    <img src="/View/images/jeans.jpg" alt="Related Product">
                    <p class="short">Quần</p>
                    <p>200.000đ</p>
                </div>
                <div class="product-item">
                    <img src="/View/images/jeans.jpg" alt="Related Product">
                    <p class="short">Quần</p>
                    <p>200.000đ</p>
                </div>
                <div class="product-item">
                    <img src="/View/images/jeans.jpg" alt="Related Product">
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
</body>
</html>
