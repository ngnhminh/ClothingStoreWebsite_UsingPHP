var dathang_btn = document.getElementById('btn-primary');
const danhSachTinhThanh = [
    "Hà Nội", "Hồ Chí Minh", "Đà Nẵng", "Hải Phòng", "Cần Thơ",
    "An Giang", "Bà Rịa - Vũng Tàu", "Bắc Giang", "Bắc Kạn", "Bạc Liêu",
    "Bắc Ninh", "Bến Tre", "Bình Định", "Bình Dương", "Bình Phước",
    "Bình Thuận", "Cà Mau", "Cao Bằng", "Đắk Lắk", "Đắk Nông",
    "Điện Biên", "Đồng Nai", "Đồng Tháp", "Gia Lai", "Hà Giang",
    "Hà Nam", "Hà Tĩnh", "Hải Dương", "Hậu Giang", "Hòa Bình",
    "Hưng Yên", "Khánh Hòa", "Kiên Giang", "Kon Tum", "Lai Châu",
    "Lâm Đồng", "Lạng Sơn", "Lào Cai", "Long An", "Nam Định",
    "Nghệ An", "Ninh Bình", "Ninh Thuận", "Phú Thọ", "Phú Yên",
    "Quảng Bình", "Quảng Nam", "Quảng Ngãi", "Quảng Ninh", "Quảng Trị",
    "Sóc Trăng", "Sơn La", "Tây Ninh", "Thái Bình", "Thái Nguyên",
    "Thanh Hóa", "Thừa Thiên Huế", "Tiền Giang", "Trà Vinh", "Tuyên Quang",
    "Vĩnh Long", "Vĩnh Phúc", "Yên Bái"
];
const tinhThanhSelect = document.getElementById("tinhThanh");
const quanHuyenSelect = document.getElementById("quanHuyen");
danhSachTinhThanh.forEach(tinh => {
    const option = document.createElement("option");
    option.value = tinh;
    option.textContent = tinh;
    tinhThanhSelect.appendChild(option);
});


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

// Đổ dữ liệu tỉnh/thành vào dropdown
Object.keys(quanHuyen).forEach(tinh => {
    let option = document.createElement("option");
    option.value = tinh;
    option.textContent = tinh;
    tinhThanhSelect.appendChild(option);
});

// Sự kiện khi thay đổi tỉnh/thành phố
tinhThanhSelect.addEventListener("change", function() {
    let tinhDuocChon = this.value;
    quanHuyenSelect.innerHTML = '<option value="">-- Chọn Quận/Huyện --</option>';

    if (tinhDuocChon) {
        quanHuyen[tinhDuocChon].forEach(quan => {
            let option = document.createElement("option");
            option.value = quan;
            option.textContent = quan;
            quanHuyenSelect.appendChild(option);
        });
    }
});

const emailinput = document.getElementById("email-input");
const hoteninput = document.getElementById("hoten-input");
const sdtinput = document.getElementById("sdt-input");
const diachiinput = document.getElementById("diachi-input");
const phuongxainput = document.getElementById("phuong-input");

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

    }else{
        annouce_box.style.display="flex";
        transport_fee.style.display="none";
        shipping_box.style.backgroundColor="#D1ECF1";
        shipping_box.style.color="#0C5460"
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

