<?php
get_header();
if(isset($_GET['phone'])){
    $phone = $_GET['phone'];
    $num_order = get_num_order_of_customer($phone);
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
                        <?php echo form_error('customer')?>
                        <label for="customer_name">Tên khách hàng</label>
                        <input type="text" name="customer_name" id="customer_name" value="<?php echo get_info_order_by_phone('customer_name', $phone) ?>">
                        <?php echo form_error('customer_name') ?>
                        <label for="phone">Số điện thoại</label>
                        <input type="text" name="phone" id="phone" value="<?php echo get_info_order_by_phone('phone', $phone) ?>">
                        <?php echo form_error('phone')?>
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" value="<?php echo get_info_order_by_phone('email', $phone) ?>">
                        <?php echo form_error('email')?>
                        <label for="address">Địa chỉ</label>
                        <input type="text" name="address" id="address" value="<?php echo get_info_order_by_phone('address', $phone) ?>">
                        <?php echo form_error('address')?>
                        <label for="num_order">Số đơn hàng</label>
                        <input type="text" name="num_order" id="num_order" readonly="readonly" value="<?php echo $num_order?>">
                        <?php echo form_error('num_order') ?>
                        <button type="submit" name="btn-update-customer" id="btn-submit">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
?>