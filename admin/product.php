<?php require_once('header.php');
	function formatMoneyVND($amount) {
		return number_format($amount, 0, ',', '.') . ' ₫';
	}
?>

//Thông báo
<?php if (isset($_GET['message'])): ?>
    <div class="alert alert-success">
        <?php 
            if ($_GET['message'] == 'Product_hidden_successfully') echo 'Sản phẩm đã được ẩn thành công.';
            elseif ($_GET['message'] == 'Product_activated_successfully') echo 'Sản phẩm đã được kích hoạt thành công.';
        ?>
    </div>
<?php endif; ?>


<section class="content-header">
	<div class="content-header-left">
		<h1>Quản lý sản phẩm</h1>
	</div>
	<div class="content-header-right">
		<a href="product-add.php" class="btn btn-primary btn-sm">Thêm sản phẩm</a>
	</div>
</section>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-body table-responsive">
					<table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th width="30">SL</th>
								<th>Photo</th>
								<th width="200">Product Name</th>
								<th width="60">Old Price</th>
								<th width="60">Current Price</th>
								<th width="60">Quantity</th>
								<th>Is Featured?</th>
								<th>Is Active?</th>
								<th>Category</th>
								<th width="80">Action</th>
							</tr>
						</thead>
						<tbody>
							
							<?php
							$i=0;
							$statement = $pdo->prepare("SELECT
														
														t1.p_id,
														t1.p_name,
														t1.p_old_price,
														t1.p_current_price,
														t1.p_qty,
														t1.p_featured_photo,
														t1.p_is_featured,
														t1.p_is_active,
														t1.ecat_id,

														t2.ecat_id,
														t2.ecat_name,

														t3.mcat_id,
														t3.mcat_name,

														t4.tcat_id,
														t4.tcat_name

							                           	FROM tbl_product t1
							                           	JOIN tbl_end_category t2
							                           	ON t1.ecat_id = t2.ecat_id
							                           	JOIN tbl_mid_category t3
							                           	ON t2.mcat_id = t3.mcat_id
							                           	JOIN tbl_top_category t4
							                           	ON t3.tcat_id = t4.tcat_id
							                           	ORDER BY t1.p_id DESC
							                           	");
							$statement->execute();
							$result = $statement->fetchAll(PDO::FETCH_ASSOC);
							foreach ($result as $row) {
								$i++;
								$check_stmt = $pdo->prepare("SELECT COUNT(*) FROM tbl_order WHERE product_id=?");
								$check_stmt->execute([$row['p_id']]);
								$is_sold = $check_stmt->fetchColumn() > 0;
								?>
								<tr>
									<td><?php echo $i; ?></td>
									<td style="width:130px;"><img src="../assets/uploads/<?php echo $row['p_featured_photo']; ?>" alt="<?php echo $row['p_name']; ?>" style="width:100px;"></td>
									<td><?php echo $row['p_name']; ?></td>
									<td>
										<?php  if (!empty($row['p_old_price']) && is_numeric($row['p_old_price'])) {
										echo formatMoneyVND($row['p_old_price']);
										} else {
										echo '-';
										} ?>
									</td>
									<td><?php echo formatMoneyVND($row['p_current_price']); ?></td>
									<td><?php echo $row['p_qty']; ?></td>
									<td>
										<?php if($row['p_is_featured'] == 1) {echo 'Yes';} else {echo 'No';} ?>
									</td>
									<td>
										<?php if($row['p_is_active'] == 1) {echo 'Yes';} else {echo 'No';} ?>
									</td>
									<td><?php echo $row['tcat_name']; ?><br><?php echo $row['mcat_name']; ?><br><?php echo $row['ecat_name']; ?></td>
									<td>										
										<a href="product-edit.php?id=<?php echo $row['p_id']; ?>" class="btn btn-primary btn-xs">Edit</a>
										<?php if($row['p_is_active'] == 1): ?>
											<?php if($is_sold): ?>
												<a href="product-hide.php?id=<?php echo $row['p_id']; ?>" class="btn btn-warning btn-xs">Hide</a>
											<?php else: ?>
												<a href="#" class="btn btn-danger btn-xs" data-href="product-delete.php?id=<?php echo $row['p_id']; ?>" data-toggle="modal" data-target="#confirm-delete">Delete</a>
											<?php endif; ?>
										<?php else: ?>
											<a href="product-show.php?id=<?php echo $row['p_id']; ?>" class="btn btn-success btn-xs">Show</a>
										<?php endif; ?>
									</td>
								</tr>
								<?php
							}
							?>							
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>


<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure want to delete this item?</p>
                <p style="color:red;">Be careful! This product will be deleted from the order table, payment table, size table, color table and rating table also.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>