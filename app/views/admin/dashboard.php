<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" type="text/css" href="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/css/admin/dashboard.css">
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
        </ul>
    </aside>

    <main class="content">
        <header class="topbar">
            <div class="filter">
                <label>Lọc: 
                    <select>
                        <option>Ngày</option>
                        <option>Tháng</option>
                    </select>
                </label>
                <input type="date">
                <input type="date">
                <button>🔍</button>
            </div>
            <div class="profile">
                <img src="avatar.png" alt="User">
            </div>
        </header>

        <!-- Thống kê -->
        <section class="stats">
            <div class="stat-box green">
                <span class="reported-title">Tổng số đơn:</span>
                <span class="reported-num">1</span>
                <div class="reported-btn-decor reported-btn-decor-green">
                    <span class="reported-btn">Xem chi tiết</span>
                </div>
            </div>
            <div class="stat-box blue">
                <span class="reported-title">Doanh thu:</span>
                <span class="reported-num">1</span> 
                <div class="reported-btn-decor reported-btn-decor-blue">
                    <span class="reported-btn">Xem chi tiết</span>
                </div>
            </div>
            <div class="stat-box yellow">
                <span class="reported-title">Chưa xử lý:</span>
                <span class="reported-num">1</span>
                <div class="reported-btn-decor reported-btn-decor-yellow">
                    <span class="reported-btn">Xem chi tiết</span>
                </div>
            </div>
            <div class="stat-box red">
                <span class="reported-title">Đơn chờ giao:</span>
                <span class="reported-num">1</span>
                <div class="reported-btn-decor reported-btn-decor-red">
                    <span class="reported-btn">Xem chi tiết</span>
                </div>
            </div>
        </section>

        <!-- Bảng dữ liệu -->
        <section class="summary">
            <div class="summary-box">
                <p>Doanh thu hôm nay</p>
                <h2>8M <span class="up">25% ↑</span></h2>
            </div>
            <div class="summary-box">
                <p>Đơn đợi xử lý</p>
                <h2>3</h2>
            </div>
            <div class="summary-box">
                <p>Đơn hôm nay</p>
                <h2>24 <span class="down">25% ↓</span></h2>
            </div>
            <div class="summary-box">
                <p>Đơn hủy</p>
                <h2>1</h2>
            </div>
        </section>

        <!-- Biểu đồ -->
        <section class="charts">
            <div class="chart-box">
                <p>Biểu đồ cột doanh thu</p>
                <canvas id="barChart"></canvas>
            </div>
            <div class="chart-box">
                <p>Biểu đồ diện</p>
                <canvas id="lineChart"></canvas>
            </div>
        </section>
    </main>
    <script src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/js/admin/dashboard.js"></script>
</body>
</html>
