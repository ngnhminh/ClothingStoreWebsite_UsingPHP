const cartItemList = document.getElementById("cart-item-list");

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

function updateTotalPriceDisplay(groupedProducts) {
    const totalElement = document.getElementById("total-price");
    if (totalElement) {
        const total = calculateTotalPrice(groupedProducts);
        totalElement.textContent = formatToVND(total);
    }
}

function updateProductQuantity(productId, size, quantity, mamau = null) {
    const key = mamau
        ? `product-${productId}-${size}-${mamau}`
        : `product-${productId}-${size}`;
    
    const product = JSON.parse(localStorage.getItem(key));
    if (product) {
        product.quantity = quantity;
        localStorage.setItem(key, JSON.stringify(product));
    }
}

window.onload = () => {
    const cartProducts = getAllProductsInCart();
    const cartItemList = document.getElementById("cart-item-list");

    const cardwrapper = document.getElementById("cart-wrapper");
    const emptycard = document.getElementById("empty-cart");

    cartItemList.innerHTML = "";

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

    if(Object.keys(groupedProducts).length === 0){
        cardwrapper.style.display = "none";
        emptycard.style.display = "flex";
    }else{
        emptycard.style.display = "none";
        cardwrapper.style.display = "flex";
    }
    
    Object.entries(groupedProducts).forEach(([key, product]) => {
        const discountedPrice = product.giamgia > 0
            ? product.gia - (product.gia * product.giamgia) / 100
            : product.gia;

        const productCard = document.createElement("tr");
        productCard.innerHTML = `
            <td class="product-info">
                <img src="${product.duongdananh}" alt="Sản phẩm">
                <div>
                    <span>${product.tensp}</span>
                    <p>Size: ${product.size}</p>
                    ${product.mamau ? `<p>Màu: ${product.mamau}</p>` : ""}
                </div>
            </td>
            <td>
                <button class="qty-btn minus-btn">−</button>
                <input type="text" value="${product.quantity}" class="qty-input" id="qty-${product.id}-${product.size}">
                <button class="qty-btn plus-btn">+</button>
            </td>
            <td class="price">
                ${product.giamgia > 0 ? `
                    <span class="discount">-${product.giamgia}%</span>
                    <span class="new-price">${formatToVND(discountedPrice)}</span>
                    <span class="old-price">${formatToVND(product.gia)}</span>
                ` : `
                    <span class="new-price">${formatToVND(product.gia)}</span>
                `}
                <i class="fas fa-trash-alt delete-icon"></i>
            </td>
        `;

        const minusBtn = productCard.querySelector(".minus-btn");
        const plusBtn = productCard.querySelector(".plus-btn");
        const qtyInput = productCard.querySelector(".qty-input");

        minusBtn.addEventListener("click", () => {
            let quantity = parseInt(qtyInput.value);
            if (quantity > 1) {
                quantity -= 1;
                qtyInput.value = quantity;
                updateProductQuantity(product.id, product.size, quantity, product.mamau);
                groupedProducts[key].quantity = quantity;
                updateTotalPriceDisplay(groupedProducts);
            }
        });

        plusBtn.addEventListener("click", () => {
            let quantity = parseInt(qtyInput.value);
            quantity += 1;
            qtyInput.value = quantity;
            updateProductQuantity(product.id, product.size, quantity, product.mamau);
            groupedProducts[key].quantity = quantity;
            updateTotalPriceDisplay(groupedProducts);
        });

        const deleteIcon = productCard.querySelector(".delete-icon");
        deleteIcon.addEventListener("click", () => {
            const localKey = product.mamau
                ? `product-${product.id}-${product.size}-${product.mamau}`
                : `product-${product.id}-${product.size}`;
            localStorage.removeItem(localKey);
            window.location.reload();
        });

        cartItemList.appendChild(productCard);
    });

    updateTotalPriceDisplay(groupedProducts);
};

const checkoutbtn = document.getElementById("checkout-btn");

checkoutbtn.addEventListener("click", () =>{
    window.location.href = "checkout.php";
})

const continuebtns = Array.from(document.getElementsByClassName("continue-btn"));

continuebtns.forEach(item => {
    item.addEventListener("click", () => {
        window.location.href = "productpage.php";
    });
});
