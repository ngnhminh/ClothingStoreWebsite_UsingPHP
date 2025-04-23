
function formatToVND(price) {
    return price.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
}

let user = JSON.parse(localStorage.getItem("user"));

window.addEventListener('userUpdated', function() {
    let userUpdated = JSON.parse(localStorage.getItem("user"));
    console.log("Thông tin người dùng đã được cập nhật:", userUpdated);
    user = userUpdated; // Cập nhật lại biến user toàn cục với dữ liệu mới
});

function defaultSetSize() {
    document.querySelectorAll("#size-options button").forEach(btn => {
        btn.style.color = "black";
        btn.style.background = "#f3f3f3";
    });
}

// Kiểm tra nếu người dùng đã chọn size chưa
function checkSizeSelected() {
    const selectedSizeButton = document.querySelector("#size-options button[style*='background: grey']");
    return selectedSizeButton !== null; // Kiểm tra nếu có size nào đã được chọn
}

function checkColorSelected() {
    const selectedColor = document.querySelector(".color-box.selected");
    return selectedColor !== null;
}

// Kiểm tra nếu sản phẩm còn hàng không
function checkProductInStock(selectedSizeButton) {
    const selectedSize = selectedSizeButton ? selectedSizeButton.getAttribute("data-tenkichco") : null;
    const sizeQuantity = selectedSizeButton ? parseInt(selectedSizeButton.getAttribute("data-soluong")) : 0;

    if (sizeQuantity === 0) {
        showAlert("Sản phẩm đã hết hàng.");
        return false;
    }
    return true;
}

function showAlert(words) {
    Swal.fire({
        title: 'Thông báo',
        text: words,
        icon: 'info',
        confirmButtonText: 'Đóng'
    });
}

