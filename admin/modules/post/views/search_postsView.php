<?php
get_header();
#Số bản ghi/trang
$num_per_page = 5;
# search post and get list posts
if(!empty($_GET['value'])){
    $value = $_GET['value'];
}
#Tổng số bản ghi tìm được
$list_posts_all = db_search_all_posts($value);
$total_row = count($list_posts_all);
#Số trang
$num_page = ceil($total_row / $num_per_page);

#chỉ số bắt đầu của trang
$page_num = (int) !empty($_GET['page_id']) ? $_GET['page_id'] : 1;
$start = ($page_num - 1) * $num_per_page;
$order_num = $start;
$list_posts = db_search_posts_by_page($value, $start, $num_per_page);

// # Bài viết đã đăng
$total_approved = db_num_rows("SELECT* FROM  `tbl_posts` Where `post_status`= 'Approved' AND CONVERT(`title` USING utf8) LIKE '%$value%'");
# Bài viết chờ xét duyệt
$total_waitting = db_num_rows("SELECT* FROM  `tbl_posts` Where `post_status`= 'Waitting...' AND CONVERT(`title` USING utf8) LIKE '%$value%'");
# Bài viết đã bị xóa
$total_trash = db_num_rows("SELECT* FROM  `tbl_posts` Where `post_status`= 'Trash' AND CONVERT(`title` USING utf8) LIKE '%$value%'");
?>
<div id="main-content-wp" class="list-post-page">
    <div class="wrap clearfix">
        <?php
        get_sidebar();
        ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Danh sách bài viết</h3>
                    <a href="?mod=post&controller=index&action=add_post" title="" id="add-new" class="fl-left">Thêm mới</a>
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
                            <input type="text" name="value" id="s"  value="<?php echo set_value('value') ?>">
                            <input type="submit" name="sm_s" value ="Tìm kiếm">
                            <input type="hidden" name="action" value ="search_posts">
                            <?php echo form_error('error')?>
                        </form>
                    </div>
                    <form method="POST" action="?mod=post&controller=index&action=apply_posts&page_id=<?php echo $page_num;?>&value=<?php if(!empty($value)){ echo $value;}?>">
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
                                        <td><span class="thead-text">Danh mục</span></td>
                                        <td><span class="thead-text">Trạng thái</span></td>
                                        <td><span class="thead-text">Người tạo</span></td>
                                        <td><span class="thead-text">Ngày tạo</span></td>
                                        <td><span class="thead-text">Người sửa</span></td>
                                        <td><span class="thead-text">Ngày sửa</span></td>
                                    </tr>
                                </thead>
                                <?php if (!empty($list_posts)) {
                                    $error = array();
                                    $order = 0;
                                ?>
                                    <tbody>
                                        <?php foreach ($list_posts as $post) {
                                            $order++;
                                        ?>
                                            <tr>
                                                <td><input type="checkbox" name="checkItem[]" class="checkItem" value="<?php echo $post['post_id'] ?>"></td>
                                                <td><span class="tbody-text"><?php echo $order ?></h3></span>
                                                <td class="clearfix">
                                                    <div class="tb-title fl-left">
                                                        <a href="?mod=post&controller=index&action=update_posts&post_id=<?php echo $post['post_id'] ?>" title=""><?php echo $post['title'] ?></a>
                                                    </div>
                                                    <ul class="list-operation fl-right">
                                                        <li><a href="?mod=post&controller=index&action=update_posts&post_id=<?php echo $post['post_id'] ?>" title="Cập nhật" class="edit"><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
                                                        <li><a href="?mod=post&controller=index&action=delete_posts&post_id=<?php echo $post['post_id'] ?>" title="Xóa" class="delete"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                                                    </ul>
                                                </td>
                                                <td><span class="tbody-text"><?php echo $post['parent_cat'] ?></span></td>
                                                <td><span class="tbody-text <?php echo text_color_status($post['post_status']) ?>"><?php echo $post['post_status'] ?></span></td>
                                                <td><span class="tbody-text"><?php echo $post['creator'] ?></span></td>
                                                <td><span class="tbody-text"><?php echo $post['created_date'] ?></span></td>
                                                <td><span class="tbody-text"><?php echo $post['editor'] ?></span></td>
                                                <td><span class="tbody-text"><?php echo $post['edit_date'] ?></span></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                <?php
                                } else {
                                    $error['post'] = "Không tồn tại bài viết nào!";
                                ?>
                                    <p class="error"><?php echo  $error['post'] ?> </p>
                                <?php
                                }
                                ?>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
            <div class="section" id="paging-wp">
                <div class="section-detail clearfix">
                    <p id="desc" class="fl-left">Chọn vào checkbox để lựa chọn tất cả</p>
                    <ul id="list-paging-pasts" class="fl-right">
                        <?php
                            echo get_pagging($num_page, $page_num, "?mod=post&controller=index&action=result_search&value=".$value);
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