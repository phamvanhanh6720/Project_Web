<?php
//=============
//PRODUCT
//=============
# get products
function get_products($start = 1, $num_per_page = 10, $where = ''){
    if(!empty($where)){
        $where = "WHERE {$where}";
    }
    $list_productss = db_fetch_array("SELECT* FROM `tbl_products` {$where} LIMIT {$start}, {$num_per_page}");
    return $list_productss;
} 
# add product
function add_product($data) {
    db_insert('tbl_products', $data);
}
# get info product
function get_info_product($field, $product_id){
    $info_product_id = db_fetch_row("SELECT `$field` FROM `tbl_products` WHERE `product_id` = '{$product_id}'");
    if(!empty($info_product_id)){
        return  $info_product_id[$field];
    }

}
# update product
function update_product($data, $product_id){
    db_update('tbl_products', $data, "`product_id` = '{$product_id}'");
}
# delete post
function delete_product($product_id) {
    db_delete("tbl_products", "`product_id` = {$product_id}");
}
# sum order product 
function get_sum_sold_product($product_id) {
    $sum_sold_product = db_fetch_assoc("SELECT SUM(`product_qty`) FROM `tbl_product_order` WHERE `product_id` = '{$product_id}'");
    if(!empty($sum_sold_product)){
        return $sum_sold_product['SUM(`product_qty`)'];
    } else{
        return 0;
    }
}
//===============
// PHÂN TRANG
//===============

# get list product
function get_product_cats($start = 0, $num_per_page = 10, $where = ''){
    if(!empty($where)){
        $where = "WHERE {$where}";
    }
    $list_product_cats = db_fetch_array("SELECT* FROM `tbl_product_cat` {$where} LIMIT {$start}, {$num_per_page}");
    return $list_product_cats;
} 

//===============
//PRODUCT CAT
//===============
# get_info_cat
function get_info_cat($field, $cat_id){
    $info_cat = db_fetch_row("SELECT `$field` FROM `tbl_product_cat` WHERE `cat_id` = '{$cat_id}'");
    return  $info_cat[$field];
}
# add cat
function add_cat($data) {
    db_insert('tbl_product_cat', $data);
}
# update cat
function update_cat($data, $cat_id){
    db_update('tbl_product_cat', $data, "`cat_id` = '{$cat_id}'");
}
# delete cat
function delete_cat($cat_id){
    db_delete('tbl_product_cat', "`cat_id` = '{$cat_id}'");
}
#get product cat
function get_cats($start = 1, $num_per_page = 10, $where = ''){
    if(!empty($where)){
        $where = "WHERE {$where}";
    }
    $list_cats = db_fetch_array("SELECT* FROM `tbl_product_cat` {$where} LIMIT {$start}, {$num_per_page}");
    return $list_cats;
} 

?>