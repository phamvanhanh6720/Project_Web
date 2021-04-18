<?php
# get list product pro
function get_list_product_pro($list_products){
    $result = array();
    if(!empty($list_products)){
        foreach ($list_products as $item){
            if(!empty($item['product_price_old'])){
                $result[] = $item;
            }
        }
         return $result;
    }
}
// get product by parent cat
function get_product_by_parent_cat($parent_cat, $where=''){
    $list_product_by_parent_cat =  db_fetch_array("SELECT* FROM `tbl_products` WHERE `parent_cat` = '{$parent_cat}'");
    if(!empty($list_product_by_parent_cat)){
    return $list_product_by_parent_cat;
    }
} 
# get cat id by cat
function get_cat_id_by_cat($cat){
    $data = db_fetch_assoc("SELECT `cat_id` FROM `tbl_product_cat` WHERE `title` = '{$cat}'");
    return $data['cat_id'];
}
# get cat by cat id
function get_cats_by_cat_id($cat_id){
    $result = array();
    $data = db_fetch_array("SELECT* FROM `tbl_product_cat` WHERE `parent_id` = '{$cat_id}'");
    foreach($data as $item){
        $result[] = $item;
        unset($data[$item['cat_id']]);
        $child = get_cats_by_cat_id($item['cat_id']);
        if(!empty($child)){
            $result = array_merge($result, $child);
        }
    }
    if(!empty($result)){
        return $result;
    }
} 
# get product by cat
function get_products_by_cat($list_cat_products, $cat_id){
    $data_0 = db_fetch_array("SELECT* FROM `tbl_product_cat` WHERE `cat_id` = '{$cat_id}'");
    if(!empty($list_cat_products)){
        $list_cat_products = array_merge($list_cat_products, $data_0);
    } else{
        $list_cat_products = $data_0;
    }
    $result = array();
    if(!empty($list_cat_products)){
        foreach($list_cat_products as $item){
            $data = db_fetch_array("SELECT* FROM `tbl_products` WHERE `parent_cat` = '{$item['title']}'");
            if(!empty($data)){
                $result = array_merge($result, $data);
            }
        }
    }
    if(!empty($result)){
        return $result;
    }
}
// get info product
function get_info_product($field, $product_id){
    $info_product_id = db_fetch_row("SELECT `$field`FROM `tbl_products` WHERE `product_id` = '{$product_id}'");
    if(!empty($info_product_id)){
        return  $info_product_id[$field];
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
#update customer 
function update_customer($data_customer, $phone){
    db_update("tbl_customers", $data_customer,"`phone` = {$phone}");
}
# get num customer
function get_num_customer($phone){
    $num_customer = db_num_rows("SELECT* FROM `tbl_customers` WHERE `phone` = '{$phone}'");
    if(!empty($num_customer)){
        return  $num_customer;
    }
}
//=================
//PRODUCT ORDER
//=================
function insert_product_order($data){
    db_insert('tbl_product_order',$data);
}
//===============
// EMAIL 
//===============
# Thêm mới email
function insert_email($data){
    db_insert('tbl_email_news', $data);
}
//===============
// SEARCH
//===============
// get_list_cat_all_search
function get_list_cat_all_search($value){
    $sql = "SELECT DISTINCT `parent_cat` FROM `tbl_products` WHERE CONVERT(`product_title` USING utf8) LIKE '%$value %' OR  CONVERT(`product_code` USING utf8) LIKE '%$value %'";
    $result = db_fetch_array($sql);
    return $result;
}
//
function get_list_all_products_search_by_cat($parent_cat, $value, $order_by =''){
    $sql = "SELECT * FROM `tbl_products` WHERE `parent_cat` = '{$parent_cat}' AND (CONVERT(`product_title` USING utf8) LIKE '%$value %' OR  CONVERT(`product_code` USING utf8) LIKE '%$value %') $order_by ";
    $result = db_fetch_array($sql);
    return $result;
}
