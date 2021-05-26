<?php
get_header();
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $brand = get_info_product('brand', $product_id);
    $parent_cat = get_info_product('parent_cat', $product_id);
    $product_type = get_info_product('product_type', $product_id);
}
$list_parent_cat = db_fetch_array('SELECT* FROM `tbl_product_cat` WHERE `parent_id` = 0');
$list_brands = db_fetch_array("SELECT DISTINCT `brand` FROM `tbl_products` WHERE `parent_cat` = '{$parent_cat}'");
$list_product_types = db_fetch_array("SELECT DISTINCT `product_type` FROM `tbl_products` WHERE `product_type` = '{$product_type}'");
// show_array($list_brands);
$data_cat = db_fetch_array('SELECT* FROM `tbl_product_cat`');
$list_cat = data_tree($data_cat, 0);
?>
<div id="main-content-wp" class="add-cat-page">
    <div class="wrap clearfix">
        <?php
        get_sidebar();
        ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Cập nhật sản phẩm</h3>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <form method="POST" enctype="multipart/form-data">
                        <?php echo form_error('product') ?>
                        <label for="title">Tên sản phẩm</label>
                        <input type="text" name="title" id="title" value="<?php echo get_info_product('product_title', $product_id) ?>">
                        <?php echo form_error('title') ?>
                        <label for="product-code">Mã sản phẩm</label>
                        <input type="text" name="product_code" id="product-code" value="<?php echo get_info_product('product_code', $product_id) ?>">
                        <?php echo form_error('product_code') ?>
                        <label for="slug">Slug ( Friendly_url )</label>
                        <input type="text" name="slug" id="slug" value="<?php echo get_info_product('slug', $product_id) ?>">
                        <?php echo form_error('slug') ?>
                        <label for="price_new">Giá sản phẩm (mới)</label>
                        <input type="text" name="price_new" id="price_new" value="<?php echo get_info_product('product_price_new', $product_id) ?>">
                        <?php echo form_error('price_new') ?>
                        <label for="price_old">Giá cũ</label>
                        <input type="text" name="price_old" id="price_old" value="<?php echo get_info_product('product_price_old', $product_id) ?>">
                        <?php echo form_error('price_old') ?>
                        <label for="num_product">Số lượng</label>
                        <input type="text" name="num_product" id="num_product" value="<?php echo get_info_product('num_product', $product_id) ?>">
                        <label for="desc">Mô tả ngắn</label>
                        <textarea name="desc" id="desc"><?php echo get_info_product('product_desc', $product_id) ?></textarea>
                        <?php echo form_error('desc') ?>
                        <label for="content">Chi tiết</label>
                        <textarea name="content" id="desc" class="ckeditor"><?php echo get_info_product('product_content', $product_id) ?></textarea>
                        <?php echo form_error('content') ?>
                        <label>Hình ảnh</label>
                        <div id="uploadFile">
                            <input type="file" name="file" id="upload-thumb" onchange="show_upload_image()">
                            <img id="upload-image" src="<?php echo get_info_product('product_thumb', $product_id) ?>">
                        </div>
                        <?php echo form_error('upload_image') ?>
                        <label>Danh mục sản phẩm</label>
                        <select name="parent_cat" class="select-parent-cat">
                            <option value="">-- Chọn danh mục --</option>
                            <?php if(!empty($list_parent_cat)) foreach($list_parent_cat as $cat){
                                ?>
                                <option <?php if(!empty($parent_cat) && $parent_cat == $cat['title']) echo "selected='selected'"; ?> value="<?php echo $cat['title']?>"><?php echo $cat['title']?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <?php echo form_error('parent_cat') ?>
                        <label>Thương hiệu</label>
                        <select name="brand" class="select-brand">
                            <option value="">-- Chọn thương hiệu --</option>
                            <?php if(!empty($list_brands)) foreach($list_brands as $item){
                                ?>
                                <option <?php if(!empty($brand) && $brand == $item['brand']) echo "selected='selected'"; ?> value="<?php echo $item['brand']?>"><?php echo $item['brand']?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <?php echo form_error('brand')?> 
                        <label>Loại sản phẩm</label>
                        <select name="type" class="select-type">
                            <option value="">-- Chọn loại sản phẩm --</option>
                            <?php if(!empty($list_product_types)) foreach($list_product_types as $item){
                                ?>
                                <option <?php if(!empty($product_type) && $product_type == $item['product_type']) echo "selected='selected'"; ?> value="<?php echo $item['product_type']?>"><?php echo $item['product_type']?></option>
                                <?php
                            }
                            ?>                           
                        </select>
                        <?php echo form_error('type')?> 
                        <button type="submit" name="btn-update-product" id="btn-submit">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
?>