<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/public/assets/css/productpage.css">
    <link rel="stylesheet"  href="/public/assets/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2&display=swap" rel="stylesheet">
    <title>Voucher</title>
</head>
<body>
    <header>
        <?php require 'header.php'; ?>
    </header>
    <main>
    <div class="container-voucher">
    <div class="header">
        Quản lý Voucher 
        <button class="add-voucher-voucher">+ Thêm voucher</button>
    </div>
    
    <div class="toolbar-voucher">
        <button>Áo (25)</button>
        <button>Quần (25)</button>
        <button>Kính (25)</button>
        <button>Giày (25)</button>
        <button>Sản phẩm giảm giá</button>
        <input type="text" placeholder="Nhập tên sản phẩm">
    </div>
    
    <div class="voucher-container">
        <table class="voucher-table">
            <thead>
                <tr>
                    <th>Mã voucher</th>
                    <th>Tên voucher</th>
                    <th>Số lượng</th>
                    <th>Tình trạng</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>VTG69898k</td>
                    <td>Vui tết </td>
                    <td>100</td>
                    <td>Còn</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

    </main>
    <footer>
        <?php require 'footer.php'; ?>
    </footer>
</body>
</html>