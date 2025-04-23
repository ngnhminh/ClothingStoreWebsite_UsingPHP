window.onload = () => {
    let user = JSON.parse(localStorage.getItem("user"));
    const authButton = document.getElementById("auth-buttons");
    const userInfo = document.getElementById("user-info");
    const welcomeText = document.getElementById("welcome-text");

    window.addEventListener('userUpdated', function() {
        let userUpdated = JSON.parse(localStorage.getItem("user"));
        console.log("Thông tin người dùng đã được cập nhật:", userUpdated);
        user = userUpdated; // Cập nhật lại biến user toàn cục với dữ liệu mới
    });

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
    let user = JSON.parse(localStorage.getItem("user"));
    window.addEventListener('userUpdated', function() {
        let userUpdated = JSON.parse(localStorage.getItem("user"));
        console.log("Thông tin người dùng đã được cập nhật:", userUpdated);
        user = userUpdated; // Cập nhật lại biến user toàn cục với dữ liệu mới
    });
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
