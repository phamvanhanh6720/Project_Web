<?php
get_header();
?>
<?php
if (!empty($_GET['product_id'])) {
    $product_id = (int)$_GET['product_id'];
    $parent_cat = get_info_product('parent_cat', $product_id);
    $list_products_by_cat = get_product_by_parent_cat_unseted($product_id, $parent_cat);
    $num_product = get_info_product('num_product', $product_id);
    $sold_product = get_info_product('sold_product', $product_id);
}
?>
<div id="main-content-wp" class="clearfix detail-product-page">
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
            <div class="section" id="detail-product-wp">
                <div class="section-detail clearfix">
                    <div class="thumb-wp fl-left customize-zoom">
                        <a href="" title="" id="main-thumb">
                            <img id="zoom" width="350px" height="280px" src="admin/<?php echo get_info_product('product_thumb', $product_id); ?>" data-zoom-image="admin/<?php echo get_info_product('product_thumb', $product_id); ?>" />
                        </a>
                        <div id="overlay" class="zoomImage" style="display: none;"></div>
                        <!-- <div id="list-thumb">
                            <a href="" data-image="admin/<?php echo get_info_product('product_thumb', $product_id); ?>" data-zoom-image="admin/<?php echo get_info_product('product_thumb', $product_id); ?>">
                                <img id="zoom" src="admin/<?php echo get_info_product('product_thumb', $product_id); ?>" />
                            </a>
                            <a href="" data-image="admin/<?php echo get_info_product('product_thumb', $product_id); ?>" data-zoom-image="admin/<?php echo get_info_product('product_thumb', $product_id); ?>">
                                <img id="zoom" src="admin/<?php echo get_info_product('product_thumb', $product_id); ?>" />
                            </a>
                            <a href="" data-image="admin/<?php echo get_info_product('product_thumb', $product_id); ?>" data-zoom-image="admin/<?php echo get_info_product('product_thumb', $product_id); ?>">
                                <img id="zoom" src="admin/<?php echo get_info_product('product_thumb', $product_id); ?>" />
                            </a>
                            <a href="" data-image="admin/<?php echo get_info_product('product_thumb', $product_id); ?>" data-zoom-image="admin/<?php echo get_info_product('product_thumb', $product_id); ?>">
                                <img id="zoom" src="admin/<?php echo get_info_product('product_thumb', $product_id); ?>" />
                            </a>
                            <a href="" data-image="admin/<?php echo get_info_product('product_thumb', $product_id); ?>" data-zoom-image="admin/<?php echo get_info_product('product_thumb', $product_id); ?>">
                                <img id="zoom" src="admin/<?php echo get_info_product('product_thumb', $product_id); ?>" />
                            </a>
                            <a href="" data-image="admin/<?php echo get_info_product('product_thumb', $product_id); ?>" data-zoom-image="admin/<?php echo get_info_product('product_thumb', $product_id); ?>">
                                <img id="zoom" src="admin/<?php echo get_info_product('product_thumb', $product_id); ?>" />
                            </a>
                        </div> -->
                    </div>
                    <div class="thumb-respon-wp fl-left">
                        <img src="admin/<?php echo get_info_product('product_thumb', $product_id); ?>" alt="">
                    </div>
                    <div class="info fl-right">
                        <h3 class="product-name"><?php echo get_info_product('product_title', $product_id); ?></h3>
                        <div class="desc">
                            <?php echo get_info_product('product_desc', $product_id); ?>
                        </div>
                        <div class="num-product">
                            <span class="title">Sản phẩm: </span>
                            <span class="status"><?php if ($sold_product >= $num_product) {
                                                        echo "Hết hàng";
                                                    } else {
                                                        echo "Còn hàng";
                                                    } ?></span>
                        </div>
                        <p class="price"><?php echo currency_format(get_info_product('product_price_new', $product_id)); ?></p>
                        <form method="POST" id="num-order-wp" action="?mod=cart&action=add_cart&product_id=<?php echo $product_id ?>">
                            <a title="" id="minus"><i class="fa fa-minus"></i></a>
                            <input type="text" name="num-order" value="1" id="num-order">
                            <a title="" id="plus"><i class="fa fa-plus"></i></a>
                            <hr>
                            <input type="submit" value="Thêm giỏ hàng" class="add-cart">
                        </form>
                    </div>
                </div>
            </div>
            <div class="section" id="post-product-wp">
                <div class="section-head">
                    <h3 class="section-title">Mô tả sản phẩm</h3>
                </div>
                <div class="section-detail">
                    <?php echo get_info_product('product_content', $product_id); ?>
                </div>
            </div>
            <div class="section" id="same-category-wp">
                <div class="section-head">
                    <h3 class="section-title">Cùng chuyên mục</h3>
                </div>
                <div class="change_slide">
                    <button class="btn fa fa-chevron-left" onclick="prev()"></button>
                    <button class="btn fa fa-chevron-right" onclick="next()"></button>
                </div>
                <div class="section-detail item_slider">
                    <?php if (!empty($list_products_by_cat)) {
                    ?>
                        <ul class="list-item" id="item_slides">
                            <?php foreach ($list_products_by_cat as $product_by_cat) {
                            ?>
                                <li>
                                    <a href="<?php echo $product_by_cat['slug'] ?>-<?php echo $product_by_cat['product_id'] ?>-i.html" title="" class="thumb">
                                        <img src="admin/<?php echo $product_by_cat['product_thumb'] ?>">
                                    </a>
                                    <a href="<?php echo $product_by_cat['slug'] ?>-<?php echo $product_by_cat['product_id'] ?>-i.html" title="" class="product-name"><?php echo $product_by_cat['product_title'] ?></a>
                                    <div class="price">
                                        <span class="new"><?php echo currency_format($product_by_cat['product_price_new']); ?></span>
                                        <span class="old"><?php if (!empty($product_by_cat['product_price_old'])) echo currency_format($product_by_cat['product_price_old']); ?></span>
                                    </div>
                                    <div class="action clearfix">
                                        <a href="gio-hang-<?php echo $product_by_cat['product_id'] ?>-c.html" title="" class="add-cart fl-left">Thêm giỏ hàng</a>
                                        <a href="dat-hang-<?php echo $product_by_cat['product_id'] ?>-b.html" title="" class="buy-now fl-right">Mua ngay</a>
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
        </div>
        <?php get_sidebar(); ?>
    </div>
</div>
<?php
get_footer();
?>