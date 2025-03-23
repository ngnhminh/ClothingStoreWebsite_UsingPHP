<?php

include $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';
$sql = "SELECT * FROM hoadon";
$result = $conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $mahoadon = $_POST['mahoadon'];
    $tinhtrang = $_POST['tinhtrang']; // Nhận giá trị "Đã xử lý" hoặc "Chưa xử lý"

    // Cập nhật trạng thái đơn hàng
    $stmt = $conn->prepare("UPDATE hoadon SET tinhtrang = ? WHERE mahoadon = ?");
    $stmt->bind_param("ss", $tinhtrang, $mahoadon);
    $stmt->execute();

    // Chuyển hướng về trang quản lý đơn hàng
    header("Location: ordermanagement.php");
    exit();
}

// Truy vấn lấy danh sách hóa đơn và chi tiết hóa đơn
$sql2 = "
    SELECT h.mahoadon, h.ngay, h.tongtien, h.tinhtrang, c.masp, c.size, c.soluong, magiamgia.tenma
    FROM hoadon h
    JOIN chitiethoadon c ON h.mahoadon = c.mahoadon
    LEFT JOIN magiamgia ON h.id = magiamgia.id
    ORDER BY h.mahoadon DESC"; 

$result2 = $conn->query($sql2);

$where = "";
if (!empty($_GET['from_date']) && !empty($_GET['to_date'])) {
    $from_date = $_GET['from_date'];
    $to_date = $_GET['to_date'];
    $where = "WHERE ngay BETWEEN '$from_date' AND '$to_date'";
}

// Truy vấn lấy đơn hàng
$sql = "SELECT * FROM hoadon $where ORDER BY ngay DESC";
$result3 = $conn->query($sql);



?>
<!DOCTYPE html>
<html lang="vi">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin</title>
        <link rel="stylesheet" type="text/css" href="/public/assets/css/admin/ordermanagement.css">
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
            <img id="logo_img" src="/public/assets/images/logo.png" alt="Lỗi hình ảnh không thể hiển thị"></a>
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
                <button>Đã xử lý (5)</button>
                <button>Chưa xử lý (5)</button>
                <button>Đã hủy (5)</button>
                <form method="GET">
    <input type="date" name="from_date" value="<?= isset($_GET['from_date']) ? $_GET['from_date'] : '' ?>">
    <input type="date" name="to_date" value="<?= isset($_GET['to_date']) ? $_GET['to_date'] : '' ?>">
    <button type="submit">🔍</button>
</form>

            </div>
            <div class="order-table">
    <table>
        <thead>
            <tr>
                <th>Mã đơn hàng</th>
                <th>diemtichluydasudung</th>
                <th>Tổng Tiền</th>
                <th>Ngày đặt</th>
                <th>Tình trạng đơn</th>
                <th>Thông tin</th>
            </tr>
        </thead>
        <tbody id="orders-container">
    <?php
    if ($result3->num_rows > 0) {
        while ($row = $result3->fetch_assoc()) {
            $statusClass = "";
            switch ($row["tinhtrang"]) {
                case "Đã xử lý":
                    $statusClass = "status processed";
                    $statusText = "Đã xử lý";
                    break;
                case "Chưa xử lý":
                    $statusClass = "status pending";
                    $statusText = "Chưa xử lý";
                    break;
                case "Đã hủy":
                    $statusClass = "status canceled";
                    $statusText = "Đã hủy";
                    break;
                default:
                    $statusText = "Không xác định";
                    break;
            }
            echo "<tr>
                    <td>{$row['mahoadon']}</td>
                    <td>{$row['diemtichluydasudung']}</td>
                    <td>{$row['tongtien']}</td>
                    <td>{$row['ngay']}</td>
                    <td class='{$statusClass}'>{$statusText}</td>
                    <td onclick='openModal()'><a href='#'>Thông tin đơn</a></td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='6'>Không có đơn hàng nào</td></tr>";
    }
    ?>
</tbody>

    </table>
</div>
        </div>
        <div class="modal" id="orderModal">
        <div class="modal-content">
        <!-- Nút đóng -->
        <button class="close-btn" onclick="closeModal()">&times;</button>

        <!-- Danh sách sản phẩm -->
        <div class="modal-items">
    <?php 
    $current_invoice = null;
    while($row = $result2->fetch_assoc()): 
        if ($current_invoice !== $row['mahoadon']):
            if ($current_invoice !== null) echo '</div>'; // Đóng div của hóa đơn trước
            $current_invoice = $row['mahoadon'];
    ?>
        <div class="invoice">
            <h3>Hóa đơn: <?= $row['mahoadon']; ?> | Ngày: <?= $row['ngay']; ?></h3>

            <!-- Trạng thái hóa đơn -->
            <form method="POST" >
    <input type="hidden" name="mahoadon" value="<?= $row['mahoadon']; ?>">
    <input type="hidden" name="tinhtrang" value="<?= ($row['tinhtrang'] == 'Đã xử lý') ? 'Chưa xử lý' : 'Đã xử lý'; ?>"> <!-- Đảo trạng thái -->
    
    <div class="summary-row">
        <span>Trạng thái:</span>
        <div class="status-toggle">
            <span class="status-text" style="color: <?= ($row['tinhtrang'] == 'Đã xử lý') ? 'red' : 'green'; ?>">
                <?= ($row['tinhtrang'] == 'Đã xử lý') ? 'Đã xử lý' : 'Chưa xử lý'; ?>
            </span>
            <label class="switch">
                <input type="submit" name="update_status" class="status-checkbox" <?= ($row['tinhtrang'] == 'Đã xử lý') ? 'checked' : ''; ?>>
                <span class="slider"></span>
            </label>
        </div>
    </div>
</form>

            <div class="invoice-items">
    <?php endif; ?>

        <!-- Hiển thị sản phẩm -->
        <div class="item-row">
            <div class="product-info">
                <img src="/public/assets/images/shirt.png" alt="<?= $row['masp']; ?>" class="product-img"/>
                <div class="item-detail">
                    <div class="item-name"><?= $row['masp']; ?></div>
                    <div class="item-sizes">Size: <?= $row['size']; ?> | SL: <?= $row['soluong']; ?></div>
                </div>
            </div>
             <div class="item-discount"><?= ($row['tenma'] > 0) ? "-{$row['tenma']}%" : "&nbsp;"; ?></div>
          <!--  <div class="item-price"><?= number_format($row['dongia']); ?>đ</div>   -->
        </div>

            </div> <!-- Đóng div của invoice-items -->
        </div> <!-- Đóng div của invoice -->
</div>

<div class="divider"></div>

<!-- Tổng kết hóa đơn -->
<div class="total">
    <span>Tổng tiền:</span>
    <span class="total-price"><?= number_format($row['tongtien']); ?>đ</span>

    <?php endwhile; ?>
</div>
    <script src="/public/assets/js/admin/ordermanagement.js"></script>
    </body>
</html>