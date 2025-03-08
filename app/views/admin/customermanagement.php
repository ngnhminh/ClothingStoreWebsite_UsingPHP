<!DOCTYPE html>
<html lang="vi">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin</title>
        <link rel="stylesheet" type="text/css" href="/public/assets/css/admin/customermanagement.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
        <link href="https://fonts.googleapis.com/css2?family=Baloo+2&display=swap" rel="stylesheet">
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
    
        <div class="customermanagement-container">
            <div class="header">Quản lý khách hàng</div>
            <div class="filter-bar">
                <button>Khách vãng lai</button>
                <button>Có Tài khoản</button>
                <input type="text" placeholder="Nhập tên/sđt/email">
                <span>Lọc:</span>
                <select>
                    <option value="ngaymuagannhat">Ngày mua gần nhất</option>
                    <option value="tongtientuthaptoicao">Tổng tiền từ cao tới thấp</option>
                    <option value="diemtichluytuthaptoicao">Điểm tích lũy từ cao tới thấp</option>
                    <option value="tongtientucaothoithap">Tổng tiền từ cao tới thấp</option>
                    <option value="diemtichluytucaotoithap">Điểm tích lũy từ cao tới thấp</option>
                </select>
                <button>🔍</button>
            </div>
            <div class="customer-table">
                <table>
                    <thead>
                        <tr>
                            <th>Mã KH</th>
                            <th>Tên KH</th>
                            <th>Tổng sản lượng mua</th>
                            <th>Điểm tích lũy</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="cutomers-container">
                        <tr>
                            <td>1</td>
                            <td>Hoàng Văn Thụ</td>
                            <td>10</td>
                            <td>500</td>
                            <td onclick="openModal()"><a href="#">Thông tin đơn</a></td>
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
        <div class="modal-items">
            <!-- Sản phẩm 1 -->
            <div class="item-row">
            <div class="product-info">
                <img
                src="/public/assets/images/shirt.png"
                alt="Sản phẩm 1"
                class="product-img"
                />
                <div class="item-detail">
                    <div class="item-name">Distressed Double Knee Denim Pants Brown</div>
                    <div class="item-sizes">Size: M &nbsp; Sl: 2</div>
                    <div class="item-bought-date"> Ngày mua: 28/5/2025</div>
                </div>
            </div>
            <div class="item-discount">-20%</div>
            <div id="bill-price">
                <del class="item-original-price">200.000đ</del>
                <div class="item-price">100.000đ</div>
            </div>
            </div>

            <!-- Sản phẩm 2 -->
            <div class="item-row">
            <div class="product-info">
                <img
                src="/public/assets/images/shirt.png"
                alt="Sản phẩm 2"
                class="product-img"
                />
                <div class="item-detail">
                    <div class="item-name">Distressed Double Knee Denim Pants Brown</div>
                    <div class="item-sizes">Size: M &nbsp; Sl: 2</div>
                </div>
            </div>
            <div class="item-discount">&nbsp;</div>
            <div class="item-price">250.000đ</div>
            </div>

            <div class="item-row">
            <div class="product-info">
                <img
                src="/public/assets/images/shirt.png"
                alt="Sản phẩm 2"
                class="product-img"
                />
                <div class="item-detail">
                    <div class="item-name">Distressed Double Knee Denim Pants Brown</div>
                    <div class="item-sizes">Size: M &nbsp; Sl: 2</div>
                </div>
            </div>
            <div class="item-discount">&nbsp;</div>
            <div class="item-price">250.000đ</div>
            </div>

            <div class="item-row">
            <div class="product-info">
                <img
                src="/public/assets/images/shirt.png"
                alt="Sản phẩm 2"
                class="product-img"
                />
                <div class="item-detail">
                <div class="item-name">Distressed Double Knee Denim Pants Brown</div>
                <div class="item-sizes">Size: M &nbsp; Sl: 2</div>
                </div>
            </div>
            <div class="item-discount">&nbsp;</div>
            <div class="item-price">250.000đ</div>
            </div>

            <div class="item-row">
            <div class="product-info">
                <img
                src="/public/assets/images/shirt.png"
                alt="Sản phẩm 2"
                class="product-img"
                />
                <div class="item-detail">
                <div class="item-name">Distressed Double Knee Denim Pants Brown</div>
                <div class="item-sizes">Size: M &nbsp; Sl: 2</div>
                </div>
            </div>
            <div class="item-discount">&nbsp;</div>
            <div class="item-price">250.000đ</div>
            </div>

            <!-- Sản phẩm 3 -->
            <div class="item-row">
            <div class="product-info">
                <img
                src="/public/assets/images/shirt.png"
                alt="Sản phẩm 3"
                class="product-img"
                />
                <div class="item-detail">
                <div class="item-name">Distressed Double Knee Denim Pants Brown</div>
                <div class="item-sizes">Size: M &nbsp; Sl: 2</div>
                </div>
            </div>
            <div class="item-discount">&nbsp;</div>
            <div class="item-price">250.000đ</div>
            </div>
        </div>

        <!-- Đường kẻ ngang -->
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
                <span>Tài khoản:</span>
                <span>Không có</span>
            </div>
            <div class="info-row">
                <span>Tổng tiền đã mua:</span>
                <span>5.000.000đ</span>
            </div>
            <div class="info-row">
                <span>Tổng số lượng:</span>
                <span>50</span>
            </div>
        </div>
    </div>
    <script src="/public/assets/js/admin/customermanagement.js"></script>
    </body>
</html>