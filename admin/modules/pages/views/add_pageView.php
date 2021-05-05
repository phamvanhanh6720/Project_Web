<?php
get_header();
?>
<div id="main-content-wp" class="add-cat-page">
    <div class="wrap clearfix">
        <?php get_sidebar(); ?>
        <div id="content" class="fl-right">      
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Thêm trang</h3>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <form method="POST"> 
                        <?php echo form_error('page')?>
                        <label for="title">Tiêu đề</label>
                        <input type="text" name="title" id="title" value="<?php  echo set_value('title') ?>">
                        <?php echo form_error('title')?>
                        <label for="slug">Slug ( Friendly_url )</label>
                        <input type="text" name="slug" id="slug"  value="<?php  echo set_value('slug') ?>">
                        <?php echo form_error('slug')?>
                        <label for="desc">Nội dung bài viết</label>
                        <textarea name="page_content" id="desc" class="ckeditor"><?php echo set_value('page_content') ?></textarea>
                        <?php echo form_error('page_content')?>
                        <label for="category">Danh  mục</label>
                        <select name = 'category'>
                            <option value="">Danh mục</option>
                            <option <?php if(!empty($_POST['category']) && $_POST['category'] == 'Giới thiệu') echo "selected='selected'"; ?> value="Giới thiệu">Giới thiệu</option>
                            <option <?php if(!empty($_POST['category']) && $_POST['category'] == 'Liên hệ') echo "selected='selected'"; ?> value="Liên hệ">Liên hệ</option>
                        </select>
                        <?php echo form_error('category')?>
                        <button type="submit" name="btn-add_page" id="btn-submit">Thêm mới</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
?>




