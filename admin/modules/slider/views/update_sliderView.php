<?php
get_header();
if (isset($_GET['slider_id'])) {
    $slider_id = $_GET['slider_id'];
    $slider_status = get_info_slider('slider_status', $slider_id);
    // echo $slider_status;
}
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
                        <input type="text" name="title" id="title" value="<?php echo get_info_slider('slider_title', $slider_id) ?>">
                        <?php echo form_error('title')?>
                        <label for="title">Link</label>
                        <input type="text" name="slug" id="slug" value="<?php echo get_info_slider('slider_slug', $slider_id) ?>">
                        <?php echo form_error('slug')?>
                        <label for="desc">Mô tả</label>
                        <textarea name="desc" id="desc" class="ckeditor"><?php echo get_info_slider('slider_desc', $slider_id) ?></textarea>
                        <?php echo form_error('desc')?>
                        <label for="title">Thứ tự</label>
                        <input type="text" name="num_order" id="num-" value="<?php echo get_info_slider('slider_ordinal', $slider_id) ?>">
                        <?php echo form_error('num_order')?>
                        <label>Hình ảnh</label>
                        <div id="uploadFile" >
                            <input type="file" name="file" id="upload-thumb" onchange="show_upload_image()">
                            <img id="upload-image" src="<?php echo get_info_slider('slider_thumb', $slider_id) ?>">
                        </div>
                        <?php echo form_error('upload_image')?>
                        <?php
                        if (is_login() && check_role($_SESSION['user_login']) == 1) {
                            ?>
                            <label>Trạng thái</label>
                            <select name="status">
                                <option value="">-- Chọn trạng thái --</option>
                                <option <?php if(!empty($slider_status) && $slider_status == '1') echo "selected='selected'"; ?> value="1">Công khai</option>
                                <option <?php if(!empty($slider_status) && $slider_status == '2') echo "selected='selected'"; ?> value="2">Chờ duyệt</option>
                            </select>
                            <?php echo form_error('status')?> 
                            <?php
                        }
                        ?>
                        <button type="submit" name="btn-update-slider" id="btn-submit">CẬP NHẬT</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
?>