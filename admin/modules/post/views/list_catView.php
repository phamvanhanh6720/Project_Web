<?php
get_header();
$data_post_cat = db_fetch_array('SELECT* FROM `tbl_post_cat`');
$list_post_cat_all = data_tree($data_post_cat, 0);

#Số bản ghi/trang
$num_per_page = 10;
$list_num_page = db_num_page('tbl_post_cat', $num_per_page);
#Tổng số bản ghi
$total_row = count($list_post_cat_all);

#Số trang
$num_page = ceil($total_row / $num_per_page);

#chỉ số bắt đầu của trang
$page_num = (int) !empty($_GET['page_id']) ? $_GET['page_id'] : 1;
$start = ($page_num - 1) * $num_per_page;
$order_num = $start;
$list_post_cat = array_slice($list_post_cat_all, $start, $num_per_page);
# Danh mục đã đăng
$total_approved = db_num_rows("SELECT* FROM  `tbl_post_cat` Where `cat_status`= 'Approved'");
# Danh mục chờ xét duyệt
$total_waitting = db_num_rows("SELECT* FROM  `tbl_post_cat` Where `cat_status`= 'Waitting...'");
# Danh mục đã bị xóa
$total_trash = db_num_rows("SELECT* FROM  `tbl_post_cat` Where `cat_status`= 'Trash'");
?>
<div id="main-content-wp" class="list-cat-page">
    <div class="wrap clearfix">
        <?php
        get_sidebar();
        ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Danh sách danh mục</h3>
                    <a href="?mod=post&controller=post_cat&action=add_cat" title="" id="add-new" class="fl-left">Thêm mới</a>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <div class="filter-wp clearfix">
                        <ul class="post-status fl-left">
                            <li class="all"><a href="">Tất cả <span class="count">(<?php echo $total_row ?>)</span></a> |</li>
                            <li class="publish"><a href="">Đã đăng <span class="count">(<?php echo $total_approved ?>)</span></a> |</li>
                            <li class="pending"><a href="">Chờ xét duyệt <span class="count">(<?php echo $total_waitting ?>)</span></a></li>
                            <li class="trash"><a href="">Thùng rác <span class="count">(<?php echo $total_trash ?>)</span></a></li>
                        </ul>
                        <form method="GET" class="form-s fl-right" action="">
                            <input type="hidden" name="mod" value="post">
                            <input type="hidden" name="controller" value="post_cat">
                            <input type="hidden" name="action" value ="search_post_cat">
                            <input type="text" name="value" id="s"  value="<?php echo set_value('value') ?>">
                            <input type="submit" name="sm_s" value ="Tìm kiếm">
                            <?php echo form_error('error')?>
                        </form>
                    </div>
                    <form method="POST" action="?mod=post&controller=post_cat&action=apply_post_cats&page_id=<?php echo $page_num;?>">
                        <div class="actions">
                            <div class="form-actions">
                                <select name="actions">
                                <option value="0">Tác vụ</option>
                                    <option <?php if (isset($_POST['actions']) && $_POST['actions'] == 1) echo "selected='selected'"; ?> value="1">Công khai</option>
                                    <option <?php if (isset($_POST['actions']) && $_POST['actions'] == 2) echo "selected='selected'"; ?> value="2">Chờ duyệt</option>
                                    <option <?php if (isset($_POST['actions']) && $_POST['actions'] == 3) echo "selected='selected'"; ?> value="3">Bỏ vào thủng rác</option>
                                </select>
                                <input type="submit" name="sm_action" value="Áp dụng">
                                <?php echo form_error('select')?>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table list-table-wp">
                                <thead>
                                    <tr>
                                        <td><input type="checkbox" name="checkAll" id="checkAll"></td>
                                        <td><span class="thead-text">STT</span></td>
                                        <td><span class="thead-text">Tiêu đề</span></td>
                                        <td><span class="thead-text">Thứ tự</span></td>
                                        <td><span class="thead-text">Trạng thái</span></td>
                                        <td><span class="thead-text">Người tạo</span></td>
                                        <td><span class="thead-text">Ngày tạo</span></td>
                                        <td><span class="thead-text">Người sửa</span></td>
                                        <td><span class="thead-text">Ngày sửa</span></td>
                                    </tr>
                                </thead>
                                <?php if (!empty($list_post_cat_all)) {
                                    $error = array();
                                    $num_order = array();
                                    $order = 0;
                                    foreach($list_post_cat_all as $post_cat_all){
                                        $order++;
                                        $num_order['num_order'] =  $order;
                                        update_cat($num_order, $post_cat_all['cat_id']);
                                    }
                                    ?>
                                <tbody>
                                <?php foreach ($list_post_cat as $post_cat) {
                                    ?>
                                        <tr>
                                            <td><input type="checkbox" name="checkItem[]" class="checkItem" value="<?php echo $post_cat['cat_id'] ?>"></td>
                                            <td><span class="tbody-text"><?php echo $post_cat['num_order']?></h3></span>
                                            <td class="clearfix">
                                                <div class="tb-title fl-left">
                                                    <a href="" title=""><?php echo str_repeat('--', $post_cat['level']).' '.$post_cat['title']?></a>
                                                </div>
                                                <ul class="list-operation fl-right">
                                                    <li><a href="?mod=post&controller=post_cat&action=update_cat&cat_id=<?php echo $post_cat['cat_id']?>" title="Sửa" class="edit"><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
                                                    <li><a href="?mod=post&controller=post_cat&action=delete_cat&cat_id=<?php echo $post_cat['cat_id']?>" title="Xóa" class="delete"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                                                </ul>
                                            </td>
                                            <td><span class="tbody-text"><?php if($post_cat['parent_id'] == 0){echo 0;} else{ echo get_num_order($post_cat['parent_id'], $list_post_cat_all);}?></span></td>
                                            <td><span class="tbody-text <?php echo text_color_status($post_cat['cat_status']) ?>"><?php echo $post_cat['cat_status']?></span></td>
                                            <td><span class="tbody-text"><?php echo $post_cat['creator']?></span></td>
                                            <td><span class="tbody-text"><?php echo $post_cat['created_date']?></span></td>
                                            <td><span class="tbody-text"><?php echo $post_cat['editor']?></span></td>
                                            <td><span class="tbody-text"><?php echo $post_cat['edit_date']?></span></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                                <?php
                                } else {
                                    $error['post_cat'] = "Không tồn tại danh mục nào!";
                                ?>
                                    <p class="error"><?php echo  $error['post_cat'] ?> </p>
                                <?php
                                }
                                ?>
                                <tfoot>
                                    <tr>
                                        <td><input type="checkbox" name="checkAll" id="checkAll"></td>
                                        <td><span class="thead-text">STT</span></td>
                                        <td><span class="thead-text">Tiêu đề</span></td>
                                        <td><span class="thead-text">Thứ tự</span></td>
                                        <td><span class="thead-text">Trạng thái</span></td>
                                        <td><span class="thead-text">Người tạo</span></td>
                                        <td><span class="thead-text">Ngày tạo</span></td>
                                        <td><span class="thead-text">Người sửa</span></td>
                                        <td><span class="thead-text">Ngày sửa</span></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
            <div class="section" id="paging-wp">
                <div class="section-detail clearfix">
                    <p id="desc" class="fl-left">Chọn vào checkbox để lựa chọn tất cả</p>
                    <ul id="list-paging" class="fl-right">
                        <?php
                            echo get_pagging($num_page, $page_num, "?mod=post&controller=post_cat&action=index");
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
?>