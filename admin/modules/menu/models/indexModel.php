<?php
function get_list_page(){
    $list_page = db_fetch_array("SELECT* FROM `tbl_pages`");
    return $list_page;
}
//add menu
function add_menu($data) {
    db_insert('tbl_menus', $data);
}
// update menu
function update_menu($data, $menu_id){
    db_update('tbl_menus', $data, "`menu_id`='{$menu_id}'");
}
// get info menu
function get_info_menu($field, $menu_id){
    $info_menu_id = db_fetch_row("SELECT `$field` FROM `tbl_menus` WHERE `menu_id` = '{$menu_id}'");
    return  $info_menu_id[$field];
}
// delete menu
function delete_menu($menu_id) {
    db_delete("tbl_menus", "`menu_id` = {$menu_id}");
}