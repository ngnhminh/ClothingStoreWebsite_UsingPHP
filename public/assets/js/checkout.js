function showAlert(words) {
    Swal.fire({
        title: 'Thông báo',
        text: words,
        icon: 'info',
        confirmButtonText: 'Đóng'
    });
}

const user = JSON.parse(localStorage.getItem("user"));
const loyalty = document.getElementById("loyalty");
var diemtichluy = document.getElementById("diemtichluy");

const emailinput = document.getElementById("email-input");
const hoteninput = document.getElementById("hoten-input");
const sdtinput = document.getElementById("sdt-input");
const diachiinput = document.getElementById("diachi-input");
const phuongxainput = document.getElementById("phuong-input");
var checkoutpricetransportfee = document.getElementById("checkout-price-transport-fee");
const checkoutPricePoint = document.getElementById("checkout-price-point");

if(user != null){
    loyalty.style.display = "block";
    diemtichluy.innerText = user.diemtichluy;
    diemtichluy.dataset.diemtichluy = user.diemtichluy;
    hoteninput.value = user.hoten;
    emailinput.value = user.email;
    sdtinput.value = user.sdt;
}else{
    loyalty.style.display = "none";
    checkoutPricePoint.dataset.point = 0; 
}

const quanHuyen = {
    "Hà Nội": [
        "Ba Đình", "Hoàn Kiếm", "Hai Bà Trưng", "Đống Đa", "Tây Hồ", "Cầu Giấy",
        "Thanh Xuân", "Hoàng Mai", "Long Biên", "Nam Từ Liêm", "Bắc Từ Liêm",
        "Hà Đông", "Sơn Tây", "Ba Vì", "Phúc Thọ", "Đan Phượng", "Hoài Đức",
        "Quốc Oai", "Thạch Thất", "Chương Mỹ", "Thanh Oai", "Thường Tín",
        "Phú Xuyên", "Ứng Hòa", "Mê Linh", "Đông Anh", "Sóc Sơn"
    ],
    "Hồ Chí Minh": [
        "Quận 1", "Quận 2", "Quận 3", "Quận 4", "Quận 5", "Quận 6", "Quận 7", "Quận 8",
        "Quận 9", "Quận 10", "Quận 11", "Quận 12", "Bình Tân", "Bình Thạnh", "Gò Vấp",
        "Phú Nhuận", "Tân Bình", "Tân Phú", "Thủ Đức", "Bình Chánh", "Cần Giờ",
        "Củ Chi", "Hóc Môn", "Nhà Bè"
    ],
    "Đà Nẵng": [
        "Hải Châu", "Thanh Khê", "Sơn Trà", "Ngũ Hành Sơn", "Liên Chiểu",
        "Cẩm Lệ", "Hòa Vang", "Hoàng Sa"
    ],
    "Hải Phòng": [
        "Hồng Bàng", "Lê Chân", "Ngô Quyền", "Hải An", "Kiến An", "Đồ Sơn",
        "Dương Kinh", "An Dương", "An Lão", "Kiến Thụy", "Tiên Lãng", "Vĩnh Bảo",
        "Cát Hải", "Bạch Long Vĩ", "Thủy Nguyên"
    ],
    "Cần Thơ": [
        "Ninh Kiều", "Bình Thủy", "Cái Răng", "Ô Môn", "Thốt Nốt",
        "Cờ Đỏ", "Phong Điền", "Thới Lai", "Vĩnh Thạnh"
    ]
};

const tinhThanhSelect = document.getElementById("tinhThanh");
const quanHuyenSelect = document.getElementById("quanHuyen");

// Đổ tỉnh/thành (chỉ các tỉnh có trong object quanHuyen)
for (const tinh of Object.keys(quanHuyen)) {
    const option = document.createElement("option");
    option.value = tinh;
    option.textContent = tinh;
    tinhThanhSelect.appendChild(option);
}

let tinhDuocChon = "";
let quanDuocChon = "";

tinhThanhSelect.addEventListener("change", function () {
    tinhDuocChon = this.value;
    console.log("Tỉnh chọn:", tinhDuocChon);

    // Cập nhật quận/huyện
    quanHuyenSelect.innerHTML = '<option value="">-- Chọn Quận/Huyện --</option>';
    if (Array.isArray(quanHuyen[tinhDuocChon])) {
        quanHuyen[tinhDuocChon].forEach(quan => {
            const option = document.createElement("option");
            option.value = quan;
            option.textContent = quan;
            quanHuyenSelect.appendChild(option);
        });
    }
});

quanHuyenSelect.addEventListener("change", function () {
    quanDuocChon = this.value;
    console.log("Quận chọn:", quanDuocChon);
});



