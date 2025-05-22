<?php require_once('header.php'); ?>

<?php
$error_message = '';
$success_message = '';

if(isset($_POST['form1'])) {
    $valid = 1;
    if(empty($_POST['subject_text'])) {
        $valid = 0;
        $error_message .= 'Subject can not be empty\n';
    }
    if(empty($_POST['message_text'])) {
        $valid = 0;
        $error_message .= 'Message can not be empty\n'; // sửa lại thông báo cho đúng
    }
    if($valid == 1) {

        $subject_text = strip_tags($_POST['subject_text']);
        $message_text = strip_tags($_POST['message_text']);

        // Getting Customer Email Address
        $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_id=?");
        $statement->execute(array($_POST['cust_id']));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $cust_email = '';
        foreach ($result as $row) {
            $cust_email = $row['cust_email'];
        }

        // Getting Admin Email Address
        $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $admin_email = '';
        foreach ($result as $row) {
            $admin_email = $row['contact_email'];
        }

        $order_detail = '';
        $statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE payment_id=?");
        $statement->execute(array($_POST['payment_id']));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
        	
        	if($row['payment_method'] == 'PayPal'):
        		$payment_details = 'Transaction Id: '.$row['txnid'].'<br>';
        	elseif($row['payment_method'] == 'Stripe'):
				$payment_details = 'Transaction Id: '.$row['txnid'].'<br>';
        	elseif($row['payment_method'] == 'Bank Deposit'):
				$payment_details = 'Transaction Details: <br>'.$row['bank_transaction_info'];
        	endif;

            $order_detail .= '
Customer Name: '.$row['customer_name'].'<br>
Customer Email: '.$row['customer_email'].'<br>
Payment Method: '.$row['payment_method'].'<br>
Payment Date: '.$row['payment_date'].'<br>
Payment Details: <br>'.$payment_details.'<br>
Paid Amount: '.$row['paid_amount'].'<br>
Payment Status: '.$row['payment_status'].'<br>
Shipping Status: '.$row['shipping_status'].'<br>
Payment Id: '.$row['payment_id'].'<br>';
        }

        $i=0;
        $statement = $pdo->prepare("SELECT * FROM tbl_order WHERE payment_id=?");
        $statement->execute(array($_POST['payment_id']));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $i++;
            $order_detail .= '
<br><b><u>Product Item '.$i.'</u></b><br>
Tên sản phẩm: '.$row['product_name'].'<br>
Size: '.$row['size'].'<br>
Màu: '.$row['color'].'<br>
Số lượng: '.$row['quantity'].'<br>
Giá sản phẩm: '.$row['unit_price'].'<br>';
        }

        $statement = $pdo->prepare("INSERT INTO tbl_customer_message (subject,message,order_detail,cust_id) VALUES (?,?,?,?)");
        $statement->execute(array($subject_text,$message_text,$order_detail,$_POST['cust_id']));

        // sending email
        $to_customer = $cust_email;
        $message = '
<html><body>
<h3>Message: </h3>
'.$message_text.'
<h3>Order Details: </h3>
'.$order_detail.'
</body></html>
';
        $headers = 'From: ' . $admin_email . "\r\n" .
                   'Reply-To: ' . $admin_email . "\r\n" .
                   'X-Mailer: PHP/' . phpversion() . "\r\n" . 
                   "MIME-Version: 1.0\r\n" . 
                   "Content-Type: text/html; charset=ISO-8859-1\r\n";

        // Sending email to customer                  
        mail($to_customer, $subject_text, $message, $headers);
        
        $success_message = 'Your email to customer is sent successfully.';
    }
}
?>

