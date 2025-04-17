<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Thanh toán</title>
  <link rel="stylesheet" type="text/css" href="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/css/checkout.css">
  <link href="https://fonts.googleapis.com/css2?family=Baloo+2&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://unpkg.com/dayjs/dayjs.min.js"></script>
</head>
<body>
  <div class="container-checkout">
    <!-- Cột bên trái: Thông tin người dùng và phương thức thanh toán -->
    <div class="grid-container-combine">
      <div class="header-logo">
        <img src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/images/logo.png" alt="ShittyStuffs Logo" />
      </div>
      
      <!-- Thông tin nhận hàng -->
      <div class="column-user-contact">
        <h2 class="checkout-title">Thông tin nhận hàng</h2>
        <form class="checkout-form">
            <label>Email</label>
            <input type="email" placeholder="Nhập email" id="email-input"/>
            <p class="error">Bạn chưa nhập email</p>

            <label>Họ tên</label>
            <input type="text" placeholder="Nhập họ tên" id="hoten-input"/>
            <p class="error">Bạn chưa nhập họ tên</p>

            <label>Số điện thoại</label>
            <input type="text" placeholder="Nhập số điện thoại" id="sdt-input"/>
            <p class="error">Bạn chưa nhập số điện thoại</p>

            <label>Địa chỉ</label>
            <input type="text" placeholder="Nhập địa chỉ (Số nhà, Đường...)" id="diachi-input"/>
            <p class="error">Bạn chưa nhập địa chỉ</p>

            <label>Tỉnh/Thành phố</label>
            <select id="tinhThanh">
                <option value="">-- Chọn tỉnh/thành --</option>
            </select>
            <p class="error">Bạn chưa nhập tỉnh/thành</p>

            <label>Quận/Huyện</label>
            <select id="quanHuyen">
                <option value="">-- Chọn quận/huyện --</option>
            </select>
            <p class="error">Bạn chưa nhập quận/huyện</p>

            <label>Phường/Xã</label>
            <input type="text" placeholder="Nhập phường/xã" id="phuong-input"/>
            <p class="error">Bạn chưa nhập phường/xã</p>

            <label>Ghi chú</label>
            <textarea rows="3" placeholder="Nhập ghi chú (tuỳ chọn)" id="ghichu"></textarea>
            </form>
      </div>

      <!-- Vận chuyển & Phương thức thanh toán -->
      <div class="column-transform-paymentmethod">
        <h2 class="checkout-title">Vận chuyển</h2>
        <div class="shipping-box">
          <p id="transport-fee">Phí vận chuyển: <strong>-30.000đ</strong></p>
          <p id="annouce-box">Vui lòng nhập thông tin giao hàng</p>
        </div>

        <h2 class="checkout-title">Phương thức thanh toán</h2>
        <div class="payment-method">
          <!-- <label>
            <input type="radio" name="payment" />
            Thanh toán qua VNPAY - QR
          </label> -->
          <label>
            <input type="radio" name="payment" />
            Thanh toán khi giao hàng (COD)
          </label>
          <p class="note">Chỉ thanh toán khi nhận được hàng</p>
        </div>
      </div>
    </div>

    <!-- Đường kẻ phân cách -->
    <div class="separator"></div>

    <!-- Cột bên phải: Đơn hàng -->
    <div class="column-order" id="column-order">
        <h2 class="checkout-title">Đơn hàng (<span  id="numberofproduct"></span> sản phẩm)</h2>

        <div class="checkout-cart" id="checkout-cart">
            <div class="cart-item">
                <div class="product-thumbnail">
                    <div class="product-thumbnail_wrapper">
                        <img class="product-thumbnail__image" src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/images/shirt.png" alt="Áo thun" />
                    </div>
                </div>
                <div class="item-info">
                    <p class="product-name">Distressed Double Knee Denim Pants Brown</p>
                    <p class="product-variant">Size: M | SL: 2</p>
                    <p class="product-price">
                    <span class="price-discount">200.000đ</span> 
                    100.000đ
                    </p>
                </div>
            </div>

            <div class="cart-item">
                <div class="product-thumbnail">
                    <div class="product-thumbnail_wrapper">
                        <img class="product-thumbnail__image" src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/images/shirt.png" alt="Áo thun" />
                    </div>
                </div>
                <div class="item-info">
                    <p class="product-name">Distressed Double Knee Denim Pants Brown</p>
                    <p class="product-variant">Size: M | SL: 2</p>
                    <p class="product-price">
                    <span class="price-discount">200.000đ</span> 
                    100.000đ
                    </p>
                </div>
            </div>
        </div>
        
    <div class="discount-box" id="discount-box">
    <label class="loyalty" id="loyalty">
        <input type="checkbox" />
        Dùng điểm tích lũy (<span id="diemtichluy" data-diemtichluy = "0"></span> điểm)<br>
        <span>Điểm tích lũy còn lại: <span id="diemtichluyconlai"></span></span>
    </label>
    <div class="coupon">
        <input type="text" id="coupon-input" placeholder="Nhập mã giảm giá" />
        <button id="apply-btn">Áp dụng</button>
    </div>
    </div>

      <table class="summary-table">
        <tr>
          <td>Tạm tính:</td>
          <td class="checkout-price" id="checkout-price" data-checkoutPrice = "0">500.000đ</td>
        </tr>
        <tr>
          <td>Phí vận chuyển:</td>
          <td class="checkout-price" id="checkout-price-transport-fee"  data-fee="0" style ="display: none">30.000đ</td>
        </tr>
        <tr>
          <td>Mã giảm giá:</td>
          <td class="checkout-price" id="checkout-price-discount" data-discountPrice = "0">0</td>
        </tr>
        <tr>
          <td>Điểm tích lũy:</td>
          <td class="checkout-price" id="checkout-price-point" data-point = "0">0</td>
        </tr>
        <tr class="total-row">
          <td>Tổng tiền:</td>
          <td class="total-price checkout-price" id="checkout-price-final" data-finalPrice ="0" >0</td>
        </tr>
      </table>

      <div class="action-buttons">
        <button class="btn-secondary" id="continue-shopping">Tiếp tục mua sắm</button>
        <button class="btn-primary" id="order-btn">Đặt hàng</button>
      </div>

      <div id="text-reminded"><span>(Điểm tích lũy giảm 1000đ với mỗi điểm)</span></div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/js/checkout.js"></script>
</body>
</html>
