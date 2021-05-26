<?php
function get_user_by_id($id){
    $item = db_fetch_row("SELECT* FROM `tbl_admins` WHERE `admin_id` = {$id}");
    return $item;
}
function update_info_account($data, $user){
	db_update('tbl_admins', $data, "`username` = '{$user}'");
}
function update_pass_new($data){
    db_update('tbl_admins', $data, "`username` = '{$_SESSION['user_login']}'");
}
function get_info_admin($field, $admin_id){
    $info_admin_id = db_fetch_row("SELECT `$field` FROM `tbl_admins` WHERE `admin_id` = '{$admin_id}'");
    return  $info_admin_id[$field];
}
// Cập nhật admin
function update_admin($data, $admin_id){ 
    db_update('tbl_admins', $data, "`admin_id`='{$admin_id}'");
}
// Xóa admin
function delete_admin($admin_id){
    db_delete('tbl_admins', "`admin_id` = '{$admin_id}'");
}
// Thêm mới
function insert_admin($data){
    db_insert('tbl_admins', $data);
}
// active_users
// function update_active_user(){
//     db_update('tbl_pages', array('active'=>'Hoạt động'), "`created_person` = '{$_SESSION['user_login']}'");
// }
// function update_not_active_user(){
//     db_update('tbl_pages', array('active'=>'Không hoạt động'), "`created_person` = '{$_SESSION['user_login']}'");
// }
# active_admins
function update_active_admin(){
    db_update('tbl_admins', array('active'=>'Hoạt động'), "`username` = '{$_SESSION['user_login']}'");
}
function update_not_active_admin(){
    db_update('tbl_admins', array('active'=>'Không hoạt động'), "`username` = '{$_SESSION['user_login']}'");
}
// danh sách admins

function get_admins($start = 1, $num_per_page = 10, $where = ''){
    if(!empty($where)){
        $where = "WHERE {$where}";
    }
    $list_users = db_fetch_array("SELECT* FROM `tbl_admins` {$where} LIMIT {$start}, {$num_per_page}");
    return $list_users;
}
?>