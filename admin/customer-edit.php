<?php require_once('header.php'); ?>

<?php
if(!isset($_REQUEST['id'])) {
    header('location: logout.php');
    exit;
} else {
    // Kiểm tra user có tồn tại không
    $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_id=?");
    $statement->execute(array($_REQUEST['id']));
    $total = $statement->rowCount();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    if( $total == 0 ) {
        header('location: logout.php');
        exit;
    }
}

$error_message = '';
$success_message = '';

if(isset($_POST['form1'])) {
    $valid = 1;

    if(empty($_POST['cust_name'])) {
        $valid = 0;
        $error_message .= 'Tên không được để trống<br>';
    }

    if(empty($_POST['cust_email'])) {
        $valid = 0;
        $error_message .= 'Email không được để trống<br>';
    } else {
        if(filter_var($_POST['cust_email'], FILTER_VALIDATE_EMAIL) === false) {
            $valid = 0;
            $error_message .= 'Email không hợp lệ<br>';
        } else {
            // Kiểm tra email có bị trùng (ngoại trừ chính user này)
            $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_email=? AND cust_id!=?");
            $statement->execute(array($_POST['cust_email'], $_REQUEST['id']));
            if($statement->rowCount() > 0) {
                $valid = 0;
                $error_message .= 'Email đã tồn tại<br>';
            }
        }
    }

    if(empty($_POST['cust_phone'])) {
        $valid = 0;
        $error_message .= 'Không được để trống số điện thoại<br>';
    }

    if(empty($_POST['cust_address'])) {
        $valid = 0;
        $error_message .= 'Không được để trống địa chỉ<br>';
    }

    if(empty($_POST['cust_country'])) {
        $valid = 0;
        $error_message .= 'Chưa chọn tỉnh thành <br>';
    }

    // Nếu muốn đổi mật khẩu thì kiểm tra
    if(!empty($_POST['cust_password']) || !empty($_POST['cust_re_password'])) {
        if($_POST['cust_password'] != $_POST['cust_re_password']) {
            $valid = 0;
            $error_message .= 'Mật khẩu không khớp<br>';
        }
    }

    if($valid == 1) {
        if(!empty($_POST['cust_password'])) {
            // Update có đổi mật khẩu
            $statement = $pdo->prepare("UPDATE tbl_customer SET cust_name=?, cust_email=?, cust_phone=?, cust_country=?, cust_address=?, cust_password=? WHERE cust_id=?");
            $statement->execute(array(
                strip_tags($_POST['cust_name']),
                strip_tags($_POST['cust_email']),
                strip_tags($_POST['cust_phone']),
                strip_tags($_POST['cust_country']),
                strip_tags($_POST['cust_address']),
                md5($_POST['cust_password']),
                $_REQUEST['id']
            ));
        } else {
            // Update không đổi mật khẩu
            $statement = $pdo->prepare("UPDATE tbl_customer SET cust_name=?, cust_email=?, cust_phone=?, cust_country=?, cust_address=? WHERE cust_id=?");
            $statement->execute(array(
                strip_tags($_POST['cust_name']),
                strip_tags($_POST['cust_email']),
                strip_tags($_POST['cust_phone']),
                strip_tags($_POST['cust_country']),
                strip_tags($_POST['cust_address']),
                $_REQUEST['id']
            ));
        }
        
        $success_message = 'Người dùng được cập nhật thông tin thành công!';
    }
}

// Lấy dữ liệu user hiện tại để điền vào form
$statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_id=?");
$statement->execute(array($_REQUEST['id']));
$result = $statement->fetch(PDO::FETCH_ASSOC);

?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Sửa người dùng</h1>
    </div>
    <div class="content-header-right">
        <a href="customer.php" class="btn btn-primary btn-sm">Xem tất cả người dùng</a>
    </div>
</section>

<section class="content">

    <div class="row">
        <div class="col-md-12">

            <?php if($error_message): ?>
            <div class="callout callout-danger">
                <p><?php echo $error_message; ?></p>
            </div>
            <?php endif; ?>

            <?php if($success_message): ?>
            <div class="callout callout-success">
                <p><?php echo $success_message; ?></p>
            </div>
            <?php endif; ?>

            <form class="form-horizontal" action="" method="post">
                <div class="box box-info">
                    <div class="box-body">

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Họ tên *</label>
                            <div class="col-sm-6">
                                <input type="text" name="cust_name" class="form-control" value="<?php echo htmlspecialchars($result['cust_name']); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Email *</label>
                            <div class="col-sm-6">
                                <input type="email" name="cust_email" class="form-control" value="<?php echo htmlspecialchars($result['cust_email']); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">SĐT *</label>
                            <div class="col-sm-6">
                                <input type="text" name="cust_phone" class="form-control" value="<?php echo htmlspecialchars($result['cust_phone']); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Địa chỉ *</label>
                            <div class="col-sm-6">
                                <textarea name="cust_address" class="form-control" rows="3"><?php echo htmlspecialchars($result['cust_address']); ?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Tỉnh thành *</label>
                            <div class="col-sm-6">
                                <select name="cust_country" class="form-control select2">
                                    <option value="">Chọn tỉnh thành</option>
                                    <?php
                                    $stmt = $pdo->prepare("SELECT * FROM tbl_country ORDER BY country_name ASC");
                                    $stmt->execute();
                                    $countries = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    foreach($countries as $country) {
                                        $selected = ($result['cust_country'] == $country['country_id']) ? 'selected' : '';
                                        echo '<option value="'.$country['country_id'].'" '.$selected.'>'.$country['country_name'].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Mật khẩu (Để trống nếu không có thay đổi)</label>
                            <div class="col-sm-6">
                                <input type="password" name="cust_password" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Xác nhận mật khẩu</label>
                            <div class="col-sm-6">
                                <input type="password" name="cust_re_password" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-6">
                                <button type="submit" name="form1" class="btn btn-success">Cập nhật</button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>

        </div>
    </div>

</section>

<?php require_once('footer.php'); ?>
