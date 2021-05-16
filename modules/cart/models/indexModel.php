<?php
// get info product
function get_info_product($product_id){
    $info_product_id = db_fetch_row("SELECT*FROM `tbl_products` WHERE `product_id` = '{$product_id}'");
    if(!empty($info_product_id)){
        return  $info_product_id;
    }
}
//=================
// ORDER
//=================
# Thêm mới order
function insert_order($data){
    db_insert('tbl_orders', $data);
}
# update order
function update_order_by_phone($data_order, $phone){
    db_update('tbl_orders', $data_order, "`phone`='{$phone}'");
}

//================
//CUSTOMER
//================
# Thêm mới customer
function insert_customer($data){
    db_insert('tbl_customers', $data);
}
# get num customer
function get_num_customer($phone){
    $num_customer = db_num_rows("SELECT* FROM `tbl_customers` WHERE `phone` = '{$phone}'");
    if(!empty($num_customer)){
        return  $num_customer;
    }
}
#update customer 
function update_customer($data_customer, $phone){
    db_update("tbl_customers", $data_customer,"`phone` = {$phone}");
}
//=================
//PRODUCT ORDER
//=================
function insert_product_order($data){
    db_insert('tbl_product_order',$data);
}

# update product
function update_product($data, $product_id){
    db_update('tbl_products', $data, "`product_id` = '{$product_id}'");
}
//================
// SELECT ADDRESS
//================
function get_matp_by_province($province){
    $query = db_fetch_assoc("SELECT `matp` FROM `tbl_province` WHERE `name`='{$province}'");
    return $query['matp'];
}
function get_matp_by_district($district){
    $query = db_fetch_assoc("SELECT `maqh` FROM `tbl_district` WHERE `name`='{$district}'");
    return $query['maqh'];
}
?>