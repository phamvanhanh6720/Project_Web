<?php
# search product and get list products
global $value, $list_all_products_search;
if (isset($_GET['value'])) {
    if (!empty($_GET['value'])) {
        $value = $_GET['value'];
    }
}
$list_cat_all_search = get_list_cat_all_search($value);
$list_all_products_search = db_search_all_products($value);
?>
<?php
get_header();
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
                <p class="desc">Hiển thị <?php echo count($list_all_products_search) ?> sản phẩm</p>
                <div class="form-filter">
                    <form method="POST" action="loc-<?php echo $value ?>.html">
                        <select name="select" id="filter-arrange">
                            <option value="">Sắp xếp</option>
                            <option <?php if (isset($_POST['select']) && $_POST['select'] == 1) echo "selected='selected'"; ?> value="1">Từ A-Z</option>
                            <option <?php if (isset($_POST['select']) && $_POST['select'] == 2) echo "selected='selected'"; ?> value="2">Từ Z-A</option>
                            <option <?php if (isset($_POST['select']) && $_POST['select'] == 3) echo "selected='selected'"; ?> value="3">Giá cao xuống thấp</option>
                            <option <?php if (isset($_POST['select']) && $_POST['select'] == 4) echo "selected='selected'"; ?> value="4">Giá thấp lên cao</option>
                        </select>
                        <button type="submit" name="filter">Lọc</button>
                        <?php echo form_error('filter') ?>
                    </form>
                </div>
            </div>
            <?php if (!empty($list_cat_all_search)) {
            ?>
                <?php foreach ($list_cat_all_search as $product_cat) {
                    $cat_id = get_cat_id_by_cat($product_cat['parent_cat']);
                    if (isset($_POST['filter'])) {
                        $error = array();
                        if (!empty($_POST['select'])) {
                            if ($_POST['select'] == 1) {
                                $list_products_by_cat = get_list_all_products_search_by_cat($product_cat['parent_cat'], $value, 'ORDER BY `product_title` ASC');
                            }
                            if ($_POST['select'] == 2) {
                                $list_products_by_cat = get_list_all_products_search_by_cat($product_cat['parent_cat'], $value, 'ORDER BY `product_title` DESC');
                            }
                            if ($_POST['select'] == 3) {
                                $list_products_by_cat = get_list_all_products_search_by_cat($product_cat['parent_cat'], $value, 'ORDER BY `product_price_new` DESC');
                            }
                            if ($_POST['select'] == 4) {
                                $list_products_by_cat = get_list_all_products_search_by_cat($product_cat['parent_cat'], $value, 'ORDER BY `product_price_new` ASC');
                            }
                        } else {
                            $list_products_by_cat = get_list_all_products_search_by_cat($product_cat['parent_cat'], $value);
                            $error['filter'] = 'Bạn chưa lựa chọn tác vụ';
                        }
                    } else {
                        $list_products_by_cat = get_list_all_products_search_by_cat($product_cat['parent_cat'], $value);
                    }
                    # Pagination
                    #Số bản ghi/trang
                    $num_per_page = 8;
                    #Tổng số bản ghi
                    $total_row = count($list_products_by_cat);
                    #Số trang
                    $num_page = ceil($total_row / $num_per_page);
                    #chỉ số bắt đầu của trang
                    $page_num = 1;
                    $start = ($page_num - 1) * $num_per_page;
                    $list_product_by_page = array_slice($list_products_by_cat, $start, $num_per_page);
                ?>
                    <div class="section" id="list-product-wp">
                        <div class="section-head">
                            <h3 class="section-title"><?php echo $product_cat['parent_cat'] ?></h3>
                        </div>
                        <div id='<?php echo $cat_id ?>'>
                            <div class="section-detail">
                                <?php if (!empty($list_product_by_page)) {
                                    $error = array();
                                ?>
                                    <ul class="list-item clearfix">
                                        <?php foreach ($list_product_by_page as $product_by_cat) {
                                        ?>
                                            <li>
                                                <a href="<?php echo $product_by_cat['slug'] ?>-<?php echo $product_by_cat['product_id'] ?>-i.html" title="" class="thumb">
                                                    <img src="admin/<?php echo $product_by_cat['product_thumb'] ?>">
                                                </a>
                                                <a href="<?php echo $product_by_cat['slug'] ?>-<?php echo $product_by_cat['product_id'] ?>-i.html" title="" class="product-name"><?php echo $product_by_cat['product_title'] ?></a>
                                                <div class="price">
                                                    <span class="new"><?php echo currency_format($product_by_cat['product_price_new']) ?></span>
                                                    <span class="old"><?php if (!empty($product_by_cat['product_price_old'])) echo currency_format($product_by_cat['product_price_old']) ?></span>
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
                                    $error['product_cat'] = 'Hiện không tồn tại sản phẩm ' . $product_cat['parent_cat'] . ' nào!';
                                ?>
                                    <p class="error"><?php echo  $error['product_cat'] ?></p>
                                <?php
                                }
                                ?>
                            </div>
                            <div class="section" id="paging-wp">
                                <div class="section-detail">
                                    <ul class="list-item clearfix">
                                        <?php
                                        echo get_pagging_search($num_page, $page_num, $cat_id, $value);
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            <?php
            } else {
                $error['product_cat'] = 'Không tìm thấy sản phẩm nào!';
            ?>
                <p class="error"><?php echo  $error['product_cat'] ?></p>
            <?php
            }
            ?>
        </div>
        <?php get_sidebar(); ?>
    </div>
</div>
<?php
get_footer();
?>