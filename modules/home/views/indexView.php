<?php
get_header();
$list_products = db_fetch_array("SELECT* FROM `tbl_products` ORDER BY `product_id` DESC");
$list_product_cat = db_fetch_array("SELECT* FROM `tbl_product_cat` WHERE `parent_id` = 0");

$list_slider = db_fetch_array("SELECT* FROM `tbl_sliders`");
$list_product_pro = get_list_product_pro($list_products);
?>
<div id="main-content-wp" class="home-page clearfix">
    <div class="wp-inner">
        <div class="main-content fl-right">
            <div class="slider">
                <?php if (!empty($list_slider)) {
                    $count = 1;
                ?>
                    <div class="slides">
                        <input type="radio" name="radio-btn" id="radio1">
                        <input type="radio" name="radio-btn" id="radio2">
                        <input type="radio" name="radio-btn" id="radio3">
                        <?php foreach ($list_slider as $slider) {
                            if ($count > 1) {
                        ?>
                                <div class="slide">
                                    <img src="admin/<?php echo $slider['slider_thumb'] ?>" alt="">
                                </div>
                            <?php
                            } else {
                                $count = $count + 1;
                            ?>
                                <div class="slide first">
                                    <img src="admin/<?php echo $slider['slider_thumb'] ?>" alt="">
                                </div>
                        <?php
                            }
                        }
                        ?>

                        <div class="navigation-auto">
                            <div class="auto-btn1"></div>
                            <div class="auto-btn2"></div>
                            <div class="auto-btn3"></div>
                        </div>

                        <div class="navigation-manual">
                            <label for="radio1" class="manual-btn"></label>
                            <label for="radio2" class="manual-btn"></label>
                            <label for="radio3" class="manual-btn"></label>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
            <div class="section" id="support-wp">
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <div class="thumb">
                                <img src="public/images/icon-1.png">
                            </div>
                            <h3 class="title">Miễn phí vận chuyển</h3>
                            <p class="desc">Tới tận tay khách hàng</p>
                        </li>
                        <li>
                            <div class="thumb">
                                <img src="public/images/icon-2.png">
                            </div>
                            <h3 class="title">Tư vấn 24/7</h3>
                            <p class="desc">1900.9999</p>
                        </li>
                        <li>
                            <div class="thumb">
                                <img src="public/images/icon-3.png">
                            </div>
                            <h3 class="title">Tiết kiệm hơn</h3>
                            <p class="desc">Với nhiều ưu đãi cực lớn</p>
                        </li>
                        <li>
                            <div class="thumb">
                                <img src="public/images/icon-4.png">
                            </div>
                            <h3 class="title">Thanh toán nhanh</h3>
                            <p class="desc">Hỗ trợ nhiều hình thức</p>
                        </li>
                        <li>
                            <div class="thumb">
                                <img src="public/images/icon-5.png">
                            </div>
                            <h3 class="title">Đặt hàng online</h3>
                            <p class="desc">Thao tác đơn giản</p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="section" id="feature-product-wp">
                <div class="section-head">
                    <h3 class="section-title">Sản phẩm nổi bật</h3>
                </div>
                <div class="change_slide">
                    <button class="btn fa fa-chevron-left" onclick="prev()"></button>
                    <button class="btn fa fa-chevron-right" onclick="next()"></button>
                </div>
                <div class="section-detail item_slider">
                    <?php if (!empty($list_product_pro)) {
                    ?>
                        <ul class="list-item" id="item_slides">
                            <?php foreach ($list_product_pro as $product_pro) {
                            ?>
                                <li>
                                    <a href="<?php echo $product_pro['slug'] ?>-<?php echo $product_pro['product_id'] ?>-i.html" title="" class="thumb">
                                        <img src="admin/<?php echo $product_pro['product_thumb'] ?>">
                                    </a>
                                    <a href="<?php echo $product_pro['slug'] ?>-<?php echo $product_pro['product_id'] ?>-i.html" title="" class="product-name"><?php echo $product_pro['product_title'] ?></a>
                                    <div class="price">
                                        <span class="new"><?php echo currency_format($product_pro['product_price_new']) ?></span>
                                        <span class="old"><?php echo currency_format($product_pro['product_price_old']) ?></span>
                                    </div>
                                    <div class="action clearfix">
                                        <a href="gio-hang-<?php echo $product_pro['product_id'] ?>-c.html" title="" class="add-cart fl-left">Thêm giỏ hàng</a>
                                        <a href="thanh-toan-<?php echo $product_pro['product_id'] ?>-b.html" title="" class="buy-now fl-right">Mua ngay</a>
                                    </div>
                                </li>
                            <?php
                            }
                            ?>
                        </ul>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <?php if (!empty($list_product_cat)) {
            ?>
                <?php foreach ($list_product_cat as $product_cat) {
                    // $list_products_by_cat= get_product_by_parent_cat($product_cat['title']);
                    # Get products by cat and created date near
                    $list_products_by_cat = db_fetch_array("SELECT * FROM `tbl_products` WHERE `parent_cat`= '{$product_cat['title']}' ORDER BY `created_date` DESC");
                    # Get products by cat has price old
                    $list_products_by_cat_pro = get_list_product_pro($list_products_by_cat);
                    # Get products by cat has lim
                    if (!empty($list_products_by_cat_pro)) {
                        $list_products_by_cat_pro_lim = array_slice($list_products_by_cat_pro, 0, 8);
                    } else {
                        $list_products_by_cat_pro_lim = $list_products_by_cat_pro;
                    }
                ?>
                    <div class="section" id="list-product-wp">
                        <div class="section-head">
                            <h3 class="section-title"><?php echo $product_cat['title'] ?> nổi bật</h3>
                        </div>
                        <div class="section-detail">
                            <?php if (!empty($list_products_by_cat_pro_lim)) {
                                $error = array();
                            ?>
                                <ul class="list-item clearfix">
                                    <?php foreach ($list_products_by_cat_pro_lim as $product_by_cat_pro) {
                                    ?>
                                        <li>
                                            <a href="<?php echo $product_by_cat_pro['slug'] ?>-<?php echo $product_by_cat_pro['product_id'] ?>-i.html" title="" class="thumb">
                                                <img src="admin/<?php echo $product_by_cat_pro['product_thumb'] ?>">
                                            </a>
                                            <a href="<?php echo $product_by_cat_pro['slug'] ?>-<?php echo $product_by_cat_pro['product_id'] ?>-i.html" title="" class="product-name"><?php echo $product_by_cat_pro['product_title'] ?></a>
                                            <div class="price">
                                                <span class="new"><?php echo currency_format($product_by_cat_pro['product_price_new']) ?></span>
                                                <span class="old"><?php echo currency_format($product_by_cat_pro['product_price_old']) ?></span>
                                            </div>
                                            <div class="action clearfix">
                                                <a href="gio-hang-<?php echo $product_by_cat_pro['product_id'] ?>-c.html" title="Thêm giỏ hàng" class="add-cart fl-left">Thêm giỏ hàng</a>
                                                <a href="dat-hang-<?php echo $product_by_cat_pro['product_id'] ?>-b.html" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                                            </div>
                                        </li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                            <?php
                            } else {
                                $error['product_cat'] = 'Hiện không tồn tại sản phẩm ' . $product_cat['title'] . ' nổi bật nào!';
                            ?>
                                <p class="error"><?php echo  $error['product_cat'] ?></p>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                <?php
                }
                ?>
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