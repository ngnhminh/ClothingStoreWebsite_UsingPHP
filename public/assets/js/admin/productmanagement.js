// biến chung
var product = document.getElementsByClassName("product");
var change_modal = document.getElementsByClassName("change-modal");
var btnadd = document.getElementById("add-product-btn");
const size_option = document.querySelectorAll(".size-option");
const product_change_colornpic = document.getElementById("product-change-colornpic");
const product_add_colornpic = document.getElementById("product-add-colornpic");
let producttypestatus = "";
let presentpage = "All";
let maspglobal = "";
let hexcodeglobal ="";
let colorCode;

//Tạo sự kiện thay đổi khi nhấp vào loại
const type = document.getElementById("product-type-selected");
const addproduct_quan = document.querySelectorAll(".size-option.addproduct-quan");
const addproduct_giay = document.querySelectorAll(".size-option.addproduct-giay");
const addproduct_kinh = document.querySelectorAll(".size-option.addproduct-kinh");
const addproduct_ao = document.querySelectorAll(".size-option.addproduct-ao");

type.addEventListener("change", async function(){
    if(type.value === "ao"){
        size_option.forEach(function (item) {
            item.style.display = "none";
        }); 
        addproduct_ao.forEach(function (item) {
            item.style.display = "flex";
        });
        btn_add.style.display = "none"
        colorCode = null;
        var selectedOption = type.options[type.selectedIndex];
        var dataType = selectedOption.getAttribute("data-type")
        await GetFunctionWithAttribute("getSizeOfProductByMaloai", { maloai: dataType });
        product_add_colornpic.style.display = "none";
    }

    if(type.value === "quan"){
        size_option.forEach(function (item) {
            item.style.display = "none";
        });
        addproduct_quan.forEach(function (item) {
            item.style.display = "flex";
        });
        btn_add.style.display = "none";
        colorCode = null;
        product_add_colornpic.style.display = "none";
        var selectedOption = type.options[type.selectedIndex];
        var dataType = selectedOption.getAttribute("data-type")
        await GetFunctionWithAttribute("getSizeOfProductByMaloai", { maloai: dataType });
    } else if(type.value === "giay"){
        size_option.forEach(function (item) {
            item.style.display = "none";
        });
        addproduct_giay.forEach(function (item) {
            item.style.display = "flex";
            product_change_colornpic.style.display = "block";
        });
        btn_add.style.display = "block";
        product_add_colornpic.style.display = "block";
    } else if(type.value === "kinh"){
        size_option.forEach(function (item) {
            item.style.display = "none";
        });
        addproduct_kinh.forEach(function (item) {
            item.style.display = "flex";
            product_change_colornpic.style.display = "block";
        });
        btn_add.style.display = "none";
        colorCode = null;
        var selectedOption = type.options[type.selectedIndex];
        var dataType = selectedOption.getAttribute("data-type")
        await GetFunctionWithAttribute("getSizeOfProductByMaloai", { maloai: dataType });
        product_add_colornpic.style.display = "none";
    }
    console.log("YES");
});

function normalizeString(str) {``
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

var search = document.getElementById("search");
search.addEventListener("input", function(){
    GetFunctionWithAttribute("getSanPhamByName", {tensanpham: search.value})
});

//alert vjp
function alertCustom(message, bgColor = "#f44336") {
    // Tạo phần tử alert
    let alertBox = document.createElement("div");
    alertBox.className = "custom-alert";
    alertBox.style.backgroundColor = bgColor;
    alertBox.textContent = message;

    // Thêm vào body
    document.body.appendChild(alertBox);

    // Xóa sau 3 giây
    setTimeout(() => {
      alertBox.remove();
    }, 1500);
  }

//Nút thêm ô trong description
document.getElementById("add-textarea-btn").addEventListener("click", function () {
    let container = document.getElementById("detail-container-change");

    let newTextarea = document.createElement("textarea");
    newTextarea.placeholder = "Chi tiết sản phẩm";
    newTextarea.classList.add("extra-textarea"); // Thêm class để dễ quản lý

    container.appendChild(newTextarea);
});

document.getElementById("remove-textarea-btn").addEventListener("click", function () {
    let container = document.getElementById("detail-container-change");
    let extraTextareas = container.getElementsByClassName("extra-textarea");

    if (extraTextareas.length > 0) {
        container.removeChild(extraTextareas[extraTextareas.length - 1]); // Xóa textarea cuối cùng
    }
});



//Chọn bảng màu
const colorPicker = document.getElementById("colorPicker");
const colorPickerAdd = document.getElementById("colorPicker");

 // Khai báo trước
var btn_change = document.getElementById("btn-change");
var btn_add = document.getElementById("btn-add");

btn_change.addEventListener("click", () => {
    colorPicker.click(); // Sử dụng sau khi đã khai báo
});

if (colorPicker) {
    colorPicker.addEventListener("change", () => {
        colorValue.textContent = colorPicker.value;
    });
} else {
    console.warn("Không tìm thấy colorPicker!");
}

btn_add.addEventListener("click", () => {
    colorPickerAdd.click(); // Sử dụng sau khi đã khai báo
});

colorPickerAdd.addEventListener("input", () => {
    const selectedColor = colorPickerAdd.value;
    addNewColorAdd(colorPickerAdd.value);
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
            await GetFunctionWithAttribute("getSizeName", {masp: masp});
        });

        colorContainer.appendChild(span);
}

