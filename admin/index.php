<?php require_once('header.php'); ?>

<section class="content-header">
	<h1>Dashboard</h1>
</section>

<?php
// Đọc các số liệu thống kê
$statement = $pdo->prepare("SELECT COUNT(*) FROM tbl_top_category");
$statement->execute();
$total_top_category = $statement->fetchColumn();

$statement = $pdo->prepare("SELECT COUNT(*) FROM tbl_mid_category");
$statement->execute();
$total_mid_category = $statement->fetchColumn();

$statement = $pdo->prepare("SELECT COUNT(*) FROM tbl_end_category");
$statement->execute();
$total_end_category = $statement->fetchColumn();

$statement = $pdo->prepare("SELECT COUNT(*) FROM tbl_product");
$statement->execute();
$total_product = $statement->fetchColumn();

$statement = $pdo->prepare("SELECT COUNT(*) FROM tbl_payment WHERE payment_status = ?");
$statement->execute(['Completed']);
$total_order_completed = $statement->fetchColumn();

$statement = $pdo->prepare("SELECT COUNT(*) FROM tbl_payment WHERE shipping_status = ?");
$statement->execute(['Completed']);
$total_shipping_completed = $statement->fetchColumn();

$statement = $pdo->prepare("SELECT COUNT(*) FROM tbl_payment WHERE payment_status = ?");
$statement->execute(['Pending']);
$total_order_pending = $statement->fetchColumn();

$statement = $pdo->prepare("SELECT COUNT(*) FROM tbl_payment WHERE payment_status = ? AND shipping_status = ?");
$statement->execute(['Completed', 'Pending']);
$total_order_complete_shipping_pending = $statement->fetchColumn();


// Xử lý form lọc top khách hàng
$top_customers = [];
$from_date = isset($_GET['from_date']) ? $_GET['from_date'] : '';
$to_date = isset($_GET['to_date']) ? $_GET['to_date'] : '';

