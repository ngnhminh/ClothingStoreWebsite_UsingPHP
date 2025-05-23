<?php require_once('header.php'); ?>

<?php
// Lấy dữ liệu trang liên hệ
$statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
$statement->execute();
$page = $statement->fetch(PDO::FETCH_ASSOC);

$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$settings = $statement->fetch(PDO::FETCH_ASSOC);
?>

<!-- Banner trang -->
<div class="page-banner" style="background-image: url(assets/uploads/<?php echo htmlspecialchars($page['contact_banner']); ?>);">
    <div class="inner text-center" style="padding: 80px 20px; background: rgba(0,0,0,0.5); color: #fff;">
        <h1 style="font-weight: bold; font-size: 3rem;"><?php echo htmlspecialchars($page['contact_title']); ?></h1>
    </div>
</div>

<!-- Nội dung chính -->
<div class="page" style="padding: 40px 0;">
    <div class="container">
        <div class="row">
            
            <!-- Thông tin liên hệ -->
            <div class="col-md-6 mb-4">
                <h3 class="mb-3">Thông tin liên hệ</h3>
                <address style="font-size: 1.1rem; line-height: 1.6;">
                    <?php echo nl2br(htmlspecialchars($settings['contact_address'])); ?>
                </address>
                <p><strong>Điện thoại:</strong> <?php echo htmlspecialchars($settings['contact_phone']); ?></p>
                <p><strong>Email:</strong> <a href="mailto:<?php echo htmlspecialchars($settings['contact_email']); ?>"><?php echo htmlspecialchars($settings['contact_email']); ?></a></p>
            </div>

            <!-- Bản đồ -->
            <div class="col-md-6">
                <h3 class="mb-3">Bản đồ chỉ đường</h3>
                <div class="map-container" style="width: 100%; height: 350px; border-radius: 8px; overflow: hidden;">
                    <?php echo $settings['contact_map_iframe']; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>