//đặt biến màu ra giá trị toàn cục
function addNewColorAdd(color){
    let colorContainer = document.getElementById("color-options-add");
    let btnImageAdd = document.getElementById("btn-image-add");
    let span = document.createElement("span");
        span.classList.add("newColor");
        span.classList.add("color");
        span.style.backgroundColor = color;
        span.setAttribute("data-colorcode", removeHash(color));

        // Gán sự kiện click ngay khi tạo span
        span.addEventListener("click", async function () {
            let hexcode = this.getAttribute("data-colorcode");
            console.log("Clicked color:", hexcode);
            btnImageAdd.style.display = "block";
            colorCode = hexcode;
            onColorChange(hexcode);
            var selectedOption = type.options[type.selectedIndex];
            var dataType = selectedOption.getAttribute("data-type");
            console.log(dataType);
            await GetFunctionWithAttribute("getSizeOfProductByMaloai", { maloai: dataType });
        });
        colorContainer.appendChild(span);
}

// Bảng hình ảnh
const btnImageChange = document.getElementById("btn-image-change");
const btnImageAdd = document.getElementById("btn-image-add");

const fileInput = document.getElementById("fileInput");
const fileInputAdd = document.getElementById("fileInputAdd");

const imageBox = document.getElementById("image-box-change");
const imageBoxAdd = document.getElementById("image-box-add");

const mainImage = document.querySelector("#first-image img");
const firstImage = document.getElementById("main-product-image");
const fileInputAvatar = document.getElementById("main-image-input");

firstImage.addEventListener("click", () => {
    fileInput.click(); // Mở hộp thoại chọn file
});

fileInput.addEventListener("change", async () => {
    const file = fileInput.files[0];
    if (!file) return;

    let formData = new FormData();
    formData.append("file", file);

    try {
        let response = await fetch("http://localhost/ClothingStoreWebsite_UsingPHP/public/upload.php", {
            method: "POST",
            body: formData
        });

        let result = await response.json();
        if (result.success) {
            let fullImageUrl = `http://localhost/ClothingStoreWebsite_UsingPHP/public${result.path}`;
            mainImage.src = fullImageUrl + "?t=" + new Date().getTime(); // 👈 Gán lại ảnh
        } else {
            console.error("Lỗi khi tải ảnh lên:", result.message);
        }
    } catch (error) {
        console.error("Lỗi upload ảnh:", error);
    }
});

btnImageChange.addEventListener("click", () => {
    fileInput.click(); // Mở cửa sổ chọn tệp
});

fileInput.addEventListener("change", async () => {
    const file = fileInput.files[0]; // Lấy file người dùng chọn
    if (!file) return;

    // Tạo FormData để gửi file lên server
    let formData = new FormData();
    formData.append("file", file);
    try {
        let response = await fetch("http://localhost/ClothingStoreWebsite_UsingPHP/public/upload.php", { // Cập nhật URL API PHP
            method: "POST",
            body: formData
        });

        let result = await response.json();
        if (result.success) {
            let relativePath = result.path; // Nhận đường dẫn từ server (Sửa từ filePath -> path)

            // Tạo URL đầy đủ để hiển thị ảnh
            let fullImageUrl = `http://localhost/ClothingStoreWebsite_UsingPHP/public${relativePath}`;

            // Thêm ảnh vào danh sách hiển thị
            const imageItem = document.createElement("div");
            imageItem.classList.add("image-item", "new-image-item");

            const img = document.createElement("img");
            img.src = fullImageUrl; // Dùng đường dẫn chính xác từ server
            img.alt = "Uploaded Image";

            const removeButton = document.createElement("button");
            removeButton.textContent = "-";
            removeButton.addEventListener("click", () => {
                imageBox.removeChild(imageItem); // Xóa ảnh khi nhấn nút "-"
            });

            imageItem.appendChild(img);
            imageItem.appendChild(removeButton);
            imageBox.appendChild(imageItem);
        } else {
            console.error("Lỗi khi tải ảnh lên:", result.message);
        }
    } catch (error) {
        console.error("Lỗi upload ảnh:", error);
    }
});


