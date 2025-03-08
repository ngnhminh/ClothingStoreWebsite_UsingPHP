const sizeOptions = document.querySelectorAll(".size-options button");

sizeOptions.forEach(button => {
    button.addEventListener("click", function() {
        // Thay đổi màu chữ và nền khi nút được click
        button.style.color = "white";
        button.style.background = "grey";
    });
});
