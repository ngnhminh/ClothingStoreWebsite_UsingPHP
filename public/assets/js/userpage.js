function ChangeTitle() {
    // thay đổi tiêu đề và cấu trúc bảng
    try {
        const title = document.getElementById("userpage-title");
        if (!title) throw new Error("Không thấy id userpage-title");
        const change_button = document.getElementById("userpage-button");
        if (!change_button) throw new Error("Không thấy id userpage-button");
        const history_product_navbar = document.getElementById("history-product-navbar");
        if (!history_product_navbar) throw new Error("Không thấy id history_product_navbar");
        const fav_product_navbar = document.getElementById("fav-product-navbar");
        if (!fav_product_navbar) throw new Error("Không thấy id fav_product_navbar");

        //parentElement
        const user_productlist_container = document.querySelector('.user-productlist-container');

        //ChildElement
        const user_fav_product = user_productlist_container.querySelectorAll('.fav-product');
        const user_purchased_order = user_productlist_container.querySelectorAll('.purchased-order');
        
        if (!title.dataset.state) {
            title.dataset.state = "1";
        }
        
        if(title.dataset.state === "1"){
            change_button.textContent = "Danh sách yêu thích";
            title.innerText = "Lịch sử mua hàng";

            fav_product_navbar.style.display="none";
            history_product_navbar.style.display="table-row";
            
            user_fav_product.forEach((child) => {
                child.style.display = "none";
            });

            user_purchased_order.forEach((child) => {
                child.style.display = "table-row";
            });
            title.dataset.state = "0";
            console.log(title.dataset.state);
        }else if(title.dataset.state === "0"){
            change_button.textContent = "Lịch sử mua hàng";
            title.innerText = "Danh sách yêu thích";
            fav_product_navbar.style.display="table-row";
            history_product_navbar.style.display="none";

            user_fav_product.forEach((child) => {
                child.style.display = "table-row";
            });

            user_purchased_order.forEach((child) => {
                child.style.display = "none";
            });
            title.dataset.state = "1";
        }
    } catch (error) {
        console.error("Error:", error.message);
    }

}
