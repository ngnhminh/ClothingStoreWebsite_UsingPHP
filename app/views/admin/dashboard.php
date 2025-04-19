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
    <?php include 'sidebar.php'; ?>

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
                <img src="https://i.pinimg.com/474x/ef/a1/40/efa14011ede7042579f6c7dd475ce7b7.jpg" alt="User">
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
