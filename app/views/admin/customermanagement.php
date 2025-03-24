<?php
     require __DIR__ . "../../../controllers/customer.controller.php";
?>
<!DOCTYPE html>
<html lang="vi">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin</title>
        <link rel="stylesheet" type="text/css" href="http://localhost/ClothingStore/public/assets/css/admin/customermanagement.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
        <link href="https://fonts.googleapis.com/css2?family=Baloo+2&display=swap" rel="stylesheet">
    </head>
    <body>
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
    
        <div class="create-kh">
            <div class="create-content">
                <button class="close-btn" onclick="closeCreate()">&times;</button>
                <div class="information">
                    <div class="info-row">
                        <span>Tên khách hàng:</span>
                        <input class="name" type="text">
                    </div>
                    <div class="info-row">
                        <span>Tên tài khoản:</span>
                        <input class="username" type="text">
                    </div>
                    <div class="info-row">
                        <span>Mật khẩu:</span>
                        <input class="pass" type="text">
                    </div>
                    <div class="info-row">
                        <span>Số điện thoại:</span>
                        <input class="phone" type="text">
                    </div>
                    <div class="info-row">
                        <span>Email:</span>
                        <input class="email" type="text">
                    </div>  
                    <div class="info-row">
                        <span>Địa chỉ:</span>
                        <input class="address" type="text">
                    </div>
                </div>
                <button class="create-btn"> Tạo </button>

            </div>
        </div>
        <div class="customermanagement-container">
            <div class="header">Quản lý khách hàng</div>
            <div class="filter-bar">
                <div class="header-bar">
                    <div>
                        <input type="text" placeholder="Nhập tên/sđt/email">
                        <button class="search-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                    <button onclick="openCreate()"><i class="fa-solid fa-plus"></i> Tạo </button>
                </div>

                <div>
                    <span>Lọc:</span>
                    <select>
                        <option value="ngaymuagannhat">Tất cả</option>
                        <option value="tongtientuthaptoicao">Bậc kim cương</option>
                        <option value="diemtichluytuthaptoicao">Bậc vàng</option>
                        <option value="tongtientucaothoithap">Bậc bạc</option>
                        <option value="diemtichluytucaotoithap">Bậc đồng</option>
                    </select>
                </div>
            </div>
            <div class="customer-table">
                <table>
                    <thead>
                        <tr>
                            <th>Mã KH</th>
                            <th>Tên KH</th>
                            <th>Điểm tích lũy</th>
                            <th>Cấp bậc</th>
                            <th>Thông tin</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="customers-container">

                    </tbody>
                </table>
            </div>
        </div>
    <div class="modal" id="customerModal">
        <div class="modal-content">
            <!-- Nút đóng -->
            <button class="close-btn" onclick="closeModal()">&times;</button>

            <div class="private-if">
            <div class="info-row">
                    <span>Tên tài khoản:</span>
                    <span>duongminh</span>
                </div>
                <div class="info-row">
                    <span>Mật khẩu</span>
                    <span>123456</span>
                </div>
            </div>
            <div class="divider"></div>
            <!-- Thông tin thanh toán -->
            <div class="information">
                <div class="info-row">
                    <span>Tên KH:</span>
                    <span>Dương Văn Minh</span>
                </div>
                <div class="info-row">
                    <span>Số điện thoại:</span>
                    <span>0868633931</span>
                </div>
                <div class="info-row">
                    <span>email:</span>
                    <span>abc@gmail.com</span>
                </div>
                <div class="info-row">
                    <span>Địa chỉ:</span>
                    <span>Đối diện Dinh Độc Lập</span>
                </div>
                <div class="info-row">
                    <span>Đơn hàng đã mua</span>
                    <span><a href="#">Lịch sử đơn hàng</a></span>
                </div>
            </div>  
            <div class="handle-btn">
                <button class="fix-btn">Sửa</button>
                <button class="save-btn">Lưu</button>
            </div>
        </div>
    </div>
    <script src="http://localhost/ClothingStore/public/assets/js/admin/customermanagement.js"></script>
    </body>
</html>