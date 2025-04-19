<?php
     require __DIR__ . "../../../controllers/ordermanagerment.controller.php";
?>

<!DOCTYPE html>
<html lang="vi">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin</title>
        <link rel="stylesheet" type="text/css" href="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/css/admin/ordermanagement.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
        <link href="https://fonts.googleapis.com/css2?family=Baloo+2&display=swap" rel="stylesheet">
        <style>
        .status.processed { color: green; }
        .status.pending { color: orange; }
        .status.canceled { color: red; }
    </style>
    </head>
    <body>
        <aside class="sidebar">
            <img id="logo_img" src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/images/logo.png" alt="Lỗi hình ảnh không thể hiển thị"></a>
            <ul class="menu-admin">
                <a href="dashboard.php"><li>📊 Dashboard</li></a>
                <a href="productmanagement.php"><li>📦 Quản lý sản phẩm</li></a>
                <a href="ordermanagement.php"><li>📜 Quản lý đơn hàng</li></a>
                <a href="customermanagement.php"><li>👥 Quản lý khách hàng</li></a>
                <a href="khuyenmaipage.php"><li>🎟️ Quản lý khuyến mãi</li></a>
                <a href="historypage.php"><li>📈 Lịch sử</li></a>
            </ul>
        </aside>
    
        <div class="ordermanagement-container">
            <div class="header">Quản lý đơn hàng</div>
            <div class="filter-bar">
                <button class="status-btn" id="inprocessing">Đã xử lý (5)</button>
                <button class="status-btn" id="done">Chưa xử lý (5)</button>
                <button class="status-btn" id="all">Tất cả</button>
                <input  class="date-start" type="date">
                <input class="date-end" type="date">
                <button class="search-btn">🔍</button>
            </div>
            <div class="order-table">
                <table>
                    <thead>
                        <tr>
                            <th>Mã đơn hàng</th>
                            <th>Mã khách hàng</th>
                            <th>Ngày đặt</th>
                            <th>Tình trạng đơn</th>
                            <th>Thông tin</th>
                        </tr>
                    </thead>
                    <tbody id="orders-container">
                    <?php
                    $orders = getOrders();
                    while ($row = $orders->fetch_assoc()) {
                        $ngay = date("Y-m-d", strtotime($row['ngay']));

                        $isPending = $row['trangthai'] == 0;
                        $trangthai = $isPending ? "Chưa xử lý" : "Đã xử lý";
                        $colorClass = $isPending ? "red" : "green";

                        echo "
                            <tr data-trangthai={$row['trangthai']} data-date='$ngay'> 
                                <td>{$row['id']}</td>
                                <td>{$row['makh']}</td>
                                <td>$ngay</td>
                                <td class='status' style='color: {$colorClass}'>{$trangthai}</td>
                                <td><a href='#'>Thông tin đơn</a></td>
                            </tr>
                        ";
                    }                    
                    ?>
                    </tbody>
                </table>
            </div>
            </div>
        </div>

        <!-- Modal chi tiết đơn hàng -->
        <div class="modal" id="orderModal">
            <div class="modal-content" id="print-content">
                <!-- Nút đóng -->
                <button class="close-btn">&times;</button>
                <!-- Danh sách sản phẩm -->
                <div class="modal-items">
                    <div class="item-row">
                        <div class="product-info">
                            <div class="item-detail">
                                <img src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/images/anh/ao/den/OUG (1).jpg" alt="ao" class="product-img">
                                <div class="item-name">haha</div>
                                <div class="item-sizes"><S></S>Size:  &nbsp; Sl: </div>
                            </div>
                        </div>
                        <div class="item-discount">-50%</div>
                        <div id="bill-price">
                            <del class="item-original-price">đ</del>
                            <div class="item-price">đ</div>
                        </div>
                    </div>
                </div>
                    <!-- Đường kẻ ngang -->
                <div class="divider"></div>

                <!-- Thông tin thanh toán -->
                <div class="summary">
                    <div class="summary-row"><span>Tên KH:</span> <span id="customer-name"></span></div>
                    <div class="summary-row"><span>Giảm giá:</span> <span id="discount"></span></div>
                    <div class="summary-row"><span>Tạm tính:</span> <span id="subtotal"></span></div>
                    <div class="summary-row"><span>Phí vận chuyển:</span> <span id="shipping-fee"></span></div>
                    <div class="summary-row"><span>Phương thức thanh toán:</span> <span id="payment-method"></span></div>
                    <div class="summary-row">
                        <span>Trạng thái:</span>
                        <div class="status-toggle">
                            <span class="status-text"></span>
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="divider"></div>
                <div>
                    <!-- Nút in đơn -->
                    <div class="handle-btn">
                        <!-- Nút bên phải -->
                        <div class="right-buttons">
                            <button class="save-btn">Lưu</button>
                            <button class="print-btn">In đơn</button>
                        </div>
                    </div>
                    <!-- Tổng tiền -->
                    <div class="total">
                        <span>Tổng tiền:</span>
                        <span class="total-price" id="total-price"></span>
                    </div>
                </div>
            </div> <!-- Đóng div của invoice-items -->
        </div> <!-- Đóng div của invoice -->

    <script src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/js/admin/ordermanagement.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    </body>
</html>