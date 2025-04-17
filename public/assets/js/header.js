window.onload = () => {
    const user = JSON.parse(localStorage.getItem("user"));
    const authButton = document.getElementById("auth-buttons");
    const userInfo = document.getElementById("user-info");
    const welcomeText = document.getElementById("welcome-text");

    if (!user) {
        authButton.style.display = "block";
        userInfo.style.display = "none";
    } else {
        authButton.style.display = "none";
        userInfo.style.display = "block";
        welcomeText.innerText = user.tentaikhoan;
    }
};

function goToUserPage() {
    const user = JSON.parse(localStorage.getItem("user"));
    if (user) {
        window.location.href = "userpage.php";
    } else {
        alert("Vui lòng đăng nhập!");
    }
}

function logout() {
    localStorage.removeItem("user");
    window.location.href = "http://localhost/ClothingStoreWebsite_UsingPHP/app/views/index.php";
}
