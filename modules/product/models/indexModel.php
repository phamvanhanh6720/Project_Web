<?php
# get info product
function get_info_product($field, $product_id){
    $info_product_id = db_fetch_row("SELECT `$field` FROM `tbl_products` WHERE `product_id` = '{$product_id}'");
    if(!empty($info_product_id)){
        return  $info_product_id[$field];
    }
}

// # get product by parent cat
function get_product_by_parent_cat($parent_cat, $order_by = ''){
    $list_product_by_parent_cat = db_fetch_array("SELECT* FROM `tbl_products` WHERE `product_status` = 'Approved' AND (`parent_cat` = '{$parent_cat}' OR `brand` = '{$parent_cat}' OR `product_type` = '{$parent_cat}') $order_by");
    return $list_product_by_parent_cat;
} 
// # get product by parent cat unseted
function get_product_by_parent_cat_unseted($product_id, $parent_cat, $order_by = ''){
    $list_product_by_parent_cat = db_fetch_array("SELECT* FROM `tbl_products` WHERE `product_id` != '{$product_id}' AND `parent_cat` = '{$parent_cat}' OR `brand` = '{$parent_cat}' OR `product_type` = '{$parent_cat}' $order_by");
    return $list_product_by_parent_cat;
} 

# get product by cat_id
function get_products_by_cat_id($cat_id){
    $cat = db_fetch_assoc("SELECT `title` FROM `tbl_product_cat` WHERE `cat_id` = '{$cat_id}'");
    $data = db_fetch_array("SELECT* FROM `tbl_products` WHERE `parent_cat` = '{$cat['title']}' OR `brand` = '{$cat['title']}' OR `product_type` = '{$cat['title']}'");
    if(!empty($data)){
        return $data;
    }
}
//===============
// SEARCH
//===============
// get_list_cat_all_search
function get_list_cat_filter($value){
    $sql = "SELECT DISTINCT `parent_cat` FROM `tbl_products` WHERE CONVERT(`product_title` USING utf8) LIKE '%$value %' OR  CONVERT(`product_code` USING utf8) LIKE '% $value %'";
    $result = db_fetch_array($sql);
    return $result;
}
//
function get_list_product_filter_by_cat($data, $cat){
    $result = array();
    if(!empty($data)){
        foreach($data as $item){
            if($item['parent_cat'] == $cat || $item['brand'] == $cat || $item['product_type'] == $cat){
                $result[] = $item;
            }
        }
        if(!empty($result)){
            return $result;
        }
    }
    
}