if ($from_date && $to_date) {
    // Lấy 5 khách hàng mua nhiều nhất trong khoảng thời gian
    $sql = "SELECT 
                c.cust_id, 
                c.cust_name, 
                c.cust_email,
                SUM(p.paid_amount) AS total_spent
            FROM tbl_payment p
            JOIN tbl_customer c ON p.customer_id = c.cust_id
            WHERE p.payment_status = 'Completed'
            AND p.payment_date BETWEEN ? AND ?
            GROUP BY c.cust_id
            ORDER BY total_spent DESC
            LIMIT 5";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["$from_date 00:00:00", "$to_date 23:59:59"]);
    $top_customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<section class="content">
	<div class="row">
		<!-- Biểu đồ tổng quan -->
		<div class="col-md-12">
			<canvas id="dashboardChart" style="width:100%; height:400px;"></canvas>
		</div>
	</div>

	<hr>

	<!-- Form lọc thống kê khách hàng -->
	<div class="row" style="margin-top: 30px;">
		<div class="col-md-12">
			<h3>Thống kê 5 khách hàng mua hàng cao nhất</h3>
			<form method="get" class="form-inline" style="margin-bottom: 20px;">
				<label for="from_date">Từ ngày: </label>
				<input type="date" id="from_date" name="from_date" class="form-control" value="<?php echo htmlspecialchars($from_date); ?>" required>
				<label for="to_date" style="margin-left:15px;">Đến ngày: </label>
				<input type="date" id="to_date" name="to_date" class="form-control" value="<?php echo htmlspecialchars($to_date); ?>" required>
				<button type="submit" class="btn btn-primary" style="margin-left:15px;">Thống kê</button>
			</form>

			<?php if ($from_date && $to_date): ?>
				<?php if (count($top_customers) > 0): ?>
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>STT</th>
								<th>Khách hàng</th>
								<th>Email</th>
								<th>Tổng tiền mua</th>
								<th>Chi tiết đơn hàng</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$stt = 0;
							foreach ($top_customers as $customer):
								$stt++;
								// Lấy đơn hàng khách trong khoảng thời gian
								$order_sql = "SELECT payment_id, payment_date, paid_amount 
								              FROM tbl_payment 
											  WHERE customer_id = ? AND payment_status = 'Completed' 
											  AND payment_date BETWEEN ? AND ? 
											  ORDER BY payment_date DESC";
								$order_stmt = $pdo->prepare($order_sql);
								$order_stmt->execute([$customer['cust_id'], "$from_date 00:00:00", "$to_date 23:59:59"]);
								$orders = $order_stmt->fetchAll(PDO::FETCH_ASSOC);
							?>
							<tr>
								<td><?php echo $stt; ?></td>
								<td><?php echo htmlspecialchars($customer['cust_name']); ?></td>
								<td><?php echo htmlspecialchars($customer['cust_email']); ?></td>
								<td><?php echo number_format($customer['total_spent'], 0, ',', '.') . ' ₫'; ?></td>
								<td>
									<ul>
										<?php foreach ($orders as $order): ?>
											<li>
												<a href="#" class="view-order-detail" data-id="<?php echo $order['payment_id']; ?>">
													Đơn #<?php echo $order['payment_id']; ?> - 
													<?php echo date('d/m/Y H:i', strtotime($order['payment_date'])); ?> - 
													<?php echo number_format($order['paid_amount'], 0, ',', '.') . ' ₫'; ?>
												</a>
											</li>
										<?php endforeach; ?>
									</ul>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				<?php else: ?>
					<p>Không có khách hàng nào trong khoảng thời gian này.</p>
				<?php endif; ?>
			<?php else: ?>
				<p>Vui lòng chọn khoảng thời gian để thống kê.</p>
			<?php endif; ?>
		</div>
	</div>
</section>

<!-- Modal xem chi tiết đơn hàng -->
<div class="modal fade" id="orderDetailModal" tabindex="-1" aria-labelledby="orderDetailLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="orderDetailLabel">Chi tiết đơn hàng</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="orderDetailContent">
        <!-- Nội dung sẽ được load ajax -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>

<!-- Thêm Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
const ctx = document.getElementById('dashboardChart').getContext('2d');

const labels = ['Top Categories', 'Mid Categories', 'End Categories', 'Products', 'Completed Orders', 'Completed Shipping', 'Pending Orders', 'Pending Shipping (Order Completed)'];
const data = [
	<?php echo $total_top_category; ?>,
	<?php echo $total_mid_category; ?>,
	<?php echo $total_end_category; ?>,
	<?php echo $total_product; ?>,
	<?php echo $total_order_completed; ?>,
	<?php echo $total_shipping_completed; ?>,
	<?php echo $total_order_pending; ?>,
	<?php echo $total_order_complete_shipping_pending; ?>
];

const dashboardChart = new Chart(ctx, {
	type: 'bar',
	data: {
		labels: labels,
		datasets: [{
			label: 'Thống kê tổng quan',
			data: data,
			backgroundColor: [
				'#007bff', '#28a745', '#ffc107', '#dc3545',
				'#17a2b8', '#6f42c1', '#fd7e14', '#20c997'
			],
		}]
	},
	options: {
		scales: {
			y: {
				beginAtZero: true,
				ticks: {
					stepSize: 1
				}
			}
		}
	}
});

// Xử lý ajax load chi tiết đơn hàng khi click
$(document).ready(function() {
    $(document).on('click', '.view-order-detail', function(e) {
        e.preventDefault();
        let paymentId = $(this).data('id');

        $('#orderDetailModal').modal('show');
        $('#orderDetailContent').html('<p>Đang tải...</p>');

        $.ajax({
            url: 'order-detail.php',
            method: 'GET',
            data: { id: paymentId, ajax: 1 },
            success: function(response) {
                $('#orderDetailContent').html(response);
            },
            error: function() {
                $('#orderDetailContent').html('<p>Không thể tải chi tiết đơn hàng.</p>');
            }
        });
    });
});
</script>

<?php require_once('footer.php'); ?>
