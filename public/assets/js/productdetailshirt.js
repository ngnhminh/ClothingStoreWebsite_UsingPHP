const sizeOptions = document.querySelectorAll(".size-options button");
let user = JSON.parse(localStorage.getItem("user"));
window.addEventListener('userUpdated', function() {
    let userUpdated = JSON.parse(localStorage.getItem("user"));
    console.log("Thông tin người dùng đã được cập nhật:", userUpdated);
    user = userUpdated; // Cập nhật lại biến user toàn cục với dữ liệu mới
});
function formatToVND(price) {
    return price.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
}

// Đặt nút về bình thường
function defaultSetSize() {
    document.querySelectorAll("#size-options button").forEach(btn => {
        btn.style.color = "black";
        btn.style.background = "#f3f3f3";
    });
}

// Hiển thị thông báo
function showAlert(words) {
    Swal.fire({
        title: 'Thông báo',
        text: words,
        icon: 'info',
        confirmButtonText: 'Đóng'
    });
}

// Kiểm tra nếu người dùng đã chọn size chưa
function checkSizeSelected() {
    const selectedSizeButton = document.querySelector("#size-options button[style*='background: grey']");
    return selectedSizeButton !== null; // Kiểm tra nếu có size nào đã được chọn
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

const params = new URLSearchParams(window.location.search);
const masp = params.get("id");
const maloai = params.get("maloai");

// Hàm gọi đến controller
axios.get('http://localhost/ClothingStoreWebsite_UsingPHP/app/controllers/productdetailshirtController.php', {
    params: { 
        action: "getProduct",
        id: masp,
        maloai: maloai
    }
}).then(res => {
    if (res.data.success) {
        const productImage = document.getElementById("product-image");
        const sizeOptions = document.getElementById("size-options");
        const productinform = document.getElementById("product-inform");
        const productname = document.getElementById("product-name");

        // Trạng thái đơn hàng
        const soldout = document.getElementById("sold-out");
        const almostsoldout = document.getElementById("almost-sold-out");
        const instock = document.getElementById("instock");

        // Lấy hình ảnh
        productImage.innerHTML = `
            <img src="${res.data.product.duongdananh}" alt="Sản phẩm" />
        `;
        
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
        
        // Thêm nút size
        res.data.productDetailSize.forEach(item => {
            const button = document.createElement("button");
            button.textContent = item.tenkichco;
            button.setAttribute("data-tenkichco", item.tenkichco);
            button.setAttribute("data-soluong", item.soluong);
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
        
        // Lấy thông tin sản phẩm
        res.data.productdetailInform.forEach(item => {
            const li = document.createElement("li");
            li.textContent = item.chitiet;
            productinform.appendChild(li);
        });

        // Hiển thị bảng size cho áo hoặc quần
        if (res.data.product.maloai_id === "0") {
            document.getElementById("size-chart-shirts").style.display = "table";
            document.getElementById("size-chart-pants").style.display = "none";
        } else {
            document.getElementById("size-chart-shirts").style.display = "none";
            document.getElementById("size-chart-pants").style.display = "table";
        }

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
                window.location.href = `productdetailshirt.php?id=${id}&maloai=${maloai}`;
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
            const selectedSizeButton = document.querySelector("#size-options button[style*='background: grey']");
            
            if (!selectedSizeButton) {
                showAlert("Vui lòng chọn kích cỡ sản phẩm.");
                return; // Nếu chưa chọn size, không thực hiện thêm vào giỏ hàng
            }

            // Kiểm tra sản phẩm có còn hàng không
            if (!checkProductInStock(selectedSizeButton)) {
                return; // Nếu sản phẩm hết hàng, không tiếp tục
            }

            const productKey = `product-${res.data.product.id}-${selectedSizeButton.getAttribute("data-tenkichco")}`;
            const existing = localStorage.getItem(productKey);

            if (existing) {
                // Nếu sản phẩm đã có trong giỏ hàng với size đó, không cộng thêm mà giữ nguyên
                showAlert("Sản phẩm đã có trong giỏ hàng với size này");
            } else {
                // Nếu sản phẩm chưa có trong giỏ hàng, thêm sản phẩm mới với quantity = 1
                const productWithQuantity = {
                    ...res.data.product,
                    quantity: 1,  // Mặc định quantity = 1
                    size: selectedSizeButton.getAttribute("data-tenkichco") // Lưu size đã chọn
                };
                localStorage.setItem(productKey, JSON.stringify(productWithQuantity));
                showAlert("Thêm sản phẩm vào giỏ hàng thành công");
            }
        });

        // Mua ngay
        var buyNow = document.getElementById("buy-now");
        buyNow.addEventListener("click", function() {
            const selectedSizeButton = document.querySelector("#size-options button[style*='background: grey']");
            
            if (!selectedSizeButton) {
                showAlert("Vui lòng chọn kích cỡ sản phẩm.");
                return; // Nếu chưa chọn size, không thực hiện mua ngay
            }

            // Kiểm tra sản phẩm có còn hàng không
            if (!checkProductInStock(selectedSizeButton)) {
                return; // Nếu sản phẩm hết hàng, không tiếp tục
            }

            const productKey = `product-${res.data.product.id}-${selectedSizeButton.getAttribute("data-tenkichco")}`;
            const existingProduct = localStorage.getItem(productKey);

            if (existingProduct) {
                const existingProduct = JSON.parse(existing);
                existingProduct.quantity += 1;
                localStorage.setItem(productKey, JSON.stringify(existingProduct));
                showAlert("Sản phẩm đã có trong giỏ hàng với size này!");
            } else {
                // Nếu chưa có sản phẩm trong giỏ hàng, thêm mới với quantity = 1
                const product = {
                    ...res.data.product,
                    quantity: 1,
                    size: selectedSizeButton.getAttribute("data-tenkichco") // Lưu size đã chọn
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
                axios.get('http://localhost/ClothingStoreWebsite_UsingPHP/app/controllers/productdetailshirtController.php', {
                    action: "isAlreadyFav",
                    masp: masp,
                    matk: user.matk,
                }).then(res => {
                    if (res.data.success) {
                        showAlert("Sản phẩm này đã có trong mục yêu thích");
                    }else{
                        axios.post('http://localhost/ClothingStoreWebsite_UsingPHP/app/controllers/productdetailshirtController.php', {
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
