<?php
require_once('header.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Khởi tạo biến thông báo
$error_message = '';
$success_message = '';

// Tạo CSRF token đơn giản
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Hàm sanitize dữ liệu đầu vào (cho hiển thị)
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

// Kiểm tra tham số id và lấy dữ liệu sản phẩm
if (!isset($_REQUEST['id']) || !is_numeric($_REQUEST['id'])) {
    header('Location: logout.php');
    exit;
}

$product_id = (int)$_REQUEST['id'];

// Lấy thông tin sản phẩm
$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=?");
$statement->execute([$product_id]);
$product = $statement->fetch(PDO::FETCH_ASSOC);
if (!$product) {
    header('Location: logout.php');
    exit;
}

// Nếu form được submit
if (isset($_POST['form1'])) {

    // Kiểm tra CSRF token
    if (empty($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error_message .= "Invalid CSRF token.<br>";
    }

    // Validate dữ liệu
    if (empty($_POST['tcat_id'])) {
        $error_message .= "You must select a top level category.<br>";
    }
    if (empty($_POST['mcat_id'])) {
        $error_message .= "You must select a mid level category.<br>";
    }
    if (empty($_POST['ecat_id'])) {
        $error_message .= "You must select an end level category.<br>";
    }
    if (empty($_POST['p_name'])) {
        $error_message .= "Product name cannot be empty.<br>";
    }
    if (empty($_POST['p_current_price']) || !is_numeric($_POST['p_current_price'])) {
        $error_message .= "Current Price must be a number and cannot be empty.<br>";
    }
    if (empty($_POST['p_qty']) || !ctype_digit($_POST['p_qty'])) {
        $error_message .= "Quantity must be an integer and cannot be empty.<br>";
    }

    // Validate file ảnh đại diện nếu upload
    if (isset($_FILES['p_featured_photo']) && $_FILES['p_featured_photo']['error'] != UPLOAD_ERR_NO_FILE) {
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
        $file_ext = strtolower(pathinfo($_FILES['p_featured_photo']['name'], PATHINFO_EXTENSION));

        if (!in_array($file_ext, $allowed_ext)) {
            $error_message .= "You must upload a file of type jpg, jpeg, png, or gif for the featured photo.<br>";
        }

        // Kiểm tra lỗi upload
        if ($_FILES['p_featured_photo']['error'] !== UPLOAD_ERR_OK) {
            $error_message .= "Error uploading featured photo.<br>";
        }
    }

    // Nếu không có lỗi thì tiến hành cập nhật
    if (empty($error_message)) {

        // Upload ảnh phụ nếu có
        if (isset($_FILES['photo']) && is_array($_FILES['photo']['name'])) {
            $photos = $_FILES['photo']['name'];
            $photos_tmp = $_FILES['photo']['tmp_name'];
            $photos_error = $_FILES['photo']['error'];

            $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

            // Lấy số id tiếp theo theo cách an toàn (lấy max id hiện có + 1)
            $stmt = $pdo->query("SELECT MAX(pp_id) AS max_id FROM tbl_product_photo");
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $next_id = $row ? (int)$row['max_id'] + 1 : 1;

            for ($i = 0; $i < count($photos); $i++) {
                if ($photos_error[$i] === UPLOAD_ERR_OK) {
                    $ext = strtolower(pathinfo($photos[$i], PATHINFO_EXTENSION));
                    if (in_array($ext, $allowed_ext)) {
                        $new_filename = $product_id . '-photo-' . $next_id . '-' . time() . '.' . $ext;
                        $destination = '../assets/uploads/product_photos/' . $new_filename;

                        if (move_uploaded_file($photos_tmp[$i], $destination)) {
                            $stmt_insert = $pdo->prepare("INSERT INTO tbl_product_photo (photo, p_id) VALUES (?, ?)");
                            $stmt_insert->execute([$new_filename, $product_id]);
                            $next_id++;
                        }
                    }
                }
            }
        }

        // Upload ảnh đại diện nếu có
        $featured_photo_name = $product['p_featured_photo'];
        if (isset($_FILES['p_featured_photo']) && $_FILES['p_featured_photo']['error'] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($_FILES['p_featured_photo']['name'], PATHINFO_EXTENSION));
            $new_featured_name = 'product-featured-' . $product_id . '-' . time() . '.' . $ext;
            $destination = '../assets/uploads/' . $new_featured_name;

            // Xóa file cũ nếu tồn tại
            if ($product['p_featured_photo'] && file_exists('../assets/uploads/' . $product['p_featured_photo'])) {
                unlink('../assets/uploads/' . $product['p_featured_photo']);
            }

            if (move_uploaded_file($_FILES['p_featured_photo']['tmp_name'], $destination)) {
                $featured_photo_name = $new_featured_name;
            } else {
                $error_message .= "Failed to upload the featured photo.<br>";
            }
        }

        // Nếu không có lỗi upload ảnh đại diện
        if (empty($error_message)) {
            // Cập nhật sản phẩm
            $stmt_update = $pdo->prepare("UPDATE tbl_product SET 
                p_name = ?, 
                p_old_price = ?, 
                p_current_price = ?, 
                p_qty = ?,
                p_featured_photo = ?, 
                p_description = ?, 
                p_short_description = ?, 
                p_feature = ?, 
                p_is_featured = ?, 
                p_is_active = ?, 
                ecat_id = ?
                WHERE p_id = ?");

            $stmt_update->execute([
                $_POST['p_name'],
                $_POST['p_old_price'],
                $_POST['p_current_price'],
                $_POST['p_qty'],
                $featured_photo_name,
                $_POST['p_description'],
                $_POST['p_short_description'],
                $_POST['p_feature'],
                $_POST['p_is_featured'],
                $_POST['p_is_active'],
                $_POST['ecat_id'],
                $product_id
            ]);

            // Cập nhật size
            $pdo->prepare("DELETE FROM tbl_product_size WHERE p_id = ?")->execute([$product_id]);
            if (isset($_POST['size']) && is_array($_POST['size'])) {
                $stmt_size = $pdo->prepare("INSERT INTO tbl_product_size (size_id, p_id) VALUES (?, ?)");
                foreach ($_POST['size'] as $size_id) {
                    $stmt_size->execute([$size_id, $product_id]);
                }
            }

            // Cập nhật color
            $pdo->prepare("DELETE FROM tbl_product_color WHERE p_id = ?")->execute([$product_id]);
            if (isset($_POST['color']) && is_array($_POST['color'])) {
                $stmt_color = $pdo->prepare("INSERT INTO tbl_product_color (color_id, p_id) VALUES (?, ?)");
                foreach ($_POST['color'] as $color_id) {
                    $stmt_color->execute([$color_id, $product_id]);
                }
            }

            $success_message = "Product is updated successfully.";
            // Cập nhật lại thông tin sản phẩm mới để hiển thị
            $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=?");
            $statement->execute([$product_id]);
            $product = $statement->fetch(PDO::FETCH_ASSOC);
        }
    }
}

// Lấy danh mục liên quan (top, mid, end)
$statement = $pdo->prepare("SELECT t1.ecat_name, t1.mcat_id, t2.tcat_id 
    FROM tbl_end_category t1 
    JOIN tbl_mid_category t2 ON t1.mcat_id = t2.mcat_id 
    WHERE t1.ecat_id = ?");
$statement->execute([$product['ecat_id']]);
$category = $statement->fetch(PDO::FETCH_ASSOC);

$tcat_id = $category['tcat_id'] ?? '';
$mcat_id = $category['mcat_id'] ?? '';
$ecat_id = $product['ecat_id'];

// Lấy size hiện tại
$statement = $pdo->prepare("SELECT size_id FROM tbl_product_size WHERE p_id = ?");
$statement->execute([$product_id]);
$size_id_arr = $statement->fetchAll(PDO::FETCH_COLUMN);

// Lấy color hiện tại
$statement = $pdo->prepare("SELECT color_id FROM tbl_product_color WHERE p_id = ?");
$statement->execute([$product_id]);
$color_id_arr = $statement->fetchAll(PDO::FETCH_COLUMN);

?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Sửa sản phẩm</h1>
    </div>
    <div class="content-header-right">
        <a href="product.php" class="btn btn-primary btn-sm">Xem tất cả</a>
    </div>
</section>

<section class="content">

    <div class="row">
        <div class="col-md-12">

            <?php if ($error_message): ?>
                <div class="callout callout-danger">
                    <p><?php echo $error_message; ?></p>
                </div>
            <?php endif; ?>

            <?php if ($success_message): ?>
                <div class="callout callout-success">
                    <p><?php echo $success_message; ?></p>
                </div>
            <?php endif; ?>

            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">

                <input type="hidden" name="csrf_token" value="<?php echo e($_SESSION['csrf_token']); ?>">

                <div class="box box-info">
                    <div class="box-body">

                        <!-- Top Category -->
                        <div class="form-group">
                            <label for="tcat_id" class="col-sm-3 control-label">Top Level Category Name <span>*</span></label>
                            <div class="col-sm-4">
                                <select id="tcat_id" name="tcat_id" class="form-control select2 top-cat">
                                    <option value="">Select Top Level Category</option>
                                    <?php
                                    $statement = $pdo->query("SELECT * FROM tbl_top_category ORDER BY tcat_name ASC");
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                        $selected = ($row['tcat_id'] == $tcat_id) ? 'selected' : '';
                                        echo '<option value="' . e($row['tcat_id']) . '" ' . $selected . '>' . e($row['tcat_name']) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <!-- Mid Category -->
                        <div class="form-group">
                            <label for="mcat_id" class="col-sm-3 control-label">Mid Level Category Name <span>*</span></label>
                            <div class="col-sm-4">
                                <select id="mcat_id" name="mcat_id" class="form-control select2 mid-cat">
                                    <option value="">Select Mid Level Category</option>
                                    <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_mid_category WHERE tcat_id = ? ORDER BY mcat_name ASC");
                                    $statement->execute([$tcat_id]);
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                        $selected = ($row['mcat_id'] == $mcat_id) ? 'selected' : '';
                                        echo '<option value="' . e($row['mcat_id']) . '" ' . $selected . '>' . e($row['mcat_name']) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <!-- End Category -->
                        <div class="form-group">
                            <label for="ecat_id" class="col-sm-3 control-label">End Level Category Name <span>*</span></label>
                            <div class="col-sm-4">
                                <select id="ecat_id" name="ecat_id" class="form-control select2 end-cat">
                                    <option value="">Select End Level Category</option>
                                    <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_end_category WHERE mcat_id = ? ORDER BY ecat_name ASC");
                                    $statement->execute([$mcat_id]);
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                        $selected = ($row['ecat_id'] == $ecat_id) ? 'selected' : '';
                                        echo '<option value="' . e($row['ecat_id']) . '" ' . $selected . '>' . e($row['ecat_name']) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <!-- Product Name -->
                        <div class="form-group">
                            <label for="p_name" class="col-sm-3 control-label">Tên sản phẩm <span>*</span></label>
                            <div class="col-sm-4">
                                <input id="p_name" type="text" name="p_name" class="form-control" value="<?php echo e($product['p_name']); ?>">
                            </div>
                        </div>

                        <!-- Old Price -->
                        <div class="form-group">
                            <label for="p_old_price" class="col-sm-3 control-label">Giá cũ<br><span style="font-size:10px;font-weight:normal;">(In USD)</span></label>
                            <div class="col-sm-4">
                                <input id="p_old_price" type="text" name="p_old_price" class="form-control" value="<?php echo e($product['p_old_price']); ?>">
                            </div>
                        </div>

                        <!-- Current Price -->
                        <div class="form-group">
                            <label for="p_current_price" class="col-sm-3 control-label">Giá mới <span>*</span><br><span style="font-size:10px;font-weight:normal;">(In USD)</span></label>
                            <div class="col-sm-4">
                                <input id="p_current_price" type="text" name="p_current_price" class="form-control" value="<?php echo e($product['p_current_price']); ?>">
                            </div>
                        </div>

                        <!-- Quantity -->
                        <div class="form-group">
                            <label for="p_qty" class="col-sm-3 control-label">Số lương <span>*</span></label>
                            <div class="col-sm-4">
                                <input id="p_qty" type="text" name="p_qty" class="form-control" value="<?php echo e($product['p_qty']); ?>">
                            </div>
                        </div>

                        <!-- Size -->
                        <div class="form-group">
                            <label for="size" class="col-sm-3 control-label">Chọn Size</label>
                            <div class="col-sm-4">
                                <select id="size" name="size[]" class="form-control select2" multiple="multiple">
                                    <?php
                                    $statement = $pdo->query("SELECT * FROM tbl_size ORDER BY size_id ASC");
                                    $sizes = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($sizes as $row) {
                                        $selected = (in_array($row['size_id'], $size_id_arr)) ? 'selected' : '';
                                        echo '<option value="' . e($row['size_id']) . '" ' . $selected . '>' . e($row['size_name']) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <!-- Color -->
                        <div class="form-group">
                            <label for="color" class="col-sm-3 control-label">Chọn Color</label>
                            <div class="col-sm-4">
                                <select id="color" name="color[]" class="form-control select2" multiple="multiple">
                                    <?php
                                    $statement = $pdo->query("SELECT * FROM tbl_color ORDER BY color_id ASC");
                                    $colors = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($colors as $row) {
                                        $selected = (in_array($row['color_id'], $color_id_arr)) ? 'selected' : '';
                                        echo '<option value="' . e($row['color_id']) . '" ' . $selected . '>' . e($row['color_name']) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <!-- Existing Featured Photo -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Existing Featured Photo</label>
                            <div class="col-sm-4" style="padding-top:4px;">
                                <?php if ($product['p_featured_photo'] && file_exists('../assets/uploads/' . $product['p_featured_photo'])): ?>
                                    <img src="../assets/uploads/<?php echo e($product['p_featured_photo']); ?>" alt="" style="width:150px;">
                                <?php else: ?>
                                    <p>No featured photo</p>
                                <?php endif; ?>
                                <input type="hidden" name="current_photo" value="<?php echo e($product['p_featured_photo']); ?>">
                            </div>
                        </div>

                        <!-- Change Featured Photo -->
                        <div class="form-group">
                            <label for="p_featured_photo" class="col-sm-3 control-label">Change Featured Photo</label>
                            <div class="col-sm-4" style="padding-top:4px;">
                                <input type="file" id="p_featured_photo" name="p_featured_photo" accept=".jpg,.jpeg,.png,.gif">
                            </div>
                        </div>

                        <!-- Other Photos -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Other Photos</label>
                            <div class="col-sm-4" style="padding-top:4px;">
                                <table id="ProductTable" style="width:100%;">
                                    <tbody>
                                        <?php
                                        $stmt_photos = $pdo->prepare("SELECT * FROM tbl_product_photo WHERE p_id = ?");
                                        $stmt_photos->execute([$product_id]);
                                        $product_photos = $stmt_photos->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($product_photos as $photo) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <img src="../assets/uploads/product_photos/<?php echo e($photo['photo']); ?>" alt="" style="width:150px;margin-bottom:5px;">
                                                </td>
                                                <td style="width:28px;">
                                                    <a onclick="return confirm('Are you sure want to delete this photo?');" href="product-other-photo-delete.php?id=<?php echo e($photo['pp_id']); ?>&id1=<?php echo $product_id; ?>" class="btn btn-danger btn-xs">X</a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-2">
                                <input type="button" id="btnAddNew" value="Add Item" style="margin-top: 5px;margin-bottom:10px;border:0;color: #fff;font-size: 14px;border-radius:3px;" class="btn btn-warning btn-xs">
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="form-group">
                            <label for="p_description" class="col-sm-3 control-label">Mô tả</label>
                            <div class="col-sm-8">
                                <textarea id="p_description" name="p_description" class="form-control" cols="30" rows="10"><?php echo e($product['p_description']); ?></textarea>
                            </div>
                        </div>

                        <!-- Short Description -->
                        <div class="form-group">
                            <label for="p_short_description" class="col-sm-3 control-label">Short Description</label>
                            <div class="col-sm-8">
                                <textarea id="p_short_description" name="p_short_description" class="form-control" cols="30" rows="10"><?php echo e($product['p_short_description']); ?></textarea>
                            </div>
                        </div>

                        <!-- Features -->
                        <div class="form-group">
                            <label for="p_feature" class="col-sm-3 control-label">Features</label>
                            <div class="col-sm-8">
                                <textarea id="p_feature" name="p_feature" class="form-control" cols="30" rows="10"><?php echo e($product['p_feature']); ?></textarea>
                            </div>
                        </div>

                        <!-- Is Featured? -->
                        <div class="form-group">
                            <label for="p_is_featured" class="col-sm-3 control-label">Is Featured?</label>
                            <div class="col-sm-8">
                                <select id="p_is_featured" name="p_is_featured" class="form-control" style="width:auto;">
                                    <option value="0" <?php if($product['p_is_featured'] == '0'){ echo 'selected'; } ?>>No</option>
                                    <option value="1" <?php if($product['p_is_featured'] == '1'){ echo 'selected'; } ?>>Yes</option>
                                </select>
                            </div>
                        </div>

                        <!-- Is Active? -->
                        <div class="form-group">
                            <label for="p_is_active" class="col-sm-3 control-label">Is Active?</label>
                            <div class="col-sm-8">
                                <select id="p_is_active" name="p_is_active" class="form-control" style="width:auto;">
                                    <option value="0" <?php if($product['p_is_active'] == '0'){ echo 'selected'; } ?>>No</option>
                                    <option value="1" <?php if($product['p_is_active'] == '1'){ echo 'selected'; } ?>>Yes</option>
                                </select>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label"></label>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-success pull-left" name="form1">Cập nhật</button>
                            </div>
                        </div>

                    </div>
                </div>

            </form>

        </div>
    </div>

</section>

<script>
// JavaScript/jQuery để thêm dòng upload ảnh phụ mới khi bấm nút "Add Item"
document.getElementById('btnAddNew').addEventListener('click', function() {
    var tbody = document.querySelector('#ProductTable tbody');
    var tr = document.createElement('tr');
    var td1 = document.createElement('td');
    var inputFile = document.createElement('input');
    inputFile.type = 'file';
    inputFile.name = 'photo[]';
    inputFile.accept = '.jpg,.jpeg,.png,.gif';
    td1.appendChild(inputFile);
    var td2 = document.createElement('td');
    td2.style.width = '28px';
    var btnRemove = document.createElement('button');
    btnRemove.type = 'button';
    btnRemove.className = 'btn btn-danger btn-xs';
    btnRemove.textContent = 'X';
    btnRemove.onclick = function() {
        tbody.removeChild(tr);
    };
    td2.appendChild(btnRemove);
    tr.appendChild(td1);
    tr.appendChild(td2);
    tbody.appendChild(tr);
});
</script>

<?php require_once('footer.php'); ?>
