function formatToVND(price) {
    return price.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
}

document.addEventListener("DOMContentLoaded", function () {
    const orderRows = document.querySelectorAll("#orders-container tr");
    const modal = document.getElementById("orderModal");
    const closeBtn = document.querySelector(".close-btn");
    const filterButtons = document.querySelectorAll(".status-btn");
    const saveButton = document.querySelector(".save-btn");
    const statusText = document.querySelector(".status-text");
    const statusToggle = document.querySelector(".switch input");
    const switchContainer = modal.querySelector(".switch");

    let ordId;

    orderRows.forEach((row) => {
        row.querySelector("td:last-child a").addEventListener("click", function (event) {
            event.preventDefault();
            openModal(row);
        });
    });

    closeBtn.addEventListener("click", closeModal);
    window.addEventListener("click", function (event) {
        if (event.target === modal) closeModal();
    });

    function openModal(row) {
        const orderId = row.querySelector("td:first-child").textContent.trim();
        ordId = orderId;

        const customerName = document.getElementById("customer-name");
        const subtotal = document.getElementById("subtotal");
        const paymentMethod = document.getElementById("payment-method");
        const totalPrice = document.getElementById("total-price");
        const orderDetailsContainer = document.querySelector(".modal-items");
        const shipperFee = document.getElementById("shipping-fee");

        axios.get(`http://localhost/ClothingStoreWebsite_UsingPHP/app/controllers/ordermanagerment.controller.php?order_id=${orderId}`)
            .then(response => {
                const data = response.data;
                if (data.length === 0) {
                    orderDetailsContainer.innerHTML = "<p>Không có dữ liệu đơn hàng.</p>";
                    return;
                }

                const orderInfo = data[0];
                customerName.textContent = orderInfo.hoten;
                paymentMethod.textContent = "Ship COD";

                // Chỉ có 2 trạng thái: Đã xử lý và Chưa xử lý
                if (orderInfo.trangthai === 1) {
                    statusText.textContent = "Đã xử lý";
                    statusText.style.color = "green";
                    statusToggle.checked = true;
                } else {
                    statusText.textContent = "Chưa xử lý";
                    statusText.style.color = "red";
                    statusToggle.checked = false;
                }

                switchContainer.style.display = "flex";

                let detailsHtml = "";
                let total = 0;
                data.forEach(item => {
                    total += item.total_price;
                    detailsHtml += `
                        <div class="item-row">
                            <div class="product-info">
                                <div class="item-detail">
                                    <div class="item-name">${item.tensp}</div>
                                    <div class="item-sizes">Size: ${item.size} &nbsp; Sl: ${item.soluong}</div>
                                </div>
                            </div>
                            <div id="bill-price">
                                <div class="item-original-price">${formatToVND(Number(item.gia))}</div>
                            </div>
                        </div>
                    `;
                });

                const tamtinh = orderInfo.tamtinh || 0;
                orderDetailsContainer.innerHTML = detailsHtml;
                subtotal.innerText = formatToVND(tamtinh);
                totalPrice.innerText = formatToVND(orderInfo.tongtien);
                shipperFee.innerText = formatToVND(30000);

                document.querySelectorAll(".order-table tbody tr").forEach(tr => tr.classList.remove("selected"));
                row.classList.add("selected");
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

    saveButton.addEventListener("click", function () {
        const newStatus = statusToggle.checked ? "Đã xử lý" : "Chưa xử lý";
        statusText.textContent = newStatus;
        statusText.style.color = newStatus === "Đã xử lý" ? "green" : "red";

        const selectedRow = document.querySelector(".order-table tr.selected");
        if (selectedRow) {
            selectedRow.querySelector(".status").textContent = newStatus;
            selectedRow.querySelector(".status").style.color = newStatus === "Đã xử lý" ? "green" : "red";
        }

        if (ordId) {
            axios.post("http://localhost/ClothingStoreWebsite_UsingPHP/app/controllers/updateOrder.php", {
                orderId: ordId,
                status: newStatus
            })
                .then(response => {
                    if (response.data.success) {
                        console.log("Cập nhật đơn hàng thành công!");
                    } else {
                        alert("Lỗi khi cập nhật đơn hàng!");
                    }
                })
                .catch(error => console.error("Lỗi:", error));
        }

        closeModal();
    });

    statusToggle.addEventListener("change", function () {
        if (this.checked) {
            statusText.textContent = "Đã xử lý";
            statusText.style.color = "green";
        } else {
            statusText.textContent = "Chưa xử lý";
            statusText.style.color = "red";
        }
    });

    // Bộ lọc theo trạng thái
    let activeFilter = null;
    filterButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const filter = this.textContent.trim();
            if (activeFilter === filter) {
                orderRows.forEach((row) => row.style.display = "");
                activeFilter = null;
            } else {
                orderRows.forEach((row) => {
                    const status = row.querySelector(".status").textContent.trim();
                    row.style.display = filter === "Tất cả" || status === filter ? "" : "none";
                });
                activeFilter = filter;
            }
        });
    });

    // Tìm theo ngày
    const startDateInput = document.querySelector(".date-start");
    const endDateInput = document.querySelector(".date-end");
    const searchButton = document.querySelector(".search-btn");

    searchButton.addEventListener("click", function () {
        if (!startDateInput.value || !endDateInput.value) {
            alert("Vui lòng chọn đầy đủ khoảng thời gian!");
            return;
        }

        const startDate = new Date(startDateInput.value + "T00:00:00");
        const endDate = new Date(endDateInput.value + "T23:59:59");

        document.querySelectorAll(".order-table tbody tr").forEach((row) => {
            const orderDateText = row.querySelector("td:nth-child(4)").textContent.trim();
            const orderDate = parseDateTime(orderDateText);
            row.style.display = (orderDate >= startDate && orderDate <= endDate) ? "" : "none";
        });
    });

    function parseDateTime(dateTimeStr) {
        const [datePart, timePart] = dateTimeStr.split(" ");
        const [day, month, year] = datePart.split("/");
        const [hours, minutes] = timePart ? timePart.split(":") : ["00", "00"];
        return new Date(year, month - 1, day, hours, minutes);
    }

    const printButton = document.querySelector(".print-btn");
    printButton.addEventListener("click", function () {
        const printContent = document.getElementById("print-content").innerHTML;

        const styledHTML = `
            <html>
            <head>
                <title>In đơn hàng</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        padding: 40px;
                        color: #000;
                    }
                    h1 {
                        text-align: center;
                        margin-bottom: 30px;
                    }
                    .item-row {
                        display: flex;
                        justify-content: space-between;
                        margin-bottom: 10px;
                        border-bottom: 1px solid #ccc;
                        padding-bottom: 5px;
                    }
                    .item-name {
                        font-weight: bold;
                    }
                    .item-sizes {
                        font-style: italic;
                        font-size: 14px;
                        margin-top: 2px;
                    }
                    #bill-price {
                        text-align: right;
                        min-width: 100px;
                    }
                    .summary {
                        margin-top: 30px;
                        font-size: 16px;
                    }
                    .summary div {
                        display: flex;
                        justify-content: space-between;
                        margin-bottom: 5px;
                    }
                    button {
                        display: none !important;
                    }
                </style>
            </head>
            <body>
                <h1>Chi tiết đơn hàng</h1>
                ${printContent}
            </body>
            </html>
        `;

        const printWindow = window.open("", "", "width=800,height=600");
        printWindow.document.write(styledHTML);
        printWindow.document.close();
        printWindow.focus();
        printWindow.print();
        printWindow.close();
    });
   
    const startInput = document.querySelector(".date-start");
    const endInput = document.querySelector(".date-end");
    const buttons = document.querySelectorAll(".status-btn");
    const rows = document.querySelectorAll("#orders-container tr");

    let selectedStatus = "all"; // mặc định là 'Tất cả'

    buttons.forEach(btn => {
        btn.addEventListener("click", () => {
            selectedStatus = btn.id;
            filterRows();
        });
    });

    startInput.addEventListener("change", filterRows);
    endInput.addEventListener("change", filterRows);

    function filterRows() {
        const startDate = startInput.value ? new Date(startInput.value) : null;
        const endDate = endInput.value ? new Date(endInput.value) : null;

        rows.forEach(row => {
            const status = row.getAttribute("data-trangthai");
            const rowDate = new Date(row.getAttribute("data-date")); // yyyy-mm-dd

            // Kiểm tra trạng thái
            let matchStatus = selectedStatus === "all" ||
                (selectedStatus === "inprocessing" && status === "1") ||
                (selectedStatus === "done" && status === "0");

            // Kiểm tra khoảng ngày
            let matchDate = true;
            if (startDate && rowDate < startDate) matchDate = false;
            if (endDate && rowDate > endDate) matchDate = false;

            // Hiển thị nếu cả 2 đều khớp
            row.style.display = (matchStatus && matchDate) ? "" : "none";
        });
    }
});
