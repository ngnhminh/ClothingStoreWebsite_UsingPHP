// biến chung
var product = document.getElementsByClassName("product");
var change_modal = document.getElementsByClassName("change-modal");
var btnadd = document.getElementById("add-product-btn");
const size_option = document.querySelectorAll(".size-option");
const product_add_colornpic = document.getElementById("product-add-colornpic");

// Tác vụ nút đóng
var closebtn = document.getElementsByClassName("close-btn");
closebtn[0].addEventListener("click", function(){
    change_modal[0].style.display="none";
});

//Tác vụ mở panel
function openChangePanel(){
    if(change_modal[0].style.display != "flex"){
        change_modal[0].style.display = "flex";
    }else{
        change_modal[0].style.display = "none";
    }
}

var changeproductclass = document.getElementsByClassName("changeproduct");
var addproductclass = document.getElementsByClassName("addproduct")

// Tạo sự kiện cho nút thêm sản phẩm
btnadd.addEventListener("click", function(){
    openChangePanel();
    size_option.forEach(function (item) {
        item.style.display = "none";
    });
    product_add_colornpic.style.display = "none";
    // changeproductclass[0].style.display = "none";
    // addproductclass[0].style.display = "flex";
    for(let i=0;i<changeproductclass.length;i++){
        changeproductclass[i].style.display = "none";
    }
    for(let i=0;i<addproductclass.length;i++){
        addproductclass[i].style.display = "flex";
    }
});

// Tác vụ mở thông tin sản phẩm sửa
const product_list = document.querySelectorAll(".product-list");
product_list.forEach(element => {
    element.addEventListener("click", function(event) {
        openChangePanel();
        // console.log("Đối tượng được click:", event.target); // Đối tượng bị click
        // console.log("ID:", event.target.id); // ID của đối tượng (nếu có)
        // console.log("Nội dung:", event.target.textContent); // Nội dung của đối tượng
        for(let i=0;i<changeproductclass.length;i++){
            changeproductclass[i].style.display = "flex";
        }
        for(let i=0;i<addproductclass.length;i++){
            addproductclass[i].style.display = "none";
        }
    });
});

//Tạo sự kiện thay đổi khi nhấp vào loại
const type = document.getElementById("product-type-selected");
const addproduct_quan = document.querySelectorAll(".size-option.addproduct-quan");
const addproduct_giay = document.querySelectorAll(".size-option.addproduct-giay");
const addproduct_kinh = document.querySelectorAll(".size-option.addproduct-kinh");
const addproduct_ao = document.querySelectorAll(".size-option.addproduct-ao");

type.addEventListener("change", function(){
    if(type.value === "ao"){
        size_option.forEach(function (item) {
            item.style.display = "none";
        });
        addproduct_ao.forEach(function (item) {
            item.style.display = "flex";
        });
    }

    if(type.value === "quan"){
        size_option.forEach(function (item) {
            item.style.display = "none";
        });
        addproduct_quan.forEach(function (item) {
            item.style.display = "flex";
            
        });
    } else if(type.value === "giay"){
        size_option.forEach(function (item) {
            item.style.display = "none";
        });
        addproduct_giay.forEach(function (item) {
            item.style.display = "flex";
            product_add_colornpic.style.display = "block";
        });
    } else if(type.value === "kinh"){
        size_option.forEach(function (item) {
            item.style.display = "none";
        });
        addproduct_kinh.forEach(function (item) {
            item.style.display = "flex";
            product_add_colornpic.style.display = "block";

        });
    }
    console.log("YES");
});


// note display của thanh setting =flex