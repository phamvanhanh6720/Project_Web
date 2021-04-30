<?php
get_header();
if(isset($_GET['post_id'])){
    $post_id = $_GET['post_id'];
    $parent_cat = get_info_post('parent_cat', $post_id);
}
$data_cat = db_fetch_array('SELECT* FROM `tbl_post_cat`');
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
                    <h3 id="index" class="fl-left">Cập nhật bài viết</h3>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <form method="POST" action="">
                        <?php echo form_error('post')?>
                        <label for="title">Tiêu đề</label>
                        <input type="text" name="title" id="title" value="<?php echo get_info_post('title', $post_id) ?>"> 
                        <?php echo form_error('title')?>
                        <label for="slug">Slug ( Friendly_url )</label>
                        <input type="text" name="slug" id="slug"  value="<?php echo get_info_post('slug', $post_id) ?>">
                        <?php echo form_error('slug')?>
                        <label for="desc">Nội dung bài viết</label>
                        <textarea name="post_content" id="desc" class="ckeditor"><?php echo get_info_post('post_content', $post_id) ?></textarea>
                        <?php echo form_error('post_content')?>
                        <label for="desc">Mô tả</label>
                        <textarea name="desc" id="desc" class="ckeditor"><?php echo get_info_post('post_desc', $post_id) ?></textarea>
                        <?php echo form_error('desc')?>
                        <label>Hình ảnh</label>
                        <div id="uploadFile">
                            <input type="file" name="file" id="upload-thumb" onchange="show_upload_image()">
                            <!-- <input type="submit" name="btn-upload-thumb" value="Upload" id="btn-upload-thumb"> -->
                            <img id="upload-image" src="<?php echo get_info_post('post_thumbnail', $post_id) ?>">
                        </div>
                        <?php echo form_error('upload_image')?>
                        <label>Danh mục cha</label>
                        <select name="parent_cat">
                            <option value="">-- Chọn danh mục --</option>
                            <?php if(!empty($list_cat)) foreach($list_cat as $cat){
                                ?>
                                <option <?php if(!empty($parent_cat) && $parent_cat == $cat['title']) echo "selected='selected'"; ?> value="<?php echo $cat['title']?>"><?php echo str_repeat('--', $cat['level']).' '.$cat['title']?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <?php echo form_error('parent_cat')?>
                        <button type="submit" name="btn-update-post" id="btn-submit">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
?>