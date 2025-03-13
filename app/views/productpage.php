<?php
 require_once __DIR__ . "/../controllers/pageproduct.php";



    $order = isset($_GET['order']) && $_GET['order'] === 'ASC' ? 'ASC' : 'DESC';
    $maloai_id = isset($_GET['maloai_id']) ? (int)$_GET['maloai_id'] : null;
   
   
    $products = getProductsByFilter($order, $maloai_id);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/public/assets/css/productpage.css">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2&display=swap" rel="stylesheet">
    <title>Trang hàng</title>
</head>
<body>
    <header>
        <?php require 'header.php'; ?>
    </header>
    <main>
        <div class="filter-bar">
            <button id="filter-btn" data-order="<?= $order ?>">
                Lọc giá <?= $order === 'DESC' ? '⇩ ' : '⇧ ' ?>
            </button>
            <select id="category-filter">
                <option value="">Tất cả loại</option>
                <option value="1" <?= $maloai_id == 1 ? 'selected' : '' ?>>Áo</option>
                <option value="2" <?= $maloai_id == 2 ? 'selected' : '' ?>>Quần</option>
                <option value="3" <?= $maloai_id == 3 ? 'selected' : '' ?>>Kính</option>
                <option value="4" <?= $maloai_id == 4 ? 'selected' : '' ?>>Giày</option>
            </select>
          
        </div>

        <div class="product-grid_page">
            <?php foreach ($products as $product) { ?>
                <div class="product-card">
                    <img src="<?php echo $product['duongdananh']; ?>" alt="<?php echo $product['tensp']; ?>">
                    <p class="product-name"><?php echo $product['tensp']; ?></p>
                    <p class="product-price"><strong><?php echo number_format($product['gia'], 0, ',', '.'); ?>đ</strong></p>
                </div>
            <?php } ?>
        </div>
    </main>
    <footer>
        <?php require 'footer.php'; ?>
    </footer>

    <script>
        document.getElementById("filter-btn").addEventListener("click", function () {
            let currentOrder = this.getAttribute("data-order"); // Lấy trạng thái hiện tại
            let newOrder = currentOrder === "DESC" ? "ASC" : "DESC"; // Đảo trạng thái

            let urlParams = new URLSearchParams(window.location.search);
            urlParams.set('order', newOrder);

            window.location.search = urlParams.toString(); // Cập nhật URL
        });


        document.getElementById("category-filter").addEventListener("change", function () {
            let maloai_id = this.value;
            let urlParams = new URLSearchParams(window.location.search);

            if (maloai_id) {
                urlParams.set('maloai_id', maloai_id);
            } else {
                urlParams.delete('maloai_id');
            }

            window.location.search = urlParams.toString();
        });
    </script>


</body>
</html>
