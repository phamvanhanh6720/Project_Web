<?php
function add_cart(){
    #lấy dữ liệu cần đưa vào list  buy cart
    $product_id = (int)$_GET['product_id'];
    $item = get_info_product($product_id);
    #Xử lý khi đã có hàng trong giỏ
    if(isset($_POST['num-order'])){
        $qty = $_POST['num-order'];
        if(isset($_SESSION['cart']) && array_key_exists($product_id, $_SESSION['cart']['buy'])){
            $qty = $_SESSION['cart']['buy'][$product_id]['qty'] + $_POST['num-order'];
        }
    } else{
        $qty = 1;
        if(isset($_SESSION['cart']) && array_key_exists($product_id, $_SESSION['cart']['buy'])){
            $qty = $_SESSION['cart']['buy'][$product_id]['qty'] + 1;
        }
    }
    $_SESSION['cart']['buy'][$product_id] = array(
        'product_id' => $item['product_id'],
        'product_code' => $item['product_code'],
        'product_thumb' => $item['product_thumb'],
        'product_title' => $item['product_title'],
        'slug' => $item['slug'],
        'product_price_new' => $item['product_price_new'],
        'qty' => $qty,
        'sub_total' => $qty * $item['product_price_new'],
    );
    #Cập nhật đơn hàng
    update_info_cart();
}
function update_info_cart(){
    if(isset($_SESSION['cart'])){
        $num_order = 0;
        $total = 0;
        if(isset($_SESSION['cart']['buy'])){
            foreach($_SESSION['cart']['buy'] as $item){
                $num_order += $item['qty'];
                $total += $item['sub_total'];
            }
            $_SESSION['cart']['info'] = array(
                'num_order' => $num_order,
                'total' => $total,
            );
        }
    }
}
function delete_cart($product_id){
    if(isset($_SESSION['cart'])){
        # Xóa sản phẩm có $product_id trong giỏ hàng
        if(!empty($product_id)){
            unset($_SESSION['cart']['buy'][$product_id]);
            #cập nhật hóa đơn
            update_info_cart();
        } else{
            unset($_SESSION['cart']);
        }
    }
}
function get_list_by_cart(){
    if(isset($_SESSION['cart']['buy'])){
        return $_SESSION['cart']['buy'];
    } return false;
}

function get_info_cart(){
    if(isset($_SESSION['cart'])){
        return $_SESSION['cart']['info'];
    } return false;
}
function update_cart($qty){ 
    foreach($qty as $product_id => $new_qty){
        $_SESSION['cart']['buy'][$product_id]['qty'] = $new_qty;
        $_SESSION['cart']['buy'][$product_id]['sub_total'] = $new_qty *  $_SESSION['cart']['buy'][$product_id]['product_price_new'];
    }
    update_info_cart();
}
