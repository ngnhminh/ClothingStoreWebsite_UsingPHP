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
const product_list = document.querySelectorAll(".product-list .product");
product_list.forEach(element => {
    element.addEventListener("click", function() {
        openChangePanel();
        let productId = element.dataset.masp;
        console.log(productId);
        GetProductSizeWithId("getProductInform", productId);
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

//Thêm sản phẩm vào web
//Gán sự kiện cho nút (Sử dụng ajax)
function displayProducts(products) {
    let productContainer = document.getElementById("product-list"); // Lấy thẻ chứa sản phẩm
    productContainer.innerHTML = ""; // Xóa nội dung cũ

    products.forEach(product => {
        let productHTML = `
            <div class="product" data-masp="${product.masp}">
                <div class="product-thumbnail">
                    <div class="product-thumbnail_wrapper">
                        <img class="product-thumbnail__image" src="${product.duongdananh}" alt="Áo thun" />
                    </div>
                </div>
                <p>${product.tensp}</p>
             </div>
        `;
        productContainer.innerHTML += productHTML;
    });
}

//lấy gửi fetch tới db để trả dữ liệu về
function GetProductsWithType(funcName, type) {
    fetch(`http://localhost:3000/app/controllers/productmanagementcontroller.php?function=${funcName}&params=${type}`)
    .then(response => response.json())
    .then(data => {
        displayProducts(data);
        console.log("Phản hồi từ server:", data);
    })
    .catch(error => console.error("Lỗi:", error));
}

const filter_buttons = document.querySelectorAll(".filter-bar button");

filter_buttons.forEach((button)=>{
    button.addEventListener("click", () => {
        console.log(button.value);
        if(button.value === "All"){
            GetProductsWithType("getAllProducts");
        }else{
            GetProductsWithType("getAllByType", button.value);
        }
    });
})

//Hiện thông tin sản phẩm qua masp
////---------------------------------------
function displaySizeProducts(sizes) {
    let sizeContainer = document.getElementById("changeproductsize-container");
    sizeContainer.innerHTML = ""; // Xóa nội dung cũ

    sizes.forEach(size => {
        let sizeHTML = `
            <div class="size-option">
                <div>${size.tenkichco}</div>
                <input type="number" value="${size.soluong}">
            </div>
        `;
        sizeContainer.innerHTML += sizeHTML;
    });
}

//Hàm gọi size và số lượng
function GetProductSizeWithId(funcName, masp) {
    fetch(`http://localhost:3000/app/controllers/productmanagementcontroller.php?function=${funcName}&params=${masp}`)
    .then(response => response.json())
    .then(data => {
        displaySizeProducts(data);
        console.log("Phản hồi từ server:", data);
    })
    .catch(error => console.error("Lỗi:", error));

    //kiểm tra dữ liệu trả về cái gì ?
    // fetch(`http://localhost:3000/app/controllers/productmanagementcontroller.php?function=${funcName}&params=${masp}`)
    // .then(response => response.text()) // Đọc dữ liệu dạng text trước
    // .then(data => {
    //     console.log("Dữ liệu nhận được:", data); // Kiểm tra xem server trả về gì
    //     return JSON.parse(data); // Chuyển đổi sang JSON
    // })
    // .then(jsonData => {
    //     displaySizeProducts(jsonData);
    //     console.log("Phản hồi JSON hợp lệ:", jsonData);
    // })
    // .catch(error => console.error("Lỗi:", error));

}

function GetProductInform(funcName, masp){
    fetch(`http://localhost:3000/app/controllers/productmanagementcontroller.php?function=${funcName}&params=${masp}`)
    .then(response => response.json())
    .then(data => {
        displaySizeProducts(data);
        console.log("Phản hồi từ server:", data);
    })
}