// Gọi khi chọn màu mới
function onColorChange(hexcode) {
    colorcode = hexcode;

    // Ẩn tất cả nhóm ảnh
    document.querySelectorAll('.image-group').forEach(group => {
        group.style.display = 'none';
    });

    // Nếu đã có nhóm ảnh cho hexcode → hiện lại
    let group = document.querySelector(`.image-group[data-colorcode="${hexcode}"]`);
    if (group) {
        group.style.display = 'flex';
    } else {
        // Nếu chưa có thì tạo mới
        const newGroup = document.createElement("div");
        newGroup.classList.add("image-group");
        newGroup.dataset.colorcode = hexcode;
        newGroup.style.display = "flex";
        imageBoxAdd.appendChild(newGroup);
    }
}

// Upload ảnh
btnImageAdd.addEventListener("click", () => {
    if (!colorCode) {
        alert("Vui lòng chọn màu trước khi thêm ảnh.");
        return;
    }
    fileInputAdd.click();
});

fileInputAdd.addEventListener("change", async () => {
    const file = fileInputAdd.files[0];
    if (!file || !colorCode) return;

    let formData = new FormData();
    formData.append("file", file);

    try {
        let response = await fetch("http://localhost/ClothingStoreWebsite_UsingPHP/public/upload.php", {
            method: "POST",
            body: formData
        });

        let result = await response.json();
        if (result.success) {
            let fullImageUrl = `http://localhost/ClothingStoreWebsite_UsingPHP/public${result.path}`;

            const group = document.querySelector(`.image-group[data-colorcode="${colorCode}"]`);

            const imageItem = document.createElement("div");
            imageItem.classList.add("image-item", "new-image-item");

            const img = document.createElement("img");
            img.src = fullImageUrl;
            img.alt = "Uploaded Image";

            const removeButton = document.createElement("button");
            removeButton.textContent = "-";
            removeButton.addEventListener("click", () => {
                group.removeChild(imageItem);
            });

            imageItem.appendChild(img);
            imageItem.appendChild(removeButton);
            group.appendChild(imageItem);
        } else {
            console.error("Lỗi khi tải ảnh lên:", result.message);
        }
    } catch (error) {
        console.error("Lỗi upload ảnh:", error);
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
    product_change_colornpic.style.display = "none";
    product_add_colornpic.style.display = "block";
    // changeproductclass[0].style.display = "none";
    // addproductclass[0].style.display = "flex";
    for(let i=0;i<changeproductclass.length;i++){
        changeproductclass[i].style.display = "none";
    }
    for(let i=0;i<addproductclass.length;i++){
        addproductclass[i].style.display = "flex";
    }
    cleanAddInput();
});

openModalChangeProduct();

// Tác vụ mở thông tin sản phẩm sửa
function openModalChangeProduct(){
    const product_list = document.querySelectorAll(".product-list .product");
    product_list.forEach(element => {
        element.addEventListener("click", async function() {
            openChangePanel();
            masp=element.dataset.masp;
            let productId = element.dataset.masp;
            console.log(productId);
            // GetFunctionWithAttribute("getProductInform", productId);
            await GetFunctionWithAttribute("getProductInform", {masp: productId});
            await GetFunctionWithAttribute("getProductDetailInform", {masp: productId});
            await GetFunctionWithAttribute("getProductDescription", {masp: productId});
            await GetFunctionWithAttribute("getTypeOfProduct", {masp: productId});
            //Kiểm tra loại sản phẩm để lấu size
            if(producttypestatus === "Giày" || producttypestatus === "Kính"){
                await GetFunctionWithAttribute("getProductColor", {masp: productId});
            }else{
                await GetFunctionWithAttribute("getProductSizeInform", {masp: productId});
            }

            for(let i=0;i<changeproductclass.length;i++){
                changeproductclass[i].style.display = "flex";
            }
            for(let i=0;i<addproductclass.length;i++){
                addproductclass[i].style.display = "none";
            }
        });
    });
}

//Thêm sản phẩm vào web
//Gán sự kiện cho nút (Sử dụng ajax)
function displayProducts(products) {
    let productContainer = document.getElementById("product-list"); // Lấy thẻ chứa sản phẩm
    productContainer.innerHTML = ""; // Xóa nội dung cũ

    products.forEach(product => {
        let productHTML = `
            <div class="product" data-masp="${product.id}">
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

let isLoading = false;

filter_buttons.forEach((button) => {
    button.addEventListener("click", async () => {
        if (isLoading) return; // Tránh request liên tục
        isLoading = true;

        filter_buttons.forEach(btn => btn.classList.remove("active"));
        button.classList.add("active");

        console.log(button.value);

        try {
            if (button.value === "All") {
                await GetFunctionWithAttribute("getAllProducts", {});
                presentpage = "All";
            } else if (button.value === "Block") {
                await GetFunctionWithAttribute("getAllProductsBlocked", {});
                presentpage = "Block";
            } else {
                presentpage = button.value;
                await GetFunctionWithAttribute("getAllByType", { loaisanpham: button.value });
            }
        } catch (error) {
            console.error("Lỗi khi lọc sản phẩm:", error);
        } finally {
            isLoading = false;
        }
    });
});

//Hiện thông tin sản phẩm qua masp
////---------------------------------------
function displaySizeProducts(sizes) {
    let sizeContainer = document.getElementById("changeproductsize-container");
    sizeContainer.innerHTML = ""; // Xóa nội dung cũ

    sizes.forEach((size, index) => {
        let sizeHTML = `
            <div class="size-option">
                <label for="size-${index}">${size.tenkichco}</label>
                <input type="number" id="size-${index}" name="size-name" value="${size.soluong}">
            </div>
        `;
        sizeContainer.innerHTML += sizeHTML;
    });    
}

function displaySizeNewProducts(sizes) {
    let sizeContainer = document.getElementById("changeproductsize-container");
    sizeContainer.innerHTML = ""; // Xóa nội dung cũ
    sizes.forEach((size, index) => {
        let sizeHTML = `
            <div class="size-option new-size">
                <label id="new-size-${index}">${size.tenkichco}</label>
                <input type="number" id="new-size-${index}" name="new-size-name" value="0">
            </div>
        `;
        sizeContainer.innerHTML += sizeHTML;
    }); 
}

function displaySizeNewProductsForRest(sizes) {
    let sizeContainer = document.getElementById("addproductsize-container");
    sizeContainer.innerHTML = ""; // Xóa nội dung cũ
    sizes.forEach((size, index) => {
        let sizeHTML = `
            <div class="size-option new-size ao-quan-size">
                <label id="new-size-${index}">${size.tenkichco}</label>
                <input type="number" id="new-size-${index}" name="new-size-name" value="0">
            </div>
        `;
        sizeContainer.innerHTML += sizeHTML;
    }); 
}

function displaySizeNewProductsAdd(sizes, hexcode) {
    const sizeContainer = document.getElementById("addproductsize-container");

    // Ẩn tất cả các size hiện tại
    sizeContainer.querySelectorAll('.new-size').forEach(el => {
        el.style.display = 'none';
    });

    // Kiểm tra xem nhóm size với hexcode này đã được tạo chưa
    const existingGroup = sizeContainer.querySelector(`.new-size[data-colorcode="${hexcode}"]`);

    if (existingGroup) {
        // Nếu đã có → chỉ cần hiển thị lại nhóm đó
        sizeContainer.querySelectorAll(`.new-size[data-colorcode="${hexcode}"]`).forEach(el => {
            el.style.display = 'flex';
        });
    } else {
        // Nếu chưa có → render mới với value = 0
        sizes.forEach((size, index) => {
            const sizeHTML = `
                <div class="size-option new-size" data-colorcode="${hexcode}" style="display: flex;">
                    <label for="new-size-${hexcode}-${index}">${size.tenkichco}</label>
                    <input type="number" id="new-size-${hexcode}-${index}" name="new-size-name" value="0" min="0">
                </div>
            `;
            sizeContainer.insertAdjacentHTML('beforeend', sizeHTML);
        });
    }
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
        var product_change_colornpic = document.querySelector('.changeproduct #product-change-colornpic');

        let infoHTML = `
            <img src="${product.duongdananh}" alt="Sản phẩm">
            <span id="nameofproduct-change" data-masp="${product.id}">${product.tensp}</span>
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

        //Sự kiện nút block
        var lock_btn = document.getElementById("change-lock-btn");
        if (lock_btn) {  // Kiểm tra nếu phần tử tồn tại
            lock_btn.innerText = product.matinhtrang === 0 ? "Mở khóa" : "Khóa";
        } else {
            console.warn("Không tìm thấy nút khóa!");
        }


        let isProcessing = false; // Biến trạng thái

        lock_btn.addEventListener("click", async function () {
            if (isProcessing) return; // Nếu đang xử lý, bỏ qua click mới
            isProcessing = true;

            let loadingIndicator = document.getElementById("loading-indicator");
            loadingIndicator.style.display = "block";

            try {
                if (product.matinhtrang === 0) {
                    await GetFunctionWithAttribute("updateStatusProduct", { matinhtrang: 1, masp: product.id });
                    await GetFunctionWithAttribute("getAllProductsBlocked", {});
                } else {
                    await GetFunctionWithAttribute("updateStatusProduct", { matinhtrang: 0, masp: product.id });
                    if (presentpage === "All") {
                        await GetFunctionWithAttribute("getAllProducts", {});
                    } else {
                        await GetFunctionWithAttribute("getAllByType", { loaisanpham: normalizeString(presentpage) });
                    }
                }
            } catch (error) {
                console.error("Lỗi khi cập nhật trạng thái sản phẩm:", error);
            } finally {
                loadingIndicator.style.display = "none";
                isProcessing = false; // Hoàn tất xử lý, cho phép click lại
            }
        });

        

        //Sự kiện nút Save
        var save_btn = document.getElementById("change-save-btn");
        save_btn.addEventListener("click", async function () {
            let loadingIndicator = document.getElementById("loading-indicator");
            let newprice = document.getElementById("changeproductprice").value;
            let description = document.getElementById("description-box").value;

            // Hiện hiệu ứng loading
            loadingIndicator.style.display = "block";

            try {
                console.log("Giá mới:", newprice);
                console.log("Mô tả:", description);

                // Cập nhật sản phẩm
                let updateResult = await GetFunctionWithAttribute("updateProduct", {
                    gia: newprice,
                    mota: description,
                    masp: product.id
                });

                if (updateResult) {
                    alertCustom("Sản phẩm đã được cập nhật!", "#4CAF50");
                    change_modal[0].style.display = "none";
                } else {
                    alertCustom("Lỗi khi cập nhật sản phẩm!");
                }

                // Thêm chi tiết sản phẩm mới (nếu có)
                let container = document.querySelectorAll("#detail-container-change .extra-textarea");
                let updatePromises = [];
                container.forEach(textarea => {
                    if (textarea.value.trim() !== "") {
                        updatePromises.push(
                            GetFunctionWithAttribute("updateProductDetail", {
                                masp: product.id,
                                chitiet: textarea.value
                            })
                        );
                    }
                });

                await Promise.all(updatePromises); // Chờ cập nhật xong

                // Xóa chi tiết sản phẩm cũ nếu trống
                let oldcontainer = document.querySelectorAll("#detail-container-change textarea");
                let deletePromises = [];
                oldcontainer.forEach(textarea => {
                    if (textarea.value.trim() === "") {
                        let detailId = textarea.getAttribute("data-id");
                        if (detailId) {
                            deletePromises.push(
                                GetFunctionWithAttribute("deleteProductDetail", { id: detailId })
                            );
                        }
                    }
                });

                await Promise.all(deletePromises); // Chờ xóa xong

                let colorContainer = document.querySelector("#color-options-change .newColor");

                if (colorContainer) { // Kiểm tra nếu tìm thấy phần tử
                    let color = colorContainer.getAttribute("data-colorcode");
                    let masanpham = colorContainer.getAttribute("data-masp_id");

                    if (!color || !masanpham || isNaN(masanpham)) {
                        console.error("Lỗi: Dữ liệu không hợp lệ", { color, masanpham });
                        return;
                    }

                    try {
                        let response = await GetFunctionWithAttribute("addColorOfProduct", { mamau: color, masp_id: masanpham });
                        if (response?.success && response?.new_mau_id) { // Kiểm tra phản hồi hợp lệ
                            await addSizeFunction(response); // Gọi hàm thêm size sau khi màu được thêm thành công
                        } else {
                            console.error("Lỗi khi thêm màu, không thể thêm size!", response);
                        }
                    } catch (error) {
                        console.error("Lỗi khi gọi API addColorOfProduct:", error);
                    }
                } else {
                    console.warn("Không có màu mới để thêm!");
                }


                const imageBox = document.querySelectorAll(".new-image-item");

                if (imageBox.length > 0) {
                    var data = await GetFunctionWithAttribute("getMauSanPhamId", {masp_id: maspglobal, mamau: hexcodeglobal})
                    var mausanphamid = "";
                    data.forEach(element => {
                        mausanphamid= element.id;
                    });
                    imageBox.forEach(image => {
                        const imgElement = image.querySelector("img");
                        if (imgElement) {
                            const imageUrl = imgElement.src;
                            console.log(imageUrl);
                            console.log(mausanphamid);
                            GetFunctionWithAttribute("addImageOfProduct", { duongdananh: imageUrl, mau_sanpham_id: mausanphamid });
                        }
                    });
                } else {
                    console.warn("Không có ảnh mới để thêm!");
                }

                // Xóa nội dung trong `#detail-container-change`
                document.getElementById("detail-container-change").innerHTML = "";

            } catch (error) {
                console.error("Lỗi khi xử lý:", error);
            } finally {
                // Ẩn hiệu ứng loading
                loadingIndicator.style.display = "none";
            }
        });

        // Hiển thị hoặc ẩn phần màu sắc & ảnh
        if (productvalue === "giay" || productvalue === "kinh") {
            product_change_colornpic.style.display = "block";
        } else {
            product_change_colornpic.style.display = "none";
        }

    });
}

var save_addbtn = document.getElementById("save-addbtn");
save_addbtn.addEventListener("click", async function () {
    let loadingIndicator = document.getElementById("loading-indicator");
    let price = document.getElementById("cost").value;
    let nameofpeoduct = document.getElementById("nameofpeoduct").value;
    let description = document.getElementById("description-box").value;
    var selectedOption = type.options[type.selectedIndex];
    var dataType = selectedOption.getAttribute("data-type")
    var sizeContainer = document.getElementById("addproductsize-container");
    var sizeOptions = sizeContainer.querySelectorAll(".size-option");

    // Hiện hiệu ứng loading
    loadingIndicator.style.display = "block";

    try {
        console.log("Giá:", price);
        console.log("Mô tả:", description);
        var masp = null;
        var imgSrc = document.getElementById("main-product-image").src;

        // Thêm sản phẩm là áo
        if (type.value === "ao" || type.value === "quan" || type.value === "kinh") {
            let addResult = await GetFunctionWithAttribute("addProduct", {
                tensp: nameofpeoduct,
                gia: price,
                mota: description,
                maloai_id: dataType,
                duongdananh: imgSrc
            });
            masp = addResult.newmasp;
            for (const option of sizeOptions) {
                const label = option.querySelector("label");
                const input = option.querySelector("input");
        
                await GetFunctionWithAttribute("addSizeOfProduct", {
                    tenkichco: label.innerHTML.trim(),
                    soluong: input.value,
                    mau_sanpham_id: addResult.mamausanpham
                });
            }
        }else{
            const imageBox = document.getElementById("image-box-add");
            const groups = imageBox.querySelectorAll(".image-group");
            let addResult = await GetFunctionWithAttribute("addProduct", {
                tensp: nameofpeoduct,
                gia: price,
                mota: description,
                maloai_id: dataType,
                duongdananh: imgSrc
            });
            masp = addResult.newmasp;
            if (!addResult || !addResult.newmasp) {
                console.error("Thêm sản phẩm thất bại hoặc không có mã sản phẩm trả về:", addResult);
                alertCustom("Lỗi khi thêm sản phẩm!", "#f44336");
                return; // Dừng xử lý tiếp nếu lỗi
            }
            for (const group of groups) {
                const colorCode = group.getAttribute("data-colorcode");
                const imageItems = group.querySelectorAll("img");
            
                const images = Array.from(imageItems).map(img => img.src);
            
                let addColorResult = await GetFunctionWithAttribute("addColorOfProduct", {
                    mamau: colorCode,
                    masp_id: addResult.newmasp
                });
            
                for (const src of images) {
                    await GetFunctionWithAttribute("addImageOfProduct", {
                        duongdananh: src,
                        mau_sanpham_id: addColorResult.mau_san_pham_id
                    });
                }
            }
            const sizeElements = document.querySelectorAll('.size-option.new-size');
            const sizesByColor = {}; // Kết quả gom theo màu

            sizeElements.forEach(sizeEl => {
                const colorCode = sizeEl.getAttribute('data-colorcode');
                const label = sizeEl.querySelector('label')?.innerText.trim();
                const quantity = sizeEl.querySelector('input')?.value;

                if (!sizesByColor[colorCode]) {
                    sizesByColor[colorCode] = [];
                }

                sizesByColor[colorCode].push({
                    size: label,
                    quantity: Number(quantity)
                });
            });
            //Duyeenjt qya sizecolor để lấy thông tin
            for (const color in sizesByColor) {
                const result = await GetFunctionWithAttribute("getMauSanPhamId", {
                    masp_id: addResult.newmasp,
                    mamau: color // dùng trực tiếp mã màu
                });
            
                const mamausanphamId = result?.[0]?.id;
                if (!mamausanphamId) {
                    console.error("Không tìm thấy ID màu sản phẩm cho mã màu:", color);
                    continue;
                }
            
                for (const item of sizesByColor[color]) {
                    await GetFunctionWithAttribute("addSizeOfProduct", {
                        tenkichco: item.size,
                        soluong: item.quantity,
                        mau_sanpham_id: mamausanphamId
                    });
                }
            }
        }
        
        if (addResult) {
            alertCustom("Sản phẩm đã được thêm thành công", "#4CAF50");
            change_modal[0].style.display = "none";
        } else {
            alertCustom("Lỗi khi thêm sản phẩm!");
        }

        // Thêm chi tiết sản phẩm mới (nếu có)
        let container = document.querySelectorAll("#detail-container-change .extra-textarea");
        let updatePromises = [];
        container.forEach(textarea => {
            if (textarea.value.trim() !== "") {
                updatePromises.push(
                    GetFunctionWithAttribute("updateProductDetail", {
                        masp: product.id,
                        chitiet: textarea.value
                    })
                );
            }
        });

        await Promise.all(updatePromises); // Chờ cập nhật xong

        // Xóa chi tiết sản phẩm cũ nếu trống
        let oldcontainer = document.querySelectorAll("#detail-container-change textarea");
        let deletePromises = [];
        oldcontainer.forEach(textarea => {
            if (textarea.value.trim() === "") {
                let detailId = textarea.getAttribute("data-id");
                if (detailId) {
                    deletePromises.push(
                        GetFunctionWithAttribute("deleteProductDetail", { id: detailId })
                    );
                }
            }
        });

        await Promise.all(deletePromises); // Chờ xóa xong

        let colorContainer = document.querySelector("#color-options-change .newColor");

        if (colorContainer) { // Kiểm tra nếu tìm thấy phần tử
            let color = colorContainer.getAttribute("data-colorcode");
            let masanpham = colorContainer.getAttribute("data-masp_id");

            if (!color || !masanpham || isNaN(masanpham)) {
                console.error("Lỗi: Dữ liệu không hợp lệ", { color, masanpham });
                return;
            }

            try {
                let response = await GetFunctionWithAttribute("addColorOfProduct", { mamau: color, masp_id: masanpham });
                if (response?.success && response?.new_mau_id) { // Kiểm tra phản hồi hợp lệ
                    await addSizeFunction(response); // Gọi hàm thêm size sau khi màu được thêm thành công
                } else {
                    console.error("Lỗi khi thêm màu, không thể thêm size!", response);
                }
            } catch (error) {
                console.error("Lỗi khi gọi API addColorOfProduct:", error);
            }
        } else {
            console.warn("Không có màu mới để thêm!");
        }


        const imageBox = document.querySelectorAll(".new-image-item");

        if (imageBox.length > 0) {
            var data = await GetFunctionWithAttribute("getMauSanPhamId", {masp_id: maspglobal, mamau: hexcodeglobal})
            var mausanphamid = "";
            data.forEach(element => {
                mausanphamid= element.id;
            });
            imageBox.forEach(image => {
                const imgElement = image.querySelector("img");
                if (imgElement) {
                    const imageUrl = imgElement.src;
                    console.log(imageUrl);
                    console.log(mausanphamid);
                    GetFunctionWithAttribute("addImageOfProduct", { duongdananh: imageUrl, mau_sanpham_id: mausanphamid });
                }
            });
        } else {
            console.warn("Không có ảnh mới để thêm!");
        }

        // Xóa nội dung trong `#detail-container-change`
        document.getElementById("detail-container-change").innerHTML = "";

    } catch (error) {
        console.error("Lỗi khi xử lý:", error);
    } finally {
        // Ẩn hiệu ứng loading
        loadingIndicator.style.display = "none";
    }
});

function displayInfoProductsDetail(data) {
    let detailContainer = document.getElementById("detail-container-change");
    detailContainer.innerHTML = ""; // Xóa nội dung cũ

    data.forEach(product => {
        let detailHTML = `
            <textarea placeholder="Chi tiết sản phẩm" data-id = ${product.id}>${product.chitiet}</textarea>
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
    let btnImageChange = document.getElementById("btn-image-change");
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
            maspglobal=masp;
            hexcodeglobal=hexcode;
            console.log("Clicked color:", hexcode);
            await GetFunctionWithAttribute("getSizeOfProductColor", {masp: masp, mamau: hexcode});
            await GetFunctionWithAttribute("getImageOfProductByColor", {mamau: hexcode, masp_id: masp})
            btnImageChange.style.display = "block";
        });

        colorContainer.appendChild(span);
    });
}

var image_box_change = document.getElementById("image-box-change");
image_box_change.addEventListener("change", function(){
    var btn = document.getElementById("btn-image-change");
    btn.style.display = "block";
});


function addSizeFunction(data) {
    let sizeContainer = document.querySelector("#changeproductsize-container");
    let sizeOptions = sizeContainer.querySelectorAll(".size-option"); 

    sizeOptions.forEach(sizeOption => {
        let tenkichco = sizeOption.querySelector("label").innerText; 
        let soluong = sizeOption.querySelector("input").value; 
        
        GetFunctionWithAttribute("addSizeOfProduct", { 
            tenkichco: tenkichco, 
            soluong: soluong, 
            mau_sanpham_id: data.mau_san_pham_id 
        });
    });
}

// Hiện hình ảnh của màu
function displayLinkImageOfColor(data) {
    const imageBox = document.getElementById("image-box-change");
    imageBox.innerHTML = ""; // Xóa nội dung cũ

    data.forEach(image => {
        // Tạo div chứa ảnh
        let imageItem = document.createElement("div");
        imageItem.classList.add("image-item");

        let img = document.createElement("img");
        img.src = image.duongdananh;

        let removeButton = document.createElement("button");
        removeButton.textContent = "-";
        removeButton.addEventListener("click", async function(){
            let isConfirmed = confirm("Bạn có chắc chắn muốn xóa hình ảnh này không?");
            if (isConfirmed) {
                let response = await GetFunctionWithAttribute("deleteProductImage", { mahinhanh: image.mahinhanh });

                if (response.success) {
                    alert("Xóa thành công!");
                    let newData = await GetFunctionWithAttribute("getImageOfProductByColor", { mamau: image.mamau, masp_id: image.masp_id });
                    displayLinkImageOfColor(newData);
                } else {
                    alert("Xóa thất bại!");
                }
            }
        });

        imageItem.appendChild(img);
        imageItem.appendChild(removeButton);

        imageBox.appendChild(imageItem);
    });
}

function cleanAddInput(){
    // Reset tất cả các input
    document.getElementById("nameofpeoduct").value = "";
    document.getElementById("cost").value = "";
    document.getElementById("description-box").value = "";

    // Reset ảnh về ảnh mặc định
    document.getElementById("main-product-image").src = "http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/images/vector.svg";

    // Reset select về mặc định (Áo)
    document.getElementById("product-type-selected").selectedIndex = 0;

    // Reset size về 0
    sizeOptions.forEach(option => {
        const input = option.querySelector("input");
        input.value = 0;
    });

    // Ẩn phần màu & ảnh màu nếu có bật
    document.getElementById("product-add-colornpic").style.display = "none";
    document.getElementById("btn-add").style.display = "none";
    document.getElementById("colorPickerAdd").style.display = "none";
    document.getElementById("colorDisplay").style.display = "none";
    document.getElementById("btn-image-add").style.display = "none";

    // Xoá các màu và hình ảnh đã thêm (nếu có)
    document.getElementById("color-options-add").innerHTML = "";
    document.getElementById("image-box-add").innerHTML = "";

}

//vì fetch bất đồng bộ phải sử dụng thêm async function
async function GetFunctionWithAttribute(funcName, paramsObj) {
    console.log("Hàm gọi:", funcName);
    console.log("Dữ liệu gửi đi:", paramsObj);

    let url = "http://localhost/ClothingStoreWebsite_UsingPHP/app/controllers/productmanagementcontroller.php";

    try {
        let response = await fetch(url, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                function: funcName,
                params: paramsObj,
            }),
        });

        if (!response.ok) {
            throw new Error(`Lỗi HTTP ${response.status}: ${response.statusText}`);
        }

        let data;
        try {
            data = await response.json();
        } catch (jsonError) {
            throw new Error("Dữ liệu phản hồi không phải JSON hợp lệ!");
        }

        console.log("Dữ liệu nhận được:", data);

        if (!data || typeof data !== "object") {
            throw new Error("Dữ liệu phản hồi không hợp lệ hoặc rỗng.");
        }

        // 🔥 Xử lý lỗi theo từng function cụ thể
        switch (funcName) {
            case "getTypeOfProduct":
                if (!data.length) throw new Error("Không tìm thấy loại sản phẩm!");
                producttypestatus = data[0]?.tenloai || "Không có dữ liệu";
                console.log("Type:", producttypestatus);
                break;
            case "getProductDescription":
                if (!data.length) throw new Error("Không có mô tả sản phẩm!");
                displayProductsDescription(data);
                break;
            case "updateProduct":
            case "updateStatusProduct":
                change_modal[0].style.display = "none";
                break;
            case "getProductSizeInform":
                if (!Array.isArray(data)) throw new Error("Dữ liệu kích cỡ sản phẩm không đúng định dạng!");
                displaySizeProducts(data);
                break;
            case "getProductInform":
                if (!Array.isArray(data)) throw new Error("Dữ liệu sản phẩm không hợp lệ!");
                displayInfoProducts(data);
                break;
            case "getProductDetailInform":
                displayInfoProductsDetail(data);
                break;
            case "getProductColor":
                displayColorProducts(data);
                break;
            case "getSizeOfProductColor":
                displaySizeProducts(data);
                break;
            case "getSizeName":
                displaySizeNewProducts(data);
                break;
            case "getAllByType":
            case "getAllProducts":
            case "getAllProductsBlocked":
                if (!Array.isArray(data)) throw new Error("Dữ liệu sản phẩm trả về không hợp lệ!");
                displayProducts(data);
                openModalChangeProduct();
                break;
            case "updateProductDetail":
                change_modal[0].style.display="none";
                break;
            case "deleteProductDetail":
                change_modal[0].style.display="none";
                break;
            case "addSizeOfProduct":
                if(data === null){
                    console.log("addSize lỗi");
                }
                break;
            case "getImageOfProductByColor":
                displayLinkImageOfColor(data);
                break;
            case "addImageOfProduct":
                console.log("Kết quả API addImageOfProduct:", data);
                if (!data.success) {
                    console.error("Lỗi khi thêm ảnh sản phẩm:", data.error || "Không rõ lỗi");
                } else {
                    console.log("Thêm ảnh thành công!");
                }
                break;
            case "getSanPhamByName":
                displayProducts(data);
                break;
            case "getSizeOfProductByMaloai":
                if(colorCode != null){
                    displaySizeNewProductsAdd(data, colorcode);
                }else{
                    displaySizeNewProductsForRest(data);
                }
                break;
            case "addProduct":
                change_modal[0].style.display = "none";
                break;
            default:
                console.warn("Hàm không được xử lý:", funcName);
        }

        return data;
    } catch (error) {
        console.error("❌ Lỗi khi gọi API:", error.message);
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


