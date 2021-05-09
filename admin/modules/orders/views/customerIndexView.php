<?php

use Aws\ForecastService\ForecastServiceClient;

get_header();
#Số bản ghi/trang
$num_per_page = 10;

#Tổng số đơn hàng
$total_row = db_num_rows("SELECT* FROM  `tbl_customers`");

$list_num_page = db_num_page('tbl_customers', $num_per_page);
#Số trang
$num_page = ceil($total_row/$num_per_page);

#chỉ số bắt đầu của trang
$page_num = (int) !empty($_GET['page_id']) ? $_GET['page_id'] : 1;
$start = ($page_num -1)*$num_per_page;
$customer_num = $start;
$list_customers = get_customers($start, $num_per_page);
// $list_orders = array();
// foreach($list_orders as $customer){
//     foreach($list_orders as $item){
//         if($customer['phone'] =! $item['phone']){
//             $list_orders[] = $customer;
//         }
//     }
// }

?>
<div id="main-content-wp" class="list-product-page">
    <div class="wrap clearfix">
        <?php
        get_sidebar();
        ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Danh sách khách hàng</h3>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <div class="filter-wp clearfix">
                        <ul class="post-status fl-left">
                            <li class="all"><a href="">Tất cả <span class="count">(<?php echo $total_row ?>)</span></a></li>
                        </ul>
                        <form method="GET" class="form-s fl-right" action="">
                            <input type="hidden" name="mod" value="orders">
                            <input type="hidden" name="controller" value="customer">
                            <input type="hidden" name="action" value ="search_customers">
                            <input type="text" name="value" id="s"  value="<?php echo set_value('value') ?>">
                            <input type="submit" name="sm_s" value ="Tìm kiếm">
                            <?php echo form_error('error')?>
                        </form>
                    </div>
                    <form method="POST" action="?mod=orders&controller=customer&action=apply_customers">
                        <div class="actions">
                            <div class="form-actions">
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
                                        <td><span class="thead-text">Họ và tên</span></td>
                                        <td><span class="thead-text">Số điện thoại</span></td>
                                        <td><span class="thead-text">Email</span></td>
                                        <td><span class="thead-text">Địa chỉ</span></td>
                                        <td><span class="thead-text">Đơn hàng</span></td>
                                        <td><span class="thead-text">Thời gian</span></td>
                                    </tr>
                                </thead>
                                <?php if(!empty($list_customers)){
                                    $error = array();
                                    $ordinal = 0;
                                    ?>
                                    <tbody>
                                    <?php foreach($list_customers as $customer){
                                        $ordinal++;
                                        $num_order = db_num_rows("SELECT* FROM  `tbl_orders` WHERE `phone` = '{$customer['phone']}'");
                                        ?>
                                        <tr>
                                            <td><input type="checkbox" name="checkItem[]" class="checkItem" value="<?php echo $customer['phone'] ?>"></td>
                                            <td><span class="tbody-text"><?php echo $ordinal?></h3></span>
                                            <td>
                                                <div class="tb-title fl-left">
                                                    <a href="?mod=orders&controller=customer&action=update_customer&phone=<?php echo $customer['phone'] ?>" title=""><?php echo $customer['customer_name']?></a>
                                                </div>
                                                <ul class="list-operation fl-right">
                                                    <li><a href="?mod=orders&controller=customer&action=update_customer&phone=<?php echo $customer['phone'] ?>" title="Sửa" class="edit"><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
                                                    <li><a href="?mod=orders&controller=customer&action=delete_customers&phone=<?php echo $customer['phone'] ?>" title="Xóa" class="delete"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                                                </ul>
                                            </td>
                                            <td><span class="tbody-text"><?php echo $customer['phone']?></span></td>
                                            <td><span class="tbody-text"><?php echo $customer['email']?></span></td>
                                            <td><span class="tbody-text"><?php echo $customer['address']?></span></td>
                                            <td><span class="tbody-text"><?php echo $num_order ?></span></td>
                                            <td><span class="tbody-text"><?php echo $customer['created_date'];?></span></td>
                                        </tr>
                                    <?php
                                        } 
                                        ?> 
                                    </tbody>
                                    <?php
                                    } else{
                                        $error['customer'] = "Không tồn tại khách hàng nào!";
                                        ?>
                                            <p class="error"><?php echo  $error['customer']?> </p>
                                        <?php
                                    }
                                    ?>
                                <tfoot>
                                    <tr>
                                        <td><input type="checkbox" name="checkAll" id="checkAll" value="<?php echo $order['phone'] ?>"></td>
                                        <td><span class="tfoot-body">STT</span></td>
                                        <td><span class="tfoot-body">Họ và tên</span></td>
                                        <td><span class="tfoot-body">Số điện thoại</span></td>
                                        <td><span class="tfoot-body">Email</span></td>
                                        <td><span class="tfoot-body">Địa chỉ</span></td>
                                        <td><span class="tfoot-body">Đơn hàng</span></td>
                                        <td><span class="tfoot-body">Thời gian</span></td>
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
                            echo get_pagging($num_page, $page_num, "?mod=orders&controller=customer&action=customer");
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



