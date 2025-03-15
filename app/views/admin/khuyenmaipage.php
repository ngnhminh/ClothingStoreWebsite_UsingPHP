
<?php
     
     require_once __DIR__ . "/../../controllers/khuyenmaimanagement.php";

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
            <button>Áo (25)</button>
            <button>Quần (25)</button>
            <button>Kính (25)</button>
            <button>Giày (25)</button>
            <button>SP giảm giá</button>
            <button id="storage">Tất cả</button>
            <button id="voucherstorage">Kho voucher</button>
            <input type="text" placeholder="Nhập tên sản phẩm">
        </div>

        <div class="product-list" id="product-list">
            <div class="product">
            <div class="product-thumbnail">
                    <div class="product-thumbnail_wrapper">
                        <img class="product-thumbnail__image" src="/public/assets/images/shirt.png" alt="Áo thun" />
                    </div>
                </div>
                <p>Distressed Double Knee Denim Pants Brown</p>
                <span><del>500.000đ</del><span id="percent_discount">-20%</span></span>
                <span>300.000đ</span>
            </div>
            <div class="product">
                <div class="product-thumbnail">
                    <div class="product-thumbnail_wrapper">
                        <img class="product-thumbnail__image" src="/public/assets/images/shirt.png" alt="Áo thun" />
                    </div>
                </div>
                <p>Distressed Double Knee Denim Pants Brown</p>
            </div>
            <div class="product">
            <div class="product-thumbnail">
                    <div class="product-thumbnail_wrapper">
                        <img class="product-thumbnail__image" src="/public/assets/images/shirt.png" alt="Áo thun" />
                    </div>
                </div>
                <p>Distressed Double Knee Denim Pants Brown</p>
            </div>
            <div class="product">
            <div class="product-thumbnail">
                    <div class="product-thumbnail_wrapper">
                        <img class="product-thumbnail__image" src="/public/assets/images/shirt.png" alt="Áo thun" />
                    </div>
                </div>
                <p>Distressed Double Knee Denim Pants Brown</p>
            </div>
        </div>
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
                <tr>
                    <td>VTG69898k</td>
                    <td>Vui tết </td>
                    <td>100</td>
                    <td>Còn</td>
                </tr>
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



    </script>

</body>
</html>