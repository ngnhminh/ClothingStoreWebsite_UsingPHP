document.addEventListener("DOMContentLoaded", function () {
    // Lấy danh sách đơn hàng
    const orderRows = document.querySelectorAll("#orders-container tr");
    const modal = document.getElementById("orderModal");
    const closeBtn = document.querySelector(".close-btn");
    const filterButtons = document.querySelectorAll(".status-btn");
    const saveButton = document.querySelector(".save-btn"); // Nút Lưu
    const cancelButton = document.querySelector(".cancel-btn"); // Nút Hủy
    const statusText = document.querySelector(".status-text"); // Trạng thái đơn hàng trong modal
    const statusToggle = document.querySelector(".switch input"); // Switch toggle
    const restoreBtn = document.querySelector(".restore-btn"); 
    const switchContainer = modal.querySelector(".switch"); // Lấy div chứa switch
    
    // Mở modal khi click vào "Thông tin đơn"
    orderRows.forEach((row) => {
        row.querySelector("td:last-child a").addEventListener("click", function (event) {
            event.preventDefault();
            openModal(row);
        });
    });

    // Đóng modal khi bấm nút đóng
    closeBtn.addEventListener("click", closeModal);
    window.addEventListener("click", function (event) {
        if (event.target === modal) {
            closeModal();
        }
    });
    
    window.openModal = function(row) {
        const orderStatus = document.querySelector('.status')
        const switchContainer = document.querySelector('.status-toggle');
        const statusToggle = document.querySelector('.status-toggle input');
        const cancelButton = document.querySelector('.cancel-btn');
        const restoreBtn = document.querySelector('.restore-btn');
        const modal = document.getElementById("orderModal");
        const customerName = document.getElementById("customer-name");
        const subtotal = document.getElementById("subtotal");
        const paymentMethod = document.getElementById("payment-method");
        const totalPrice = document.getElementById("total-price");
        const orderDetailsContainer = document.querySelector(".modal-items");

        const orderId = row.querySelector("td:first-child").textContent.trim();

        console.log("openModal called!", row);

        fetch(`http://localhost/ClothingStore/app/controllers/ordermanagerment.controller.php?order_id=${orderId}`)
        .then(response => response.json())
        .then(data => {
            if (data.length === 0) {
                console.log("Dữ liệu API trả về:", data);
                orderDetailsContainer.innerHTML = "<p>Không có dữ liệu đơn hàng.</p>";
                return;
            }

            let orderInfo = data[0]; // Lấy thông tin chung của đơn hàng
            customerName.textContent = orderInfo.customer_name;
            paymentMethod.textContent = orderInfo.phuongthucthanhtoan;
            statusText.textContent = orderInfo.status;
            
            statusText.textContent = orderStatus.textContent;
            switch (statusText.textContent) {
                case "Đã xử lý":
                    statusText.style.color = "green";
                    switchContainer.style.display = "flex";
                    statusToggle.checked = true;
                    cancelButton.style.display = "inline";
                    restoreBtn.style.display = "none";
                    break;
                case "Chờ xử lý":
                    statusText.style.color = "orange";
                    switchContainer.style.display = "flex";
                    statusToggle.checked = false;
                    cancelButton.style.display = "inline";
                    restoreBtn.style.display = "none";
                    break;
                case "Đã hủy":
                    statusText.style.color = "red";
                    switchContainer.style.display = "none";
                    cancelButton.style.display = "none";
                    restoreBtn.style.display = "inline";
                    break;
                default:
                    statusText.style.color = "black";
                    switchContainer.style.display = "none";
                    statusToggle.checked = false;
            }

            // Hiển thị danh sách sản phẩm trong đơn hàng
            let detailsHtml = "";
            let total = 0;
            data.forEach(item => {
                total += item.total_price; // Tính tổng tiền
                detailsHtml += `
                    <div class="item-row">
                        <div class="product-info">
                            <div class="item-detail">
                                <img src="http://localhost/ClothingStore/public/assets/images/anh/ao/den/OUG (1).jpg" alt="${item.product_name}" class="product-img">
                                <div class="item-name">${item.product_name}</div>
                                <div class="item-sizes">Size: ${item.size} &nbsp; Sl: ${item.soluong}</div>
                            </div>
                        </div>
                        <div id="bill-price">
                            <del class="item-original-price">${item.product_price * 1.2} đ</del>
                            <div class="item-price">${item.product_price} đ</div>
                        </div>
                    </div>
                `;
            });

            orderDetailsContainer.innerHTML = detailsHtml;
            subtotal.textContent = total + " đ";
            totalPrice.textContent = (total + 10) + " đ"; // Thêm phí vận chuyển
                    // Đánh dấu hàng được chọn
            document.querySelectorAll(".order-table tbody tr").forEach(tr => tr.classList.remove("selected"));
            row.classList.add("selected");
            // Hiển thị modal
            modal.style.display = "flex";
        })
        .catch(error => {
            console.error("Lỗi khi tải chi tiết đơn hàng:", error);
            orderDetailsContainer.innerHTML = "<p>Lỗi khi lấy dữ liệu đơn hàng.</p>";
        });
    }

    function closeModal() {
        modal.style.display = "none";
    }

    // Khi bấm nút "Hủy"
    cancelButton.addEventListener("click", function () {
        statusText.textContent = "Đã hủy";
        statusText.style.color = "red";
        switchContainer.style.display = "none";
        this.style.display = "none";
        restoreBtn.style.display = "flex";

        // Cập nhật trạng thái trong bảng
        const selectedRow = document.querySelector(".order-table tr.selected");
        if (selectedRow) {
            selectedRow.querySelector(".status").textContent = "Đã hủy";
            selectedRow.querySelector(".status").style.color = "red";
        }

        // Gửi AJAX cập nhật trạng thái (nếu có backend)
        const orderId = selectedRow ? selectedRow.cells[0].textContent.trim() : null;
        if (orderId) {
            fetch("http://localhost/ClothingStore/api/update-order.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ orderId: orderId, status: "Đã hủy" }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log("Đơn hàng đã bị hủy!");
                } else {
                    alert("Lỗi khi hủy đơn hàng!");
                }
            })
            .catch(error => console.error("Lỗi:", error));
        }
        // closeModal()
    });
    
    // // Khi chọn khôi phục đơn hàng
    restoreBtn.addEventListener("click", function () {
        const selectedRow = document.querySelector(".order-table tr.selected");
        if (!selectedRow) return;
    
        // Cập nhật trạng thái trong modal
        statusText.textContent = "Chờ xử lý"; 
        statusText.style.color = "orange"; // Đổi màu cam giống trạng thái ban đầu
        switchContainer.style.display = "flex"; // Hiện lại switch
        statusToggle.checked = false; 
    
        // Hiện lại nút Hủy, ẩn nút Khôi phục
        cancelButton.style.display = "inline";  
        restoreBtn.style.display = "none"; 
    
        // Cập nhật trạng thái trong bảng
        selectedRow.querySelector(".status").textContent = "Chờ xử lý";
        selectedRow.querySelector(".status").style.color = "orange";
    });

    saveButton.addEventListener("click", function () {
        const newStatus = statusToggle.checked ? "Đã xử lý" : "Chờ xử lý";

        // Nếu trạng thái hiện tại là "Đã hủy", giữ nguyên
        if (statusText.textContent === "Đã hủy") {
            statusText.style.color = "red";
            statusToggle.style.display = "none";
        } else {
            statusText.textContent = newStatus;
            statusText.style.color = newStatus === "Đã xử lý" ? "green" : "orange";
            statusToggle.style.display = "inline-block"; 
        }
        
        // Cập nhật trạng thái trong bảng
        const selectedRow = document.querySelector(".order-table tr.selected");
        if (selectedRow) {
            const currentStatus = selectedRow.querySelector(".status").textContent.trim();
        
            // Nếu đơn hàng đang là "Đã hủy", giữ nguyên
            if (currentStatus === "Đã hủy") {
                selectedRow.querySelector(".status").style.color = "red";
            } else {
                selectedRow.querySelector(".status").textContent = newStatus;
                selectedRow.querySelector(".status").style.color = newStatus === "Đã xử lý" ? "green" : "orange";
            }
        }

        // Gửi AJAX cập nhật trạng thái đơn hàng (nếu có backend)
        const orderId = selectedRow ? selectedRow.cells[0].textContent.trim() : null;
        if (orderId) {
            fetch("http://localhost/ClothingStore/api/update-order.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ orderId: orderId, status: newStatus }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log("Cập nhật đơn hàng thành công!");
                } else {
                    alert("Lỗi khi cập nhật đơn hàng!");
                }
            })
            .catch(error => console.error("Lỗi:", error));
        }

        // Đóng modal
        closeModal();
    });


    document.querySelector(".switch input").addEventListener("change", function () {
        const selectedRow = document.querySelector(".order-table tr.selected");
        if (!selectedRow) return;

        if (this.checked) {
            statusText.textContent = "Đã xử lý";
            statusText.style.color = "green";
        } else {
            statusText.textContent = "Chờ xử lý";
            statusText.style.color = "orange";
        }
    });
    
    let activeFilter = null; // Lưu trạng thái nút đang được chọn

    filterButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const words = this.textContent.trim().split(" "); 
            const filter = words.slice(0, 2).join(" "); // Lấy 2 từ đầu tiên
    
            // Nếu bấm lại cùng nút đang chọn -> Hiển thị tất cả
            if (activeFilter === filter) {
                orderRows.forEach((row) => row.style.display = ""); // Reset bộ lọc
                activeFilter = null; // Đặt lại trạng thái
            } else {
                orderRows.forEach((row) => {
                    const status = row.querySelector(".status").textContent.trim();
                    row.style.display = filter === "Tất cả" || status.includes(filter) ? "" : "none";
                });
                activeFilter = filter; // Lưu trạng thái nút đã chọn
            }
        });
    });

    const startDateInput = document.querySelector(".date-start");
    const endDateInput = document.querySelector(".date-end");
    const searchButton = document.querySelector(".search-btn"); 
  

    searchButton.addEventListener("click", function () {

        const isDateMissing  = !startDateInput.value || !endDateInput.value;
        if (isDateMissing ) {
            alert("Vui lòng chọn đầy đủ khoảng thời gian!");
            return;
        }
        // Chuyển input YYYY-MM-DD thành Date object (00:00:00 và 23:59:59 để bao trọn ngày)
        const startDate = new Date(startDateInput.value + "T00:00:00");
        const endDate = new Date(endDateInput.value + "T23:59:59");

        document.querySelectorAll(".order-table tbody tr").forEach((row) => {
            const orderDateText = row.querySelector("td:nth-child(4)").textContent.trim(); // Lấy ngày có giờ từ bảng
            
            const orderDate = parseDateTime(orderDateText); // Chuyển thành Date object

            // So sánh ngày đặt hàng có nằm trong khoảng đã chọn không
            row.style.display = (orderDate >= startDate && orderDate <= endDate) ? "" : "none";
        });
    });
    // Chuyển đổi từ "dd/mm/yyyy hh:mm:ss" sang Date object
    function parseDateTime(dateTimeStr) {
        const [datePart, timePart] = dateTimeStr.split(" "); // Tách "dd/mm/yyyy" và "hh:mm:ss"
        const [day, month, year] = datePart.split("/"); // Tách ngày, tháng, năm
        const [hours, minutes] = timePart ? timePart.split(":") : ["00", "00"]; // Tách giờ, phút, giây (mặc định 00:00:00)

        return new Date(year, month - 1, day, hours, minutes);
    }
});
