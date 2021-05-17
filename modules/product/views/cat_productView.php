<?php
get_header();
$cat_id = $_GET['cat_id'];
$product_cat = db_fetch_assoc("SELECT `title` FROM `tbl_product_cat` WHERE `cat_id` = '{$cat_id}'");
if(isset($_POST['filter'])){
    $error = array();
    if(!empty($_POST['select'])){
        if($_POST['select'] == 1){
            $list_products = get_product_by_parent_cat($product_cat['title'], 'ORDER BY `product_title` ASC');
        }
        if($_POST['select'] == 2){
            $list_products = get_product_by_parent_cat($product_cat['title'], 'ORDER BY `product_title` DESC');
        }
        if($_POST['select'] == 3){
            $list_products = get_product_by_parent_cat($product_cat['title'], 'ORDER BY `product_price_new` DESC');
        }
        if($_POST['select'] == 4){
            $list_products = get_product_by_parent_cat($product_cat['title'], 'ORDER BY `product_price_new` ASC');
        }
    } else{
        $list_products = get_product_by_parent_cat($product_cat['title']);
        $error['filter'] = 'Bạn chưa lựa chọn tác vụ';
    }
} else{
    $list_products= get_product_by_parent_cat($product_cat['title']);
} 
 # Pagination
 if(!empty($list_products)){
    #Số bản ghi/trang
    $num_per_page = 8;
    #Tổng số bản ghi
    $total_row = count($list_products);
    #Số trang
    $num_page = ceil($total_row / $num_per_page);
    #chỉ số bắt đầu của trang
    $page_num = 1;
    $start = ($page_num - 1) * $num_per_page;
    $list_product_by_page = array_slice($list_products, $start, $num_per_page);
} else{
    $num_page = 0;
}
?>
<div id="main-content-wp" class="clearfix category-product-page">
    <div class="wp-inner">
        <div class="secion" id="breadcrumb-wp">
            <div class="secion-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="" title="">Sản phẩm</a>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="main-content fl-right">
            <div class="filter-wp fl-right">
                <p class="desc">Hiển thị <span id="num-filter"><?php if(!empty($total_row)){echo  $total_row;}else{ echo 0;} ?></span> sản phẩm trên <span id="num-page"><?php echo $num_page?></span> trang</p>
                <div class="form-filter">
                    <form method="POST" action="">
                        <select name="select" id="filter-arrange">
                            <option value="">Sắp xếp</option>
                            <option <?php if (isset($_POST['select']) && $_POST['select'] == 1) echo "selected='selected'"; ?> value="1">Từ A-Z</option>
                            <option <?php if (isset($_POST['select']) && $_POST['select'] == 2) echo "selected='selected'"; ?>  value="2">Từ Z-A</option>
                            <option <?php if (isset($_POST['select']) && $_POST['select'] == 3) echo "selected='selected'"; ?> value="3">Giá cao xuống thấp</option>
                            <option <?php if (isset($_POST['select']) && $_POST['select'] == 4) echo "selected='selected'"; ?> value="4">Giá thấp lên cao</option>
                        </select>
                        <button type="submit" name="filter">Lọc</button>
                        <?php echo form_error('filter')?>
                    </form>
                </div>
            </div>
            <div class="section" id="list-product-wp">
                <div class="section-head">
                    <h3 class="section-title" id="cat-title" cat-id='<?php echo $cat_id ?>'><?php echo $product_cat['title'] ?></h3>
                </div>
                <div id="result-product-cat">     
                    <div class="section-detail">
                    <?php if (!empty($list_product_by_page)) {
                            $error = array();
                        ?>       
                        <ul class="list-item clearfix" id="result-filter">
                            <?php foreach ($list_product_by_page as $product_by_cat) {
                                ?>
                            <li>
                                <a href="<?php echo $product_by_cat['slug'] ?>-<?php echo $product_by_cat['product_id'] ?>-i.html" title="" class="thumb">
                                    <img src="admin/<?php echo $product_by_cat['product_thumb'] ?>">
                                </a>
                                <a href="<?php echo $product_by_cat['slug'] ?>-<?php echo $product_by_cat['product_id'] ?>-i.html" title="" class="product-name"><?php echo $product_by_cat['product_title'] ?></a>
                                <div class="price">
                                    <span class="new"><?php echo currency_format($product_by_cat['product_price_new']) ?></span>
                                    <span class="old"><?php if(!empty($product_by_cat['product_price_old'])) echo currency_format($product_by_cat['product_price_old']) ?></span>
                                </div>
                                <div class="action clearfix">
                                    <a href="gio-hang-<?php echo $product_by_cat['product_id'] ?>-c.html" title="Thêm giỏ hàng" class="add-cart fl-left">Thêm giỏ hàng</a>
                                    <a href="dat-hang-<?php echo $product_by_cat['product_id'] ?>-b.html" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                                </div>
                            </li>
                            <?php
                                }
                            ?>
                        </ul>
                        <?php
                        } else {
                            $error['product_cat'] = 'Hiện không tồn tại sản phẩm '.$product_cat['title'].' nào!';
                        ?>
                            <p class="error"><?php echo  $error['product_cat'] ?></p>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="section" id="paging-wp">
                        <div class="section-detail" id="pagging-filter">
                            <ul class="list-item clearfix">
                                <?php
                                    if(!empty($list_products)) {echo get_pagging($num_page, $page_num);}
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php get_sidebar('product');?>
    </div>
</div>
<?php
get_footer();
?>
