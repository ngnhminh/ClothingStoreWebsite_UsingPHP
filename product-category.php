<?php require_once('header.php'); ?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $banner_product_category = $row['banner_product_category'];
}

if( !isset($_REQUEST['id']) || !isset($_REQUEST['type']) ) {
    header('location: index.php');
    exit;
} else {

    if( ($_REQUEST['type'] != 'top-category') && ($_REQUEST['type'] != 'mid-category') && ($_REQUEST['type'] != 'end-category') ) {
        header('location: index.php');
        exit;
    } else {

        $statement = $pdo->prepare("SELECT * FROM tbl_top_category");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
        foreach ($result as $row) {
            $top[] = $row['tcat_id'];
            $top1[] = $row['tcat_name'];
        }

        $statement = $pdo->prepare("SELECT * FROM tbl_mid_category");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
        foreach ($result as $row) {
            $mid[] = $row['mcat_id'];
            $mid1[] = $row['mcat_name'];
            $mid2[] = $row['tcat_id'];
        }

        $statement = $pdo->prepare("SELECT * FROM tbl_end_category");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
        foreach ($result as $row) {
            $end[] = $row['ecat_id'];
            $end1[] = $row['ecat_name'];
            $end2[] = $row['mcat_id'];
        }

        if($_REQUEST['type'] == 'top-category') {
            if(!in_array($_REQUEST['id'],$top)) {
                header('location: index.php');
                exit;
            } else {

                for ($i=0; $i < count($top); $i++) { 
                    if($top[$i] == $_REQUEST['id']) {
                        $title = $top1[$i];
                        break;
                    }
                }
                $arr1 = array();
                $arr2 = array();

                for ($i=0; $i < count($mid); $i++) { 
                    if($mid2[$i] == $_REQUEST['id']) {
                        $arr1[] = $mid[$i];
                    }
                }
                for ($j=0; $j < count($arr1); $j++) {
                    for ($i=0; $i < count($end); $i++) { 
                        if($end2[$i] == $arr1[$j]) {
                            $arr2[] = $end[$i];
                        }
                    }   
                }
                $final_ecat_ids = $arr2;
            }   
        }

        if($_REQUEST['type'] == 'mid-category') {
            if(!in_array($_REQUEST['id'],$mid)) {
                header('location: index.php');
                exit;
            } else {
                for ($i=0; $i < count($mid); $i++) { 
                    if($mid[$i] == $_REQUEST['id']) {
                        $title = $mid1[$i];
                        break;
                    }
                }
                $arr2 = array();        
                for ($i=0; $i < count($end); $i++) { 
                    if($end2[$i] == $_REQUEST['id']) {
                        $arr2[] = $end[$i];
                    }
                }
                $final_ecat_ids = $arr2;
            }
        }

        if($_REQUEST['type'] == 'end-category') {
            if(!in_array($_REQUEST['id'],$end)) {
                header('location: index.php');
                exit;
            } else {
                for ($i=0; $i < count($end); $i++) { 
                    if($end[$i] == $_REQUEST['id']) {
                        $title = $end1[$i];
                        break;
                    }
                }
                $final_ecat_ids = array($_REQUEST['id']);
            }
        }
        
    }   
}
?>

<div class="page-banner" style="background-image: url(assets/uploads/<?php echo $banner_product_category; ?>)">
    <div class="inner">
        <h1><?php echo LANG_VALUE_50; ?> <?php echo $title; ?></h1>
    </div>
</div>

