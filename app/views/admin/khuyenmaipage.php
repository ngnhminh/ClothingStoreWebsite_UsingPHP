
<?php
     
     require_once __DIR__ . "/../../controllers/khuyenmaimanagement.php";
// get san pham 
$sql = "SELECT id, tensp, gia, giamgia FROM sanpham";
$result = $conn->query($sql);
// so luong laoi san phampham
$sql2 = "SELECT loaisanpham.tenloai, SUM(soluong) AS tong_soluong  
FROM sanpham  
INNER JOIN mausanpham ON sanpham.id = mausanpham.masp_id  
INNER JOIN loaisanpham ON loaisanpham.maloai = sanpham.maloai_id  
INNER JOIN kichco ON kichco.mau_sanpham_id = mausanpham.id  
INNER JOIN mau ON mau.id = mausanpham.mau_id  

GROUP BY loaisanpham.tenloai  
ORDER BY loaisanpham.tenloai ASC  
LIMIT 0, 1000";
$result2 = $conn->query($sql2);

// Lưu dữ liệu vào mảng
$counts = [];
while ($row = $result2->fetch_assoc()) {
    $counts[$row['tenloai']] = $row['tong_soluong'];
}
// get voucher
$sql3 = "SELECT codegiamgia, tenma, soluong FROM magiamgia";
$result3 = $conn->query($sql3);
// timkiemtimkiem
$search = "";
if (isset($_POST['query'])) {
    $search = $conn->real_escape_string($_POST['query']);
}

// Truy vấn lấy sản phẩm theo tên
$sql4 = "SELECT id, tensp, gia, giamgia FROM sanpham 
        WHERE tensp LIKE '%$search%'";

$result4 = $conn->query($sql4);

$conn->close();
?>


<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"  href="/public/assets/css/admin/khuyenmaipage.css">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2&display=swap" rel="stylesheet">
    <title>Voucher</title>
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
    <div class="productlist-container">
        <div class="header">
            Quản lý Khuyến mãi 
            <button class="add-voucher-voucher" id="add-voucher-voucher">+ Thêm voucher</button>
        </div>
        
        <div class="toolbar-voucher">
    <button>Áo (<?= $counts['Áo'] ?? 0 ?>)</button>
    <button>Quần (<?= $counts['Quần'] ?? 0 ?>)</button>
    <button>Kính (<?= $counts['Kính'] ?? 0 ?>)</button>
    <button>Giày (<?= $counts['Giày'] ?? 0 ?>)</button>
    <button id="storage">Tất cả</button>
    <button id="voucherstorage">Kho voucher</button>
    <form method="POST" action="">
        <input type="text" name="query" placeholder="Nhập tên sản phẩm" value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">Tìm kiếm</button>
    </form>
</div>



<div class="product-list"  id="product-list">
        <?php if ($result4->num_rows > 0): ?>
            <?php while ($row = $result4->fetch_assoc()): ?>
                <div class="product">
                    <div class="product-thumbnail">
                        <img src="/public/assets/images/shirt.png" alt="<?php echo htmlspecialchars($row['tensp']); ?>">
                    </div>
                    <p><?php echo htmlspecialchars($row['tensp']); ?></p>
                    <span>
                        <del><?php echo number_format($row['gia']); ?>đ</del>
                        <span id="percent_discount">-<?php echo $row['giamgia']; ?>%</span>
                    </span>
                    <span><?php echo number_format($row['gia'] * (1 - $row['giamgia'] / 100)); ?>đ</span>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Không tìm thấy sản phẩm</p>
        <?php endif; ?>
    </div>

<!-- Form nhập khuyến mãi -->
<div class="discount-modal"><?php require 'khuyenmaiadd.php'; ?></div>
</div>
<div class="voucher-container">
    <table class="voucher-table">
        <thead>
            <tr>
                <th>Mã voucher</th>
                <th>Tên voucher</th>
                <th>Số lượng</th>
                <th>Tình trạng</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // 3. Hiển thị dữ liệu từ database lên bảng HTML
            if ($result3->num_rows > 0) {
                while($row = $result3->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["codegiamgia"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["tenma"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["soluong"]) . "</td>";
                    
                    // Xác định tình trạng dựa trên số lượng
                    $status = ($row["soluong"] > 0) ? "Còn" : "Hết";
                    echo "<td>" . $status . "</td>";

                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Không có voucher nào.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
 
    <div class="discount-modal"><?php require 'voucheradd.php'; ?></div>
    <script src="/public/assets/js/admin/khuyenmaipage.js"></script>
    <script>
        
        async function addVoucher() {
  
    let voucherName = document.getElementById("voucher_name")?.value.trim() || "";
    let voucherCode = document.getElementById("voucher_code")?.value.trim() || "";
    let quantity = document.getElementById("quantity")?.value.trim() || "";

    if (!discount && !voucherName && !voucherCode && !quantity) {
        alert("Vui lòng nhập đầy đủ thông tin.");
        return;
    }

    let formData = new FormData();
 
    formData.append("voucher_name", voucherName);
    formData.append("voucher_code", voucherCode);
    formData.append("quantity", quantity);

    try {
        let response = await fetch("khuyenmai.php", {
            method: "POST",
            body: formData
        });

        let textResponse = await response.text();
        console.log("Response từ PHP:", textResponse);

        if (textResponse.includes("Thêm voucher thành công")) {
            alert("Thêm voucher thành công!");

            // ✅ Cập nhật bảng hiển thị voucher
            let status = (parseInt(quantity) > 0) ? "Còn" : "Hết";
            let voucherList = document.querySelector(".voucher-table tbody");
            let newVoucher = document.createElement("tr");
            newVoucher.innerHTML = `
                <td>${voucherCode}</td>
                <td>${voucherName}</td>
                <td>${quantity}</td>
                <td>${status}</td>
            `;
            voucherList.appendChild(newVoucher);

            // ✅ Xóa dữ liệu trong form
         
            document.getElementById("voucher_name").value = "";
            document.getElementById("voucher_code").value = "";
            document.getElementById("quantity").value = "";

            // ✅ Đóng modal (nếu có)
            if (typeof closeModal === "function") closeModal();
        } else {
            alert("Có lỗi xảy ra: " + textResponse);
        }
    } catch (error) {
        console.error("Fetch error:", error);
        alert("Lỗi khi gửi dữ liệu: " + error.message);
    }
}



document.querySelectorAll('.product').forEach(product => {
    product.addEventListener('click', function () {
        let productId = this.id.replace('product-', ''); // Lấy ID thật của sản phẩm
        document.getElementById('product-id').value = productId; // Gán vào input ẩn
        console.log("Sản phẩm đã chọn có ID:", productId);
    });
});


    </script>

    

</body>
</html>