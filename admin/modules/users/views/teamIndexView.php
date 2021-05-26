<?php
get_header();
// $list_page = get_list_page();
#Số bản ghi/trang
$num_per_page = 3;
$list_num_page = db_num_page('tbl_admins', $num_per_page);
#Tổng số bản ghi
$total_row = db_num_rows("SELECT* FROM  `tbl_admins`");

#Số trang
$num_page = ceil($total_row / $num_per_page);

#chỉ số bắt đầu của trang
$page = (int) !empty($_GET['page_id']) ? $_GET['page_id'] : 1;
$start = ($page - 1) * $num_per_page;
$order_num = $start;
$list_admins = get_admins($start, $num_per_page);
# Bài viết đã phê duyệt
$total_approved = db_num_rows("SELECT* FROM  `tbl_admins` Where `admin_status`= 'Approved'");
# Bài viết chờ xét duyệt
$total_waitting = db_num_rows("SELECT* FROM  `tbl_admins` Where `admin_status`= 'Waitting...'");
# Bài viết đã bị xóa
$total_trash = db_num_rows("SELECT* FROM  `tbl_admins` Where `admin_status`= 'Trash'");
?>
<div id="main-content-wp" class="list-post-page">
    <div class="wrap clearfix">
        <div class="section" id="title-page">
            <div class="clearfix">
                <a href="?mod=users&controller=team&action=add" title="" id="add-new" class="fl-left">Thêm mới</a>
                <h3 id="index" class="fl-left">Nhóm quản trị</h3>
            </div>
        </div>
        <?php
        get_sidebar();
        ?>
        <div id="content" class="fl-right">
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <div class="filter-wp clearfix">
                        <ul class="post-status fl-left">
                            <li class="all"><a href="">Tất cả <span class="count">(<?php echo $total_row; ?>)</span></a> |</li>
                            <li class="publish"><a href="">Đã phê duyệt<span class="count">(<?php echo $total_approved; ?>)</span></a> |</li>
                            <li class="pending"><a href="">Chờ xét duyệt <span class="count">(<?php echo $total_waitting; ?>)</span></a></li>
                            <li class="trash"><a href="">Thùng rác <span class="count">(<?php echo $total_trash; ?>)</span></a></li>
                        </ul>
                        <form method="GET" class="form-s fl-right" action="">
                            <input type="hidden" name="mod" value="users">
                            <input type="hidden" name="controller" value="team">
                            <input type="hidden" name="action" value="search_admins">
                            <input type="text" name="value" id="s" value="<?php echo set_value('value') ?>">
                            <input type="submit" name="sm_s" value="Tìm kiếm">
                            <?php echo form_error('error') ?>
                        </form>
                    </div>
                    <form method="POST" action="?mod=users&controller=team&action=apply_admins&page_id=<?php echo $page; ?>">
                        <div class="actions">
                            <div class="form-actions">
                                <select name="actions">
                                    <option value="0">Tác vụ</option>
                                    <option <?php if (isset($_POST['actions']) && $_POST['actions'] == 1) echo "selected='selected'"; ?> value="1">Phê duyệt</option>
                                    <option <?php if (isset($_POST['actions']) && $_POST['actions'] == 2) echo "selected='selected'"; ?> value="2">Chờ duyệt</option>
                                    <option <?php if (isset($_POST['actions']) && $_POST['actions'] == 3) echo "selected='selected'"; ?> value="3">Bỏ vào thủng rác</option>
                                </select>
                                <input type="submit" name="sm_action" value="Áp dụng">
                                <?php echo form_error('select') ?>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table list-table-wp">
                                <thead>
                                    <tr>
                                        <td><input type="checkbox" name="checkAll" id="checkAll"></td>
                                        <td><span class="thead-text">STT</span></td>
                                        <td><span class="thead-text">Ảnh đại diện</span></td>
                                        <td><span class="thead-text">Tên đăng nhập</span></td>
                                        <td><span class="thead-text">Họ và tên</span></td>
                                        <td><span class="thead-text">Email</span></td>
                                        <td><span class="thead-text">Số điện thoại</span></td>
                                        <td><span class="thead-text">Địa chỉ</span></td>
                                        <td><span class="thead-text">Trạng thái</span></td>
                                        <td><span class="thead-text">Hoạt động</span></td>
                                        <td><span class="thead-text">Ngày đăng ký</span></td>
                                    </tr>
                                </thead>
                                <?php if (!empty($list_admins)) {
                                    $error = array();
                                    $order = 0;
                                ?>
                                    <tbody>
                                        <?php foreach ($list_admins as $admin) {
                                            $order++;
                                        ?>
                                            <tr>
                                                <td><input type="checkbox" name="checkItem[]" class="checkItem" value="<?php echo $admin['admin_id'] ?>"></td>
                                                <td><span class="tbody-text"><?php echo $order ?></h3></span>
                                                <td>
                                                    <div class="tbody-thumb">
                                                        <a href='<?php if (!empty($admin['avatar'])) {
                                                                        echo $admin['avatar'];
                                                                    } else {
                                                                        echo 'public/images/img-thumb.png';
                                                                    } ?>'><img src="<?php if (!empty($admin['avatar'])) {
                                                                                        echo $admin['avatar'];
                                                                                    } else {
                                                                                        echo 'public/images/img-thumb.png';
                                                                                    } ?>" alt=""></a>
                                                    </div>
                                                </td>
                                                <td class="clearfix">
                                                    <div class="tb-title fl-left">
                                                        <a href="?mod=users&controller=team&action=update_admin&admin_id=<?php echo $admin['admin_id'] ?>" title=""><?php echo $admin['username'] ?></a>
                                                    </div>
                                                    <ul class="list-operation fl-right">
                                                        <li><a href="?mod=users&controller=team&action=update_admin&admin_id=<?php echo $admin['admin_id'] ?>" title="Cập nhật" class="edit"><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
                                                        <li><a href="?mod=users&controller=team&action=delete_admin&admin_id=<?php echo $admin['admin_id'] ?>" title="Xóa" class="delete"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                                                    </ul>
                                                </td>
                                                <td><span class="tbody-text"><?php echo $admin['fullname'] ?></span></td>
                                                <td><span class="tbody-text"><?php echo $admin['email'] ?></span></td>
                                                <td><span class="tbody-text"><?php echo $admin['tel'] ?></span></td>
                                                <td><span class="tbody-text"><?php echo $admin['address'] ?></span></td>
                                                <td><span class="tbody-text <?php echo text_color_status($admin['admin_status']) ?>"><?php echo $admin['admin_status'] ?></span></td>
                                                <td><span class="tbody-text"><?php echo $admin['active'] ?></span></td>
                                                <td><span class="tbody-text"><?php echo $admin['reg_date'] ?></span></td>

                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                <?php
                                } else {
                                    $error['admin'] = "Không có admin nào!";
                                ?>
                                    <p class="error"><?php echo  $error['admin'] ?> </p>
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
                    <ul id="list-paging-admins" class="fl-right">
                        <?php
                        echo get_pagging($num_page, $page, "?mod=users&controller=team&action=index");
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

</script>
<?php
get_footer();
?>