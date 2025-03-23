<?php
     require __DIR__ . "../../../controllers/ordermanagerment.controller.php";
?>

<!DOCTYPE html>
<html lang="vi">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin</title>
        <link rel="stylesheet" type="text/css" href="http://localhost/ClothingStore/public/assets/css/admin/ordermanagement.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
        <link href="https://fonts.googleapis.com/css2?family=Baloo+2&display=swap" rel="stylesheet">
    </head>
    <body>
        <script src="http://localhost/ClothingStore/public/assets/js/admin/ordermanagement.js"></script>
        <aside class="sidebar">
            <img id="logo_img" src="http://localhost/ClothingStore/public/assets/images/logo.png" alt="Lỗi hình ảnh không thể hiển thị"></a>
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
                <button class="status-btn">Đã xử lý (5)</button>
                <button class="status-btn">Chưa xử lý (5)</button>
                <button class="status-btn">Đã hủy (5)</button>
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
                        $orderId = htmlspecialchars($row['order_id'], ENT_QUOTES, 'UTF-8'); // Đảm bảo không bị lỗi ký tự đặc biệt
                        echo "
                            <tr data-order-id='{$orderId}'> 
                                <td>{$row['order_id']}</td>
                                <td>{$row['customer_id']}</td>
                                <td>" . date("d/m/Y H:i", strtotime($row['order_date'])) . "</td>
                                <td class='status'>{$row['order_status']}</td>
                                <td class='order-info'><a href='#'>Thông tin đơn</a></td>
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
            <div class="modal-content">
            <!-- Nút đóng -->
            <button class="close-btn" onclick="closeModal()">&times;</button>

            <!-- Danh sách sản phẩm -->
            <div class="modal-items"></div>

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
                        <span class="status-text" id="order-status" style="color: green;"></span>
                        <label class="switch">
                            <input type="checkbox">
                            <span class="slider"></span>
                        </label>
                    </div>
                </div>
            </div>

            <div>
                <!-- Nút in đơn -->
                <div class="handle-btn">
                    <!-- Nút bên trái -->
                    <div class="left-buttons">
                        <button class="restore-btn">Khôi phục</button>
                        <button class="cancel-btn">Hủy</button>
                    </div>

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
        </div>
    <script src="http://localhost/ClothingStore/public/assets/js/admin/ordermanagement.js"></script>
    </body>
</html>