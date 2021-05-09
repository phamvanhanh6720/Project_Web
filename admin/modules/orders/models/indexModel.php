<?php
//===========
//  ORDER
//===========
# update order
function update_order($data, $order_id){
    db_update('tbl_orders', $data, "`order_id`='{$order_id}'");
}
# update order by phone
function update_order_by_phone($data, $phone){
    db_update('tbl_orders', $data, "`phone` = '{$phone}'");
}

# delete order
function delete_order($order_code) {
    db_delete("tbl_orders", "`order_code` = '{$order_code}'");
}
# get info order
function get_info_order($field, $order_id){
    $info_order = db_fetch_row("SELECT `$field` FROM `tbl_orders` WHERE `order_id` = '{$order_id}'");
    if(!empty($info_order)){
        return  $info_order[$field];
    }
}
# get info order by order code
function get_info_order_by_order_code($field, $order_code){
    $info_order = db_fetch_row("SELECT `$field` FROM `tbl_orders` WHERE `order_code` = '{$order_code}'");
    if(!empty($info_order)){
        return  $info_order[$field];
    }
}
# get info order by phone
function get_list_order_by_phone($phone){
    $info_order = db_fetch_array("SELECT* FROM `tbl_orders` WHERE `phone` = '{$phone}'");
    if(!empty($info_order)){
        return  $info_order;
    }
}
# get num order by phone
function get_num_order_by_phone($phone){
    $num_order = db_num_rows("SELECT* FROM `tbl_orders` WHERE `phone` = '{$phone}'");
    if(!empty($num_order)){
        return  $num_order;
    }
}
# get info order
function get_info_order_by_phone($field, $phone){
    $info_order = db_fetch_row("SELECT `$field` FROM `tbl_orders` WHERE `phone` = '{$phone}'");
    if(!empty($info_order)){
        return  $info_order[$field];
    }
}
# show payment
function show_payment($data){
    if($data == 1){
        $data = 'Thanh toán tại nhà';
        return $data;
    } else if($data == 2){
        $data = 'Thanh toán ngân hàng';
        return $data;
    }
}
# show status
function show_status($data){
    if($data == 1){
        $data = 'Chờ duyệt';
        return $data;
    } else if($data == 2){
        $data = 'Đang vận chuyển';
        return $data;
    } else{
        $data = 'Thành công';
        return $data;
    }
}
//=============
//PRODUCT ORDER
//=============
// get info product
function get_info_product($field, $product_id){
    $info_product_id = db_fetch_row("SELECT `$field` FROM `tbl_products` WHERE `product_id` = '{$product_id}'");
    if(!empty($info_product_id)){
        return  $info_product_id[$field];
    }
}
# get list product order
function get_list_product_order($order_code){
    $list_product_order = db_fetch_array("SELECT* FROM `tbl_product_order` WHERE `order_code` = '{$order_code}'");
    // $list_products = array();
    // foreach($list_product_order as $product){
    //     if($product['order_code'] == $order_code);
    //     $list_products[] = $product;
    // }
    return $list_product_order;
}
# delete product order
function delete_product_order($order_code) {
    db_delete("tbl_product_order", "`order_code` = '{$order_code}'");
}
//=============
//CUSTOMERS
//=============

# get info customer of order
function get_info_customer($field, $order_id){
    $info_customer = db_fetch_row("SELECT `$field` FROM `tbl_customers` WHERE `order_id` = '{$order_id}'");
    if(!empty($info_customer)){
        return  $info_customer[$field];
    }
}
# update customer 
function get_customer_update(){
    global $old_phone;
    $list_customers = db_fetch_array("SELECT* FROM `tbl_orders` WHERE `phone` = '{$old_phone}'");
    if(!empty($list_customers)){
        return $list_customers;
    }
}
# update customer by phone
function update_customer_by_phone($data, $phone){
    db_update('tbl_customers', $data, "`phone`='{$phone}'");
}

# get_num_order_of_customer
function get_num_order_of_customer($phone){
    $num_order = db_num_rows("SELECT* FROM `tbl_orders` WHERE `phone` = {$phone}");
    return $num_order;
}
# delete customer
function delete_customers($phone) {
    db_delete("tbl_customers", "`phone` = {$phone}");
}
# delete customer
function delete_orders_by_phone($phone) {
    db_delete("tbl_orders", "`phone` = {$phone}");
}
//==============
// PHÂN TRANG
//==============

function get_orders($start = 1, $num_per_page = 10, $where = ''){
    if(!empty($where)){
        $where = "WHERE {$where}";
    }
    $list_orders = db_fetch_array("SELECT* FROM `tbl_orders` {$where} LIMIT {$start}, {$num_per_page}");
    return $list_orders;
} 
function get_customers($start = 1, $num_per_page = 10, $where = ''){
    if(!empty($where)){
        $where = "WHERE {$where}";
    }
    $list_customers = db_fetch_array("SELECT* FROM `tbl_customers` {$where} LIMIT {$start}, {$num_per_page}");
    return $list_customers;
} 