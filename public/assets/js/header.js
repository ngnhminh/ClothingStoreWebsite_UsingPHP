window.onload = () => {
    const user = JSON.parse(localStorage.getItem("user"));
    const authbutton = document.getElementById("auth-buttons");
    const userinfo = document.getElementById("user-info");
    const welcomeholder = document.getElementById("welcome-text");

    if (!user) {
        authbutton.style.display = "block";
        userinfo.style.display = "none";
    } else {
        authbutton.style.display = "none";
        userinfo.style.display = "block";
        welcomeholder.innerText = user.tentaikhoan;
    }
};


function logout(){
    localStorage.removeItem("user");
    location.reload();
}