var error = document.getElementsByClassName("error");
var btn_primary = document.getElementsByClassName("btn-primary");

var btn_primary = document.getElementsByClassName("btn-primary");
var annouce_box = document.getElementById("annouce-box");
var transport_fee = document.getElementById("transport-fee");
var shipping_box = document.getElementsByClassName("shipping-box")[0];

tinhThanhSelect.addEventListener("change", function() {
    if(tinhThanhSelect.value != ""){
        shipping_box.style.backgroundColor="white";
        shipping_box.style.color="black"
        annouce_box.style.display="none";
        transport_fee.style.display="flex";
        checkoutpricetransportfee.style.display = "block";
        checkoutpricetransportfee.dataset.fee = 30000;
    }else{
        annouce_box.style.display="flex";
        transport_fee.style.display="none";
        shipping_box.style.backgroundColor="#D1ECF1";
        shipping_box.style.color="#0C5460"
        checkoutpricetransportfee.style.display = "none";
        checkoutpricetransportfee.dataset.fee = "0"
    }
});

for (var i = 0; i < btn_primary.length; i++) {
    btn_primary[i].addEventListener("click", function() {
        if (emailinput.value == "") {
            error[0].style.display = "block";
        }
        if (hoteninput.value == "") {
            error[1].style.display = "block";
        }
        if (sdtinput.value == "") {
            error[2].style.display = "block";
        }
        if (diachiinput.value == "") {
            error[3].style.display = "block";
        }
        if (phuongxainput.value == "") {
            error[4].style.display = "block";
        }
    });
}

function formatToVND(price) {
    return price.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
}

function getAllProductsInCart() {
    const products = [];

    for (let i = 0; i < localStorage.length; i++) {
        const key = localStorage.key(i);
        if (key.startsWith("product-")) {
            const item = localStorage.getItem(key);
            try {
                const product = JSON.parse(item);
                products.push(product);
            } catch (e) {
                console.warn(`Lỗi parse JSON cho key ${key}`, e);
            }
        }
    }

    return products;
}

const numberofproduct = document.getElementById("numberofproduct");

