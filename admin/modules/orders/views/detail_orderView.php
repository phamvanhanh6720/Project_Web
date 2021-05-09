<?php
get_header();
if(!empty($_GET['order_id'])){
    $order_id = $_GET['order_id'];
}
// $list_buy = get_list_by_cart();
$status = get_info_order('order_status', $order_id);
$order_code = get_info_order('order_code', $order_id);
$payment = get_info_order('payment', $order_id);
$list_product_order = get_list_product_order($order_code);
// show_array($list_product_order);
?>
<div id="main-content-wp" class="list-product-page">
    <div class="wrap clearfix">
        <?php
        get_sidebar();
        ?>
        <div id="content" class="detail-exhibition fl-right">
            <div class="section" id="info">
                <div class="section-head">
                    <h3 class="section-title">Thông tin đơn hàng</h3>
                </div>
                <ul class="list-item">
                    <li>
                        <h3 class="title">Mã đơn hàng</h3>
                        <span class="detail"><?php echo get_info_order('order_code', $order_id) ?></span>
                    </li>
                    <li>
                        <h3 class="title">Địa chỉ nhận hàng</h3>
                        <span class="detail"><?php echo get_info_order('address', $order_id) ?> / <?php echo get_info_order('phone', $order_id) ?></span>
                    </li>
                    <li>
                        <h3 class="title">Hình thức thanh toán</h3>
                        <span class="detail"><?php if($payment == 'payment-home'){ echo 'Thanh toán tại nhà';} else{ echo 'Thanh toán tại cửa hàng';} ?></span>
                    </li>
                    <form method="POST" action="?mod=orders&controller=order&action=situation&order_id=<?php echo $order_id ?>">
                        <li>
                            <h3 class="title">Tình trạng đơn hàng</h3>
                            <select name="status">
                                <option <?php if (!empty($status)  && $status == 'Chờ duyệt') echo "selected='selected'"; ?> value='1'>Chờ duyệt</option>
                                <option <?php if (!empty($status)  && $status == 'Đang vận chuyển') echo "selected='selected'"; ?> value='2'>Đang vận chuyển</option>
                                <option <?php if (!empty($status)  && $status == 'Thành công') echo "selected='selected'"; ?> value='3'>Thành công</option>                           
                            </select>
                            <input type="submit" name="sm_status" value="Cập nhật đơn hàng">
                        </li>
                        <?php echo form_error('transport')?>
                    </form>
                </ul>
            </div>
            <div class="section">
                <div class="section-head">
                    <h3 class="section-title">Sản phẩm đơn hàng</h3>
                </div>
                <div class="table-responsive">
                    <table class="table info-exhibition">
                        <thead>
                            <tr>
                                <td class="thead-text">STT</td>
                                <td class="thead-text">Ảnh sản phẩm</td>
                                <td class="thead-text">Tên sản phẩm</td>
                                <td class="thead-text">Đơn giá</td>
                                <td class="thead-text">Số lượng</td>
                                <td class="thead-text">Thành tiền</td>
                            </tr>
                        </thead>
                        <?php if (!empty($list_product_order)) {
                                $error = array();
                                $order = 0;
                            ?>
                        <tbody>
                            <?php foreach ($list_product_order as $product) {
                                $order++;
                                ?>
                            <tr>
                                <td class="thead-text"><?php echo $order;?></td>
                                <td class="thead-text">
                                    <div class="thumb">
                                        <img src="<?php echo get_info_product('product_thumb', $product['product_id']);?>" alt="">
                                    </div>
                                </td>
                                <td class="thead-text"><?php echo get_info_product('product_title', $product['product_id']);?></td>
                                <td class="thead-text"><?php echo currency_format(get_info_product('product_price_new', $product['product_id']));?></td>
                                <td class="thead-text"><?php echo $product['product_qty'];?></td>
                                <td class="thead-text"><?php echo currency_format($product['sub_total']);?></td>
                            </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                        <?php
                            } else {
                                $error['product'] = "Không tồn tại sản phẩm nào!";
                            ?>
                                <p class="error"><?php echo  $error['product'] ?> </p>
                            <?php
                            }
                            ?>
                    </table>
                </div>
            </div>
            <div class="section">
                <h3 class="section-title">Giá trị đơn hàng</h3>
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <span class="total-fee">Tổng số lượng</span>
                            <span class="total">Tổng đơn hàng</span>
                        </li>
                        <li>
                            <span class="total-fee"><?php echo get_info_order('num_total', $order_id) ?> sản phẩm</span>
                            <span class="total"><?php echo currency_format(get_info_order('total_price', $order_id)) ?></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
?>