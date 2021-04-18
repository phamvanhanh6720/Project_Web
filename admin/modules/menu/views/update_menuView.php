<?php
get_header();
?>
<?php
if(isset($_GET['menu_id'])){
    $menu_id = $_GET['menu_id'];
}
// Category pages
$list_pages = db_fetch_array("SELECT* FROM `tbl_pages`");
// Category products
$data_product_cat = db_fetch_array('SELECT* FROM `tbl_product_cat`');
$list_product_cat_all = data_tree($data_product_cat, 0);
// Category posts
$data_post_cat = db_fetch_array('SELECT* FROM `tbl_post_cat`');
$list_post_cat_all = data_tree($data_post_cat, 0);
// Category posts
$data_menu = db_fetch_array('SELECT* FROM `tbl_menus`');
// $list_menus = data_tree($data_menu, 0);
// Menu
$list_menus = db_fetch_array("SELECT* FROM `tbl_menus`");
?>
<div id="main-content-wp" class="add-cat-page menu-page">
    <div class="section" id="title-page">
        <div class="clearfix">
            <a href="?mod=menu&action=index" title="" id="add-new" class="fl-left">Thêm mới</a>
            <h3 id="index" class="fl-left">Menu</h3>
        </div>
    </div>
    <div class="wrap clearfix">
        <?php
        get_sidebar();
        ?>
        <div id="content" class="fl-right">
            <div class="section-detail clearfix">
                <div id="list-menu" class="fl-left">
                    <?php echo form_error('menu')?>
                    <form  method="POST" action="">
                        <div class="form-group">
                            <label for="title">Tên menu</label>
                            <input type="text" name="title" id="title" value="<?php echo get_info_menu('menu_title', $menu_id) ?>">
                        </div>
                        <p class='mess_error'><?php echo form_error('title')?></p>
                        <div class="form-group">
                            <label for="url-static">Đường dẫn tĩnh</label>
                            <input type="text" name="url_static" id="url-static" value="<?php echo get_info_menu('menu_url_static', $menu_id) ?>">
                            <p>Chuỗi đường dẫn tĩnh cho menu</p>
                        </div>
                        <p class='mess_error'><?php echo form_error('url_static')?></p>  
                        <div class="form-group clearfix">
                            <label>Trang</label>
                            <?php if(!empty($list_pages)){
                            ?>
                                <select name="page_slug">
                                    <option value="0">-- Chọn --</option>
                                    <?php foreach($list_pages as $page){
                                        $page_slug = get_info_menu('page_slug', $menu_id);
                                        ?>
                                    <option <?php if(!empty($page_slug) && $page_slug == $page['title']) echo "selected='selected'"; ?> value="<?php echo $page['title'] ?>"><?php echo $page['title'] ?></option>
                                    <?php
                                        }
                                        ?>
                                </select> 
                            <?php
                            }
                            ?>
                            <p>Trang liên kết đến menu</p>
                        </div>
                        <div class="form-group clearfix">
                            <label>Danh mục sản phẩm</label>
                            <?php if(!empty($list_product_cat_all)){
                                ?>
                            <select name="product_id">
                                <option value="0">-- Chọn --</option>
                                <?php foreach($list_product_cat_all as $prodcut_cat){
                                     $product_id = get_info_menu('product_id', $menu_id);
                                    ?>
                                    <option <?php if(!empty($product_id) && $product_id == $prodcut_cat['title']) echo "selected='selected'"; ?> value="<?php echo $prodcut_cat['title']?>"><?php echo str_repeat('--', $prodcut_cat['level']).' '.$prodcut_cat['title']?></option>
                                <?php
                                }
                                ?>
                            </select> 
                            <?php
                            }
                            ?>
                            <p>Danh mục sản phẩm liên kết đến menu</p>
                        </div>
                        <div class="form-group clearfix">
                            <label>Danh mục bài viết</label>
                            <select name="post_id">
                                <option value="0">-- Chọn --</option>
                                <?php foreach($list_post_cat_all as $post_cat){
                                     $post_id = get_info_menu('post_id', $menu_id);
                                    ?>
                                    <option <?php if(!empty($post_id) && $post_id == $post_cat['title']) echo "selected='selected'"; ?> value="<?php echo $post_cat['title']?>"><?php echo str_repeat('--', $post_cat['level']).' '.$post_cat['title']?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <p>Danh mục bài viết liên kết đến menu</p>
                        </div>

                        <div class="form-group">
                            <label for="menu-order">Thứ tự</label>
                            <input type="text" name="menu_order" id="menu-order" value="<?php echo get_info_menu('menu_order', $menu_id) ?>">
                        </div>
                        <?php echo form_error('menu_order')?>
                        <br>
                        <div class="form-group">
                            <button type="submit" name="btn-update-menu" id="btn-save-list">CẬP NHẬT</button>
                        </div>
                    </form>
                </div>
                <form method="POST" id="category-menu" class="fl-right" action="?mod=menu&controller=index&action=apply_menus">
                    <div class="actions">
                        <select name="actions">
                            <option value="0">Tác vụ</option>
                            <option <?php if (isset($_POST['actions']) && $_POST['actions'] == 1) echo "selected='selected'"; ?> value="1">Xóa vĩnh viễn</option>
                        </select>
                        <button type="submit" name="sm_action" id="sm-block-status">Áp dụng</button> 
                        <?php echo form_error('select')?>
                    </div>
                    <div class="table-responsive">
                        <table class="table list-table-wp">
                            <thead>
                                <tr>
                                    <td><input type="checkbox" name="checkAll" id="checkAll"></td>
                                    <td><span class="thead-text">STT</span></td>
                                    <td><span class="thead-text">Tên menu</span></td>
                                    <td style="text-align: center;"><span class="thead-text">Đường dẫn tĩnh</span></td>
                                    <td style="text-align: center;"><span class="thead-text">Thứ tự</span></td>
                                </tr>
                            </thead>
                            <?php if (!empty($list_menus)) {
                                $error = array();
                                $order = 0;
                                ?>
                            <tbody>
                                <?php foreach ($list_menus as $menu) {
                                    $order++;
                                ?>
                                <tr>
                                    <td><input type="checkbox" name="checkItem[]" class="checkItem" value="<?php echo $menu['menu_id'] ?>"></td>
                                    <td><span class="tbody-text"><?php echo $order ?></span>
                                    <td>
                                        <div class="tb-title fl-left">
                                            <a href="?mod=menu&controller=index&action=update_menu&menu_id=<?php echo $menu['menu_id'] ?>" title=""><?php echo $menu['menu_title'] ?></a>
                                        </div>
                                        <ul class="list-operation fl-right">
                                            <li><a href="?mod=menu&controller=index&action=update_menu&menu_id=<?php echo $menu['menu_id'] ?>" title="Sửa" class="edit"><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
                                            <li><a href="?mod=menu&controller=index&action=delete_menus&menu_id=<?php echo $menu['menu_id'] ?>" title="Xóa" class="delete"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                                        </ul>
                                    </td>
                                    <td style="text-align: center;"><span class="tbody-text"><?php echo $menu['menu_url_static'] ?></span></td>
                                    <td style="text-align: center;"><span class="tbody-text"><?php echo $menu['menu_order'] ?></span></td>
                                </tr>
                                <?php
                                    }
                                ?>
                            </tbody>
                            <?php
                            } else {
                                $error['menu'] = "Không tồn tại menu nào!";
                            ?>
                                <p class="error"><?php echo  $error['menu'] ?> </p>
                            <?php
                            }
                            ?>
                            <tfoot>
                                <tr>
                                    <td><input type="checkbox" name="checkAll" id="checkAll"></td>
                                    <td><span class="thead-text">STT</span></td>
                                    <td><span class="thead-text">Tên menu</span></td>
                                    <td style="text-align: center;"><span class="thead-text">Đường dẫn tĩnh</span></td>
                                    <td style="text-align: center;"><span class="thead-text">Thứ tự</span></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
?>



