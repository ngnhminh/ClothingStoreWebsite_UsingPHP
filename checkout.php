<?php require_once('header.php'); ?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $banner_checkout = $row['banner_checkout'];
}
?>

<?php
if(!isset($_SESSION['cart_p_id'])) {
    header('location: cart.php');
    exit;
}
?>

<div class="page-banner" style="background-image: url(assets/uploads/<?php echo $banner_checkout; ?>)">
    <div class="overlay"></div>
    <div class="page-banner-inner">
        <h1><?php echo LANG_VALUE_22; ?></h1>
    </div>
</div>

<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                
                <?php if(!isset($_SESSION['customer'])): ?>
                    <p>
                        <a href="login.php" class="btn btn-md btn-danger"><?php echo LANG_VALUE_160; ?></a>
                    </p>
                <?php else: ?>

                <h3 class="special"><?php echo LANG_VALUE_26; ?></h3>
                <div class="cart">
                    <table class="table table-responsive">
                        <tr>
                            <th><?php echo LANG_VALUE_7; ?></th>
                            <th><?php echo LANG_VALUE_8; ?></th>
                            <th><?php echo LANG_VALUE_47; ?></th>
                            <th><?php echo LANG_VALUE_157; ?></th>
                            <th><?php echo LANG_VALUE_158; ?></th>
                            <th><?php echo LANG_VALUE_159; ?></th>
                            <th><?php echo LANG_VALUE_55; ?></th>
                            <th class="text-right"><?php echo LANG_VALUE_82; ?></th>
                        </tr>
                         <?php
                        $table_total_price = 0;

                        $i=0;
                        foreach($_SESSION['cart_p_id'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_p_id[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_size_id'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_size_id[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_size_name'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_size_name[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_color_id'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_color_id[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_color_name'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_color_name[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_p_qty'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_p_qty[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_p_current_price'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_p_current_price[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_p_name'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_p_name[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_p_featured_photo'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_p_featured_photo[$i] = $value;
                        }
                        ?>
                        <?php for($i=1;$i<=count($arr_cart_p_id);$i++): ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td>
                                <img src="assets/uploads/<?php echo $arr_cart_p_featured_photo[$i]; ?>" alt="">
                            </td>
                            <td><?php echo $arr_cart_p_name[$i]; ?></td>
                            <td><?php echo $arr_cart_size_name[$i]; ?></td>
                            <td><?php echo $arr_cart_color_name[$i]; ?></td>
                            <td><?php echo LANG_VALUE_1; ?><?php echo formatMoneyVND($arr_cart_p_current_price[$i]); ?></td>
                            <td><?php echo $arr_cart_p_qty[$i]; ?></td>
                            <td class="text-right">
                                <?php
                                $row_total_price = $arr_cart_p_current_price[$i]*$arr_cart_p_qty[$i];
                                $table_total_price = $table_total_price + $row_total_price;
                                ?>
                                <?php echo LANG_VALUE_1; ?><?php echo formatMoneyVND($row_total_price); ?>
                            </td>
                        </tr>
                        <?php endfor; ?>           
                        <tr>
                            <th colspan="7" class="total-text"><?php echo LANG_VALUE_81; ?></th>
                            <th class="total-amount"><?php echo LANG_VALUE_1; ?><?php echo formatMoneyVND($table_total_price); ?></th>
                        </tr>
                        <?php
                        $statement = $pdo->prepare("SELECT * FROM tbl_shipping_cost WHERE country_id=?");
                        $statement->execute(array($_SESSION['customer']['cust_country']));
                        $total = $statement->rowCount();
                        if($total) {
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $row) {
                                $shipping_cost = $row['amount'];
                            }
                        } else {
                            $statement = $pdo->prepare("SELECT * FROM tbl_shipping_cost_all WHERE sca_id=1");
                            $statement->execute();
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $row) {
                                $shipping_cost = $row['amount'];
                            }
                        }                        
                        ?>
                        <tr>
                            <td colspan="7" class="total-text"><?php echo LANG_VALUE_84; ?></td>
                            <td class="total-amount"><?php echo LANG_VALUE_1; ?><?php echo $shipping_cost; ?></td>
                        </tr>
                        <tr>
                            <th colspan="7" class="total-text"><?php echo LANG_VALUE_82; ?></th>
                            <th class="total-amount">
                                <?php
                                $final_total = $table_total_price+$shipping_cost;
                                ?>
                                <?php echo LANG_VALUE_1; ?><?php echo formatMoneyVND($final_total); ?>
                            </th>
                        </tr>
                    </table> 
                </div>

                

                <form action="<?php echo BASE_URL; ?>payment/bank/init.php" method="post" id="checkoutForm">

                    <div class="billing-address">
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="special"><?php echo LANG_VALUE_162; ?></h3>
                                <!-- Checkbox chọn tự nhập địa chỉ -->
                                <div class="form-group">
                                    <label>
                                        <input type="checkbox" id="use_different_address" name="use_different_address" value="1">
                                        Tôi muốn nhập địa chỉ khác
                                    </label>
                                </div>
                                <!-- Form nhập địa chỉ mới (ẩn ban đầu) -->
                                <div id="different_address_form" style="display:none; margin-top:15px;">
                                    <div class="form-group">
                                        <label for="new_cust_name">Họ và tên:</label>
                                        <input type="text" name="new_cust_name" id="new_cust_name" class="form-control" placeholder="Nhập họ và tên">
                                    </div>
                                    <div class="form-group">
                                        <label for="new_cust_phone">Số điện thoại:</label>
                                        <input type="text" name="new_cust_phone" id="new_cust_phone" class="form-control" placeholder="Nhập số điện thoại">
                                    </div>
                                    <div class="form-group">
                                        <label for="new_cust_province">Tỉnh:</label>
                                        <select name="new_cust_province" id="new_cust_province" class="form-control">
                                            <?php
                                            $stmt = $pdo->query("SELECT * FROM tbl_country ORDER BY country_name ASC");
                                            foreach ($stmt as $row) {
                                                echo '<option value="' . $row['country_id'] . '">' . htmlspecialchars($row['country_name']) . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="new_cust_address">Địa chỉ:</label>
                                        <textarea name="new_cust_address" id="new_cust_address" class="form-control" rows="3" placeholder="Nhập địa chỉ"></textarea>
                                    </div>
                                </div>

                                <!-- Hiển thị địa chỉ hiện tại nếu không chọn nhập mới -->
                                <table class="table table-responsive table-bordered bill-address" id="current_address_table">
                                    <tr>
                                        <td><?php echo LANG_VALUE_102; ?></td>
                                        <td><?php echo htmlspecialchars($_SESSION['customer']['cust_name']); ?></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo LANG_VALUE_104; ?></td>
                                        <td><?php echo htmlspecialchars($_SESSION['customer']['cust_phone']); ?></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo LANG_VALUE_106; ?></td>
                                        <td>
                                            <?php
                                            $statement = $pdo->prepare("SELECT * FROM tbl_country WHERE country_id=?");
                                            $statement->execute(array($_SESSION['customer']['cust_country']));
                                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($result as $row) {
                                                echo htmlspecialchars($row['country_name']);
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php echo LANG_VALUE_105; ?></td>
                                        <td><?php echo nl2br(htmlspecialchars($_SESSION['customer']['cust_address'])); ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="cart-buttons mt-4">
                        <ul>
                            <li><a href="cart.php" class="btn btn-primary"><?php echo LANG_VALUE_21; ?></a></li>
                        </ul>
                    </div>

                    <h3 class="special mt-5"><?php echo LANG_VALUE_33; ?></h3>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="payment_method"><?php echo LANG_VALUE_34; ?> *</label>
                                <select name="payment_method" class="form-control" id="paymentMethodSelect" required>
                                    <option value="">Chọn phương thức</option>
                                    <option value="Tiền mặt">Thanh toán tiền mặt</option>
                                    <option value="Chuyển khoản">Chuyển khoản ngân hàng</option>
                                </select>
                            </div>

                            <input type="hidden" name="amount" value="<?php echo $final_total; ?>">

                            <div class="form-group mt-2">
                                <input type="submit" class="btn btn-primary" value="<?php echo LANG_VALUE_46; ?>" id="submitButton" name="form_checkout" style="display: none;">
                            </div>
                        </div>
                    </div>
                </form>

                <script>
                    document.getElementById('use_different_address').addEventListener('change', function() {
                        var form = document.getElementById('different_address_form');
                        var currentAddress = document.getElementById('current_address_table');
                        if(this.checked) {
                            form.style.display = 'block';
                            currentAddress.style.display = 'none';
                        } else {
                            form.style.display = 'none';
                            currentAddress.style.display = 'table';
                        }
                    });

                    const selectselect = document.getElementById('paymentMethodSelect');
                    const submitBtnsubmitButton = document.getElementById('submitButton');

                    selectselect.addEventListener('change', function () {
                        if (this.value !== '') {
                            submitBtnsubmitButton.style.display = 'block';
                        } else {
                            submitBtnsubmitButton.style.display = 'none';
                        }
                    });
                </script>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<?php require_once('footer.php'); ?>