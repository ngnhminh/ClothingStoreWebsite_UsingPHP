<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row)
{
	$footer_about = $row['footer_about'];
	$contact_email = $row['contact_email'];
	$contact_phone = $row['contact_phone'];
	$contact_address = $row['contact_address'];
	$footer_copyright = $row['footer_copyright'];
	$total_recent_post_footer = $row['total_recent_post_footer'];
    $total_popular_post_footer = $row['total_popular_post_footer'];
    $newsletter_on_off = $row['newsletter_on_off'];
    $before_body = $row['before_body'];
}
?>

<?php
// Lấy dữ liệu trang liên hệ
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$settings = $statement->fetch(PDO::FETCH_ASSOC);
?>


<?php if($newsletter_on_off == 1): ?>
<section class="home-newsletter">
    <div class="custom-footer-wrapper">
        <div class="container" style="display: flex; gap: 20px; align-items: flex-start;">
            <div class="logo">
                <img id="logo_footer_img" src="assets/img/logo.png" alt="Lỗi hình ảnh không thể hiển thị">
            </div>
            <div class="info" style="flex: 1; color: #fff; font-weight: 700;">
                <p>
                    Hệ Thống Cửa Hàng<br>
                    Chi Nhánh Hồ Chí Minh: 99 An Duong Vuong,<br>
                    Phường 16, Quận 5 TP.HCM<br>
                    SĐT hỗ trợ/ Khiếu nại: 012345678
                </p>
            </div>

            <!-- Bản đồ bên phải -->
            <div class="map-container" style="flex: 1; border-radius: 8px; overflow: hidden;">
                <div style="width: 100%; height: 350px;">
                    <?php echo $settings['contact_map_iframe']; ?>
                </div>
            </div>
        </div>
    </div>
</section>


<style>
.custom-footer-wrapper .container {
    margin: 0 auto;
    padding: 20px;
    background-color: #FF6B00;
    border: none;
    text-align: center;
    max-width: 1500px;
}

.custom-footer-wrapper .logo {
    float: left;
    text-align: left;   
    width: 30%;
    padding-bottom: 2%;
}

.custom-footer-wrapper .info {
    float: right;
    width: 70%;
    text-align: left;
	color: #ffffff;      /* chữ màu trắng */
    font-weight: 700; 
	font-size: 22px;
}

.custom-footer-wrapper .info p {
    margin-left: 0;
}

.custom-footer-wrapper .footer {
    clear: both;
    margin-top: 20px;
    border-top: 1px solid #ccc;
    padding-top: 10px;
    font-size: 12px;
}

.custom-footer-wrapper #logo_footer_img {
    height: 150px;
    width: 200px;
    margin-left: 30%;
}
</style>
<?php endif; ?>





<div class="footer-bottom">
	<div class="container">
		<div class="row">
			<div class="col-md-12 copyright">
				<?php echo $footer_copyright; ?>
			</div>
		</div>
	</div>
</div>


<a href="#" class="scrollup">
	<i class="fa fa-angle-up"></i>
</a>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $stripe_public_key = $row['stripe_public_key'];
    $stripe_secret_key = $row['stripe_secret_key'];
}
?>

<script src="assets/js/jquery-2.2.4.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="https://js.stripe.com/v2/"></script>
<script src="assets/js/megamenu.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/owl.animate.js"></script>
<script src="assets/js/jquery.bxslider.min.js"></script>
<script src="assets/js/jquery.magnific-popup.min.js"></script>
<script src="assets/js/rating.js"></script>
<script src="assets/js/jquery.touchSwipe.min.js"></script>
<script src="assets/js/bootstrap-touch-slider.js"></script>
<script src="assets/js/select2.full.min.js"></script>
<script src="assets/js/custom.js"></script>
<?php echo $before_body; ?>
</body>
</html>