
let user = JSON.parse(localStorage.getItem("user"));

window.addEventListener('userUpdated', function() {
    let userUpdated = JSON.parse(localStorage.getItem("user"));
    console.log("Thông tin người dùng đã được cập nhật:", userUpdated);
    user = userUpdated; // Cập nhật lại biến user toàn cục với dữ liệu mới
});

document.getElementById('login-form').addEventListener('submit', function(e) {
    e.preventDefault();

    const email = e.target.email.value;
    const password = e.target.password.value;

    axios.post('http://localhost/ClothingStoreWebsite_UsingPHP/app/controllers/loginController.php', {
        email: email,
        password: password
    })
    .then(res => {
        console.log('Kết quả:', res.data);
        console.log('Kết quả:', res.data.users);
        if (res.data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Đăng nhập thành công!',
                text: `Xin chào ${res.data.user.tentaikhoan}`,
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                localStorage.setItem("user", JSON.stringify(res.data.user));
                location.replace("index.php");
            });
        }else{
            Swal.fire({
                icon: 'error',
                title: 'Đăng nhập thất bại',
                text: res.data.message || 'Tài khoản hoặc mật khẩu không đúng.'
            });
        }
    })
    .catch(err => {
        console.error('Lỗi:', err);
    });
});