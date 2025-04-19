function formatCurrencyVND(value) {
    return value.toLocaleString('vi-VN') + 'đ';
}
document.addEventListener("DOMContentLoaded", function () {
    const searchBtn = document.querySelector(".search-btn");
    const searchInput = document.querySelector("input[type='text']");
    const customerTable = document.getElementById("customers-container");
    const customerModal = document.getElementById("customerModal");
    const closeModalBtn = document.querySelector(".close-btn");
    // const editBtn = document.querySelector(".fix-btn");
    // const saveBtn = document.querySelector(".save-btn");
    const createBtn = document.querySelector(".create-btn");
    const createModal = document.querySelector(".create-kh");

    // Lấy các trường thông tin
    const nameField = document.querySelector(".name");
    const phoneField = document.querySelector(".phone");
    const emailField = document.querySelector(".email");
    const addressField = document.querySelector(".address");
    const passwordField = document.querySelector(".pass");

    // Hàm mở modal
    window.openModal = async function (makh) {
        try {
            // Gọi API để lấy thông tin khách hàng theo `makh`
            let result = await sendRequest("getCustomerById", { makh });
    
            if (result && result.status === "success" && result.data) {
                const customer = result.data;
    
                // Hiển thị thông tin khách hàng trong modal
                document.getElementById("username").textContent = customer.tentaikhoan;
                document.getElementById("fullname").textContent = customer.hoten;
                document.getElementById("sdt").textContent = customer.sdt;
                document.getElementById("email").textContent = customer.email;

                document.getElementById("history-btn").onclick = () => showInvoiceList(makh);

                document.getElementById("customerModal").style.display = "flex";
                // Hiển thị modal
                customerModal.style.display = "flex";
            } else {
                alert("❌ Không tìm thấy thông tin khách hàng!");
            }
        } catch (error) {
            console.error("❌ Lỗi khi lấy thông tin khách hàng:", error);
        }
    };

    // Đóng modal
    window.closeModal = function () {
        document.getElementById("customerModal").style.display = "none";
    };

    // Hiển thị danh sách hóa đơn
    window.showInvoiceList = async function (makh) {
        const result = await sendRequest("getInvoicesByCustomer", { makh });

        const listContainer = document.getElementById("invoice-list-body");
        listContainer.innerHTML = "";

        if (result && result.status === "success" && result.data) {
            result.data.forEach(invoice => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${invoice.id}</td>
                    <td>${invoice.ngay}</td>
                    <td>${formatCurrencyVND(invoice.tongtien)}</td>
                    <td><button onclick="showInvoiceDetail(${invoice.id})">Xem</button></td>
                `;
                listContainer.appendChild(row);
            });
        } else {
            const row = document.createElement("tr");
            row.innerHTML = `<td colspan="4">Không có hóa đơn nào</td>`;
            listContainer.appendChild(row);
        }

        document.getElementById("invoiceModal").style.display = "flex";
    };

    // Hiển thị chi tiết hóa đơn
    window.showInvoiceDetail = async function (mahd) {
        const result = await sendRequest("getInvoiceDetail", { mahd });

        const detailContainer = document.getElementById("invoice-detail-body");
        detailContainer.innerHTML = "";

        if (result && result.status === "success" && result.data) {
            result.data.forEach(item => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${item.tensp}</td>
                    <td>${item.soluong}</td>
                    <td>${formatCurrencyVND(item.gia)}</td>
                `;
                detailContainer.appendChild(row);
            });
        } else {
            const row = document.createElement("tr");
            row.innerHTML = `<td colspan="3">Không có chi tiết hóa đơn</td>`;
            detailContainer.appendChild(row);
        }

        document.getElementById("invoiceDetailModal").style.display = "flex";
    };

    // Đóng các modal phụ
    window.closeInvoiceModal = function () {
        document.getElementById("invoiceModal").style.display = "none";
    };
    window.closeInvoiceDetailModal = function () {
        document.getElementById("invoiceDetailModal").style.display = "none";
    };
    
    window.openCreate = function () {
        createModal.style.display = "flex";
    };

    // Hàm đóng modal
    window.closeModal = function () {
        customerModal.style.display = "none";
    };

    window.closeCreate = function () {
        createModal.style.display = "none";
    };

    // Đóng modal khi click ra ngoài
    window.onclick = function (event) {
        if (event.target === customerModal) {
            window.closeModal();
        }
    };

    const searchUser = document.getElementById("searchUser");

    // Hàm tìm kiếm khách hàng
    searchUser.addEventListener("input", async function () {
        const tenkhachhang = searchUser.value.trim();
        const result = await sendRequest("getCustomerByName", { tenkhachhang });
        if (result && result.status === "success" && result.data) {
            renderCustomers(result.data);
        }
    });

    
    // Lưu thông tin khách hàng
    // saveBtn.addEventListener("click", function () {
    //     nameField.contentEditable = false;
    //     phoneField.contentEditable = false;
    //     emailField.contentEditable = false;
    //     addressField.contentEditable = false;
    //     passwordField.contentEditable = false;

    //     nameField.style.border = "none";
    //     phoneField.style.border = "none";
    //     emailField.style.border = "none";
    //     addressField.style.border = "none";
    //     passwordField.style.border = "none";
    // });

    // document.getElementById("userRank").addEventListener("change", function () {
    //     const selectedRank = this.value;
    //     filterCustomersByRank(selectedRank);
    // });
    // Hiển thị thông báo

    function showAlert(words) {
        Swal.fire({
            title: 'Thông báo',
            text: words,
            icon: 'info',
            confirmButtonText: 'Đóng'
        });
    }

    createBtn.addEventListener("click", createCustomer);

    // ✅ Hàm tạo khách hàng
    async function createCustomer() {
        const data = {
            username: document.querySelector(".username").value.trim(),
            password: document.querySelector(".pass").value.trim(),
            hoten: document.querySelector(".name").value.trim(),
            sdt: document.querySelector(".phone").value.trim(),
            email: document.querySelector(".email").value.trim(),
        };

        if (!data.username || !data.password || !data.hoten || !data.sdt) {
            alert("Vui lòng nhập đầy đủ thông tin!");
            return;
        }
        console.log()
        const tennguoidung = data.username;
        const checkUsername = await sendRequest("getUserByUsername", {tennguoidung});
        if (checkUsername && checkUsername.data != null) {
            showAlert("Tên tài khoản đã tồn tại");
            return;
        }
        else{
            const email = data.email;
            const checkEmail = await sendRequest("getUserByEmail", {email});
            if (checkEmail && checkEmail.data != null) {
                showAlert("Tên tài khoản đã tồn tại");
                return;
            }else{
                const result = await sendRequest("createUserAndCustomer", data);
                if (result && result.status === "success") {
                    alert(result.message);
                    window.closeCreate(); // Đóng modal sau khi tạo thành công
                fetchCustomers();
                }
             }
        }
    }

    async function deleteCustomer(makh) {
        if (!confirm("⚠️ Bạn có chắc chắn muốn xóa khách hàng này?")) return;
    
        try {
            const result = await sendRequest("deleteCustomer", { makh });
    
            if (result && result.status === "success") {
                alert(result.message);
                fetchCustomers(); // Cập nhật lại danh sách khách hàng sau khi xóa
            } else {
                alert("❌ Lỗi khi xóa: " + (result?.message || "Không xác định"));
            }
        } catch (error) {
            console.error("❌ Lỗi khi gọi API:", error);
            alert("❌ Lỗi khi kết nối đến server!");
        }
    }

    async function sendRequest(funcName, paramsObj) {
        try {
            let response = await fetch("http://localhost/ClothingStoreWebsite_UsingPHP/app/controllers/customer.controller.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ function: funcName, params: paramsObj }),
            });
    
            if (!response.ok) {
                throw new Error(`Lỗi HTTP ${response.status}: ${response.statusText}`);
            }
    
            let data = await response.json();
            return data;
        } catch (error) {
            console.error("❌ Lỗi khi gọi API:", error.message);
            return null;
        }
    }


    async function fetchCustomers() {
        try {
            // Gửi yêu cầu lấy danh sách khách hàng qua sendRequest()
            let data = await sendRequest("getCustomers", {});
    
            if (data && data.status === "success" && Array.isArray(data.data)) {
                renderCustomers(data.data);
            } else {
                console.error("❌ Lỗi: Không có dữ liệu khách hàng hợp lệ!");
            }
        } catch (error) {
            console.error("❌ Lỗi khi gọi API:", error.message);
        }
    }
    
    // ✅ Hàm hiển thị danh sách khách hàng vào bảng
    function renderCustomers(customers) {
        const customerTable = document.getElementById("customers-container");
        customerTable.innerHTML = ""; // Xóa dữ liệu cũ trước khi render mới
    
        customers.forEach(row => {
            let rank = "Đồng";
            if (row.diemtichluy > 200) rank = "Kim cương";
            else if (row.diemtichluy > 150) rank = "Vàng";
            else if (row.diemtichluy > 100) rank = "Bạc";
    
            customerTable.innerHTML += `
                <tr>
                    <td>${row.makh}</td>
                    <td>${row.hoten}</td>
                    <td>${row.diemtichluy}</td>
                    <td>${rank}</td>
                    <td><a href="#" onclick="openModal(${row.makh})">Thông tin đơn</a></td>
                    <td><button onclick="deleteCustomer(${row.makh})">X</button></td>
                </tr>
            `;
        });
    }
    
    // ✅ Gọi API khi trang load xong
     fetchCustomers();
});
