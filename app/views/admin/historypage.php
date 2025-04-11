<!DOCTYPE html>
<html lang="vi">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin</title>
        <link rel="stylesheet" type="text/css" href="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/css/admin/historypage.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
        <link href="https://fonts.googleapis.com/css2?family=Baloo+2&display=swap" rel="stylesheet">
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
        </aside>
        <div class="historypage-container">
                <div class="header">Lịch sử</div>
                <div class="history-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Ngày</th>
                                <th>Chi tiết thay đổi</th>
                                <th>Thời gian</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="history-container">
                            <tr>
                                <td>25/11/2025</td>
                                <td>Cập nhật sản phẩm</td>
                                <td>12:32:32s</td>
                                <td onclick="openModal()"><a href="#">Chi tiết</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal" id="customerModal">
            <div class="modal-content">
            <!-- Nút đóng -->
            <button class="close-btn" onclick="closeModal()">&times;</button>

            <!-- Danh sách sản phẩm -->
            <div class="modal-items" id="them">
                <!-- Sản phẩm 1 -->
                <div class="item-row">
                <div class="product-info">
                    <img
                    src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/images/shirt.png"
                    alt="Sản phẩm 1"
                    class="product-img"
                    />
                    <div class="item-detail">
                        <div class="item-name">Distressed Double Knee Denim Pants Brown</div>
                        <div class="item-id">Mã: 30041975</div>
                    </div>
                </div>
            </div>

            <!-- Đường kẻ ngang -->
            <div class="divider"></div>

            <!-- Thông tin thanh toán -->
            <div class="information">
                <div class="info-row">
                    <span>Thay đổi:</span>
                    <span>Cập nhật sản phẩm</span>
                </div>
                <div class="info-row">
                    <span>Ngày: </span>
                    <span>12/11/2025</span>
                </div>
                <div class="info-row">
                    <span>Thời gian: </span>
                    <span> 23:11:32s</span>
                </div>
                <div class="info-row">
                    <span>Nội dung:</span>
                    <span> Thêm Size (M: 20 X: 20 L: 20)</span>
                </div>
                </div>
            </div>
        </div>
        <script src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/js/admin/historypage.js"></script>
    </body>
</html>
