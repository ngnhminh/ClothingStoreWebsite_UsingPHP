<!DOCTYPE html>
<html lang="vi">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/css/userpage.css">
        <link href="https://fonts.googleapis.com/css2?family=Baloo+2&display=swap" rel="stylesheet">
        <title>Trang hàng</title>
        <style>
            #overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                backdrop-filter: blur(4px);
                background-color: rgba(0, 0, 0, 0.3);
                z-index: 999;
                display: none;
            }

            .modal {
                display: none;
                position: fixed;
                z-index: 1000;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background-color: #fff;
                padding: 30px 40px;
                border-radius: 15px;
                box-shadow: 0 8px 16px rgba(0,0,0,0.2);
                /* width: 400px; */
                max-width: 90%;
                font-family: 'Baloo 2', sans-serif;
            }

            .modal-content h2 {
                margin-bottom: 15px;
                font-size: 22px;
                text-align: center;
            }

            .modal-content label {
                display: block;
                margin-top: 10px;
                font-weight: 500;
            }

            .modal-content input {
                width: 100%;
                padding: 10px;
                margin-top: 5px;
                border-radius: 8px;
                border: 1px solid #ccc;
                font-size: 14px;
            }

            .modal-buttons {
                margin-top: 20px;
                display: flex;
                justify-content: space-between;
            }

            .modal-buttons button {
                padding: 8px 16px;
                border: none;
                border-radius: 8px;
                font-size: 14px;
                cursor: pointer;
                transition: 0.3s;
            }

            .modal-buttons button:first-child {
                background-color: #333;
                color: white;
            }

            .modal-buttons button:last-child {
                background-color: #ccc;
                color: #333;
            }

            .modal-buttons button:hover {
                opacity: 0.9;
            }
        </style>
    </head>
    <body>
        <header>
            <?php require 'header.php'; ?>
        </header>
        <main>
        <main class="infoproduct_container">
            <h2 id="userpage-title">Danh sách sản phẩm yêu thích</h2><br> 
            <div class="wishlist">
                <table>
                    <thead>
                        <tr id="fav-product-navbar">
                            <th>Sản phẩm</th>
                            <th>Giá</th>
                            <th></th>
                            <th></th>
                        </tr>
                        <tr id="history-product-navbar">
                            <th style="width: 10%">Mã Đơn hàng</th>
                            <th style="width: 20%">Ngày đặt</th>
                            <th style="text-align: center; width: 20%">Số lượng</th>
                            <th style=" width: 30%">Giá tiền</th>
                            <th style=" width: 20%"></th>
                        </tr>
                    </thead>
                    <tbody class="user-productlist-container">
                        <!-- <tr class="fav-product">
                            <td>
                                <img src="/public/assets/images/shirt.png" alt="Pants">
                                <span class="break-word">Distressed Double Knee Denim Pants Brown</span>
                            </td>
                            <td class="flex-container">
                                <strong>250.000đ</strong>
                                <button class="userpage-btn">Mua ngay</button>
                                <i class="fa-solid fa-trash"></i>
                            </td>
                        </tr>
                        <tr class="fav-product">
                            <td>
                                <img src="/public/assets/images/shirt.png" alt="Pants">
                                <span>Distressed Double Knee Denim Pants Brown</span>
                            </td>
                            <td class="flex-container">
                                <strong>250.000đ</strong>
                                <button class="userpage-btn">Mua ngay</button>
                                <i class="fa-solid fa-trash"></i>
                            </td>
                        </tr> -->
                        <!-- <tr class="purchased-order" id="purchased-order">
                            <td>
                                <span>Distressed Double Knee Denim Pants Brown</span>
                            </td>
                            <td>
                                <span>25/3/2005</span>
                            </td>
                            <td id="number_of_product">
                                <strong>1</strong>
                            </td>
                            <td class="flex-container">
                                <strong>250.000đ</strong>
                                <button class="userpage-btn">Đơn hàng</button>
                            </td>
                        </tr> -->
                    </tbody>
                </table>
            </div>

            <!-- Thông tin người dùng -->
            <aside class="user-info-box">
                <h3>Thông tin</h3>
                <p><strong>User:</strong> <span id="user-name"></span></p>
                <p><strong>Name:</strong> <span id="user-fullname"></span></p>
                <p><strong>Password:</strong> <span id="user-password">****</span> 
                    <button type="button" id="toggle-password" onclick="togglePasswordVisibility()">Hiện</button>
                </p>
                <p><strong>Phone:</strong> <span id="user-phone"></span></p>
                <p><strong>Email:</strong> <span id="user-email"></span></p>
                <p><strong>Điểm tích lũy:</strong> <span id="user-points"></span></p>
                <button class="change-password">Change password</button>
                <button value="1" class="order-history" id="userpage-button" onclick="ChangeTitle()">Lịch sử mua hàng</button>
            </aside>
        </main>

        <!-- Overlay làm mờ -->
        <div id="overlay"></div>

        <!-- Modal đổi mật khẩu -->
        <div id="change-password-modal" class="modal">
            <div class="modal-content">
                <h2>Đổi mật khẩu</h2>
                <label for="old-password">Mật khẩu cũ</label>
                <input type="password" id="old-password" placeholder="Nhập mật khẩu cũ">
                
                <label for="new-password">Mật khẩu mới</label>
                <input type="password" id="new-password" placeholder="Nhập mật khẩu mới">
                
                <label for="confirm-password">Nhập lại mật khẩu mới</label>
                <input type="password" id="confirm-password" placeholder="Xác nhận mật khẩu mới">

                <div class="modal-buttons">
                    <button onclick="submitPasswordChange()">Xác nhận</button>
                    <button onclick="closeModal()">Hủy</button>
                </div>
            </div>
        </div>

        <div id="order-detail-modal" class="modal">
            <div class="modal-content">
                <div class="invoice">
                    <div class="product-list" id="product-list">
                        <!-- <div class="product">
                            <img src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/images/shirt.png" alt="Product">
                            <div class="product-info">
                                <p class="product-name">Distressed Double Knee Denim Pants Brown</p>
                                <p class="product-details">Size: M &nbsp; SL: 2</p>
                                <p class="product-price">
                                    <span class="old-price">200.000đ</span>
                                    <span class="discount">-20%</span>
                                    <span class="new-price">100.000đ</span>
                                </p>
                            </div>
                        </div>
                        <div class="product">
                            <img src="/public/assets/images/shirt.png" alt="Product">
                            <div class="product-info">
                                <p class="product-name">Distressed Double Knee Denim Pants Brown</p>
                                <p class="product-details">Size: M &nbsp; SL: 2</p>
                                <p class="product-price"><span class="new-price">250.000đ</span></p>
                            </div>
                        </div>
                        <div class="product">
                            <img src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/images/shirt.png" alt="Product">
                            <div class="product-info">
                                <p class="product-name">Distressed Double Knee Denim Pants Brown</p>
                                <p class="product-details">Size: M &nbsp; SL: 2</p>
                                <p class="product-price"><span class="new-price">250.000đ</span></p>
                            </div>
                        </div> -->
                    </div>

                    <hr>

                    <div class="summary" id="summary">
                        <p>Tạm tính: <span>500.000đ</span></p>
                        <p>Giảm giá: <span>500.000đ</span></p>
                        <p>Phí vận chuyển: <span>-30.000đ</span></p>
                        <p>Phương thức thanh toán: <span>Ship COD</span></p>
                        <p>Trạng thái: <span class="processed">Đã xử lý</span></p>
                    </div>

                    <div class="total" id="total">
                        <p>Tổng tiền: <span>1.000.000đ</span></p>
                    </div>
                    <button onclick="closeModal()">Hủy</button>
                </div>
            </div>
        </div>

        <div id="loading-screen" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(255,255,255,0.8); z-index:9999; justify-content:center; align-items:center;">
            <div class="spinner"></div>
        </div>
        
        <div id="myModal" class="modal" style="display:none;">
            <div class="modal-content" id="modal-content"></div>
        </div>

        <footer>
            <?php require 'footer.php'; ?>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script>
            document.querySelector(".change-password").addEventListener("click", () => {
                document.getElementById("overlay").style.display = "block";
                document.getElementById("change-password-modal").style.display = "block";
            });

            function closeModal() {
                document.getElementById("overlay").style.display = "none";
                document.getElementById("change-password-modal").style.display = "none";
                document.getElementById("order-detail-modal").style.display = "none";
            }

            let user = JSON.parse(localStorage.getItem("user"));
            window.addEventListener('userUpdated', function() {
                let userUpdated = JSON.parse(localStorage.getItem("user"));
                console.log("Thông tin người dùng đã được cập nhật:", userUpdated);
                user = userUpdated; // Cập nhật lại biến user toàn cục với dữ liệu mới
            });
            function togglePasswordVisibility() {
                const pwSpan = document.getElementById("user-password");
                const toggleBtn = document.getElementById("toggle-password");

                if (pwSpan.innerText.includes("*")) {
                    pwSpan.innerText = user?.matkhau || "Không có mật khẩu";
                    toggleBtn.innerText = "Ẩn";
                } else {
                    let stars = "*".repeat(user?.password?.length || 4);
                    pwSpan.innerText = stars;
                    toggleBtn.innerText = "Hiện";
                }
            }

            function submitPasswordChange() {
                var newpasssword = document.getElementById("new-password");
                var newPassswordConfirm = document.getElementById("confirm-password");
                
                var oldpassword = document.getElementById("old-password");
                if(oldpassword.value != user.matkhau){
                    alert("Mật khẩu cũ không khớp");
                    return;
                }

                if(newpasssword.value != newPassswordConfirm.value){
                    alert("Mật khẩu mới không khớp");
                    return
                }else{
                    axios.post("http://localhost/ClothingStoreWebsite_UsingPHP/app/controllers/userPageController.php", {
                        action: 'changePassword',
                        matk: user.matk,
                        matkhau: newpasssword.value
                    })
                    .then(function (response) {
                        // alert(response.data);
                        window.location.href = "userpage.php";
                    })
                    .catch(function (error) {
                        console.error("Lỗi:", error);
                        alert("Đổi mật khẩu thất bại.");
                    });
                }
                //Kiểm tra khớp mật khẩu cũ và mới

                alert("Mật khẩu đã được đổi thành công!");
                closeModal();
            }

            function ChangeTitle() {
                try {
                    const title = document.getElementById("userpage-title");
                    const change_button = document.getElementById("userpage-button");
                    const history_product_navbar = document.getElementById("history-product-navbar");
                    const fav_product_navbar = document.getElementById("fav-product-navbar");
                    const user_productlist_container = document.querySelector('.user-productlist-container');
                    const user_fav_product = user_productlist_container.querySelectorAll('.fav-product');
                    const user_purchased_order = user_productlist_container.querySelectorAll('.purchased-order');

                    if (!title.dataset.state) {
                        title.dataset.state = "1"; // Mặc định là trạng thái yêu thích
                    }

                    if (title.dataset.state === "1") {
                        change_button.textContent = "Danh sách yêu thích";
                        title.innerText = "Lịch sử mua hàng";
                        fav_product_navbar.style.display = "none";
                        history_product_navbar.style.display = "table-row";

                        user_fav_product.forEach(child => child.style.display = "none");
                        user_purchased_order.forEach(child => child.style.display = "table-row");

                        // Gọi API để lấy lịch sử mua hàng
                        if (!historyLoaded) {
                            updateHistory();
                            historyLoaded = true;
                        }

                        title.dataset.state = "0";
                    } else {
                        change_button.textContent = "Lịch sử mua hàng";
                        title.innerText = "Danh sách yêu thích";
                        fav_product_navbar.style.display = "table-row";
                        history_product_navbar.style.display = "none";

                        user_fav_product.forEach(child => child.style.display = "table-row");
                        user_purchased_order.forEach(child => child.style.display = "none");

                        // Gọi API để lấy danh sách sản phẩm yêu thích
                        if (!favLoaded) {
                            updateWishlist();
                            favLoaded = true;
                        }

                        title.dataset.state = "1";
                    }
                } catch (error) {
                    console.error("Error:", error.message);
                }
            }
            let favLoaded = false;
            let historyLoaded = false;

            document.addEventListener("DOMContentLoaded", () => {
                updateWishlist();
                favLoaded = true;
            });

            function formatToVND(price) {
                return price.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
            }

            // Cập nhật lịch sử mua hàng
            function updateHistory() {
                const container = document.querySelector(".user-productlist-container");
                axios.get('http://localhost/ClothingStoreWebsite_UsingPHP/app/controllers/userPageController.php', {
                    params: {
                        action: "getHoaDonByMatk",
                        matk: user.matk
                    }
                }).then(res => {
                    if (res.data.success && res.data.getHoaDonByMatk) {
                        res.data.getHoaDonByMatk.forEach(order => {
                            const tr = document.createElement("tr");    
                            tr.classList.add("purchased-order");
                            tr.style.display = "table-row";
                            tr.innerHTML = `
                                <td><span>${order.id}</span></td>
                                <td><span>${order.ngay}</span></td>
                                <td><strong>${order.soluong}</strong></td>
                                <td class="flex-container">
                                    <strong>${formatToVND(order.tongtien)}</strong>
                                </td>
                                <td>
                                    <button class="detailOrderBtn">Đơn hàng</button>
                                </td>
                            `;

                            const detailOrderBtn = tr.querySelector(".detailOrderBtn");
                            detailOrderBtn.addEventListener("click", () => {
                                console.log("clicked", order.id);
                                const productlist = document.getElementById("product-list");
                                productlist.innerHTML = ``;
                                axios.get('http://localhost/ClothingStoreWebsite_UsingPHP/app/controllers/userPageController.php', {
                                    params: {
                                        action: 'getChiTietHoaDonByMaHoaDon',
                                        orderid: order.id
                                    }
                                }).then(res => {
                                    if (res.data.success) {
                                        if (res.data.getChiTietHoaDonByMaHoaDon) {
                                            res.data.getChiTietHoaDonByMaHoaDon.forEach(item => {
                                                const productDiv = document.createElement("div");
                                                productDiv.className = "product";

                                                const img = document.createElement("img");
                                                img.src = item.duongdananh;
                                                img.alt = "Product";
                                                productDiv.appendChild(img);

                                                const infoDiv = document.createElement("div");
                                                infoDiv.className = "product-info";

                                                const nameP = document.createElement("p");
                                                nameP.className = "product-name";
                                                nameP.textContent = item.tensp;

                                                const detailsP = document.createElement("p");
                                                detailsP.className = "product-details";
                                                detailsP.innerHTML = `Size: ${item.size} &nbsp; SL: ${item.soluong}`;

                                                const priceP = document.createElement("p");
                                                priceP.className = "product-price";

                                                if (item.giamgia > 0) {
                                                    const oldPrice = document.createElement("span");
                                                    oldPrice.className = "old-price";
                                                    oldPrice.textContent = formatToVND(item.gia);

                                                    const newPrice = document.createElement("span");
                                                    newPrice.className = "new-price";
                                                    newPrice.textContent = formatToVND(item.gia * (1 - item.giamgia / 100));

                                                    const discount = document.createElement("span");
                                                    discount.className = "discount";
                                                    discount.textContent = `-${item.giamgia}%`;

                                                    priceP.appendChild(newPrice);
                                                    priceP.appendChild(oldPrice);
                                                    priceP.appendChild(discount);

                                                } else {
                                                    const newPrice = document.createElement("span");
                                                    newPrice.className = "new-price";
                                                    newPrice.textContent = formatToVND(item.gia);
                                                    priceP.appendChild(newPrice);
                                                }

                                                // Gắn các thành phần vào infoDiv
                                                infoDiv.appendChild(nameP);
                                                infoDiv.appendChild(detailsP);
                                                infoDiv.appendChild(priceP);

                                                // Gắn infoDiv vào productDiv
                                                productDiv.appendChild(infoDiv);

                                                // Gắn vào danh sách
                                                productlist.appendChild(productDiv);
                                            });
                                            
                                            const total = document.getElementById("total");
                                            total.innerHTML = `
                                                <p>Tổng tiền: <span>${formatToVND(order.tongtien)}</span></p>
                                            `;
                                            const summary = document.getElementById("summary");
                                            summary.innerHTML = `
                                                <p>Tạm tính: <span>${formatToVND(order.tamtinh)}</span></p>
                                                <p>Giảm giá: <span>${formatToVND(order.giamgia)}</span></p>
                                                <p>Điểm tích lũy đã sử dụng: <span>${order.diemdasudung}</span></p>
                                                <p>Phí vận chuyển: <span>${formatToVND(30000)}</span></p>
                                                <p>Phương thức thanh toán: <span>Ship COD</span></p>
                                                ${order.trangthai === 0 ? `<p>Trạng thái: <span class="processed" id="chuaxuly">Chưa xử lý</span></p>` : `<p>Trạng thái: <span class="processed" id="daxuly">Đã xử lý</span></p>`}
                                                
                                            `;

                                            document.getElementById("overlay").style.display = "block";
                                            document.getElementById("order-detail-modal").style.display = "block";
                                        } else {
                                            console.log("bruh");;
                                        }
                                    }else{
                                        console.log("Mã giảm không tồn tại");
                                    }            
                                });
                            });

                            container.appendChild(tr);
                        });
                    } else {
                        alert("Không có hóa đơn.");
                    }
                }).catch(err => {
                    console.error("Lỗi khi gọi API:", err);
                    alert("Đã xảy ra lỗi khi tải hóa đơn.");
                });
            }

            // Cập nhật danh sách sản phẩm yêu thích
            function updateWishlist() {
                const container = document.querySelector(".user-productlist-container");
                container.innerHTML = ""; // Xóa nội dung cũ trước khi load lại
                axios.get('http://localhost/ClothingStoreWebsite_UsingPHP/app/controllers/userPageController.php', {
                    params: {
                        action: "getSanPhamYeuThichByMatk",
                        matk: user.matk
                    }
                }).then(res => {
                    if (res.data.success && res.data.getSanPhamYeuThichByMatk) {
                        res.data.getSanPhamYeuThichByMatk.forEach(product => {
                            const tr = document.createElement("tr");    
                            tr.classList.add("fav-product");
                            tr.style.display = "table-row";
                            tr.innerHTML = `
                                <td>
                                    <img src="${product.duongdananh}" alt="${product.tensp}">
                                    <span>${product.tensp}</span>
                                </td>
                                <td class="flex-container">
                                    ${product.giamgia > 0 
                                        ? `<strong>${formatToVND(product.gia * (1 - product.giamgia / 100))}</strong>
                                        <span style="text-decoration: line-through;">${formatToVND(product.gia)}</span>` 
                                        : `<strong>${formatToVND(product.gia)}</strong>`}
                                </td>
                                <td>
                                    <button class="userpage-btn">Mua ngay</button>
                                </td>
                                <td>
                                    <i class="fa-solid fa-trash delete-icon" style="cursor:pointer;"></i>
                                </td>
                            `;

                            const userpageBtn = tr.querySelector(".userpage-btn");
                            userpageBtn.addEventListener("click", () => {
                                if (product.maloai_id != 2) {
                                    window.location.href = 'productdetailshirt.php?id=' + product.id + '&maloai=' + product.maloai_id;
                                } else {
                                    window.location.href = 'productdetailshoes.php?id=' + product.id + '&maloai=' + product.maloai_id;
                                }
                            });

                            // Gắn sự kiện xóa
                            const deleteIcon = tr.querySelector(".delete-icon");
                            deleteIcon.addEventListener("click", () => {
                                axios.post('http://localhost/ClothingStoreWebsite_UsingPHP/app/controllers/userPageController.php', {
                                    action: "deleteSanPhamYeuThich",
                                    matk: user.matk,
                                    masp: product.id
                                }).then(deleteRes => {
                                    if (deleteRes.data.success) {
                                        tr.remove(); // Xóa ngay trên UI
                                    } else {
                                        alert("Xóa không thành công.");
                                    }
                                }).catch(err => {
                                    console.error("Lỗi khi xóa:", err);
                                    alert("Đã xảy ra lỗi khi xóa sản phẩm.");
                                });
                            });

                            container.appendChild(tr);
                        });
                    } else {
                        container.innerHTML = "<tr><td colspan='4'>Không có sản phẩm yêu thích.</td></tr>";
                    }
                }).catch(err => {
                    console.error("Lỗi khi gọi API:", err);
                    alert("Đã xảy ra lỗi khi tải danh sách yêu thích.");
                });
            }


            function logout() {
                localStorage.removeItem("user");
                window.location.href = "http://localhost/ClothingStoreWebsite_UsingPHP/app/views/index.php";
            }

            function formatToVND(price) {
                return price.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
            }
            
            // function showAlert(words) {
            //     Swal.fire({
            //         title: 'Thông báo',
            //         text: words,
            //         icon: 'info',
            //         confirmButtonText: 'Đóng'
            //     });
            // }
           
        </script>
        <script src="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/js/header.js"></script>
    </body>
</html>
