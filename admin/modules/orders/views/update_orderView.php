<?php
get_header();
if(isset($_GET['order_id'])){
    $order_id = $_GET['order_id'];
    $payment = get_info_order('payment', $order_id);
    $status = get_info_order('order_status', $order_id);
}
?>
<div id="main-content-wp" class="add-cat-page">
    <div class="wrap clearfix">
        <?php
        get_sidebar();   
        ?>
        <div id="content" class="fl-right">
            <div class="section" id="code-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Cập nhật đơn hàng</h3>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <form method="POST" action="">
                        <?php echo form_error('order')?>
                        <label for="code">Mã đơn hàng</label>
                        <input type="text" name="code" id="code" readonly ='readonly' value="<?php echo get_info_order('order_code', $order_id) ?>"> 
                        <?php echo form_error('code')?>
                        <label for="customer_name">Tên khách hàng</label>
                        <input type="text" name="customer_name" id="customer_name" value="<?php echo get_info_order('customer_name', $order_id) ?>">
                        <?php echo form_error('customer_name') ?>
                        <label for="num_total">Số sản phẩm</label>
                        <input type="text" name="num_total" id="num_total" value="<?php echo get_info_order('num_total', $order_id) ?>">
                        <?php echo form_error('num_total') ?>
                        <label for="total_price">Tổng giá</label>
                        <input type="text" name="total_price" id="total_price" value="<?php echo get_info_order('total_price', $order_id) ?>">
                        <?php echo form_error('total_price')?>
                        <label for="address">Địa chỉ</label>
                        <input type="text" name="address" id="address" value="<?php echo get_info_order('address', $order_id) ?>">
                        <?php echo form_error('address')?>
                        <label for="phone">Số điện thoại</label>
                        <input type="text" name="phone" id="phone" value="<?php echo get_info_order('phone', $order_id) ?>">
                        <?php echo form_error('phone')?>
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" value="<?php echo get_info_order('email', $order_id) ?>">
                        <?php echo form_error('email')?>
                        <label>Hình thức thanh toán</label>
                        <select name="payment">
                                <option <?php if (!empty($payment) && $payment == 'Thanh toán tại nhà') echo "selected='selected'"; ?> value='1'>Thanh toán tại nhà</option>
                                <option <?php if (!empty($payment) && $payment == 'Thanh toán ngân hàng') echo "selected='selected'"; ?> value='2'>Thanh toán ngân hàng</option>
                        </select>
                        <?php echo form_error('payment')?>
                        <label>Trạng thái đơn hàng</label>
                        <select name="status">
                                <option <?php if (!empty($status) && $status == 'Chờ duyệt') echo "selected='selected'"; ?> value='1'>Chờ duyệt</option>
                                <option <?php if (!empty($status) && $status == 'Đang vận chuyển') echo "selected='selected'"; ?> value='2'>Đang vận chuyển</option>
                                <option <?php if (!empty($status) && $status == 'Thành công') echo "selected='selected'"; ?> value='3'>Thành công</option>                           
                        </select>
                        <?php echo form_error('status')?>
                        <button type="submit" name="btn-update-order" id="btn-submit">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
?>