<div class="page">
    <div class="container">
        <div class="row">
          <div class="col-md-3">
                <?php require_once('sidebar-category.php'); ?>
            </div>
            <div class="col-md-9">

                <h3><?php echo LANG_VALUE_51; ?> "<?php echo $title; ?>"</h3>

                <!-- Form Tìm kiếm nâng cao -->
                <form method="get" class="form-inline" style="margin-bottom: 20px;">
                    <input type="hidden" name="type" value="<?php echo htmlspecialchars($_REQUEST['type']); ?>">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($_REQUEST['id']); ?>">

                    <div class="form-group">
                        <label for="search_text">Tên sản phẩm:</label>
                        <input type="text" id="search_text" name="search_text" class="form-control" style="margin-left:5px;" 
                            value="<?php echo isset($_GET['search_text']) ? htmlspecialchars($_GET['search_text']) : ''; ?>">
                    </div>

                    <div class="form-group" style="margin-left:15px;">
                        <label for="category_filter">Phân loại:</label>
                        <select id="category_filter" name="category_filter" class="form-control" style="margin-left:5px;">
                            <option value="">Tất cả</option>
                            <?php
                            $stmt_cat = $pdo->prepare("SELECT ecat_id, ecat_name FROM tbl_end_category ORDER BY ecat_name ASC");
                            $stmt_cat->execute();
                            $categories = $stmt_cat->fetchAll(PDO::FETCH_ASSOC);
                            $selected_cat = isset($_GET['category_filter']) ? $_GET['category_filter'] : '';
                            foreach($categories as $cat) {
                                $selected = ($selected_cat == $cat['ecat_id']) ? 'selected' : '';
                                echo '<option value="'.htmlspecialchars($cat['ecat_id']).'" '.$selected.'>'.htmlspecialchars($cat['ecat_name']).'</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group" style="margin-left:15px;">
                        <label for="price_min">Giá từ:</label>
                        <input type="number" min="0" step="1000" id="price_min" name="price_min" class="form-control" style="margin-left:5px; width: 100px;" 
                            value="<?php echo isset($_GET['price_min']) ? (int)$_GET['price_min'] : ''; ?>">
                    </div>

                    <div class="form-group" style="margin-left:15px;">
                        <label for="price_max">Đến:</label>
                        <input type="number" min="0" step="1000" id="price_max" name="price_max" class="form-control" style="margin-left:5px; width: 100px;" 
                            value="<?php echo isset($_GET['price_max']) ? (int)$_GET['price_max'] : ''; ?>">
                    </div>

                    <button type="submit" class="btn btn-primary" style="margin-left:15px;">Tìm kiếm</button>
                </form>

                <div class="product product-cat">
                    <div class="row">
                        <?php
                        // Xây dựng truy vấn tìm kiếm kết hợp điều kiện
                        $where_clauses = [];
                        $params = [];

                        // Lọc phân loại dựa trên category chính (final_ecat_ids)
                        if(!empty($final_ecat_ids)) {
                            $placeholders = implode(',', array_fill(0, count($final_ecat_ids), '?'));
                            $where_clauses[] = "ecat_id IN ($placeholders)";
                            $params = array_merge($params, $final_ecat_ids);
                        }

                        // Lọc theo tên sản phẩm
                        if(!empty($_GET['search_text'])) {
                            $where_clauses[] = "p_name LIKE ?";
                            $params[] = '%' . $_GET['search_text'] . '%';
                        }

                        // Lọc theo phân loại chọn trong form (override phân loại nếu có)
                        if(!empty($_GET['category_filter'])) {
                            $where_clauses[] = "ecat_id = ?";
                            $params[] = $_GET['category_filter'];
                        }

                        // Lọc theo khoảng giá
                        if(!empty($_GET['price_min'])) {
                            $where_clauses[] = "p_current_price >= ?";
                            $params[] = (int)$_GET['price_min'];
                        }
                        if(!empty($_GET['price_max'])) {
                            $where_clauses[] = "p_current_price <= ?";
                            $params[] = (int)$_GET['price_max'];
                        }

                        // Luôn lọc sản phẩm active
                        $where_clauses[] = "p_is_active = 1";

                        $where_sql = '';
                        if(count($where_clauses) > 0) {
                            $where_sql = ' WHERE ' . implode(' AND ', $where_clauses);
                        }

                        $sql = "SELECT * FROM tbl_product $where_sql ORDER BY p_id DESC";
                        $statement = $pdo->prepare($sql);
                        $statement->execute($params);
                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                        if(count($result) == 0) {
                            echo '<div class="pl_15">Không tìm thấy sản phẩm nào.</div>';
                        } else {
                            foreach ($result as $row) {
                                ?>
                                <div class="col-md-4 item item-product-cat">
                                    <div class="inner">
                                        <div class="thumb">
                                            <div class="photo" style="background-image:url(assets/uploads/<?php echo $row['p_featured_photo']; ?>);"></div>
                                            <div class="overlay"></div>
                                        </div>
                                        <div class="text">
                                            <h3><a href="product.php?id=<?php echo $row['p_id']; ?>"><?php echo $row['p_name']; ?></a></h3>
                                            <h4>
                                                <?php echo LANG_VALUE_1; ?><?php echo $row['p_current_price']; ?> 
                                                <?php if($row['p_old_price'] != ''): ?>
                                                <del>
                                                    <?php echo LANG_VALUE_1; ?><?php echo $row['p_old_price']; ?>
                                                </del>
                                                <?php endif; ?>
                                            </h4>
                                            <div class="rating">
                                                <?php
                                                $t_rating = 0;
                                                $statement1 = $pdo->prepare("SELECT * FROM tbl_rating WHERE p_id=?");
                                                $statement1->execute(array($row['p_id']));
                                                $tot_rating = $statement1->rowCount();
                                                if($tot_rating == 0) {
                                                    $avg_rating = 0;
                                                } else {
                                                    $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($result1 as $row1) {
                                                        $t_rating = $t_rating + $row1['rating'];
                                                    }
                                                    $avg_rating = $t_rating / $tot_rating;
                                                }
                                                ?>
                                                <?php
                                                if($avg_rating == 0) {
                                                    echo '';
                                                }
                                                elseif($avg_rating == 1.5) {
                                                    echo '
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-half-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                    ';
                                                } 
                                                elseif($avg_rating == 2.5) {
                                                    echo '
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-half-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                    ';
                                                }
                                                elseif($avg_rating == 3.5) {
                                                    echo '
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-half-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                    ';
                                                }
                                                elseif($avg_rating == 4.5) {
                                                    echo '
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-half-o"></i>
                                                    ';
                                                }
                                                else {
                                                    for($i=1;$i<=5;$i++) {
                                                        ?>
                                                        <?php if($i>$avg_rating): ?>
                                                            <i class="fa fa-star-o"></i>
                                                        <?php else: ?>
                                                            <i class="fa fa-star"></i>
                                                        <?php endif; ?>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                            <?php if($row['p_qty'] == 0): ?>
                                                <div class="out-of-stock">
                                                    <div class="inner">
                                                        Out Of Stock
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <p><a href="product.php?id=<?php echo $row['p_id']; ?>"><?php echo LANG_VALUE_154; ?></a></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>
