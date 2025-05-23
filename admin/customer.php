<?php require_once('header.php'); ?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Quản lý khách hàng</h1>
	</div>
	<div class="content-header-right">
		<a href="customer-add.php" class="btn btn-primary btn-sm">Thêm khách hàng</a>
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
								<th width="180">Họ Tên</th>
								<th width="180">Email</th>
								<th width="180">Thành phố, Địa chỉ</th>
								<th>Status</th>
								<th width="100">Kích hoạt/Tạm khóa tài khoản</th>
								<th width="100">Hành động</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$i=0;
								$statement = $pdo->prepare("SELECT * 
															FROM tbl_customer t1
															JOIN tbl_country t2 
															ON t1.cust_country = t2.country_id
														");
								$statement->execute();
								$result = $statement->fetchAll(PDO::FETCH_ASSOC);                        
								foreach ($result as $row) {
									$i++;
									?>
									<tr class="<?php if($row['cust_status']==1) {echo 'bg-g';}else {echo 'bg-r';} ?>">
										<td><?php echo $i; ?></td>
										<td><?php echo $row['cust_name']; ?></td>
										<td><?php echo $row['cust_email']; ?></td>
										<td>
											<?php echo $row['country_name']; ?><br>
											<?php echo nl2br(htmlspecialchars($row['cust_address'])); ?><br> <!-- Thêm dòng địa chỉ -->
										</td>
										<td><?php if($row['cust_status']==1) {echo 'Kích hoạt';} else {echo 'Bị khóa';} ?></td>
										<td>
											<a href="customer-change-status.php?id=<?php echo $row['cust_id']; ?>" class="btn btn-success btn-xs">Change Status</a>
										</td>
										<td>
											<a href="customer-edit.php?id=<?php echo $row['cust_id']; ?>" class="btn btn-primary btn-xs">Edit</a>
											<a href="#" class="btn btn-danger btn-xs" data-href="customer-delete.php?id=<?php echo $row['cust_id']; ?>" data-toggle="modal" data-target="#confirm-delete">Delete</a>
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
                <h4 class="modal-title" id="myModalLabel">Xác nhận xóa</h4>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa người dùng này không ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                <a class="btn btn-danger btn-ok">Xóa</a>
            </div>
        </div>
    </div>
</div>


<?php require_once('footer.php'); ?>