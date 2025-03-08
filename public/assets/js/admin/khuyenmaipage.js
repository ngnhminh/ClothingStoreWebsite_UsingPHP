
var adddiscountModal = document.getElementsByClassName("discount-modal");

function closeModal() {
    adddiscountModal[0].style.display = 'none';
    adddiscountModal[1].style.display = 'none';
}

// Tác vụ mở thông tin sản phẩm giảm giá
const product_list = document.querySelectorAll(".product-list");
product_list.forEach(element => {
    element.addEventListener("click", function(event) {
        adddiscountModal[0].style.display = 'flex';
    });
});

// Mở kho voucher
const voucher_storage_btn = document.getElementById("voucherstorage");
const product_list_id = document.getElementById("product-list");
const voucher_container = document.getElementsByClassName("voucher-container");
const add_voucher_voucher = document.getElementsByClassName("add-voucher-voucher");

voucher_storage_btn.addEventListener("click", function(){
    product_list_id.style.display="none";
    voucher_container[0].style.display="block";
    add_voucher_voucher[0].style.display="block";
});

//Mở trang sản phẩm
const storage = document.getElementById("storage");
storage.addEventListener("click", function(){
    product_list_id.style.display="grid";
    voucher_container[0].style.display="none";
    add_voucher_voucher[0].style.display="none";
});

//Mở panel thêm voucher
const voucher_adding_panel = document.getElementsByClassName("add-voucher-modal");
const add_voucher_btn = document.getElementById("add-voucher-voucher");
add_voucher_btn.addEventListener("click", function(){
    adddiscountModal[1].style.display = 'flex';
});