<?php
if($error_message != '') {
    echo "<script>alert('".$error_message."')</script>";
}
if($success_message != '') {
    echo "<script>alert('".$success_message."')</script>";
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>View Orders</h1>
	</div>
</section>

<section class="content">

  <div class="row">
    <div class="col-md-12">

      <div class="box box-info">

        <!-- FORM LỌC -->
        <form method="get" action="" class="form-inline" style="margin-bottom: 15px; margin-left: 25px">
            <!-- Tình trạng thanh toán -->
            <label for="payment_status" style="margin-right:5px;">Tình trạng thanh toán:</label>
            <select name="payment_status" id="payment_status" class="form-control" style="margin-right:15px;">
                <option value="">Tất cả</option>
                <option value="Pending" <?php if(isset($_GET['payment_status']) && $_GET['payment_status']=='Pending') echo 'selected'; ?>>Pending</option>
                <option value="Completed" <?php if(isset($_GET['payment_status']) && $_GET['payment_status']=='Completed') echo 'selected'; ?>>Completed</option>
                <option value="Cancelled" <?php if(isset($_GET['payment_status']) && $_GET['payment_status']=='Cancelled') echo 'selected'; ?>>Cancelled</option>
            </select>

            <!-- Tình trạng giao hàng -->
            <label for="shipping_status" style="margin-right:5px;">Tình trạng giao hàng:</label>
            <select name="shipping_status" id="shipping_status" class="form-control" style="margin-right:15px;">
                <option value="">Tất cả</option>
                <option value="Pending" <?php if(isset($_GET['shipping_status']) && $_GET['shipping_status']=='Pending') echo 'selected'; ?>>Pending</option>
                <option value="Completed" <?php if(isset($_GET['shipping_status']) && $_GET['shipping_status']=='Completed') echo 'selected'; ?>>Completed</option>
                <option value="Cancelled" <?php if(isset($_GET['shipping_status']) && $_GET['shipping_status']=='Cancelled') echo 'selected'; ?>>Cancelled</option>
            </select>

            <!-- Khoảng thời gian đặt hàng -->
            <label for="date_from" style="margin-right:5px;">Từ ngày:</label>
            <input type="date" name="date_from" id="date_from" class="form-control" style="margin-right:15px;" value="<?php echo isset($_GET['date_from']) ? htmlspecialchars($_GET['date_from']) : ''; ?>">

            <label for="date_to" style="margin-right:5px;">Đến ngày:</label>
            <input type="date" name="date_to" id="date_to" class="form-control" style="margin-right:15px;" value="<?php echo isset($_GET['date_to']) ? htmlspecialchars($_GET['date_to']) : ''; ?>">

            <!-- Địa điểm giao hàng (thành phố) -->
            <label for="city" style="margin-right:5px;">Thành phố:</label>
            <select name="city" class="form-control select2" style="width: 200px;">
                <option value="">Chọn thành phố</option>
                <?php
                $statement = $pdo->prepare("SELECT * FROM tbl_country ORDER BY country_name ASC");
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
                foreach ($result as $row) {
                    ?>
                    <option value="<?php echo htmlspecialchars($row['country_name']); ?>" <?php if(isset($_GET['city']) && $_GET['city'] == $row['country_name']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($row['country_name']); ?>
                    </option>
                    <?php
                }
                ?>
            </select>

            <button type="submit" class="btn btn-primary">Lọc</button>
            <a href="?" class="btn btn-default" style="margin-left:10px;">Reset</a>
        </form>

        <div class="box-body table-responsive">
          <table id="example1" class="table table-bordered table-striped">
			<thead>
			    <tr>
			        <th>SL</th>
                    <th>Thông tin khách hàng</th>
			        <th>Thông tin sản phẩm</th>
                    <th>Thông tin đơn hàng</th>
                    <th>Tổng tiền phải chả</th>
                    <th>Xác nhận</th>
                    <th>Shipping Status</th>
			        <th>Hành động</th>
			    </tr>
			</thead>
            <tbody>
            	<?php
            	$i=0;

                // Build conditions for filtering
                $where_clauses = [];
                $params = [];

                // Lọc theo tình trạng thanh toán
                if (!empty($_GET['payment_status'])) {
                    $where_clauses[] = "payment_status = ?";
                    $params[] = $_GET['payment_status'];
                }

                // Lọc theo tình trạng giao hàng
                if (!empty($_GET['shipping_status'])) {
                    $where_clauses[] = "shipping_status = ?";
                    $params[] = $_GET['shipping_status'];
                }

                // Lọc theo khoảng thời gian đặt hàng
                if (!empty($_GET['date_from'])) {
                    // thêm giờ bắt đầu ngày để đúng khoảng
                    $where_clauses[] = "payment_date >= ?";
                    $params[] = $_GET['date_from'] . " 00:00:00";
                }
                if (!empty($_GET['date_to'])) {
                    // thêm giờ kết thúc ngày để đúng khoảng
                    $where_clauses[] = "payment_date <= ?";
                    $params[] = $_GET['date_to'] . " 23:59:59";
                }

                // Lọc theo thành phố (tbl_customer)
                if (!empty($_GET['city'])) {
                    $where_clauses[] = "EXISTS (SELECT 1 FROM tbl_customer c WHERE c.cust_id = tbl_payment.customer_id AND c.cust_country LIKE ?)";
                    $params[] = '%' . $_GET['city'] . '%';
                }

                $where_sql = '';
                if(count($where_clauses) > 0) {
                    $where_sql = ' WHERE ' . implode(' AND ', $where_clauses);
                }

                $sql = "SELECT * FROM tbl_payment" . $where_sql . " ORDER BY id DESC";
                $statement = $pdo->prepare($sql);
                $statement->execute($params);
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);

            	foreach ($result as $row) {
            		$i++;
            		?>
					<tr class="<?php if($row['payment_status']=='Pending'){echo 'bg-r';}else{echo 'bg-g';} ?>">
	                    <td><?php echo $i; ?></td>
	                    <td>
                            <b>Id:</b> <?php echo $row['customer_id']; ?><br>
                            <b>Name:</b><br> <?php echo $row['customer_name']; ?><br>
                            <b>Email:</b><br> <?php echo $row['customer_email']; ?><br><br>
                            <?php
                                // Lấy thông tin khách hàng theo customer_id
                                $statement_customer = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_id = ?");
                                $statement_customer->execute(array($row['customer_id']));
                                $customer_info = $statement_customer->fetch(PDO::FETCH_ASSOC);
                            ?>
                            <p>
                                <b>Địa chỉ:</b><br> <?php echo isset($customer_info['cust_address']) ? nl2br(htmlspecialchars($customer_info['cust_address'])) : 'N/A'; ?><br>
                                <b>Thành phố:</b><br> <?php echo isset($customer_info['cust_country']) ? nl2br(htmlspecialchars($customer_info['cust_country'])) : 'N/A'; ?><br>
                            </p>
                            
                            <b>SĐT:</b><br> <?php echo isset($customer_info['cust_phone']) ? htmlspecialchars($customer_info['cust_phone']) : 'N/A'; ?><br><br>
                            <div id="model-<?php echo $i; ?>" class="modal fade" role="dialog">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h4 class="modal-title" style="font-weight: bold;">Send Message</h4>
										</div>
										<div class="modal-body" style="font-size: 14px">
											<form action="" method="post">
                                                <input type="hidden" name="cust_id" value="<?php echo $row['customer_id']; ?>">
                                                <input type="hidden" name="payment_id" value="<?php echo $row['payment_id']; ?>">
												<table class="table table-bordered">
													<tr>
														<td>Subject</td>
														<td>
                                                            <input type="text" name="subject_text" class="form-control" style="width: 100%;">
														</td>
													</tr>
                                                    <tr>
                                                        <td>Message</td>
                                                        <td>
                                                            <textarea name="message_text" class="form-control" cols="30" rows="10" style="width:100%;height: 200px;"></textarea>
                                                        </td>
                                                    </tr>
													<tr>
														<td></td>
														<td><input type="submit" value="Send Message" name="form1"></td>
													</tr>
												</table>
											</form>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										</div>
									</div>
								</div>
							</div>
                        </td>
                        <td>
                           <?php
                           $statement1 = $pdo->prepare("SELECT * FROM tbl_order WHERE payment_id=?");
                           $statement1->execute(array($row['payment_id']));
                           $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                           foreach ($result1 as $row1) {
                                echo '<b>Tên sản phẩm:</b> '.$row1['product_name'];
                                echo '<br>(<b>Size:</b> '.$row1['size'];
                                echo ', <b>Màu:</b> '.$row1['color'].')';
                                echo '<br>(<b>Số lượng:</b> '.$row1['quantity'];
                                echo ', <b>Giá sản phẩm:</b> '.$row1['unit_price'].')';
                                echo '<br><br>';
                           }
                           ?>
                        </td>
                        <td>
                        	<b>Phương thức thanh toán:</b> <span style="color:red;"><b><?php echo $row['payment_method']; ?></b></span><br>
                            <b>Mã đơn hàng Id:</b> <?php echo $row['payment_id']; ?><br>
                            <b>Ngày đặt:</b> <?php echo $row['payment_date']; ?><br>

                            <?php if(!empty($row['txnid'])): ?>
                                <b>Transaction Id:</b> <?php echo $row['txnid']; ?><br>
                            <?php endif; ?>
                        </td>
                        <td><?php echo $row['paid_amount']; ?></td>
                        <td>
                            <?php echo $row['payment_status']; ?>
                            <br><br>
                            <?php
                                if($row['payment_status']=='Pending'){
                                    ?>
                                    <a href="order-change-status.php?id=<?php echo $row['id']; ?>&task=Completed" class="btn btn-warning btn-xs" style="width:100%;margin-bottom:4px;">Make Completed</a>
                                    <?php
                                }
                            ?>
                        </td>
                        <td>
                            <?php echo $row['shipping_status']; ?>
                            <br><br>
                            <?php
                            if($row['payment_status']=='Completed') {
                                if($row['shipping_status']=='Pending'){
                                    ?>
                                    <a href="shipping-change-status.php?id=<?php echo $row['id']; ?>&task=Completed" class="btn btn-warning btn-xs" style="width:100%;margin-bottom:4px;">Make Completed</a>
                                    <?php
                                }
                            }
                            ?>
                        </td>
	                    <td>
                            <a href="#" class="btn btn-danger btn-xs" data-href="order-delete.php?id=<?php echo $row['id']; ?>" data-toggle="modal" data-target="#confirm-delete" style="width:100%;">Delete</a>
	                    </td>
	                </tr>
            		<?php
            	}
            	?>
            </tbody>
          </table>
        </div>
      </div>

</section>

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Xác nhận</h4>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn xóa đơn hàng này không ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                <a class="btn btn-danger btn-ok">Xóa</a>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>
