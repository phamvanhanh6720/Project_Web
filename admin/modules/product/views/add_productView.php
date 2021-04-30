<?php
get_header();
$parent_cat = db_fetch_array('SELECT* FROM `tbl_product_cat` WHERE `parent_id` = 0');
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
                    <h3 id="index" class="fl-left">Thêm sản phẩm</h3>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <form method="POST" enctype="multipart/form-data">
                        <?php echo form_error('product')?>
                        <label for="title">Tên sản phẩm</label>
                        <input type="text" name="title" id="title" value="<?php  echo set_value('title') ?>">
                        <?php echo form_error('title')?>
                        <label for="product-code">Mã sản phẩm</label>
                        <input type="text" name="product_code" id="product-code" value="<?php  echo set_value('product_code') ?>">
                        <?php echo form_error('product_code')?>
                        <label for="slug">Slug ( Friendly_url )</label>
                        <input type="text" name="slug" id="slug"  value="<?php  echo set_value('slug') ?>">
                        <?php echo form_error('slug')?>
                        <label for="price_new">Giá sản phẩm (Mới)</label>
                        <input type="text" name="price_new" id="price_new" value="<?php echo set_value('product_price_new') ?>">
                        <?php echo form_error('price_new')?>
                        <label for="price_old">Giá cũ</label>
                        <input type="text" name="price_old" id="price_old" value="<?php echo set_value('product_price_old') ?>">
                        <?php echo form_error('price_old')?>
                        <label for="num_product">Số lượng</label>
                        <input type="text" name="num_product" id="num_product" value="<?php echo set_value('num_product') ?>">
                        <?php echo form_error('num_product')?>
                        <label for="desc">Mô tả ngắn</label>
                        <textarea name="desc" id="desc"><?php echo set_value('desc') ?></textarea>
                        <?php echo form_error('desc')?>
                        <label for="content">Chi tiết</label>
                        <textarea name="content" id="desc" class="ckeditor"><?php echo set_value('content') ?></textarea>
                        <?php echo form_error('content')?>
                        <label>Hình ảnh</label>
                        <div id="uploadFile">
                            <input type="file" name="file" id="upload-thumb" onchange="show_upload_image()">
                            <input type="submit" name="btn-upload-thumb" value="Upload" id="btn-upload-thumb">
                            <img id="upload-image" src="public/images/upload/products/<?php if(isset($_FILES['file']) && !empty($_FILES['file']['name'])){ echo $_FILES['file']['name'];} else{ echo 'img-thumb.png';}?>">
                        </div>
                        <?php echo form_error('upload_image')?>
                        <label>Danh mục sản phẩm</label>
                        <select name="parent_cat" class="select-parent-cat">
                            <option value="">-- Chọn mục danh mục --</option>
                            <?php if(!empty($parent_cat)) foreach($parent_cat as $cat){
                                ?>
                                <option value="<?php echo $cat['title']?>"><?php echo $cat['title']?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <?php echo form_error('parent_cat')?> 
                        <label>Thương hiệu</label>
                        <select name="brand" class="select-brand">
                            <option value="">-- Chọn thương hiệu --</option>
                        </select>
                        <?php echo form_error('brand')?> 
                        <label>Loại sản phẩm</label>
                        <select name="type" class="select-type">
                            <option value="">-- Chọn loại sản phẩm --</option>                           
                        </select>
                        <?php echo form_error('type')?> 
                        <button type="submit" name="btn-add-product" id="btn-submit">Thêm mới</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
?>