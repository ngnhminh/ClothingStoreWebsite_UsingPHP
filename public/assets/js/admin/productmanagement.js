// biến chung
var product = document.getElementsByClassName("product");
var change_modal = document.getElementsByClassName("change-modal");
var btnadd = document.getElementById("add-product-btn");
const size_option = document.querySelectorAll(".size-option");
const product_add_colornpic = document.getElementById("product-add-colornpic");
let producttypestatus = "";
function normalizeString(str) {
    // Loại bỏ dấu và chuyển đổi thành chữ thường
    return str.normalize("NFD") // Tách ký tự và dấu
              .replace(/[\u0300-\u036f]/g, "") // Xóa các dấu bằng regex
              .toLowerCase(); // Chuyển thành chữ thường
}

function formatCurrencyVND(value) {
    return value.toLocaleString('vi-VN') + 'đ';
}

function removeHash(str) {
    return str.replace(/^#/, ''); 
}

console.log(removeHash("#abc")); // "abc"
console.log(removeHash("abc"));  // "abc" (không bị ảnh hưởng)

//Chọn bảng màu
var btn_change = document.getElementById("btn-change");
btn_change.addEventListener("click", () => {
    colorPicker.click(); 
});

colorPicker.addEventListener("change", () => {
    colorValue.textContent = colorPicker.value; 
    var masp = document.getElementById("nameofproduct-change").getAttribute("data-masp");
    // console.log(masp);
    let existingColor = document.querySelectorAll(".color-options-change .color").length; // Đếm số size-option hiện tại

    if (existingColor >= 5) {
        alert("Chỉ được thêm tối đa 5 màu!");
        return; 
    }
    addNewColor(colorPicker.value, masp); 
});

function addNewColor(color, masp){
    let colorContainer = document.getElementById("color-options-change");
    let span = document.createElement("span");
        span.classList.add("newColor");
        span.classList.add("color");
        span.style.backgroundColor = color;
        span.setAttribute("data-colorcode", removeHash(color));
        span.setAttribute("data-masp_id", masp);

        // Gán sự kiện click ngay khi tạo span
        span.addEventListener("click", async function () {
            let masp = this.getAttribute("data-masp_id");
            let hexcode = this.getAttribute("data-colorcode");
            console.log("Clicked color:", hexcode);
            await GetFunctionWithAttribute("getSizeName", masp);
        });

        colorContainer.appendChild(span);
}

//Bảng hình ảnh
const btnImageChange = document.getElementById("btn-image-change");
const fileInput = document.getElementById("fileInput");
const imageBox = document.getElementById("image-box-change");

btnImageChange.addEventListener("click", () => {
    fileInput.click(); // Mở cửa sổ chọn tệp
});

fileInput.addEventListener("change", () => {
    const file = fileInput.files[0]; // Lấy tệp được chọn
    if (file) {
        // Tạo một phần tử hiển thị hình ảnh
        const imageItem = document.createElement("div");
        imageItem.className = "image-item";

        const img = document.createElement("img");
        img.src = URL.createObjectURL(file); // Tạo đường dẫn tạm cho hình ảnh

        const removeButton = document.createElement("button");
        removeButton.textContent = "-";
        removeButton.addEventListener("click", () => {
            imageBox.removeChild(imageItem); // Xóa hình ảnh khi nhấn nút "-"
        });

        imageItem.appendChild(img);
        imageItem.appendChild(removeButton);
        imageBox.appendChild(imageItem); // Thêm hình ảnh vào container
    }
});

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
    element.addEventListener("click", async function() {
        openChangePanel();
        masp=element.dataset.masp;
        let productId = element.dataset.masp;
        console.log(productId);
        // GetFunctionWithAttribute("getProductInform", productId);
        await GetFunctionWithAttribute("getProductInform", productId);
        await GetFunctionWithAttribute("getProductDetailInform", productId);
        await GetFunctionWithAttribute("getProductDescription", productId);
        await GetFunctionWithAttribute("getTypeOfProduct", productId);
        //Kiểm tra loại sản phẩm để lấu size
        if(producttypestatus === "Giày" || producttypestatus === "Kính"){
            await GetFunctionWithAttribute("getProductColor", productId);
        }else{
            await GetFunctionWithAttribute("getProductSizeInform", productId);
        }

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
const filter_buttons = document.querySelectorAll(".filter-bar button");

filter_buttons.forEach((button)=>{
    button.addEventListener("click", () => {
        console.log(button.value);
        if(button.value === "All"){
            GetFunctionWithAttribute("getAllProducts");
        }else{
            GetFunctionWithAttribute("getAllByType", button.value);
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

function displaySizeNewProducts(sizes) {
    let sizeContainer = document.getElementById("changeproductsize-container");
    sizeContainer.innerHTML = ""; // Xóa nội dung cũ
    sizes.forEach(size => {
        let sizeHTML = `
            <div class="size-option new-size">
                <div>${size.tenkichco}</div>
                <input type="number" value="0">
            </div>
        `;
        sizeContainer.innerHTML += sizeHTML;
    });
    
}

//View thông tin sản phẩm
function displayInfoProducts(data) {
    let productContainer = document.getElementById("changeinfoproduct");
    productContainer.innerHTML = ""; // Xóa nội dung cũ
    let changebuttons = document.getElementById("changebuttons");
    // changebuttons.innerHTML = "";
    let product_type = document.getElementById("product-type");
    product_type.innerHTML = "";
    data.forEach(product => {
        //biến
        var productvalue = normalizeString(product.tenloai);
        var pricetvalue = formatCurrencyVND(product.gia);
        var product_add_colornpic = document.querySelector('.changeproduct #product-add-colornpic');

        let infoHTML = `
            <img src="${product.duongdananh}" alt="Sản phẩm">
            <span id="nameofproduct-change" data-masp="${product.masp}">${product.tensp}</span>
            <div class="price" id="change-price-input" style="display: none">
                <span>Giá:</span> 
                <input id="changeproductprice" value="${product.gia}">
            </div>
            <div class="price" id="change-price">
                <span>Giá:</span> 
                <div id="changeproductprice" value="${product.gia}">
                    <span>${pricetvalue}</span>
                </div> 
                <button class="edit-btn" id="edit-btn-change">✎</button>
            </div>
            <button class="save-addbtn">Lưu</button>
        `;

        let typeHTML = `
            <span>Loại:</span>
            <select name="product-type" disabled>
                <option value="${productvalue}">${product.tenloai}</option>
            </select>
        `;
        productContainer.innerHTML += infoHTML;
        product_type.innerHTML += typeHTML;

        var edit_btn_change = document.getElementById("edit-btn-change");
        var change_price_input = document.getElementById("change-price-input");
        var change_price= document.getElementById("change-price");
        edit_btn_change.addEventListener("click", function(){
            change_price_input.style.display = "flex"
            change_price.style.display = "none";
        });

        if(productvalue == "giay" || productvalue == "kinh"){
            product_add_colornpic.style.display = "block";

        }else{
            product_add_colornpic.style.display = "none";
        }  
    });
}

function displayInfoProductsDetail(data) {
    let detailContainer = document.getElementById("detail-container-change");
    detailContainer.innerHTML = ""; // Xóa nội dung cũ

    data.forEach(product => {
        let detailHTML = `
            <textarea placeholder="Chi tiết sản phẩm">${product.chitiet}</textarea>
        `;
        detailContainer.innerHTML += detailHTML;
    });
}

function displayProductsDescription(data) {
    let detailContainer = document.getElementById("description-box");
    detailContainer.innerHTML = ""; // Xóa nội dung cũ

    data.forEach(product => {
        let detailHTML = `${product.mota}`;
        detailContainer.innerHTML += detailHTML;
    });
}

function displayColorProducts(colors) {
    let colorContainer = document.getElementById("color-options-change");
    if (!colorContainer) return; // Tránh lỗi nếu ID không tồn tại

    colorContainer.innerHTML = ""; // Xóa nội dung cũ

    colors.forEach(color => {
        let span = document.createElement("span");
        span.classList.add("color");
        span.style.backgroundColor = "#"+color.mamau;
        span.setAttribute("data-colorcode", color.mamau);
        span.setAttribute("data-masp_id", color.masp_id);

        // Gán sự kiện click ngay khi tạo span
        span.addEventListener("click", async function () {
            let masp = this.getAttribute("data-masp_id");
            let hexcode = this.getAttribute("data-colorcode");
            console.log("Clicked color:", hexcode);
            await GetFunctionWithAttribute("getSizeOfProductColor", masp, hexcode);
        });

        colorContainer.appendChild(span);
    });
}


//vì fetch bất đồng bộ phải sử dụng thêm async function
async function GetFunctionWithAttribute(funcName, masp, mamau) {
    console.log("Màu được truyền vào:", mamau);
    let url = `http://localhost:3000/app/controllers/productmanagementcontroller.php?function=${funcName}&params=${masp}`;
    if (mamau != null) {
        url += `&color=${mamau}`; 
    }
    console.log("URL gọi API:", url); 

    try {
        let response = await fetch(url);
        let data = await response.json();

        console.log("Dữ liệu nhận được:", data); 

        // Kiểm tra kiểu dữ liệu trả về
        if (!data || typeof data !== "object") {
            console.warn("Dữ liệu không hợp lệ hoặc không phải object:", data);
            return null;
        }

        // Kiểm tra các giá trị cụ thể
        if (Array.isArray(data)) {
            console.log("Dữ liệu là một mảng, số lượng phần tử:", data.length);
        } else {
            console.log("Dữ liệu không phải mảng, kiểu dữ liệu:", typeof data);
        }

        if (funcName === "getTypeOfProduct") {
            producttypestatus = data[0]?.tenloai || "Không có dữ liệu";
            console.log("Type:", producttypestatus);
        } else if (funcName === "getProductSizeInform") {
            displaySizeProducts(data);
        } else if (funcName === "getProductInform") {
            displayInfoProducts(data);
        } else if (funcName === "getProductDetailInform") {
            displayInfoProductsDetail(data);
        } else if (funcName === "getProductDescription") {
            displayProductsDescription(data);
        } else if (funcName === "getProductColor") {
            displayColorProducts(data);
        }else if (funcName === "getSizeOfProductColor") {
            displaySizeProducts(data);
        }else if(funcName === "getSizeName") {
            displaySizeNewProducts(data);
        }
        return data;
    } catch (error) {
        console.error("Lỗi khi gọi API:", error);
        return null;
    }
}



    // // kiểm tra dữ liệu trả về cái gì ?
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


