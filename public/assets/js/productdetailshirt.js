const sizeOptions = document.querySelectorAll(".size-options button");

//Đặt nút về bình thường 
function defaultSetSize(){
    sizeOptions.forEach(button => {
        button.style.color = "black";
        button.style.background = "#f3f3f3";
    });
}

sizeOptions.forEach(button => {
    button.addEventListener("click", function() {
        if(button.style.color != "white" && button.style.background != "grey"){
            defaultSetSize();
            button.style.color = "white";
            button.style.background = "grey";
        }else{
            defaultSetSize();
            button.style.color = "black";
            button.style.background = "#f3f3f3";
        }
    });
});

//Nút like
const likebtn = document.getElementById("likebtn");

likebtn.addEventListener("click", function () {
    likebtn.classList.toggle("active");
});

const params = new URLSearchParams(window.location.search);
const masp = params.get("id");

//Hàm gọi đến controlelr
axios.get('http://localhost/ClothingStoreWebsite_UsingPHP/app/controllers/productdetailshirtController.php', {
    params: { id: masp }
}).then(res => {
    if (res.data.success) {
        const productImage = document.getElementById("product-image");
        productImage.innerHTML = `
            <img src="${res.data.product.duongdananh}" alt="Sản phẩm" />
        `;
    }
})