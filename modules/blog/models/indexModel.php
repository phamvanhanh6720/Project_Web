<?php
//===============
// PHÂN TRANG
//===============
function get_posts($start = 1, $num_per_page = 10, $where = ''){
    if(!empty($where)){
        $where = "WHERE {$where}";
    }
    $list_posts = db_fetch_array("SELECT* FROM `tbl_posts` WHERE `post_status` = 'Approved' ORDER BY `post_id` DESC {$where} LIMIT {$start}, {$num_per_page}");
    return $list_posts;
} 
# get info post
function get_info_post($field, $post_id){
    $info_post_id = db_fetch_row("SELECT `$field` FROM `tbl_posts` WHERE `post_id` = '{$post_id}'");
    return  $info_post_id[$field];
}
//=============
//MENU
//=============
// get info menu
function get_info_menu($field, $menu_id){
    $info_menu_id = db_fetch_row("SELECT `$field` FROM `tbl_menus` WHERE `menu_id` = '{$menu_id}'");
    return  $info_menu_id[$field];
}
