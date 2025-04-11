document.getElementById('register-form').addEventListener('submit', function(e) {
    e.preventDefault();

    const fullname = e.target.fullname.value;
    const email = e.target.email.value;
    const username = e.target.user.value;
    const phone = e.target.phone.value;
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
