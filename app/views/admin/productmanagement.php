<?php
     require_once __DIR__ . "/../../controllers/productmanagementcontroller.php";
?>

<html lang="vi">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin</title>
        <link rel="stylesheet" href="/public/assets/css/admin/productmanagement.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
        <link href="https://fonts.googleapis.com/css2?family=Baloo+2&display=swap" rel="stylesheet">
    </head>
    <body>
        <aside class="sidebar">
            <img id="logo_img" src="http://localhost/ClothingStore/public/assets/images/logo.png" alt="Lỗi hình ảnh không thể hiển thị"></a>
            <ul class="menu-admin">
                <a href="dashboard.php"><li>📊 Dashboard</li></a>
                <a href="productmanagement.php"><li>📦 Quản lý sản phẩm</li></a>
                <a href="ordermanagement.php"><li>📜 Quản lý đơn hàng</li></a>
                <a href="customermanagement.php"><li>👥 Quản lý khách hàng</li></a>
                <a href="khuyenmaipage.php"><li>🎟️ Quản lý khuyến mãi</li></a>
                <a href="historypage.php"><li>📈 Lịch sử</li></a>
            </ul>
        </aside>
        <div class="productmanager-container">
            <div class="header">
                <h2>Quản lý sản phẩm</h2>
                <button class="btn-add" id="add-product-btn">+ Thêm sản phẩm</button>
            </div>
            
            <div class="filter-bar">
                <button id="za" value="Áo">Áo (25)</button>
                <button value="Quần">Quần (25)</button>
                <button value="Kính">Kính (25)</button>
                <button value="Giày">Giày (25)</button>
                <button value="All">Tất cả</button>
                <button value="Block">Đồ khóa (25)</button>
                <input type="text" placeholder="Nhập tên sản phẩm" id="search">
            </div>

            <div class="product-list" id="product-list">
                <?php $products = getAllProducts(); 
                foreach ($products as $product): ?>
                    <div class="product" data-masp="<?php echo htmlspecialchars($product['id']); ?>">
                        <div class="product-thumbnail">
                            <div class="product-thumbnail_wrapper">
                                <img class="product-thumbnail__image" src="<?php echo htmlspecialchars($product['duongdananh']); ?>" alt="<?php echo htmlspecialchars($product['tensp']); ?>" />
                            </div>
                        </div>
                        <p><?php echo htmlspecialchars($product['tensp']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="change-modal">
            <div class="modal-content">
                <button class="close-btn">&times;</button>
                
                <div class="product-info">
                    <div class="product-config">
                        <div class="column1 changeproduct" id ="column1changeproduct">
                            <div class="buttons" id="changebuttons">
                                <button class="lock-btn" id="change-lock-btn">Khóa</button>
                                <button class="save-btn" id="change-save-btn">Lưu</button>
                            </div>
                            <div id="product-type">
                                <span>Loại:</span>
                                <select name="product-type" disabled>
                                    <option value="ao">Áo</option>
                                    <option value="quan">Quần</option>
                                    <option value="kinh">Kính</option>
                                    <option value="giay">Giày</option>
                                </select>
                            </div>
                            <div class="product-image" id="changeinfoproduct">
                                <!-- <img src="/public/assets/images/shirt.png" alt="Sản phẩm">
                                <span>Distressed Double Knee Denim Pants Brown</span>
                                <div class="price">
                                    <span>Giá:</span> <span>120.000</span> <button class="edit-btn">✎</button>
                                </div>
                                <button class="save-addbtn">Lưu</button> -->
                            </div>
                            <div id="product-add-colornpic" style="display: none">
                                <div class="color-section">
                                    <button class="btn btn-change" id="btn-change">Thêm màu</button>
                                    <input type="color" id="colorPicker" style="display: none;">
                                    <div id="colorDisplay" style="display:none">Giá trị màu: <span id="colorValue">#000000</span></div>
                                    <span class="divider">:</span>
                                    <div class="color-options color-options-change" id="color-options-change">
                                        <span class="color black"></span>
                                        <span class="color beige"></span>
                                        <span class="color brown"></span>
                                    </div>
                                </div>

                                <button class="btn" id="btn-image-change" style="display: none;">Thêm hình ảnh màu</button>
                                <input type="file" id="fileInput" accept="image/*" style="display: none;">
                                <div class="image-box" id="image-box-change"></div>
                            </div>
                        </div>

                        <div class="column1 addproduct">
                            <div id="product-type">
                                <span>Loại:</span>
                                <select name="product-type" id="product-type-selected">
                                    <option value="ao">Áo</option>
                                    <option value="quan">Quần</option>
                                    <option value="kinh">Kính</option>
                                    <option value="giay">Giày</option>
                                </select>
                            </div>
                            <div class="product-image">
                                <img src="http://localhost/ClothingStore/public/assets/images/vector.svg" alt="Sản phẩm" class="addproduct">
                                <input type="text" id="nameofpeoduct" placeholder="Nhập tên sản phẩm" required>
                                <div class="price">
                                    <label for="cost">Giá</label>
                                    <input type="number" id="cost" name="price" placeholder="Nhập giá" min="0" step="1000" required>
                                    <span>VNĐ</span>                                
                                </div>
                                <button class="save-addbtn">Lưu</button>
                            </div>
                            <div id="product-add-colornpic" >
                                <div class="color-section">
                                    <button class="btn">Thêm màu</button>
                                    <span class="divider">:</span>
                                    <div class="color-options">
                                        <span class="color black"></span>
                                        <span class="color beige"></span>
                                        <span class="color brown"></span>
                                    </div>
                                    <input type="checkbox" class="checkbox">
                                </div>

                                <button class="btn">Thêm hình ảnh màu</button>
                                <div class="image-box">
                                    <p>D:/abc.xyz.img <span class="remove">—</span></p>
                                    <p>D:/abc.xyz.img <span class="remove">—</span></p>
                                    <p>D:/abc.xyz.img <span class="remove">—</span></p>
                                    <p>D:/abc.xyz.img <span class="remove">—</span></p>
                                </div>

                                <button class="btn">Hình ảnh</button>
                                <div class="image-box">
                                    <p>D:/abc.xyz.img <span class="remove">—</span></p>
                                    <p>D:/abc.xyz.img <span class="remove">—</span></p>
                                    <p>D:/abc.xyz.img <span class="remove">—</span></p>
                                    <p>D:/abc.xyz.img <span class="remove">—</span></p>
                                </div>
                            </div>
                        </div>

                        <div class="column2 changeproduct">
                            <div class="sizes" id="changeproductsize-container">
                                <span>Số lượng</span>
                            </div>
                        </div>

                        <div class="column2 addproduct" id ="column2changeproduct">
                            <div class="sizes">
                                <span>Số lượng</span>
                                <div class="size-option addproduct-ao" >
                                    <div>S</div>
                                    <input type="number" value="5">
                                </div>
                                <div class="size-option addproduct-ao">
                                    <div>M</div>
                                    <input type="number" value="5">
                                </div>
                                <div class="size-option addproduct-ao">
                                    <div>L</div>
                                    <input type="number" value="5">
                                </div>
                                <div class="size-option addproduct-ao">
                                    <div>XL</div>
                                    <input type="number" value="5">
                                </div>
                                <div class="size-option addproduct-ao">
                                    <div>XXL</div>
                                    <input type="number" value="5">
                                </div>

                                <!-- Size Quần -->
                                <div class="size-option addproduct-quan">
                                    <div>26</div>
                                    <input type="number" value="5">
                                </div>
                                <div class="size-option addproduct-quan">
                                    <div>28</div>
                                    <input type="number addproduct-quan" value="5">
                                </div>
                                <div class="size-option addproduct-quan">
                                    <div>30</div>
                                    <input type="number addproduct-quan" value="5">
                                </div>
                                <div class="size-option addproduct-quan">
                                    <div>32</div>
                                    <input type="number addproduct-quan" value="5">
                                </div>
                                <div class="size-option addproduct-quan">
                                    <div>34</div>
                                    <input type="number" value="5">
                                </div>

                                <!-- Size Giày -->
                                <div class="size-option addproduct-giay">
                                    <div>40</div>
                                    <input type="number" value="5">
                                </div>
                                <div class="size-option addproduct-giay">
                                    <div>41</div>
                                    <input type="number addproduct-giay" value="5">
                                </div>
                                <div class="size-option addproduct-giay">
                                    <div>42</div>
                                    <input type="number addproduct-giay" value="5">
                                </div>
                                <div class="size-option addproduct-giay">
                                    <div>43</div>
                                    <input type="number addproduct-giay" value="5">
                                </div>
                                <div class="size-option addproduct-giay">
                                    <div>44</div>
                                    <input type="number" value="5">
                                </div>
                                <div class="size-option addproduct-giay">
                                    <div>45</div>
                                    <input type="number" value="5">
                                </div>
                                <div class="size-option addproduct-giay">
                                    <div>46</div>
                                    <input type="number" value="5">
                                </div>
                                <div class="size-option addproduct-giay">
                                    <div>47</div>
                                    <input type="number" value="5">
                                </div>

                                <!-- Size kính -->
                                <div class="size-option addproduct-kinh">
                                    <div>FS</div>
                                    <input type="number" value="5">
                                </div>
                            </div>
                        </div>
                    </div>              

                    <div class="description">
                        <textarea id="description-box" placeholder="Mô tả"></textarea>
                        <div id="detail-container-change">
                            <textarea placeholder="Chi tiết sản phẩm"></textarea>
                        </div>
                        <button id="add-textarea-btn">+</button>
                        <button id="remove-textarea-btn">-</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="loading-indicator" class="spinner-container">
            <div class="spinner"></div>
        </div>
        <script src="http://localhost/ClothingStore/public/assets/js/admin/productmanagement.js"></script>
    </body>
</html>