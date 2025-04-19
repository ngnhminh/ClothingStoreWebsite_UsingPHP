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
    <link rel="stylesheet" type="text/css" href="http://localhost/ClothingStoreWebsite_UsingPHP/public/assets/css/productpage.css">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2&display=swap" rel="stylesheet">
    <title>Trang hàng</title>
</head>
<body>
    <header>
        <?php require 'header.php'; ?>
    </header>
    <main>
        <div class="section-arrival">
            <div class="container-fluid">
                <div class="section-head">
                    <h2 class="section-title-container">
                        <a class="section-title">Tất cả sản phẩm</a>
                    </h2>
                </div>
                <div class="filter-bar">
                    <button id="filter-btn" data-order="<?= $order ?>">
                        Lọc giá <?= $order === 'DESC' ? '⇩ ' : '⇧ ' ?>
                    </button>
                    <select id="category-filter">
                        <option value="">Tất cả loại</option>
                        <option value="0" <?= $maloai_id == 0 ? 'selected' : '' ?>>Áo</option>
                        <option value="1" <?= $maloai_id == 1 ? 'selected' : '' ?>>Quần</option>
                        <option value="2" <?= $maloai_id == 2 ? 'selected' : '' ?>>Kính</option>
                        <option value="3" <?= $maloai_id == 3 ? 'selected' : '' ?>>Giày</option>
                    </select>
                </div>
                <div class="section-content">
                    <div class="content-product-lists">
                        <?php foreach ($products as $product) { ?>
                        <div class="product-block-container">
                            <div class="product-block">
                                <div class="product-img">
                                    <div class="product-new">New</div>
                                    <button class="product-cart"><i class="fa-solid fa-cart-plus"></i></button>
                                    <a class="image-resize" href="#">
                                        <img class="image-loop" src="<?php echo htmlspecialchars($product['duongdananh']); ?>" alt="<?php echo htmlspecialchars($product['tensp']); ?>">
                                    </a>
                                </div>
                                <div class="product-detail">
                                    <div class="box-product-detail">
                                        <h3 class="product-name"><?php echo htmlspecialchars($product['tensp']); ?></h3>
                                        <div class="box-product-prices">
                                            <p class="product-price">
                                                <span><?php echo number_format($product['gia'], 0, ',', '.'); ?>₫</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <?php require 'footer.php'; ?>

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

        // Hiệu ứng click vào sản phẩm (nếu có trang chi tiết thì chuyển trang)
        document.querySelectorAll(".product-card").forEach(card => {
        card.addEventListener("mousedown", function () {
            card.style.transform = "translateY(2px)";
            card.style.boxShadow = "0 2px 5px rgba(0,0,0,0.2)";
        });

        card.addEventListener("mouseup", function () {
            card.style.transform = "translateY(0)";
            card.style.boxShadow = "";

            const id = card.getAttribute("data-masp");
            const maloai = card.getAttribute("data-loai");

            if (maloai != 2) {
                window.location.href = 'productdetailshirt.php?id=' + id;
            } else {
                window.location.href = 'productdetailshoes.php?id=' + id;
            }
        });
    });
    </script>
</body>
</html>
