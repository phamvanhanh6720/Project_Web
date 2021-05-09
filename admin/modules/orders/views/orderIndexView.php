<?php
get_header();
#Số bản ghi/trang
$num_per_page = 10;
$list_num_page = db_num_page('tbl_orders', $num_per_page);
#Tổng số bản ghi
$total_row = db_num_rows("SELECT* FROM  `tbl_orders`");

#Số trang
$num_page = ceil($total_row / $num_per_page);

#chỉ số bắt đầu của trang
$page_num = (int) !empty($_GET['page_id']) ? $_GET['page_id'] : 1;
$start = ($page_num - 1) * $num_per_page;
$order_num = $start;
$list_orders = get_orders($start, $num_per_page);
# Đơn hàng đã đăng
$total_approved = db_num_rows("SELECT* FROM  `tbl_orders` Where `order_status`= 'Approved'");
# Đơn hàng chờ xét duyệt
$total_waitting = db_num_rows("SELECT* FROM  `tbl_orders` Where `order_status`= 'Waitting...'");
# Đơn hàng đã bị xóa
$total_trash = db_num_rows("SELECT* FROM  `tbl_orders` Where `order_status`= 'Trash'");
?>
<div id="main-content-wp" class="list-product-page">
    <div class="wrap clearfix">
        <?php
        get_sidebar();
        ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Danh sách đơn hàng</h3>
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
                            <input type="hidden" name="mod" value="orders">
                            <input type="hidden" name="controller" value="order">
                            <input type="hidden" name="action" value ="search_orders">
                            <input type="text" name="value" id="s"  value="<?php echo set_value('value') ?>">
                            <input type="submit" name="sm_s" value ="Tìm kiếm">
                            <?php echo form_error('error')?>
                        </form>
                    </div>
                    <form method="POST" action="?mod=orders&controller=order&action=apply_orders&page_id=<?php echo $page_num;?>">
                        <div class="actions">
                            <div action="" class="form-actions">
                                <select name="actions">
                                    <option value="0">Tác vụ</option>
                                    <option <?php if (isset($_POST['actions']) && $_POST['actions'] == 1) echo "selected='selected'"; ?> value="1">Xóa</option>
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
                                        <td><span class="thead-text">Mã đơn hàng</span></td>
                                        <td><span class="thead-text">Họ và tên</span></td>
                                        <td><span class="thead-text">Số sản phẩm</span></td>
                                        <td><span class="thead-text">Tổng giá</span></td>
                                        <td><span class="thead-text">Trạng thái</span></td>
                                        <td><span class="thead-text">Thời gian</span></td>
                                        <td><span class="thead-text">Chi tiết</span></td>
                                    </tr>
                                </thead>
                                <?php if (!empty($list_orders)) {
                                        $error = array();
                                        $ordinal = 0;
                                    ?>
                                <tbody>
                                <?php foreach ($list_orders as $order) {
                                    $ordinal++;
                                    ?>
                                    <tr>
                                        <td><input type="checkbox" name="checkItem[]" class="checkItem" value="<?php echo $order['order_code'] ?>"></td>
                                        <td><span class="tbody-text"><?php echo $ordinal ?></h3></span>
                                        <td><span class="tbody-text"><?php echo $order['order_code'] ?></h3></span>
                                        <td>
                                            <div class="tb-title fl-left">
                                                <a href="?mod=orders&controller=order&action=update_order&order_id=<?php echo $order['order_id'] ?>" title=""><?php echo $order['customer_name'];?></a>
                                            </div>
                                            <ul class="list-operation fl-right">
                                                <li><a href="?mod=orders&controller=order&action=update_order&order_id=<?php echo $order['order_id'] ?>" title="Sửa" class="edit"><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
                                                <li><a href="?mod=orders&controller=order&action=delete_order&order_code=<?php echo $order['order_code'] ?>" title="Xóa" class="delete"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                                            </ul>
                                        </td>
                                        <td><span class="tbody-text"><?php echo $order['num_total'] ?></span></td>
                                        <td><span class="tbody-text"><?php echo currency_format($order['total_price']) ?></span></td>
                                        <td><span class="tbody-text <?php echo text_color_status($order['order_status'] ) ?>"><?php echo $order['order_status'] ?></span></td>
                                        <td><span class="tbody-text"><?php echo $order['created_date'] ?></span></td>
                                        <td><a href="?mod=orders&controller=order&action=detail_order&order_id=<?php echo $order['order_id'] ?>" title="" class="tbody-text">Chi tiết</a></td>
                                    </tr>
                                    <?php
                                        }
                                    ?>
                                </tbody>
                                <?php
                                    } else {
                                        $error['order'] = "Không tồn tại đơn hàng nào!";
                                    ?>
                                        <p class="error"><?php echo  $error['order'] ?> </p>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td><input type="checkbox" name="checkAll" id="checkAll"></td>
                                        <td><span class="tfoot-text">STT</span></td>
                                        <td><span class="tfoot-text">Mã đơn hàng</span></td>
                                        <td><span class="tfoot-text">Họ và tên</span></td>
                                        <td><span class="tfoot-text">Số sản phẩm</span></td>
                                        <td><span class="tfoot-text">Tổng giá</span></td>
                                        <td><span class="tfoot-text">Trạng thái</span></td>
                                        <td><span class="tfoot-text">Thời gian</span></td>
                                        <td><span class="tfoot-text">Chi tiết</span></td>
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
                    <ul id="list-paging-pages" class="fl-right">
                        <?php
                            echo get_pagging($num_page, $page_num, "?mod=orders&controller=order&action=index");
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