window.onload = () => {
    const cartProducts = getAllProductsInCart();
    numberofproduct.innerText = cartProducts.length;
    var checkoutCart = document.getElementById("checkout-cart");
    checkoutCart.innerHTML = "";

    const groupedProducts = {};

    cartProducts.forEach(product => {
        const key = product.mamau
            ? `${product.id}-${product.size}-${product.mamau}`
            : `${product.id}-${product.size}`;

        if (!groupedProducts[key]) {
            groupedProducts[key] = { ...product, quantity: 0 };
        }
        groupedProducts[key].quantity += product.quantity;
    });

    let tongsoluong = 0;
    Object.entries(groupedProducts).forEach(([key, product]) => {
        const discountedPrice = product.giamgia > 0
            ? product.gia - (product.gia * product.giamgia) / 100
            : product.gia;

        const productCard = document.createElement("div");
        productCard.classList.add("cart-item");
        productCard.innerHTML = `
            <div class="product-thumbnail">
                <div class="product-thumbnail_wrapper">
                    <img class="product-thumbnail__image" src="${product.duongdananh}" alt="Áo thun" />
                </div>
            </div>
            <div class="item-info">
                <p class="product-name">${product.tensp}</p>
                <p class="product-variant">Size: ${product.size} | SL: ${product.quantity} ${product.mamau ? `| Màu: ${product.mamau}` : ""}</p> 
                <p class="product-price">
                    ${product.giamgia > 0 ? `
                        <span class="discount">-${product.giamgia}%</span>
                        <span class="new-price">${formatToVND(discountedPrice * product.quantity)}</span>
                        <span class="old-price">${formatToVND(product.gia * product.quantity)}</span>
                    ` : `
                        <span class="new-price">${formatToVND(product.gia)}</span>
                    `}
                </p>
            </div>
        `;
        checkoutCart.appendChild(productCard);
        tongsoluong += product.quantity;
    });

    
    const checkoutPrice = document.getElementById("checkout-price");
    const checkoutPriceTransportFee = document.getElementById("checkout-price-transport-fee");
    const checkoutPriceDiscount = document.getElementById("checkout-price-discount");
    const checkoutPriceFinal = document.getElementById("checkout-price-final");
    const diemtichluyconlai = document.getElementById("diemtichluyconlai");

    checkoutPriceDiscount.dataset.discountedPrice = 0;
    checkoutPricePoint.dataset.point = 0;
    checkoutPriceTransportFee.dataset.fee = 0;

    checkoutPrice.innerText = formatToVND(calculateTotalPrice(groupedProducts));
    checkoutPrice.dataset.checkoutPrice = calculateTotalPrice(groupedProducts);

    var data = calculateFinalPrice(
        checkoutPrice.dataset.checkoutPrice, 
        checkoutPriceDiscount.dataset.discountedPrice, 
        checkoutPricePoint.dataset.point, 
        checkoutPriceTransportFee.dataset.fee);

    checkoutPriceFinal.innerText = formatToVND(data.total);
    checkoutPriceFinal.dataset.finalPrice = data.total;
    
    const observer = new MutationObserver(() => {
        var data = calculateFinalPrice(
            parseInt(checkoutPrice.dataset.checkoutPrice),
            parseInt(checkoutPriceDiscount.dataset.discountedPrice),
            parseInt(checkoutPricePoint.dataset.point),
            parseInt(checkoutPriceTransportFee.dataset.fee)
        )

        checkoutPriceFinal.innerText = formatToVND(data.total);
        checkoutPriceFinal.dataset.finalPrice = data.total;
        // checkoutPriceDiscount.innerText = formatToVND(data.usedPoint);
    });

    observer.observe(checkoutPriceDiscount, { attributes: true, attributeFilter: ['data-discounted-price'] });
    observer.observe(checkoutPricePoint, { attributes: true, attributeFilter: ['data-point'] });
    observer.observe(checkoutPriceTransportFee, { attributes: true, attributeFilter: ['data-fee'] });

    const checkbox = document.querySelector("#loyalty input[type='checkbox']");
    checkbox.addEventListener("change", () => {
        if(checkbox.checked){
            var data = calculateFinalPrice(
                parseInt(checkoutPrice.dataset.checkoutPrice),
                parseInt(checkoutPriceDiscount.dataset.discountedPrice),
                parseInt(diemtichluy.dataset.diemtichluy),
                parseInt(checkoutPriceTransportFee.dataset.fee)
            )
            checkoutPricePoint.innerText = data.usedPoint;
            checkoutPricePoint.dataset.point = data.usedPoint;

            diemtichluyconlai.innerText = data.remainingPoint;
            diemtichluyconlai.dataset.diemtichluyconlai = data.remainingPoint;

            checkoutPriceFinal.innerText = formatToVND(data.total);
            checkoutPriceFinal.dataset.finalPrice = data.total;

        }else{
            checkoutPricePoint.dataset.point = 0;
            checkoutPricePoint.innerText = 0;
            diemtichluyconlai.innerText = diemtichluy.dataset.diemtichluy;
            diemtichluyconlai.dataset.diemtichluyconlai = diemtichluy.dataset.diemtichluy;
        }
    });

    const input = document.getElementById('coupon-input');
    const button = document.getElementById('apply-btn');

    function applyCoupon() {
        const code = input.value.trim();
        axios.get('http://localhost/ClothingStoreWebsite_UsingPHP/app/controllers/checkoutController.php', {
            params: {
                action: 'getCodeGiamGia',
                magiamgia: code
            }
        }).then(res => {
            if (res.data.success) {
                if (res.data.getCodeGiamGia) {
                    checkoutPriceDiscount.dataset.discountedPrice = res.data.getCodeGiamGia.tiengiam;
                    checkoutPriceDiscount.innerHTML = `-${formatToVND(res.data.getCodeGiamGia.tiengiam)}`;
                } else {
                    alert("Mã giảm không tồn tại");
                }
            }else{
                showAlert("Mã giảm không tồn tại");
            }            
        });
    }

    // Nhấn Enter trong ô input
    input.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            applyCoupon();
        }
    });
    
    // Click nút
    button.addEventListener('click', applyCoupon);
    const now = dayjs();
    const mysqlDate = now.format('YYYY-MM-DD HH:mm:ss');  // Đảm bảo định dạng đúng cho MySQL

    const orderbtn = document.getElementById("order-btn");
    const ghichu = document.getElementById("ghichu");

    orderbtn.addEventListener("click", () => {
        if (
            !emailinput.value.trim() ||
            !hoteninput.value.trim() ||
            !sdtinput.value.trim() ||
            !diachiinput.value.trim() ||
            !phuongxainput.value.trim()||
            !tinhThanhSelect.value.trim()||
            !quanHuyenSelect.value.trim()
        ) {
            showAlert("Vui lòng điền đầy đủ thông tin trước khi đặt hàng.");
            return;
        }
        const diaChiDayDu = `${diachiinput.value}, ${phuongxainput.value}, ${quanDuocChon}, ${tinhDuocChon}`;

        if(user.makh != null){
            console.log(mysqlDate);
            axios.post('http://localhost/ClothingStoreWebsite_UsingPHP/app/controllers/checkoutController.php', {
                action: "createOrder",
                ngay: mysqlDate,
                tongtien: checkoutPriceFinal.dataset.finalPrice,
                makh: user.makh,
                dssanpham: groupedProducts,
                diachi: diaChiDayDu,
                ghichu: ghichu.value,
                soluong: tongsoluong
            }).then(res => {
                if (res.data.success) {
                    showAlert("Thêm sản phẩm thành công"); // toast đẹp
                    clearLocalStorageExceptUser();
            
                    // Chờ 2 giây sau khi show toast rồi mới chuyển trang
                    setTimeout(() => {
                        window.location.href = "index.php";
                    }, 2000); // hoặc 3000ms tùy thời gian toast hiển thị
                }
            });            
        }else{
            axios.get('http://localhost/ClothingStoreWebsite_UsingPHP/app/controllers/checkoutController.php', {
                params: { 
                    action: 'getEmail',
                    email: emailinput.value
                }
            }).then(res => {
                if(res.data.success){
                    if(res.data.getEmail){
                        axios.post('http://localhost/ClothingStoreWebsite_UsingPHP/app/controllers/checkoutController.php', {
                            action: "createOrder",
                            ngay: mysqlDate,
                            tongtien: checkoutPriceFinal.dataset.finalPrice,
                            makh: res.data.getEmail.makh,
                            dssanpham: groupedProducts,
                            diachi: diaChiDayDu,
                            ghichu: ghichu.value,
                            soluong: tongsoluong
                        })
                        .then(res => {
                            if (res.data.success) {
                                showAlert("Thêm sản phẩm thành công"); // toast đẹp
                                clearLocalStorageExceptUser();
                        
                                // Chờ 2 giây sau khi show toast rồi mới chuyển trang
                                setTimeout(() => {
                                    window.location.href = "index.php";
                                }, 2000); // hoặc 3000ms tùy thời gian toast hiển thị
                            }
                        })
                    }
                }else{
                    axios.post('http://localhost/ClothingStoreWebsite_UsingPHP/app/controllers/checkoutController.php', {
                        action: "createCustomer",
                        hoten: hoteninput.value,
                        sdt: sdtinput.value,
                        email: emailinput.value
                    })
                    .then(response => {
                        axios.post('http://localhost/ClothingStoreWebsite_UsingPHP/app/controllers/checkoutController.php', {
                            action: "createOrder",
                            ngay: mysqlDate,
                            tongtien: checkoutPriceFinal.dataset.finalPrice,
                            makh: response.data.newCustomerId,
                            dssanpham: groupedProducts,
                            diachi: diaChiDayDu,
                            ghichu: ghichu.value,
                            soluong: tongsoluong
                        })
                        .then(response => {
                            if (response.data.success) {
                                console.log(response.data.createOrderAndOrderDetail);
                                showAlert("Thêm sản phẩm thành công"); // toast đẹp
                                clearLocalStorageExceptUser();
                        
                                // Chờ 2 giây sau khi show toast rồi mới chuyển trang
                                setTimeout(() => {
                                    window.location.href = "index.php";
                                }, 2000); // hoặc 3000ms tùy thời gian toast hiển thị
                            }
                        })
                    })
                }
            });
        }
    });
};

