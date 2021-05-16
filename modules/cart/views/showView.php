<?php
get_header();
?>
<?php
$list_buy = get_list_by_cart();
$list_info = get_info_cart();
?>
<div id="main-content-wp" class="cart-page">
    <div class="section" id="breadcrumb-wp">
        <div class="wp-inner">
            <div class="section-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="?mod=home" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="" title="">Giỏ hàng</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div id="wrapper" class="wp-inner clearfix">
        <div class="section" id="info-cart-wp">
            <div class="section-detail table-responsive">
                <form action="" method="POST">
                    <table class="table">
                        <thead>
                            <tr>
                                <td>Mã sản phẩm</td>
                                <td>Ảnh sản phẩm</td>
                                <td>Tên sản phẩm</td>
                                <td>Giá sản phẩm</td>
                                <td>Số lượng</td>
                                <td colspan="2">Thành tiền</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($list_buy)) {
                                ?>
                                <?php foreach ($list_buy as $item) {
                                    ?>
                                    <tr>
                                        <td><?php echo $item['product_code'] ?></td>
                                        <td>
                                            <a href="<?php echo $item['slug'] ?>-<?php echo $item['product_id'] ?>-i.html" title="" class="thumb">
                                                <img src="admin/<?php echo $item['product_thumb'] ?>" alt="">
                                            </a>
                                        </td>
                                        <td>
                                            <a href="<?php echo $item['slug'] ?>-<?php echo $item['product_id'] ?>-i.html" title="" class="name-product"><?php echo $item['product_title'] ?></a>
                                        </td>
                                        <td><?php echo currency_format($item['product_price_new']) ?></td>
                                        <td>
                                            <input type="number" min="1" max="20" data-id="<?php echo $item['product_id'] ?>" name="qty[<?php echo $item['product_id'] ?>]" value="<?php echo $item['qty'] ?>" class="num-order">
                                        </td>
                                        <td id="sub-total-<?php echo $item['product_id'] ?>"><?php echo currency_format($item['sub_total']) ?></td>
                                        <td>
                                            <a href="xoa-<?php echo $item['product_id'] ?>-d.html" title="" class="del-product"><i class="fa fa-trash-o"></i></a>
                                        </td>
                                    </tr> 
                                    <?php
                                    }
                                    ?>
                                <?php
                                    } else {
                                ?>
                                <p id='no-cart'>Không có sản phẩm nào trong giỏ hàng!</p>
                                <?php
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7">
                                    <div class="clearfix">
                                        <?php
                                            if (empty($list_buy)) {
                                                ?>
                                                <p id="total-price" class="fl-right">Tổng giá: <span>0</span></p>
                                                <?php
                                            } else {
                                                ?>
                                                <p id="total-price" class="fl-right">Tổng giá: <span><?php echo currency_format($list_info['total'])?></span></p>
                                                <?php
                                            }
                                        ?>
                                        
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7">
                                    <div class="clearfix">
                                        <div class="fl-right">
                                            <!-- <a id="update-cart" name="btn_update">Cập nhật giỏ hàng</a> -->
                                            <a href='thanh-toan.html' id="checkout-cart">Thanh toán</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </form>
            </div>
        </div>
        <div class="section" id="action-cart-wp">
            <div class="section-detail">
                <p class="title">Click vào <span>“Cập nhật giỏ hàng”</span> để cập nhật số lượng. Nhập vào số lượng <span>0</span> để xóa sản phẩm khỏi giỏ hàng. Nhấn vào thanh toán để hoàn tất mua hàng.</p>
                <a href="san-pham.html" title="" id="buy-more">Mua tiếp</a><br/>
                <a href="xoa-0-d.html" title="" id="delete-cart">Xóa giỏ hàng</a>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
?>




