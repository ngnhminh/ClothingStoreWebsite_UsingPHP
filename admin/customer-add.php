<?php require_once('header.php'); ?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $banner_registration = $row['banner_registration'];
}

if (isset($_POST['form1'])) {

    $valid = 1;
    $error_message = '';
    $success_message = '';

    // Validate inputs
    if(empty($_POST['cust_name'])) {
        $valid = 0;
        $error_message .= 'Tên không được để trống<br>';
    }

    if(empty($_POST['cust_email'])) {
        $valid = 0;
        $error_message .= 'Email không được để trống<br>';
    } else {
        if (filter_var($_POST['cust_email'], FILTER_VALIDATE_EMAIL) === false) {
            $valid = 0;
            $error_message .= 'Email không đúng định dạng<br>';
        } else {
            $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_email=?");
            $statement->execute(array($_POST['cust_email']));
            if($statement->rowCount() > 0) {
                $valid = 0;
                $error_message .= 'Email đã tồn tại<br>';
            }
        }
    }

    if(empty($_POST['cust_phone'])) {
        $valid = 0;
        $error_message .= 'Số điện thoại không được để trống<br>';
    }

    if(empty($_POST['cust_address'])) {
        $valid = 0;
        $error_message .= 'Địa chỉ không được để trống<br>';
    }

    if(empty($_POST['cust_country'])) {
        $valid = 0;
        $error_message .= 'Phải chọn tỉnh thành<br>';
    }

    if( empty($_POST['cust_password']) || empty($_POST['cust_re_password']) ) {
        $valid = 0;
        $error_message .= 'Password and Confirm Password can not be empty<br>';
    } elseif($_POST['cust_password'] != $_POST['cust_re_password']) {
        $valid = 0;
        $error_message .= 'Mật khẩu không khớp<br>';
    }

    if($valid == 1) {

        $token = md5(time());
        $cust_datetime = date('Y-m-d H:i:s');
        $cust_timestamp = time();

        // Prepare data to insert (without photo)
        $statement = $pdo->prepare("INSERT INTO tbl_customer (
            cust_name,
            cust_email,
            cust_phone,
            cust_country,
            cust_address,
            cust_password,
            cust_token,
            cust_datetime,
            cust_timestamp,
            cust_status
        ) VALUES (?,?,?,?,?,?,?,?,?,?)");

        $statement->execute(array(
            strip_tags($_POST['cust_name']),
            strip_tags($_POST['cust_email']),
            strip_tags($_POST['cust_phone']),
            strip_tags($_POST['cust_country']),
            strip_tags($_POST['cust_address']),
            md5($_POST['cust_password']),
            $token,
            $cust_datetime,
            $cust_timestamp,
            1
        ));

        // Send confirmation email
        // $to = $_POST['cust_email'];
        // $subject = 'Confirm your registration';
        // $verify_link = BASE_URL.'verify.php?email='.$to.'&token='.$token;
        // $message = 'Please verify your account by clicking <a href="'.$verify_link.'">here</a>.';
        // $headers = "Content-type:text/html;charset=UTF-8\r\n";
        // $headers .= "From: noreply@" . BASE_URL . "\r\n";
        // mail($to, $subject, $message, $headers);

        $success_message = 'Đăng kí thành công.';

        // Clear POST data
        unset($_POST);
    }
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Đăng kí người dùng</h1>
    </div>
    <div class="content-header-right">
		<a href="customer.php" class="btn btn-primary btn-sm">Xem tất cả</a>
	</div>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">

            <?php if(!empty($error_message)): ?>
            <div class="callout callout-danger">
                <p><?php echo $error_message; ?></p>
            </div>
            <?php endif; ?>

            <?php if(!empty($success_message)): ?>
            <div class="callout callout-success">
                <p><?php echo $success_message; ?></p>
            </div>
            <?php endif; ?>

            <form class="form-horizontal" action="" method="post">
                <div class="box box-info">
                    <div class="box-body">

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Họ tên *</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="cust_name" value="<?php echo htmlspecialchars($_POST['cust_name'] ?? ''); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Địa chỉ email *</label>
                            <div class="col-sm-6">
                                <input type="email" class="form-control" name="cust_email" value="<?php echo htmlspecialchars($_POST['cust_email'] ?? ''); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Số điện thoại *</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="cust_phone" value="<?php echo htmlspecialchars($_POST['cust_phone'] ?? ''); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Địa chỉ *</label>
                            <div class="col-sm-6">
                                <textarea class="form-control" name="cust_address" rows="3"><?php echo htmlspecialchars($_POST['cust_address'] ?? ''); ?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Thành phố *</label>
                            <div class="col-sm-6">
                                <select name="cust_country" class="form-control select2">
                                    <option value="">Chọn tỉnh thành</option>
                                    <?php
                                    $stmt = $pdo->prepare("SELECT * FROM tbl_country ORDER BY country_name ASC");
                                    $stmt->execute();
                                    $countries = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($countries as $country) {
                                        $selected = (isset($_POST['cust_country']) && $_POST['cust_country'] == $country['country_id']) ? 'selected' : '';
                                        echo '<option value="'.$country['country_id'].'" '.$selected.'>'.$country['country_name'].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Mật khẩu *</label>
                            <div class="col-sm-6">
                                <input type="password" class="form-control" name="cust_password">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Xác nhận mật khẩu *</label>
                            <div class="col-sm-6">
                                <input type="password" class="form-control" name="cust_re_password">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-6">
                                <button type="submit" name="form1" class="btn btn-primary">Đăng kí</button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>

        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>