const params = new URLSearchParams(window.location.search);
const masp = params.get("id");
const maloai = params.get("maloai");
axios.get('http://localhost/ClothingStoreWebsite_UsingPHP/app/controllers/productdetailshoesController.php', {
    params: {
        action: "getProductDetail",
        id: masp,
        maloai: maloai
    }
}).then(res => {
    if(res.data.success){
        // Trạng thái đơn hàng
        const soldout = document.getElementById("sold-out");
        const almostsoldout = document.getElementById("almost-sold-out");
        const instock = document.getElementById("instock");

        const productname = document.getElementById("product-name");
        const description = document.getElementById("description");
        const productMainImage = document.getElementById("product-main-image");
        const productinform = document.getElementById("product-inform");
        const sizeOptions = document.getElementById("size-options");

        // Thêm tên sản phẩm
        if(res.data.product.giamgia > 0){
            productname.innerHTML = `
                <h2>${res.data.product.tensp}</h2>
                <p class="product-price">
                    <span class="discount" id="discount">-${res.data.product.giamgia}%</span>
                    <span class="new-price"  id="new-price">${formatToVND(res.data.product.gia - ((res.data.product.giamgia/100) * res.data.product.gia))}</span>
                    <span class="old-price" id="old-price">${formatToVND(res.data.product.gia)}</span>
                </p>
            `;
        }else{
            productname.innerHTML = `
                <h2>${res.data.product.tensp}</h2>
                <p class="product-price">
                    <span class="new-price"  id="new-price">${res.data.product.gia}</span>
                </p>
            `;  
        }

        description.innerHTML = `
            <p>${res.data.product.mota}</P>
        `;
        productMainImage.innerHTML = `
            <img src="${res.data.product.duongdananh}" alt="Sản phẩm" />
        `;

        res.data.productdetailInform.forEach(item => {
            const li = document.createElement("li");
            li.textContent = item.chitiet;
            productinform.appendChild(li);
        });

        //Thêm màu
        const colorOptions = document.getElementById("color-options");
        res.data.getProductColor.forEach(color => {
            const colorDiv = document.createElement("div");
            colorDiv.classList.add("color-box");
            colorDiv.style.backgroundColor = `#${color.mamau}`;  // Đảm bảo màu hợp lệ (ví dụ #ff5733)
            colorDiv.addEventListener("click", () => {
                // Xoá chọn trước đó
                document.querySelectorAll(".color-box").forEach(el => el.classList.remove("selected"));
                // Thêm class đã chọn cho phần tử hiện tại
                colorDiv.classList.add("selected");
                // Bạn có thể lưu màu đã chọn nếu cần
                console.log("Màu đã chọn:", color.mamau); // Chắc chắn đúng màu
                axios.get('http://localhost/ClothingStoreWebsite_UsingPHP/app/controllers/productdetailshoesController.php', {
                    params: { 
                        action: "getProductDetail",
                        id: res.data.product.id,
                        mamau: color.mamau
                    }
                }).then(res => {
                    sizeOptions.innerHTML = ``;
                    // Thêm nút size
                    res.data.getSizeOfProductColor.forEach(item => {
                        const button = document.createElement("button");
                        button.textContent = item.tenkichco;
                        button.setAttribute("data-tenkichco", item.tenkichco);
                        button.setAttribute("data-soluong", item.soluong);
                        button.setAttribute("data-mamau", item.mamau);
                        button.addEventListener("click", function() {
                            if(button.style.color !== "white" && button.style.background !== "grey"){
                                defaultSetSize();
                                button.style.color = "white";
                                button.style.background = "grey";
                            } else {
                                defaultSetSize();
                                button.style.color = "black";
                                button.style.background = "#f3f3f3";
                            }
                            
                            if (item.soluong === 0) {
                                soldout.style.display = "block";
                                almostsoldout.style.display = "none";
                                instock.style.display = "none";
                            } else if (item.soluong <= 10) {
                                soldout.style.display = "none";
                                almostsoldout.style.display = "block";
                                instock.style.display = "none";
                            } else {
                                soldout.style.display = "none";
                                almostsoldout.style.display = "none";
                                instock.style.display = "block";
                            }

                            // Lưu thông tin kích cỡ vào sản phẩm trong localStorage
                            const selectedSize = button.getAttribute("data-tenkichco");
                            localStorage.setItem("selectedSize", selectedSize);  // Lưu tên size vào localStorage
                        });
                        sizeOptions.appendChild(button);
                    });

                    const productimagesshoes = document.getElementById("product-images-shoes");
                    productimagesshoes.innerHTML = ``;
                    res.data.getImageOfProductByColor.forEach(item => {
                        productimagesshoes.innerHTML += `
                            <img src="${item.duongdananh}" alt="Error">
                        `;
                    });
                });
            });

            colorOptions.appendChild(colorDiv);
        });

        // Hiển thị sản phẩm liên quan
        const shuffled = res.data.dsspcungloai.sort(() => 0.5 - Math.random());
        const random10 = shuffled.slice(0, 10);
        const relatedContainer = document.getElementById("related-products"); // chỗ chứa sản phẩm
        relatedContainer.innerHTML = ""; 

        function renderRelatedProducts(products) {
            relatedContainer.innerHTML = "";
            products.forEach(product => {
              const item = document.createElement("div");
              item.classList.add("product-item");
              item.setAttribute("data-masp", product.id);
              item.setAttribute("data-maloai", product.maloai_id);
          
              const discountedPrice = product.giamgia > 0
                ? product.gia - (product.gia * product.giamgia) / 100
                : product.gia;
          
              item.innerHTML = `
                <div class="thumbnail-wrapper">
                  <img src="${product.duongdananh}" alt="Related Product">
                </div>
                <p class="short">${product.tensp}</p>
                <p>
                  ${product.giamgia > 0 ? `
                    <span class="discount">-${product.giamgia}%</span>
                    <span class="new-price">${formatToVND(discountedPrice)}</span>
                    <span class="old-price">${formatToVND(product.gia)}</span>
                  ` : `
                    <span class="new-price">${formatToVND(product.gia)}</span>
                  `}
                </p>
              `;
          
              item.addEventListener("click", function () {
                const id = this.dataset.masp;
                const maloai = this.dataset.maloai;
                window.location.href = `productdetailshoes.php?id=${id}&maloai=${maloai}`;
              });
          
              relatedContainer.appendChild(item);
            });
          }
          
          function scrollToIndex(index) {
            const itemWidth = relatedContainer.querySelector(".product-item").offsetWidth;
            relatedContainer.style.transform = `translateX(-${index * itemWidth}px)`;
          }
          
          // Scroll buttons
          document.querySelector(".related-button.left").addEventListener("click", () => {
            if (currentIndex > 0) {
              currentIndex--;
              scrollToIndex(currentIndex);
            }
          });
          
          document.querySelector(".related-button.right").addEventListener("click", () => {
            const maxIndex = relatedContainer.children.length - itemsPerPage;
            if (currentIndex < maxIndex) {
              currentIndex++;
              scrollToIndex(currentIndex);
            }
          });
          
          // Gọi sau khi lấy được random10
        renderRelatedProducts(random10);

        // Thêm sản phẩm vào giỏ hàng
        var addToCart = document.getElementById("add-to-cart");
        addToCart.addEventListener("click", function () {
            // Kiểm tra đã chọn màu chưa
            if (!checkColorSelected()) {
                showAlert("Vui lòng chọn màu sản phẩm.");
                return;
            }

            // Kiểm tra đã chọn size chưa
            const selectedSizeButton = document.querySelector("#size-options button[style*='background: grey']");
            if (!selectedSizeButton) {
                showAlert("Vui lòng chọn kích cỡ sản phẩm.");
                return;
            }

            // Kiểm tra còn hàng không
            if (!checkProductInStock(selectedSizeButton)) {
                return;
            }

            const size = selectedSizeButton.getAttribute("data-tenkichco");
            const mamau = selectedSizeButton.getAttribute("data-mamau");
            const productKey = `product-${res.data.product.id}-${size}-${mamau}`;
            const existing = localStorage.getItem(productKey);

            if (existing) {
                // const existingProduct = JSON.parse(existing);
                // existingProduct.quantity += 1;
                // localStorage.setItem(productKey, JSON.stringify(existingProduct));
                showAlert("Sản phẩm đã có trong giỏ hàng với size này và màu này");
            } else {
                const productWithQuantity = {
                    ...res.data.product,
                    quantity: 1,
                    size: size,
                    mamau: mamau
                };
                localStorage.setItem(productKey, JSON.stringify(productWithQuantity));
                showAlert("Thêm sản phẩm vào giỏ hàng thành công");
            }
        });

        // Mua ngay
        var buyNow = document.getElementById("buy-now");
        buyNow.addEventListener("click", function() {
            const selectedSizeButton = document.querySelector("#size-options button[style*='background: grey']");

            if (!checkColorSelected()) {
                showAlert("Vui lòng chọn màu sản phẩm.");
                return;
            }

            if (!selectedSizeButton) {
                showAlert("Vui lòng chọn kích cỡ sản phẩm.");
                return;
            }

            if (!checkProductInStock(selectedSizeButton)) {
                return;
            }

            const size = selectedSizeButton.getAttribute("data-tenkichco");
            const mamau = selectedSizeButton.getAttribute("data-mamau");
            const productKey = `product-${res.data.product.id}-${size}-${mamau}`;
            const existing = localStorage.getItem(productKey);

            if (existing) {
                const existingProduct = JSON.parse(existing);
                existingProduct.quantity += 1;
                localStorage.setItem(productKey, JSON.stringify(existingProduct));
                showAlert("Đã tăng số lượng sản phẩm trong giỏ hàng");
            } else {
                const product = {
                    ...res.data.product,
                    quantity: 1,
                    size: size,
                    mamau: mamau
                };
                localStorage.setItem(productKey, JSON.stringify(product));
                showAlert("Thêm sản phẩm vào giỏ hàng thành công!");
            }

            // Chuyển hướng tới giỏ hàng
            window.location.href = "cart.php";
        });

        const likebtn = document.getElementById("likebtn");
        likebtn.addEventListener('click', () => {
            if(user.matk != null){
                axios.get('http://localhost/ClothingStoreWebsite_UsingPHP/app/controllers/productdetailshoesController.php', {
                    action: "isAlreadyFav",
                    masp: masp,
                    matk: user.matk,
                }).then(res => {
                    if (res.data.success) {
                        showAlert("Sản phẩm này đã có trong mục yêu thích");
                    }else{
                        axios.post('http://localhost/ClothingStoreWebsite_UsingPHP/app/controllers/productdetailshoesController.php', {
                            action: "addFavProduct",
                            masp: masp,
                            matk: user.matk,
                        }).then(res => {
                            if (res.data.success) {
                                showAlert("Thêm sản phẩm vào danh sách yêu thích thành công");
                            }else{
                                showAlert("Sản phẩm này đã có trong mục yêu thích");
                                return
                            }
                        }); 
                    }
                });            
            }else{
                showAlert("Hãy đăng nhập để thêm sản phẩm yêu thích");
                return
            }
        })
    }
});