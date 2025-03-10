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
