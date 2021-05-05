<?php
function insert_page($data){
    db_insert('tbl_pages', $data);
}
//============
//TRANG
//============
// Cập nhật trang
function update_page($data, $page_id){
    db_update('tbl_pages', $data, "`page_id`='{$page_id}'");
}
function get_list_page(){
    $list_page = db_fetch_array("SELECT* FROM `tbl_pages`");
    return $list_page;
}
function get_info_page($field, $page_id){
    $info_page_id = db_fetch_row("SELECT `$field` FROM `tbl_pages` WHERE `page_id` = '{$page_id}'");
    return  $info_page_id[$field];
}
function get_page_active(){
    $row_page_active = db_num_rows("SELECT* FROM `tbl_pages` WHERE `active` = 'hoạt động'");
    return  $row_page_active;
}
function get_page_not_active(){
    $row_page_not_active = db_num_rows("SELECT* FROM `tbl_pages` WHERE `active` = 'không hoạt động'");
    return  $row_page_not_active;
}
// Xóa trang
function delete_page($page_id){
    db_delete('tbl_pages', "`page_id` = '{$page_id}'");
}
// Phân trang
function db_pagging($tbl, $record){
    global $conn;
    #Xuất dữ liệu
    $current_page_id = (int) !empty($_GET['page_id']) ? $_GET['page_id'] : 1;// id trang hiện tại
    $start = ($current_page_id - 1) * $record;// thứ tự dữ liệu bắt đầu lấy
    $sql = "SELECT* FROM $tbl LIMIT $start, $record";
    $list_current_rows = db_fetch_array($sql);
    foreach ($list_current_rows as &$user) {
        $user['url_update'] = "?mod=users&act=update&id={$user['user_id']}";
        $user['url_delete'] = "?mod=users&act=delete&id={$user['user_id']}";
    }
    unset($user);
    return $list_current_rows;
}

function get_pages($start = 1, $num_per_page = 10, $where = ''){
    if(!empty($where)){
        $where = "WHERE {$where}";
    }
    $list_pages = db_fetch_array("SELECT* FROM `tbl_pages` {$where} LIMIT {$start}, {$num_per_page}");
    return $list_pages;
} 

?>