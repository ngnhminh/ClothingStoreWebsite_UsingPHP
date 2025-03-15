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
   
    <div class="modal-header">
        <span>Thêm Voucher</span>
    </div>
    <div class="modal-body">
    <form  method="POST">
    <label for="voucher-name">Tên mã giảm giá:</label>
    <input type="text" name="voucher_name" id="voucher_name"><br>

    <label for="quantity">Số lượng:</label>
    <input type="number" name="quantity" id="quantity"><br>

    <label for="voucher-code">Mã giảm giá:</label>
    <input type="text" name="voucher_code" id="voucher_code"><br>

   
</form>

    </div>
    <div class="modal-footer">
        <button class="btn btn-cancel" onclick="closeModal()">Hủy</button>
        <button class="btn btn-save"  onclick="addVoucher()">Lưu</button>
    </div>
</div>

</body>
</html>