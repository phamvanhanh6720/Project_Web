<?php
get_header();
#Số bản ghi/trang
$num_per_page = 10;
$list_num_page = db_num_page('tbl_products', $num_per_page);
#Tổng số bản ghi
$total_row = db_num_rows("SELECT* FROM  `tbl_products`");
#Số trang
$num_page = ceil($total_row / $num_per_page);
#chỉ số bắt đầu của trang
$page_num = (int) !empty($_GET['page_id']) ? $_GET['page_id'] : 1;
$start = ($page_num - 1) * $num_per_page;
$order_num = $start;
$list_products = get_products($start, $num_per_page);
# Sản phẩm đã đăng
$total_approved = db_num_rows("SELECT* FROM  `tbl_products` Where `product_status`= 'Approved'");
# Sản phẩm chờ xét duyệt
$total_waitting = db_num_rows("SELECT* FROM  `tbl_products` Where `product_status`= 'Waitting...'");
# Sản phẩm đã bị xóa
$total_trash = db_num_rows("SELECT* FROM  `tbl_products` Where `product_status`= 'Trash'");
?>
<div id="main-content-wp" class="list-product-page">
    <div class="wrap clearfix">
        <?php
        get_sidebar();
        ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Danh sách sản phẩm</h3>
                    <a href="?mod=product&action=add_product" title="" id="add-new" class="fl-left">Thêm mới</a>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <div class="filter-wp clearfix">
                        <ul class="post-status fl-left">
                            <li class="all"><a href="">Tất cả <span class="count">(<?php echo $total_row ?>)</span></a> |</li>
                            <li class="publish"><a href="">Đã đăng <span class="count">(<?php echo $total_approved ?>)</span></a> |</li>
                            <li class="pending"><a href="">Chờ xét duyệt <span class="count">(<?php echo $total_waitting ?>)</span></a></li>
                            <li class="trash"><a href="">Thùng rác <span class="count">(<?php echo $total_trash ?>)</span></a></li>
                        </ul>
                        <form method="GET" class="form-s fl-right" action="">
                            <input type="hidden" name="mod" value="product">
                            <input type="hidden" name="action" value ="search_products">
                            <input type="text" name="value" id="s"  value="<?php echo set_value('value') ?>">
                            <input type="submit" name="sm_s" value ="Tìm kiếm">
                            <?php echo form_error('error')?>
                        </form>
                    </div>
                    <form method="POST" action="?mod=product&controller=index&action=apply_products&page_id=<?php echo $page_num;?>">
                        <div class="actions">
                            <div class="form-actions">
                                <select name="actions">
                                    <option value="0">Tác vụ</option>
                                    <option <?php if (isset($_POST['actions']) && $_POST['actions'] == 1) echo "selected='selected'"; ?> value="1">Công khai</option>
                                    <option <?php if (isset($_POST['actions']) && $_POST['actions'] == 2) echo "selected='selected'"; ?> value="2">Chờ duyệt</option>
                                    <option <?php if (isset($_POST['actions']) && $_POST['actions'] == 3) echo "selected='selected'"; ?> value="3">Bỏ vào thủng rác</option>
                                </select>
                                <input type="submit" name="sm_action" value="Áp dụng">
                                <?php echo form_error('select')?>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table list-table-wp"> 
                                <thead>
                                    <tr>
                                        <td><input type="checkbox" name="checkAll" id="checkAll"></td>
                                        <td><span class="thead-text">STT</span></td>
                                        <td><span class="thead-text">Mã sản phẩm</span></td>
                                        <td><span class="thead-text">Hình ảnh</span></td>
                                        <td><span class="thead-text">Tên sản phẩm</span></td>
                                        <td><span class="thead-text">Giá mới</span></td>
                                        <td><span class="thead-text">Giá cũ</span></td>
                                        <td><span class="thead-text">Danh mục</span></td>
                                        <td><span class="thead-text">Kho hàng</span></td>
                                        <td><span class="thead-text">Đã bán</span></td>
                                        <td><span class="thead-text">Trạng thái</span></td>
                                        <td><span class="thead-text">Người tạo</span></td>
                                        <td><span class="thead-text">Thời gian</span></td>
                                    </tr>
                                </thead>
                                <?php if (!empty($list_products)) {
                                        $error = array();
                                        $order = 0;
                                    ?>
                                <tbody>
                                    <?php foreach ($list_products as $product) {
                                        $order++;
                                        $sum_sold_product = get_sum_sold_product($product['product_id']);
                                        $data = array(
                                            'sold_product' => $sum_sold_product,
                                        );
                                        update_product($data, $product['product_id']);
                                        ?>
                                    <tr>
                                        <td><input type="checkbox" name="checkItem[]" class="checkItem" value="<?php echo $product['product_id'] ?>"></td>
                                        <td><span class="tbody-text"><?php echo $order ?></h3></span>
                                        <td><span class="tbody-text"><?php echo $product['product_code'] ?></h3></span>
                                        <td>
                                            <div class="tbody-thumb">
                                                <a href='?mod=product&controller=index&action=update_products&product_id=<?php echo $product['product_id']?>'><img src="<?php if(!empty($product['product_thumb'])){echo $product['product_thumb'];} else{echo 'public/images/img-product.png';}?>" alt=""></a>
                                            </div>
                                        </td>
                                        <td class="clearfix">
                                            <div class="tb-title fl-left">
                                                <a href="?mod=product&controller=index&action=update_products&product_id=<?php echo $product['product_id']?>" title=""><?php echo $product['product_title'] ?></a>
                                            </div>
                                            <ul class="list-operation fl-right">
                                                <li><a href="?mod=product&controller=index&action=update_products&product_id=<?php echo $product['product_id']?>" title="Sửa" class="edit"><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
                                                <li><a href="?mod=product&controller=index&action=delete_products&product_id=<?php echo $product['product_id']?>" title="Xóa" class="delete"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                                            </ul>
                                        </td>
                                        <td><span class="tbody-text"><?php echo currency_format($product['product_price_new']) ?></span></td>
                                        <td><span class="tbody-text"><?php if(!empty($product['product_price_old'])) echo currency_format($product['product_price_old']) ?></span></td>
                                        <td><span class="tbody-text"><?php echo $product['parent_cat'] ?></span></td>
                                        <td><span class="tbody-text"><?php echo $product['num_product'] ?></span></td>
                                        <td><span class="tbody-text"><?php if(!empty($product['sold_product'])){echo $product['sold_product'];} else{ echo 0;}?></span></td>
                                        <td><span class="tbody-text <?php echo text_color_status($product['product_status']) ?>"><?php echo $product['product_status'] ?></span></td>
                                        <td><span class="tbody-text"><?php echo $product['creator'] ?></span></td>
                                        <td><span class="tbody-text"><?php echo $product['created_date'] ?></span></td>
                                    </tr>
                                    <?php
                                        }
                                    ?>
                                </tbody>
                                <?php
                                    } else {
                                        $error['product'] = "Không tồn tại sản phẩm nào!";
                                    ?>
                                        <p class="error"><?php echo  $error['product'] ?> </p>
                                    <?php
                                    }
                                    ?>
                                <tfoot>
                                    <tr>
                                        <td><input type="checkbox" name="checkAll" id="checkAll"></td>
                                        <td><span class="tfoot-text">STT</span></td>
                                        <td><span class="tfoot-text">Mã sản phẩm</span></td>
                                        <td><span class="tfoot-text">Hình ảnh</span></td>
                                        <td><span class="tfoot-text">Tên sản phẩm</span></td>
                                        <td><span class="thead-text">Giá mới</span></td>
                                        <td><span class="thead-text">Giá cũ</span></td>
                                        <td><span class="tfoot-text">Danh mục</span></td>
                                        <td><span class="thead-text">Kho hàng</span></td>
                                        <td><span class="thead-text">Đã bán</span></td>
                                        <td><span class="tfoot-text">Trạng thái</span></td>
                                        <td><span class="tfoot-text">Người tạo</span></td>
                                        <td><span class="tfoot-text">Thời gian</span></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
            <div class="section" id="paging-wp">
                <div class="section-detail clearfix">
                    <p id="desc" class="fl-left">Chọn vào checkbox để lựa chọn tất cả</p>
                    <ul id="list-paging-pages" class="fl-right">
                        <?php
                            echo get_pagging($num_page, $page_num, "?mod=product&controller=index&action=index");
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
?>