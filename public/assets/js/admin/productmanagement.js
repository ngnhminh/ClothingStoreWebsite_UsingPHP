// biến chung
var product = document.getElementsByClassName("product");
var change_modal = document.getElementsByClassName("change-modal");
var btnadd = document.getElementById("add-product-btn");
const size_option = document.querySelectorAll(".size-option");
const product_add_colornpic = document.getElementById("product-add-colornpic");
let producttypestatus = "";
let presentpage = "All";
let maspglobal = "";
let hexcodeglobal ="";
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
var btn_change = document.getElementById("btn-change");
btn_change.addEventListener("click", () => {
    colorPicker.click(); 
});

colorPicker.addEventListener("change", () => {
    colorValue.textContent = colorPicker.value; 
    var masp = document.getElementById("nameofproduct-change").getAttribute("data-masp");
    // console.log(masp);
    let existingColor = document.querySelectorAll(".color-options-change .color").length; // Đếm số size-option hiện tại

    // if (existingColor > 2) {
    //     alert("Chỉ được thêm 1 màu mỗi lần");
    //     return; 
    // }
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
            await GetFunctionWithAttribute("getSizeName", {masp: masp});
        });

        colorContainer.appendChild(span);
}

// Bảng hình ảnh
const btnImageChange = document.getElementById("btn-image-change");
const fileInput = document.getElementById("fileInput");
const imageBox = document.getElementById("image-box-change");

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
        let response = await fetch("http://localhost/ClothingStore/public/upload.php", { // Cập nhật URL API PHP
            method: "POST",
            body: formData
        });

        let result = await response.json();
        if (result.success) {
            let relativePath = result.path; // Nhận đường dẫn từ server (Sửa từ filePath -> path)

            // Tạo URL đầy đủ để hiển thị ảnh
            let fullImageUrl = `http://localhost/ClothingStore/public${relativePath}`;

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

filter_buttons.forEach((button)=>{
    button.addEventListener("click", () => {
        console.log(button.value);
        if(button.value === "All"){
            GetFunctionWithAttribute("getAllProducts", {});
        }else if(button.value === "Block"){
            GetFunctionWithAttribute("getAllProductsBlocked", {});
            presentpage = "Block";
        }else{
            GetFunctionWithAttribute("getAllByType", {loaisanpham: button.value});
            presentpage = "button.value";
        }
    });
})

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
                <input type="number" id="new-size-${index} name="new-size-name" value="0">
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
        if(product.matinhtrang === 0){
            lock_btn.innerText = "Mở khóa";
        }else{
            lock_btn.innerText = "Khóa";
        }

        lock_btn.addEventListener("click", function(){
            if(product.matinhtrang === 0){
                // lock_btn.style.backgroundColor="red";
                GetFunctionWithAttribute("updateStatusProduct", 1, {masp: product.id});
                GetFunctionWithAttribute("getAllProductsBlocked",{});
            }else{
                // lock_btn.style.backgroundColor="blue";
                GetFunctionWithAttribute("updateStatusProduct", 0, {masp: product.id});
                //Chuyển về trang hiện tại
                if(presentpage === "All"){
                    GetFunctionWithAttribute("getAllProducts",{})
                }else{
                    GetFunctionWithAttribute("getAllByType", {loaisanpham: normalizeString(presentpage)});
                }
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
            product_add_colornpic.style.display = "block";
        } else {
            product_add_colornpic.style.display = "none";
        }

    });
}

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
        });

        colorContainer.appendChild(span);
    });
}

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

//vì fetch bất đồng bộ phải sử dụng thêm async function
async function GetFunctionWithAttribute(funcName, paramsObj) {
    console.log("Hàm gọi:", funcName);
    console.log("Dữ liệu gửi đi:", paramsObj);

    let url = "http://localhost/ClothingStore/app/controllers/productmanagementcontroller.php";

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


