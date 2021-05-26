<?php
get_header();
$data_cat = db_fetch_array('SELECT* FROM `tbl_product_cat`');
$list_cat = data_tree($data_cat, 0);
// show_array($list_cat);
?>
<div id="main-content-wp" class="add-cat-page">
    <div class="wrap clearfix">
        <?php
            get_sidebar();   
        ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Thêm mới danh mục</h3>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <form method="POST">
                        <?php echo form_error('cat')?>
                        <label for="title">Tên danh mục</label>
                        <input type="text" name="title" id="title" value="<?php  echo set_value('title') ?>">
                        <?php echo form_error('title')?>
                        <label for="slug">Slug ( Friendly_url )</label>
                        <input type="text" name="slug" id="slug" value="<?php  echo set_value('slug') ?>">
                        <?php echo form_error('slug')?>
                        <label>Danh mục cha</label>
                        <select name="parent_id">
                            <option <?php if(!empty($_POST['parent_id']) && $_POST['parent_id'] == 0) echo "selected='selected'"; ?> value="0">Danh mục cha</option>
                            <?php if(!empty($list_cat)) foreach($list_cat as $cat){
                                ?>
                                <option <?php if(!empty($_POST['parent_id']) && $_POST['parent_id'] == $cat['cat_id']) echo "selected='selected'"; ?> value="<?php echo $cat['cat_id']?>"><?php echo str_repeat('--', $cat['level']).' '.$cat['title']?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <?php echo form_error('parent_id')?>
                        <button type="submit" name="btn-add-cat" id="btn-submit">Thêm mới</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
?>