function calculateTotalPrice(groupedProducts) {
    let total = 0;
    Object.values(groupedProducts).forEach(product => {
        const discountedPrice = product.giamgia > 0
            ? product.gia - (product.gia * product.giamgia) / 100
            : product.gia;
        total += discountedPrice * product.quantity;
    });
    return total;
}

function calculateFinalPrice(totalPrice, discount, point, transportfee) {
    let total = parseInt(totalPrice) + parseInt(transportfee);
    let remainingPoint = 0;
    let usedPoint = 0;

    if (total - discount > 0) {
        total -= discount;
        if (total - point * 1000 > 0) {
            total -= point * 1000;
            usedPoint = 0;
        } else {
            remainingPoint = point * 1000 - total;
            usedPoint = point * 1000 - remainingPoint;
            usedPoint /= 1000;
            remainingPoint /= 1000;
            total = 0;
        }
    } else {
        total = 0;
    }

    return {
        total,
        usedPoint,
        remainingPoint
    };
}

function clearLocalStorageExceptUser() {
    const user = localStorage.getItem("user"); // Lưu lại user
    localStorage.clear(); // Xóa toàn bộ localStorage
    if (user) {
        localStorage.setItem("user", user); // Gán lại user nếu có
    }
}

const continueshopping = document.getElementById("continue-shopping");
continueshopping.addEventListener("click", ()=>{
    window.location.href = "productpage.php";
})