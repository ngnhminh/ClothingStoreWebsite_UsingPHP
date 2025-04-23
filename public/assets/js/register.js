function isValidPhone(phone) {
    // Số điện thoại Việt Nam: 10 chữ số, bắt đầu bằng 0
    const regex = /^0\d{9}$/;
    return regex.test(phone);
}

function isValidEmail(email) {
    // Email đúng định dạng cơ bản
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

function showAlert(words) {
    Swal.fire({
        title: 'Thông báo',
        text: words,
        icon: 'info',
        confirmButtonText: 'Đóng'
    });
}

document.getElementById('register-form').addEventListener('submit', function(e) {
    e.preventDefault();

    const fullname = e.target.fullname.value;
    const email = e.target.email.value;
    if(!isValidEmail(email)){
        showAlert("Email không hợp lệ");
        return;
    } 
    const username = e.target.user.value;
    const phone = e.target.phone.value;
    if(!isValidPhone(phone)){
        showAlert("Số điện thoại không hợp lệ"); 
        return;
    } 
    const password = e.target.password.value;
    const confirmpassword = e.target.confirm_password.value;

    if (password === confirmpassword) {
        // Kiểm tra user đã tồn tại chưa
        axios.post('http://localhost/ClothingStoreWebsite_UsingPHP/app/controllers/registerController.php', {
            username: username,
        })
        .then(res => {
            if (!res.data.success) {
                // Tiến hành tạo user mới
                axios.post('http://localhost/ClothingStoreWebsite_UsingPHP/app/controllers/registerController.php', {
                    fullname: fullname,
                    email: email,
                    username: username,
                    phone: phone,
                    password: password,
                })
                .then(res => {
                    console.log(res.data);
                    if (res.data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Đăng kí thành công',
                            text: 'Bạn có thể đăng nhập ngay bây giờ.'
                        }).then(() => {
                            location.replace("login.php");
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Đăng kí thất bại',
                            text: res.data.message || 'Có lỗi xảy ra khi tạo tài khoản.'
                        });
                    }
                })
                .catch(err => {
                    console.error('Lỗi:', err);
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Đăng kí thất bại',
                    text: 'Tên người dùng đã tồn tại.'
                });
            }
        })
        .catch(err => {
            console.error('Lỗi:', err);
        });
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Đăng kí thất bại',
            text: 'Mật khẩu và xác nhận mật khẩu không khớp.'
        });
    }
});
