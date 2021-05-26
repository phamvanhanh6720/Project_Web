<?php
function db_search($value, $field, $table){
    $sql = "SELECT * FROM $table WHERE $field LIKE '%$value %'";
    $result = db_fetch_array($sql);
    return $result;
}

// search  all admins
function db_search_all_admins($value){
    $sql = "SELECT * FROM `tbl_admins` WHERE  CONVERT(`username` USING utf8) LIKE '%$value %' OR CONVERT(`fullname` USING utf8) LIKE '%$value %'";
    $result = db_fetch_array($sql);
    return $result;
}
# search admins by page
function db_search_admins_by_page($value, $start = 1, $num_per_page = 10){
    $sql = "SELECT * FROM `tbl_admins` WHERE  CONVERT(`username` USING utf8) LIKE '%$value %' OR CONVERT(`fullname` USING utf8) LIKE '%$value %' LIMIT {$start}, {$num_per_page}";
    $result = db_fetch_array($sql);
    return $result;
}
// search  all pages
function db_search_all_pages($value){
    $sql = "SELECT * FROM `tbl_pages` WHERE CONVERT(`title` USING utf8) LIKE '%$value %'";
    $result = db_fetch_array($sql);
    return $result;
}
# search pages by page
function db_search_pages_by_page($value, $start = 1, $num_per_page = 10){
    $sql = "SELECT * FROM `tbl_pages` WHERE CONVERT(`title` USING utf8) LIKE '%$value %' LIMIT {$start}, {$num_per_page}";
    $result = db_fetch_array($sql);
    return $result;
}
// search  all posts
function db_search_all_posts($value){
    $sql = "SELECT * FROM `tbl_posts` WHERE CONVERT(`title` USING utf8) LIKE '%$value %'";
    $result = db_fetch_array($sql);
    return $result;
}
# search posts by page
function db_search_posts_by_page($value, $start = 1, $num_per_page = 10){
    $sql = "SELECT * FROM `tbl_posts` WHERE CONVERT(`title` USING utf8) LIKE '%$value %' LIMIT {$start}, {$num_per_page}";
    $result = db_fetch_array($sql);
    return $result;
}
// search  all products
function db_search_all_products($value, $order_by=''){
    $sql = "SELECT * FROM `tbl_products` WHERE CONVERT(`product_title` USING utf8) LIKE '%$value %' OR  CONVERT(`product_code` USING utf8) LIKE '%$value %' $order_by ";
    $result = db_fetch_array($sql);
    return $result;
}
# search products by page
function db_search_products_by_page($value, $start = 1, $num_per_page = 10){
    $sql = "SELECT * FROM `tbl_products`  WHERE CONVERT(`product_title` USING utf8) LIKE '%$value %' OR  CONVERT(`product_code` USING utf8) LIKE '%$value %' LIMIT {$start}, {$num_per_page}";
    $result = db_fetch_array($sql);
    return $result;
}
// search  all customers
function db_search_all_customers($value){
    $sql = "SELECT * FROM `tbl_customers` WHERE CONVERT(`customer_name` USING utf8) LIKE '%$value %' OR CONVERT(`phone` USING utf8) LIKE '%$value %' OR CONVERT(`email` USING utf8) LIKE '%$value %'";
    $result = db_fetch_array($sql);
    return $result;
}
# search customers by page
function db_search_customers_by_page($value, $start = 1, $num_per_page = 10){
    $sql = "SELECT * FROM `tbl_customers` WHERE CONVERT(`customer_name` USING utf8) LIKE '%$value %' OR CONVERT(`phone` USING utf8) LIKE '%$value %' OR CONVERT(`email` USING utf8) LIKE '%$value %' LIMIT {$start}, {$num_per_page}";
    $result = db_fetch_array($sql);
    return $result;
}
// search  all orders
function db_search_all_orders($value){
    $sql = "SELECT * FROM `tbl_orders` WHERE CONVERT(`order_code` USING utf8) LIKE '%$value %' OR CONVERT(`customer_name` USING utf8) LIKE '%$value %'";
    $result = db_fetch_array($sql);
    return $result;
}
# search orders by page
function db_search_orders_by_page($value, $start = 1, $num_per_page = 10){
    $sql = "SELECT * FROM `tbl_orders` WHERE CONVERT(`order_code` USING utf8) LIKE '%$value %' OR CONVERT(`customer_name` USING utf8) LIKE '%$value %' LIMIT {$start}, {$num_per_page}";
    $result = db_fetch_array($sql);
    return $result;
}
// search  all sliders
function db_search_all_sliders($value){
    $sql = "SELECT * FROM `tbl_sliders` WHERE CONVERT(`slider_title` USING utf8) LIKE '%$value %' OR CONVERT(`slider_slug` USING utf8) LIKE '%$value %'";
    $result = db_fetch_array($sql);
    return $result;
}
# search orders by page
function db_search_sliders_by_page($value, $start = 1, $num_per_page = 10){
    $sql = "SELECT * FROM `tbl_sliders` WHERE CONVERT(`slider_title` USING utf8) LIKE '%$value %' OR CONVERT(`slider_slug` USING utf8) LIKE '%$value %' LIMIT {$start}, {$num_per_page}";
    $result = db_fetch_array($sql);
    return $result;
}
// search  all medias
function db_search_all_medias($value){
    $sql = "SELECT * FROM `tbl_sliders` WHERE CONVERT(`slider_thumb` USING utf8) LIKE '%$value %'"
    ."SELECT * FROM `tbl_admins` WHERE CONVERT(`avatar` USING utf8) LIKE '%$value %'"
    ."SELECT * FROM `tbl_posts` WHERE CONVERT(`post_thumbnail` USING utf8) LIKE '%$value %'"
    ."SELECT * FROM `tbl_products` WHERE CONVERT(`product_thumb` USING utf8) LIKE '%$value %'";
    $result = db_fetch_array($sql);
    return $result;
}
// search  all product cat
function db_search_all_product_cats($value){
    $sql = "SELECT * FROM `tbl_product_cat` WHERE CONVERT(`title` USING utf8) LIKE '%$value %'";
    $result = db_fetch_array($sql);
    return $result;
}
# search product cat by page
function db_search_product_cats_by_page($value, $start = 1, $num_per_page = 10){
    $sql = "SELECT * FROM `tbl_product_cat`  WHERE CONVERT(`title` USING utf8) LIKE '%$value %' LIMIT {$start}, {$num_per_page}";
    $result = db_fetch_array($sql);
    return $result;
}
// search  all product cat
function db_search_all_post_cats($value){
    $sql = "SELECT * FROM `tbl_post_cat` WHERE CONVERT(`title` USING utf8) LIKE '%$value %'";
    $result = db_fetch_array($sql);
    return $result;
}
# search product cat by page
function db_search_post_cats_by_page($value, $start = 1, $num_per_page = 10){
    $sql = "SELECT * FROM `tbl_post_cat`  WHERE CONVERT(`title` USING utf8) LIKE '%$value %' LIMIT {$start}, {$num_per_page}";
    $result = db_fetch_array($sql);
    return $result;
}
?>