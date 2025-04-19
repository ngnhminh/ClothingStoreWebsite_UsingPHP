function ChangeTitle() {
    // thay đổi tiêu đề và cấu trúc bảng
    try {
        const title = document.getElementById("userpage-title");
        if (!title) throw new Error("Không thấy id userpage-title");
        const change_button = document.getElementById("userpage-button");
        if (!change_button) throw new Error("Không thấy id userpage-button");
        const history_product_navbar = document.getElementById("history-product-navbar");
        if (!history_product_navbar) throw new Error("Không thấy id history_product_navbar");
        const fav_product_navbar = document.getElementById("fav-product-navbar");
        if (!fav_product_navbar) throw new Error("Không thấy id fav_product_navbar");

        //parentElement
        const user_productlist_container = document.querySelector('.user-productlist-container');

        //ChildElement
        const user_fav_product = user_productlist_container.querySelectorAll('.fav-product');
        const user_purchased_order = user_productlist_container.querySelectorAll('.purchased-order');
        
        if (!title.dataset.state) {
            title.dataset.state = "1";
        }
        
        if(title.dataset.state === "1"){
            change_button.textContent = "Danh sách yêu thích";
            title.innerText = "Lịch sử mua hàng";

            fav_product_navbar.style.display="none";
            history_product_navbar.style.display="table-row";
            
            user_fav_product.forEach((child) => {
                child.style.display = "none";
            });

            user_purchased_order.forEach((child) => {
                child.style.display = "table-row";
            });
            title.dataset.state = "0";
            console.log(title.dataset.state);
        }else if(title.dataset.state === "0"){
            change_button.textContent = "Lịch sử mua hàng";
            title.innerText = "Danh sách yêu thích";
            fav_product_navbar.style.display="table-row";
            history_product_navbar.style.display="none";

            user_fav_product.forEach((child) => {
                child.style.display = "table-row";
            });

            user_purchased_order.forEach((child) => {
                child.style.display = "none";
            });
            title.dataset.state = "1";
        }
    } catch (error) {
        console.error("Error:", error.message);
    }

}

function formatToVND(price) {
    return price.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
}

window.onload = () => {
    let user = JSON.parse(localStorage.getItem("user"));
    window.addEventListener('userUpdated', function() {
        let userUpdated = JSON.parse(localStorage.getItem("user"));
        console.log("Thông tin người dùng đã được cập nhật:", userUpdated);
        user = userUpdated; // Cập nhật lại biến user toàn cục với dữ liệu mới
    });
    const authButton = document.getElementById("auth-buttons");
    const userInfo = document.getElementById("user-info");
    const welcomeText = document.getElementById("welcome-text");

    if (user) {
        // Cập nhật thông tin người dùng trong user-info-box
        document.getElementById("user-name").innerText = user.tentaikhoan;
        document.getElementById("user-fullname").innerText = user.fullname || "Chưa có tên";
        document.getElementById("user-password").innerText = "****"; // Mặc định là dấu sao
        document.getElementById("user-phone").innerText = user.phone || "Chưa có số điện thoại";
        document.getElementById("user-email").innerText = user.email || "Chưa có email";
        document.getElementById("user-points").innerText = user.points || 0;
    }

    const userpagebutton = document.getElementById("userpage-button");
    userpagebutton.addEventListener("click", () => {
        const userpageTitle = document.getElementById("userpage-title");
        if (userpageTitle.dataset.state === "0") {
            axios.get('http://localhost/ClothingStoreWebsite_UsingPHP/app/controllers/userPageController.php', {
                params: {
                    action: 'getHoaDonByMatk',
                    matk: user.matk
                }
            }).then(res => {
                if (res.data.success && res.data.getHoaDonByMatk) {
                    const container = document.querySelector(".user-productlist-container");
                    res.data.getHoaDonByMatk.forEach(order => {
                        const tr = document.createElement("tr");
                        tr.classList.add("purchased-order");
                        tr.innerHTML = `
                            <td><span>Distressed Double Knee Denim Pants Brown</span></td>
                            <td><span>${order.ngay}</span></td>
                            <td><strong>${order.soluong}</strong></td>
                            <td class="flex-container">
                                <strong>${formatToVND(order.tongtien)}</strong>
                                <button class="userpage-btn">Đơn hàng</button>
                            </td>
                        `;
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
    });

    document.querySelector(".change-password").addEventListener("click", () => {
        document.getElementById("overlay").style.display = "block";
        document.getElementById("change-password-modal").style.display = "block";
    });

    function closeModal() {
        document.getElementById("overlay").style.display = "none";
        document.getElementById("change-password-modal").style.display = "none";
    }

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
}

document.querySelector(".change-password").addEventListener("click", () => {
    document.getElementById("overlay").style.display = "block";
    document.getElementById("change-password-modal").style.display = "block";
});

function closeModal() {
    document.getElementById("overlay").style.display = "none";
    document.getElementById("change-password-modal").style.display = "none";
}

function togglePasswordVisibility() {
    let user = JSON.parse(localStorage.getItem("user"));
    window.addEventListener('userUpdated', function() {
        let userUpdated = JSON.parse(localStorage.getItem("user"));
        console.log("Thông tin người dùng đã được cập nhật:", userUpdated);
        user = userUpdated; // Cập nhật lại biến user toàn cục với dữ liệu mới
    });
    const pwSpan = document.getElementById("user-password");
    const toggleBtn = document.getElementById("toggle-password");

    if (pwSpan.innerText.includes("*")) {
        pwSpan.innerText = user?.password || "Không có mật khẩu";
        toggleBtn.innerText = "Ẩn";
    } else {
        let stars = "*".repeat(user?.password?.length || 4);
        pwSpan.innerText = stars;
        toggleBtn.innerText = "Hiện";
    }
}

function submitPasswordChange() {
    // Xử lý đổi mật khẩu ở đây (gửi request hoặc kiểm tra local)
    alert("Mật khẩu đã được đổi thành công!");
    closeModal();
}
