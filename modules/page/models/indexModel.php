<?php
//=============
//MENU
//=============
// get info menu
function get_info_menu($field, $menu_id){
    $info_menu_id = db_fetch_row("SELECT `$field` FROM `tbl_menus` WHERE `menu_id` = '{$menu_id}'");
    return  $info_menu_id[$field];
}
function get_info_page($field, $page_id){
    $info_page_id = db_fetch_row("SELECT `$field` FROM `tbl_pages` WHERE `page_id` = '{$page_id}'");
    return  $info_page_id[$field];
}