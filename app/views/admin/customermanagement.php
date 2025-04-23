<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" type="text/css" href="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/css/admin/customermanagement.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
    <?php include 'sidebar.php'; ?>

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
            </div>
            <button class="create-btn"> Tạo </button>
        </div>
    </div>
    <div class="customermanagement-container">
        <div class="header">Quản lý khách hàng</div>
        <div class="filter-bar">
            <div class="header-bar">
                <div>
                    <input type="text" placeholder="Nhập tên/sđt/email" id="searchUser">
                    <button class="search-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
                <button onclick="openCreate()"><i class="fa-solid fa-plus"></i> Tạo </button>
            </div>

            <div>
                <span style="margin-right: 5px;">Lọc:</span>
                <select style="padding: 4px;">
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
                    </tr>
                </thead>
                <tbody id="customers-container">
                    <!-- Dữ liệu sẽ được chèn ở đây -->
                </tbody>
            </table>
        </div>

        <div class="modal" id="customerModal">
            <div class="modal-content">
                <!-- Nút đóng -->
                <button class="close-btn" onclick="closeModal()">&times;</button>

                <div class="private-if">
                    <div class="info-row">
                        <span>Tên tài khoản:</span>
                        <span id="username">duongminh</span>
                    </div>
                </div>
                <div class="divider"></div>
                <!-- Thông tin thanh toán -->
                <div class="information">
                    <div class="info-row">
                        <span>Tên KH:</span>
                        <span id="fullname">Dương Văn Minh</span>
                    </div>
                    <div class="info-row">
                        <span>Số điện thoại:</span>
                        <span id="sdt">0868633931</span>
                    </div>
                    <div class="info-row">
                        <span>email:</span>
                        <span id="email">abc@gmail.com</span>
                    </div>
                    <div class="info-row">
                        <span>Đơn hàng đã mua</span>
                        <span><a href="#" id="history-btn">Lịch sử đơn hàng</a></span>
                    </div>
                </div>
                <!-- <div class="handle-btn">
                <button class="fix-btn">Sửa</button>
                <button class="save-btn">Lưu</button>
            </div> -->
            </div>
        </div>
        <!-- Modal danh sách hóa đơn -->
        <div class="modal" id="invoiceModal">
            <div class="modal-content">
                <button class="close-btn" onclick="closeInvoiceModal()">&times;</button>
                <h3>🧾 Danh sách hóa đơn</h3>
                <div class="scroll-wrapper">
                    <table class="scroll-table">
                        <thead>
                            <tr>
                                <th>Mã hóa đơn</th>
                                <th>Ngày mua</th>
                                <th>Tổng tiền</th>
                                <th>Địa chỉ</th>
                                <th>Chi tiết</th>
                            </tr>
                        </thead>
                        <tbody id="invoice-list-body">
                            <!-- JS sẽ đổ dữ liệu vào đây -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal chi tiết hóa đơn -->
        <div class="modal" id="invoiceDetailModal">
            <div class="modal-content">
                <button class="close-btn" onclick="closeInvoiceDetailModal()">&times;</button>
                <h3>📋 Chi tiết hóa đơn</h3>
                <div class="scroll-wrapper">
                    <table class="scroll-table">
                        <thead>
                            <tr>
                                <th>Tên sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Giá</th>
                            </tr>
                        </thead>
                        <tbody id="invoice-detail-body">
                            <!-- JS sẽ đổ dữ liệu vào đây -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/js/admin/customermanagement.js"></script>
</body>

</html>