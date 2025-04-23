<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hóa đơn</title>
    <link rel="stylesheet" href="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/css/purchased_order_detail.css">
    
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="invoice">
        <div class="product-list">
            <div class="product">
                <img src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/images/shirt.png" alt="Product">
                <div class="product-info">
                    <p class="product-name">Distressed Double Knee Denim Pants Brown</p>
                    <p class="product-details">Size: M &nbsp; SL: 2</p>
                    <p class="product-price">
                        <span class="old-price">200.000đ</span>
                        <span class="discount">-20%</span>
                        <span class="new-price">100.000đ</span>
                    </p>
                </div>
            </div>
            <div class="product">
                <img src="/public/assets/images/shirt.png" alt="Product">
                <div class="product-info">
                    <p class="product-name">Distressed Double Knee Denim Pants Brown</p>
                    <p class="product-details">Size: M &nbsp; SL: 2</p>
                    <p class="product-price"><span class="new-price">250.000đ</span></p>
                </div>
            </div>
            <div class="product">
                <img src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/images/shirt.png" alt="Product">
                <div class="product-info">
                    <p class="product-name">Distressed Double Knee Denim Pants Brown</p>
                    <p class="product-details">Size: M &nbsp; SL: 2</p>
                    <p class="product-price"><span class="new-price">250.000đ</span></p>
                </div>
            </div>
        </div>

        <hr>

        <div class="summary">
            <p>Giảm giá: <span>500.000đ</span></p>
            <p>Tạm tính: <span>500.000đ</span></p>
            <p>Phí vận chuyển: <span>500.000đ</span></p>
            <p>Phương thức thanh toán: <span>Chuyển khoản</span></p>
            <p>Trạng thái: <span class="processed">Đã xử lý</span></p>
        </div>

        <div class="total">
            <p>Tổng tiền: <span>1.000.000đ</span></p>
        </div>
    </div>
</body>
</html>
