<?php
get_header();
#Số bản ghi/trang
$num_per_page = 3;
# search slider and get list sliders
if(!empty($_GET['value'])){
    $value = $_GET['value'];
}
#Tổng số bản ghi tìm được
$list_sliders_all = db_search_all_sliders($value);
$total_row = count($list_sliders_all);
#Số trang
$num_page = ceil($total_row / $num_per_page);

#chỉ số bắt đầu của trang
$page_num = (int) !empty($_GET['page_id']) ? $_GET['page_id'] : 1;
$start = ($page_num - 1) * $num_per_page;
$order_num = $start;
$list_sliders = db_search_sliders_by_page($value, $start, $num_per_page);
# Sản phẩm đã đăng
$total_approved = db_num_rows("SELECT* FROM  `tbl_sliders` Where `slider_status`= '1' AND CONVERT(`slider_title` USING utf8) LIKE '%$value%'");
# Sản phẩm chờ xét duyệt
$total_waitting = db_num_rows("SELECT* FROM  `tbl_sliders` Where `slider_status`= '2' AND CONVERT(`slider_title` USING utf8) LIKE '%$value%'");
# Sản phẩm đã bị xóa
$total_trash = db_num_rows("SELECT* FROM  `tbl_sliders` Where `slider_status`= '3' AND CONVERT(`slider_title` USING utf8) LIKE '%$value%'");
?>
<div id="main-content-wp" class="list-slider-page list-slider">
    <div class="wrap clearfix">
        <?php
        get_sidebar();
        ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Danh sách slider</h3>
                    <a href="?mod=slider&controller=index&action=add_slider" title="" id="add-new" class="fl-left">Thêm mới</a>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <div class="filter-wp clearfix">
                        <ul class="post-status fl-left">
                            <li class="all"><a href="">Tất cả <span class="count">(<?php echo $total_row ?>)</span></a> |</li>
                            <li class="publish"><a href="">Đã đăng <span class="count">(<?php echo $total_approved ?>)</span></a> |</li>
                            <li class="pending"><a href="">Chờ xét duyệt<span class="count">(<?php echo $total_waitting ?>)</span></a></li>
                            <li class="pending"><a href="">Thùng rác<span class="count">(<?php echo $total_trash ?>)</span></a></li>
                        </ul>
                        <form method="GET" class="form-s fl-right" action="">
                            <input type="hidden" name="mod" value="slider">
                            <input type="hidden" name="action" value ="search_sliders">
                            <input type="text" name="value" id="s"  value="<?php echo set_value('value') ?>">
                            <input type="submit" name="sm_s" value ="Tìm kiếm">
                            <?php echo form_error('error')?>
                        </form>
                    </div>
                    <form method="POST" action="?mod=slider&controller=index&action=apply_sliders&page_id=<?php echo $page_num;?>&value=<?php if(!empty($value)){ echo $value;}?>">
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
                                        <td><span class="thead-text">Hình ảnh</span></td>
                                        <td><span class="thead-text">Tên Slider</span></td>
                                        <td><span class="thead-text">Link</span></td>
                                        <td><span class="thead-text">Thứ tự</span></td>
                                        <td><span class="thead-text">Trạng thái</span></td>
                                        <td><span class="thead-text">Người tạo</span></td>
                                        <td><span class="thead-text">Thời gian tạo</span></td>
                                        <td><span class="thead-text">Người sửa</span></td>
                                        <td><span class="thead-text">Thời gian sửa</span></td>
                                    </tr>
                                </thead>
                                <?php if (!empty($list_sliders)) {
                                        $error = array();
                                        $order = 0;
                                      
                                    ?>
                                <tbody>
                                    <?php foreach ($list_sliders as $slider) {
                                        $order++;
                                        $status = show_status_active($slider['slider_status']);
                                        ?>
                                    <tr>
                                        <td><input type="checkbox" name="checkItem[]" class="checkItem" value="<?php echo $slider['slider_id'] ?>"></td>
                                        <td><span class="tbody-text"><?php echo $order ?></h3></span>
                                        <td>
                                            <div class="tbody-thumb">
                                            <a href='<?php if(!empty($slider['slider_thumb'])){echo $slider['slider_thumb'];} else{echo 'public/images/img-thumb.png';}?>'><img src="<?php if(!empty($slider['slider_thumb'])){echo $slider['slider_thumb'];} else{echo 'public/images/img-thumb.png';}?>" alt=""></a>
                                            </div>
                                        </td>
                                        <td><a href="?mod=slider&controller=index&action=update_sliders&slider_id=<?php echo $slider['slider_id']?>"><span class="tbody-text"><?php echo $slider['slider_title'] ?></span></a></td>
                                        <td class="clearfix">
                                            <div class="tb-title fl-left">
                                                <a href="" title=""><?php echo $slider['slider_slug'] ?></a>
                                            </div>
                                            <ul class="list-operation fl-right">
                                                <li><a href="?mod=slider&controller=index&action=update_sliders&slider_id=<?php echo $slider['slider_id']?>" title="Sửa" class="edit"><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
                                                <li><a href="?mod=slider&controller=index&action=delete_sliders&slider_id=<?php echo $slider['slider_id']?>" title="Xóa" class="delete"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                                            </ul>
                                        </td>
                                        <td><span class="tbody-text"><?php echo $slider['slider_ordinal'] ?></span></td>
                                        <td><span class="tbody-text <?php echo text_color_status($status) ?>"><?php echo $status?></span></td>
                                        <td><span class="tbody-text"><?php echo $slider['creator'] ?></span></td>
                                        <td><span class="tbody-text"><?php echo $slider['created_date'] ?></span></td>
                                        <td><span class="tbody-text"><?php echo $slider['editor'] ?></span></td>
                                        <td><span class="tbody-text"><?php echo $slider['edit_date'] ?></span></td>
                                    </tr>
                                    <?php
                                        }
                                    ?>
                                </tbody>
                                <?php
                                    } else {
                                        $error['slider'] = "Không tồn tại slide nào!";
                                    ?>
                                        <p class="error"><?php echo  $error['slider'] ?> </p>
                                    <?php
                                    }
                                    ?>
                                <tfoot>
                                    <tr>
                                        <td><input type="checkbox" name="checkAll" id="checkAll"></td>
                                        <td><span class="thead-text">STT</span></td>
                                        <td><span class="thead-text">Hình ảnh</span></td>
                                        <td><span class="thead-text">Link</span></td>
                                        <td><span class="thead-text">Thứ tự</span></td>
                                        <td><span class="thead-text">Trạng thái</span></td>
                                        <td><span class="thead-text">Người tạo</span></td>
                                        <td><span class="thead-text">Thời gian tạo</span></td>
                                        <td><span class="thead-text">Người sửa</span></td>
                                        <td><span class="thead-text">Thời gian sửa</span></td>
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
                            echo get_pagging($num_page, $page_num, "?mod=slider&controller=index&action=result_search&value=".$value);
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