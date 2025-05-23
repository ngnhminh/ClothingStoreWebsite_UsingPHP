<h3>Tìm kiếm nâng cao</h3>
<form action="product-category.php" method="GET" class="form-vertical">
    <input type="hidden" name="type" value="<?php echo $_GET['type'] ?? 'top-category'; ?>">
    <input type="hidden" name="id" value="<?php echo $_GET['id'] ?? 0; ?>">

    <!-- Tên sản phẩm -->
    <div class="form-group">
        <label for="search_text">Tên sản phẩm:</label>
        <input type="text" class="form-control" name="search_text" placeholder="Nhập tên..." 
               value="<?php echo isset($_GET['search_text']) ? htmlspecialchars($_GET['search_text']) : ''; ?>">
    </div>

    <!-- Phân loại cấp 2 (Mid Category) -->
    <div class="form-group">
        <label for="mcat_id">Danh mục phụ:</label>
        <select class="form-control" name="mcat_id" id="mcat_id">
            <option value="">-- Tất cả --</option>
            <?php
            $current_type = $_GET['type'] ?? '';
            $current_id = $_GET['id'] ?? 0;

            if ($current_type == 'top-category' && $current_id) {
                $stmt = $pdo->prepare("SELECT * FROM tbl_mid_category WHERE tcat_id=? ORDER BY mcat_name ASC");
                $stmt->execute([$current_id]);
                foreach ($stmt as $row) {
                    $selected = (isset($_GET['mcat_id']) && $_GET['mcat_id'] == $row['mcat_id']) ? 'selected' : '';
                    echo '<option value="' . $row['mcat_id'] . '" ' . $selected . '>' . $row['mcat_name'] . '</option>';
                }
            } elseif ($current_type == 'mid-category' && $current_id) {
                // Nếu đang xem mid-category thì chỉ show đúng cái mid-category đó để chọn (không phải list tất cả)
                $stmt = $pdo->prepare("SELECT * FROM tbl_mid_category WHERE mcat_id=?");
                $stmt->execute([$current_id]);
                $mid_cat = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($mid_cat) {
                    echo '<option value="' . $mid_cat['mcat_id'] . '" selected>' . $mid_cat['mcat_name'] . '</option>';
                }
            }
            ?>
        </select>
    </div>

    <!-- Phân loại cấp 3 (End Category) -->
    <div class="form-group">
        <label for="ecat_id">Danh mục con:</label>
        <select class="form-control" name="ecat_id" id="ecat_id">
            <option value="">-- Tất cả --</option>
            <?php
            if (!empty($_GET['mcat_id'])) {
                $stmt = $pdo->prepare("SELECT * FROM tbl_end_category WHERE mcat_id=? ORDER BY ecat_name ASC");
                $stmt->execute([$_GET['mcat_id']]);
                foreach ($stmt as $row) {
                    $selected = (isset($_GET['ecat_id']) && $_GET['ecat_id'] == $row['ecat_id']) ? 'selected' : '';
                    echo '<option value="' . $row['ecat_id'] . '" ' . $selected . '>' . $row['ecat_name'] . '</option>';
                }
            }
            ?>
        </select>
    </div>

    <!-- Khoảng giá -->
    <div class="form-group">
        <label>Khoảng giá:</label>
        <div class="d-flex">
            <input type="number" name="price_min" class="form-control" placeholder="Từ" min="0" 
                   value="<?php echo isset($_GET['price_min']) ? (int)$_GET['price_min'] : ''; ?>">
            <span class="mx-2">-</span>
            <input type="number" name="price_max" class="form-control" placeholder="Đến" min="0" 
                   value="<?php echo isset($_GET['price_max']) ? (int)$_GET['price_max'] : ''; ?>">
        </div>
    </div>

    <!-- Nút tìm kiếm -->
    <div class="form-group mt-2">
        <button type="submit" class="btn btn-primary btn-block">Tìm kiếm</button>
    </div>
</form>

<!-- JS: Chỉ load danh mục con khi chọn mid-category -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$('#mcat_id').on('change', function() {
    var mcat_id = $(this).val();
    $('#ecat_id').html('<option>Loading...</option>');

    if(mcat_id) {
        $.get('get-end-categories.php', { mcat_id: mcat_id }, function(data) {
            $('#ecat_id').html(data);
        });
    } else {
        $('#ecat_id').html('<option value="">-- Tất cả --</option>');
    }
});
</script>
