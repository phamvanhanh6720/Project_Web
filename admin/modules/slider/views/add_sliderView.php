<?php
get_header();
?>
<div id="main-content-wp" class="add-cat-page slider-page">
    <div class="wrap clearfix">
        <?php
            get_sidebar();
        ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Thêm Slider</h3>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <form method="POST" enctype="multipart/form-data">
                        <?php echo form_error('slider')?>
                        <label for="title">Tên slider</label>
                        <input type="text" name="title" id="title" value="<?php echo set_value('title') ?>">
                        <?php echo form_error('title')?>
                        <label for="title">Link</label>
                        <input type="text" name="slug" id="slug" value="<?php  echo set_value('slug') ?>">
                        <?php echo form_error('slug')?>
                        <label for="desc">Mô tả</label>
                        <textarea name="desc" id="desc" class="ckeditor"><?php  echo set_value('desc') ?></textarea>
                        <?php echo form_error('desc')?>
                        <label for="title">Thứ tự</label>
                        <input type="text" name="num_order" id="num-" value="<?php  echo set_value('num_order') ?>">
                        <?php echo form_error('num_order')?>
                        <label>Hình ảnh</label>
                        <div id="uploadFile" >
                            <input type="file" name="file" id="upload-thumb" onchange="show_upload_image()">
                            <input type="submit" name="btn-upload-thumb" value="Upload" id="btn-upload-thumb">
                            <img id="upload-image" src="public/images/<?php if(isset($_FILES['file']) && !empty($_FILES['file']['name'])){ echo 'upload/sliders/'.$_FILES['file']['name'];} else{ echo 'img-thumb.png';}?>">
                        </div>
                        <?php echo form_error('upload_image')?>
                        <?php
                        if (is_login() && check_role($_SESSION['user_login']) == 1) {
                            ?>
                            <label>Trạng thái</label>
                            <select name="status">
                                <option value="">-- Chọn trạng thái --</option>
                                <option <?php if(!empty($_POST['status']) && $_POST['status'] == '1') echo "selected='selected'"; ?> value="1">Công khai</option>
                                <option <?php if(!empty($_POST['status']) && $_POST['status'] == '2') echo "selected='selected'"; ?> value="2">Chờ duyệt</option>
                            </select>
                            <?php echo form_error('status')?> 
                            <?php
                        }
                        ?>
                        <button type="submit" name="btn-add-slider" id="btn-submit">THÊM SILDER</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
?>