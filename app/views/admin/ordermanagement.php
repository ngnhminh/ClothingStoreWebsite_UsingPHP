<!DOCTYPE html>
<html lang="vi">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin</title>
        <link rel="stylesheet" type="text/css" href="/public/assets/css/admin/ordermanagement.css">
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
                <li>🎟️ Quản lý khuyến mãi</li>
                <li>📈 Thống kê</li>
            </ul>
        </aside>
    
        <div class="ordermanagement-container">
            <div class="header">Quản lý đơn hàng</div>
            <div class="filter-bar">
                <button>Đã xử lý (5)</button>
                <button>Chưa xử lý (5)</button>
                <button>Đã hủy (5)</button>
                <input type="date">
                <input type="date">
                <button>🔍</button>
            </div>
            <div class="order-table">
                <table>
                    <thead>
                        <tr>
                            <th>Mã đơn hàng</th>
                            <th>Tên đơn</th>
                            <th>Số lượng</th>
                            <th>Ngày đặt</th>
                            <th>Tình trạng đơn</th>
                            <th>Thông tin</th>
                        </tr>
                    </thead>
                    <tbody id="orders-container">
                        <tr>
                            <td>1</td>
                            <td>Giày, dép ...</td>
                            <td>1</td>
                            <td>25/12/2025 22:10</td>
                            <td class="status processed">Đã xử lý</td>
                            <td onclick="openModal()"><a href="#">Thông tin đơn</a></td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Giày, dép ...</td>
                            <td>1</td>
                            <td>25/12/2025 22:10</td>
                            <td class="status processed">Đã xử lý</td>
                            <td onclick="openModal()"><a href="#">Thông tin đơn</a></td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Giày, dép ...</td>
                            <td>1</td>
                            <td>25/12/2025 22:10</td>
                            <td class="status processed">Đã xử lý</td>
                            <td onclick="openModal()"><a href="#">Thông tin đơn</a></td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Giày, dép ...</td>
                            <td>1</td>
                            <td>25/12/2025 22:10</td>
                            <td class="status processed">Đã xử lý</td>
                            <td onclick="openModal()"><a href="#">Thông tin đơn</a></td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Giày, dép ...</td>
                            <td>1</td>
                            <td>25/12/2025 22:10</td>
                            <td class="status processed">Đã xử lý</td>
                            <td onclick="openModal()"><a href="#">Thông tin đơn</a></td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Giày, dép ...</td>
                            <td>1</td>
                            <td>25/12/2025 22:10</td>
                            <td class="status processed">Đã xử lý</td>
                            <td onclick="openModal()"><a href="#">Thông tin đơn</a></td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Giày, dép ...</td>
                            <td>1</td>
                            <td>25/12/2025 22:10</td>
                            <td class="status processed">Đã xử lý</td>
                            <td onclick="openModal()"><a href="#">Thông tin đơn</a></td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Giày, dép ...</td>
                            <td>1</td>
                            <td>25/12/2025 22:10</td>
                            <td class="status processed">Đã xử lý</td>
                            <td onclick="openModal()"><a href="#">Thông tin đơn</a></td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Giày, dép ...</td>
                            <td>1</td>
                            <td>25/12/2025 22:10</td>
                            <td class="status processed">Đã xử lý</td>
                            <td onclick="openModal()"><a href="#">Thông tin đơn</a></td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Giày, dép ...</td>
                            <td>1</td>
                            <td>25/12/2025 22:10</td>
                            <td class="status processed">Đã xử lý</td>
                            <td onclick="openModal()"><a href="#">Thông tin đơn</a></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Giày, dép ...</td>
                            <td>1</td>
                            <td>25/12/2025 22:10</td>
                            <td class="status pending">Chưa xử lý</td>
                            <td onclick="openModal()"><a href="#">Thông tin đơn</a></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Giày, dép ...</td>
                            <td>1</td>
                            <td>25/12/2025 22:10</td>
                            <td class="status canceled">Đã hủy</td>
                            <td onclick="openModal()"><a href="#">Thông tin đơn</a></td>
                        </tr>
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
        <div class="summary">
            <div class="summary-row">
                <span>Tên KH</span>
                <span>Dương Văn Minh</span>
            </div>
            <div class="summary-row">
                <span>Giảm giá:</span>
                <span>500.000đ</span>
            </div>
            <div class="summary-row">
                <span>Tạm tính:</span>
                <span>500.000đ</span>
            </div>
            <div class="summary-row">
                <span>Phí vận chuyển:</span>
                <span>500.000đ</span>
            </div>
            <div class="summary-row">
                <span>Phương thức thanh toán:</span>
                <span>Chuyển khoản</span>
            </div>
            <div class="summary-row">
                <span>Trạng thái:</span>
            <div class="status-toggle">
                <span class="status-text" style="color: green;">Đã xử lý</span>
                <!-- Toggle switch -->
                <label class="switch">
                <input type="checkbox" checked>
                <span class="slider"></span>
                </label>
            </div>
            </div>
        </div>

        <!-- Nút in đơn -->
        <div class="print-btn">
            <button>In đơn</button>
        </div>

        <!-- Tổng tiền -->
        <div class="total">
            <span>Tổng tiền:</span>
            <span class="total-price">1.000.000đ</span>
        </div>
        </div>
    </div>
    <script src="/public/assets/js/admin/ordermanagement.js"></script>
    </body>
</html>