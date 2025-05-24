<?php
session_start();
require_once('header.php');

// Tạo CSRF token nếu chưa có
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$error_message = '';
$success_message = '';

// Hàm an toàn lấy dữ liệu POST
function getPost($key) {
    return isset($_POST[$key]) ? trim($_POST[$key]) : '';
}

// Giới hạn kích thước file upload (2MB)
define('MAX_FILE_SIZE', 2 * 1024 * 1024);

if(isset($_POST['form1'])) {

    // Kiểm tra CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('Invalid CSRF token');
    }

    $valid = 1;

    if(empty(getPost('tcat_id'))) {
        $valid = 0;
        $error_message .= "Bạn phải chọn danh mục chính.<br>";
    }

    if(empty(getPost('mcat_id'))) {
        $valid = 0;
        $error_message .= "Bạn phải chọn danh mục phụ.<br>";
    }

    if(empty(getPost('ecat_id'))) {
        $valid = 0;
        $error_message .= "Bạn phải chọn danh mục con<br>";
    }

    if(empty(getPost('p_name'))) {
        $valid = 0;
        $error_message .= "Không được để trống tên.<br>";
    }

    if(empty(getPost('p_current_price'))) {
        $valid = 0;
        $error_message .= "Không được để trống giá tiền.<br>";
    }

    if(empty(getPost('p_qty'))) {
        $valid = 0;
        $error_message .= "Số lượng không được để trống.<br>";
    }

    $path = isset($_FILES['p_featured_photo']['name']) ? $_FILES['p_featured_photo']['name'] : '';
    $path_tmp = isset($_FILES['p_featured_photo']['tmp_name']) ? $_FILES['p_featured_photo']['tmp_name'] : '';

    if($path != '') {
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $allowed_ext = ['jpg','jpeg','png','gif'];
        if(!in_array($ext, $allowed_ext)) {
            $valid = 0;
            $error_message .= 'Hình ảnh chính phải là jpg, jpeg, gif hoặc png file.<br>';
        }
        if($_FILES['p_featured_photo']['size'] > MAX_FILE_SIZE) {
            $valid = 0;
            $error_message .= 'Ảnh chính phải nhỏ hơn 2MB<br>';
        }
    } else {
        $valid = 0;
        $error_message .= 'Bạn chưa chọn ảnh chính<br>';
    }

    // Kiểm tra ảnh phụ nếu có
    if(isset($_FILES['photo']['name'])) {
        foreach ($_FILES['photo']['name'] as $key => $name) {
            $tmp_name = $_FILES['photo']['tmp_name'][$key];
            $size = $_FILES['photo']['size'][$key];
            $ext_photo = strtolower(pathinfo($name, PATHINFO_EXTENSION));
            if(!in_array($ext_photo, $allowed_ext)) {
                $valid = 0;
                $error_message .= "Hình ảnh phụ phải là jpg, jpeg, png hoặc gif<br>";
                break;
            }
            if($size > MAX_FILE_SIZE) {
                $valid = 0;
                $error_message .= "Hình ảnh phụ phải nhỏ hơn 2MB<br>";
                break;
            }
        }
    }

    if($valid == 1) {
        // Thêm sản phẩm trước, tạm thời lưu tên ảnh đại diện rỗng (hoặc giá trị tạm)
        $statement = $pdo->prepare("INSERT INTO tbl_product (
                                        p_name,
                                        p_old_price,
                                        p_current_price,
                                        p_qty,
                                        p_featured_photo,
                                        p_description,
                                        p_short_description,
                                        p_feature,
                                        p_total_view,
                                        p_is_featured,
                                        p_is_active,
                                        ecat_id
                                    ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
        $statement->execute(array(
            getPost('p_name'),
            getPost('p_old_price'),
            getPost('p_current_price'),
            getPost('p_qty'),
            '',  // Để trống ảnh đại diện trước, sẽ update sau
            getPost('p_description'),
            getPost('p_short_description'),
            getPost('p_feature'),
            0,
            getPost('p_is_featured'),
            // getPost('p_is_active'),
            0,
            getPost('ecat_id')
        ));

        // Lấy ID vừa thêm
        $last_id = $pdo->lastInsertId();

        // Lưu ảnh đại diện với tên dựa trên $last_id
        $final_name = 'product-featured-'.$last_id.'.'.$ext;
        move_uploaded_file($path_tmp, '../assets/uploads/'.$final_name);

        // Cập nhật lại tên ảnh đại diện vào sản phẩm vừa thêm
        $statement = $pdo->prepare("UPDATE tbl_product SET p_featured_photo=? WHERE p_id=?");
        $statement->execute(array($final_name, $last_id));

        // Xử lý ảnh phụ như trước, dùng $last_id
        $final_name1 = [];
        if( isset($_FILES['photo']["name"]) && isset($_FILES['photo']["tmp_name"]) )
        {
            $photo = array_values(array_filter($_FILES['photo']["name"]));
            $photo_temp = array_values(array_filter($_FILES['photo']["tmp_name"]));

            // Lấy auto_increment bảng tbl_product_photo để đặt tên file ảnh phụ
            $statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_product_photo'");
            $statement->execute();
            $result = $statement->fetchAll();
            foreach($result as $row) {
                $next_id1 = $row['Auto_increment'];
            }
            $z = $next_id1;

            $m=0;
            $timestamp = time();
            for($i=0; $i<count($photo); $i++) {
                $my_ext1 = strtolower(pathinfo($photo[$i], PATHINFO_EXTENSION));
                if(in_array($my_ext1, $allowed_ext)) {
                    $uniqueName = $last_id . '-photo-' . $z . '-' . $timestamp . '.' . $my_ext1;

                    while(file_exists('../assets/uploads/product_photos/' . $uniqueName)) {
                        $uniqueName = $last_id . '-photo-' . $z . '-' . $timestamp . '-' . rand(1000,9999) . '.' . $my_ext1;
                    }

                    move_uploaded_file($photo_temp[$i], "../assets/uploads/product_photos/" . $uniqueName);

                    $final_name1[$m] = $uniqueName;
                    $statement = $pdo->prepare("INSERT INTO tbl_product_photo (photo,p_id) VALUES (?,?)");
                    $statement->execute(array($uniqueName, $last_id));

                    $m++;
                    $z++;
                }
            }
        }

        // Thêm size
        if(isset($_POST['size'])) {
            foreach($_POST['size'] as $value) {
                $statement = $pdo->prepare("INSERT INTO tbl_product_size (size_id,p_id) VALUES (?,?)");
                $statement->execute(array($value, $last_id));
            }
        }

        // Thêm color
        if(isset($_POST['color'])) {
            foreach($_POST['color'] as $value) {
                $statement = $pdo->prepare("INSERT INTO tbl_product_color (color_id,p_id) VALUES (?,?)");
                $statement->execute(array($value, $last_id));
            }
        }

        $success_message = 'Product is added successfully.';
        unset($_SESSION['csrf_token']);
    }

}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Thêm sản phẩm</h1>
    </div>
    <div class="content-header-right">
        <a href="product.php" class="btn btn-primary btn-sm">Xem tất cả</a>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Preview ảnh đại diện
    function previewFeaturedPhoto(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#featured-photo-preview').attr('src', e.target.result).show();
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Preview ảnh phụ
    function previewOtherPhoto(input) {
        if(input.files && input.files[0]){
            var reader = new FileReader();
            var previewImg = $(input).closest('td').find('.other-photo-preview');
            reader.onload = function(e) {
                previewImg.attr('src', e.target.result).show();
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $(document).ready(function(){
        // Preview ảnh đại diện
        $('input[name="p_featured_photo"]').change(function(){
            previewFeaturedPhoto(this);
        });

        // Preview ảnh phụ - sử dụng event delegation
        $(document).on('change', 'input[name="photo[]"]', function(){
            previewOtherPhoto(this);
        });

        // Thêm dòng ảnh phụ - unbind trước khi bind để tránh duplicate
        $('#btnAddNew').off('click').on('click', function(e){
            e.preventDefault(); // Ngăn form submit
            
            var newRow = `<tr>
                <td>
                    <div class="upload-btn">
                        <input type="file" name="photo[]" style="margin-bottom:5px;">
                        <br>
                        <img src="#" class="other-photo-preview" style="width:150px; display:none; margin-top:5px;" alt="Preview Other Photo" />
                    </div>
                </td>
                <td style="width:28px;">
                    <a href="javascript:void(0)" class="Delete btn btn-danger btn-xs">X</a>
                </td>
            </tr>`;
            
            $('#ProductTable tbody').append(newRow);
            
            // Debug: in ra số lượng dòng hiện tại
            console.log('Số dòng hiện tại: ' + $('#ProductTable tbody tr').length);
        });

        // Xóa dòng ảnh phụ - sử dụng event delegation
        $(document).on('click', '.Delete', function(e){
            e.preventDefault();
            $(this).closest('tr').remove();
            
            // Debug: in ra số lượng dòng sau khi xóa
            console.log('Số dòng sau khi xóa: ' + $('#ProductTable tbody tr').length);
        });
    });
</script>

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

            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>" />
                <div class="box box-info">
                    <div class="box-body">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Tên danh mục chính <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="tcat_id" class="form-control select2 top-cat" required>
                                    <option value="">Chọn danh mục chính</option>
                                    <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_top_category ORDER BY tcat_name ASC");
                                    $statement->execute();
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                        $selected = (getPost('tcat_id') == $row['tcat_id']) ? 'selected' : '';
                                        echo '<option value="'.$row['tcat_id'].'" '.$selected.'>'.$row['tcat_name'].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Tên danh mục phụ <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="mcat_id" class="form-control select2 mid-cat" required>
                                    <option value="">Chọn danh mục phụ</option>
                                    <!-- Tốt nhất bạn dùng AJAX để load danh mục con theo danh mục cha -->
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Tên danh mục con <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="ecat_id" class="form-control select2 end-cat" required>
                                    <option value="">Chọn danh mục con</option>
                                    <!-- Tốt nhất bạn dùng AJAX để load danh mục con theo danh mục cha -->
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Tên sản phẩm <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="p_name" class="form-control" required value="<?php echo htmlspecialchars(getPost('p_name')); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Giá cũ <br><span style="font-size:10px;font-weight:normal;">(In VND)</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="p_old_price" class="form-control" value="<?php echo htmlspecialchars(getPost('p_old_price')); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Giá hiện tại <span>*</span><br><span style="font-size:10px;font-weight:normal;">(In VND)</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="p_current_price" class="form-control" required value="<?php echo htmlspecialchars(getPost('p_current_price')); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Số lượng <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="number" name="p_qty" class="form-control" required min="0" value="<?php echo htmlspecialchars(getPost('p_qty')); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Chọn Size</label>
                            <div class="col-sm-4">
                                <select name="size[]" class="form-control select2" multiple="multiple">
                                    <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_size ORDER BY size_id ASC");
                                    $statement->execute();
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                        $selected = '';
                                        if(isset($_POST['size']) && in_array($row['size_id'], $_POST['size'])) {
                                            $selected = 'selected';
                                        }
                                        echo '<option value="'.$row['size_id'].'" '.$selected.'>'.$row['size_name'].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Chọn màu</label>
                            <div class="col-sm-4">
                                <select name="color[]" class="form-control select2" multiple="multiple">
                                    <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_color ORDER BY color_id ASC");
                                    $statement->execute();
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                        $selected = '';
                                        if(isset($_POST['color']) && in_array($row['color_id'], $_POST['color'])) {
                                            $selected = 'selected';
                                        }
                                        echo '<option value="'.$row['color_id'].'" '.$selected.'>'.$row['color_name'].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Hình ảnh chính<span>*</span></label>
                            <div class="col-sm-4" style="padding-top:4px;">
                                <input type="file" name="p_featured_photo" required>
                                <br>
                                <img id="featured-photo-preview" src="#" style="width:150px; display:none; margin-top:5px;" alt="Preview Featured Photo" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Hình ảnh phụ</label>
                            <div class="col-sm-4" style="padding-top:4px;">
                                <table id="ProductTable" style="width:100%;">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="upload-btn">
                                                    <input type="file" name="photo[]" style="margin-bottom:5px;">
                                                    <br>
                                                    <img src="#" class="other-photo-preview" style="width:150px; display:none; margin-top:5px;" alt="Preview Other Photo" />
                                                </div>
                                            </td>
                                            <td style="width:28px;">
                                                <a href="javascript:void(0)" class="Delete btn btn-danger btn-xs">X</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-2">
                                <input type="button" id="btnAddNew" value="Add Item" style="margin-top:5px;margin-bottom:10px;border:0;color:#fff;font-size:14px;border-radius:3px;" class="btn btn-warning btn-xs">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Mô tả</label>
                            <div class="col-sm-8">
                                <textarea name="p_description" class="form-control" cols="30" rows="10" id="editor1"><?php echo htmlspecialchars(getPost('p_description')); ?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Short Description</label>
                            <div class="col-sm-8">
                                <textarea name="p_short_description" class="form-control" cols="30" rows="10" id="editor2"><?php echo htmlspecialchars(getPost('p_short_description')); ?></textarea>
                            </div>
                        </div>

						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Features</label>
							<div class="col-sm-8">
								<textarea name="p_feature" class="form-control" cols="30" rows="10" id="editor3"></textarea>
							</div>
						</div>

						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Is Featured?</label>
							<div class="col-sm-8">
								<select name="p_is_featured" class="form-control" style="width:auto;">
									<option value="0">No</option>
									<option value="1">Yes</option>
								</select> 
							</div>
						</div>  

						<!-- <div class="form-group">
							<label for="" class="col-sm-3 control-label">Is Active?</label>
							<div class="col-sm-8">
								<select name="p_is_active" class="form-control" style="width:auto;">
									<option value="0">Yes</option>
									<option value="1">No</option>
								</select> 
							</div>
						</div> -->
						
						<div class="form-group">
							<label for="" class="col-sm-3 control-label"></label>
							<div class="col-sm-6">
								<button type="submit" class="btn btn-success pull-left" name="form1">Submit</button>
							</div>
						</div>
					</div>
				</div>

			</form>


		</div>
	</div>

</section>

<?php require_once('footer.php'); ?>