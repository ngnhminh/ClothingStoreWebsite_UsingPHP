<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"  href="/public/assets/css/admin/khuyenmaipage.css">

    <link href="https://fonts.googleapis.com/css2?family=Baloo+2&display=swap" rel="stylesheet">
    <title>Khuyến mãi</title>
</head>
<body>

<div class="modal-voucher">

    <div class="modal-header-voucher">
        <span>Thêm Khuyến Mãi</span>
       
    </div>
    <div class="modal-body-voucher">
        <label for="discount">Nhập giảm giá:</label>
        <input type="text" id="discount" title="Nhập giảm giá" placeholder="Nhập giảm giá">

        <label for="voucher-name">Giá gốc:</label>
        <input type="text" id="voucher-name" title="Tên voucher" placeholder="Giá gốc">

        <label for="voucher-code">Sau giảm:</label>
        <input type="text" id="voucher-code" title="Mã voucher" placeholder="Sau giảm">

       
    <div class="modal-footer-voucher">
        <button class="btn btn-cancel-voucher" onclick="closeModal()">Hủy</button>
        <button class="btn btn-save-voucher">Lưu</button>
    </div>
</div>

</body>
</html>