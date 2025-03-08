<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"  href="/public/assets/css/admin/khuyenmaipage.css">

    <link href="https://fonts.googleapis.com/css2?family=Baloo+2&display=swap" rel="stylesheet">
    <title>Voucher</title>
</head>
<body>

<div class="modal">
    <button id="btn">&times;</button>
    <div class="modal-header">
        <span>Thêm Voucher</span>
    </div>
    <div class="modal-body">
        <label for="discount">Nhập giảm giá:</label>
        <input type="text" id="discount" title="Nhập giảm giá" placeholder="Nhập giảm giá">

        <label for="voucher-name">Tên voucher:</label>
        <input type="text" id="voucher-name" title="Tên voucher" placeholder="Nhập tên voucher">

        <label for="voucher-code">Mã voucher:</label>
        <input type="text" id="voucher-code" title="Mã voucher" placeholder="Nhập mã voucher">

        <label for="quantity">Số lượng:</label>
        <input type="number" id="quantity" title="Số lượng" placeholder="Nhập số lượng">
    </div>
    <div class="modal-footer">
        <button class="btn btn-cancel" onclick="closeModal()">Hủy</button>
        <button class="btn btn-save">Lưu</button>
    </div>
</div>

</body>
</html>