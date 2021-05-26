<?php
function get_list_users(){
    $result = db_fetch_array("SELECT * FROM `tbl_admins`");
    return $result;
}
function check_login($username,$password){
    $list_users = db_fetch_array("SELECT * FROM `tbl_admins`");
    foreach($list_users as $user){
        if($username == $user['username'] && md5($password) == $user['password']){
            return True;  
        } 
    } 
    return FALSE;   
}
// Trả về true nếu đã login
function is_login(){
    if(isset($_SESSION['is_login']))
        return  true;
    return false;
}
function user_login(){
    if(!empty($_SESSION['user_login']))
        return  $_SESSION['user_login'];
    return false;
}

function info_user($field){
    $list_users = get_list_users();
    if(isset($_SESSION['is_login'])){
        foreach ($list_users as $user){
            if($_SESSION['user_login']== $user['username']){
                if(array_key_exists($field, $user))
                        return $user[$field];
            }
        }
    }
}
function get_info_account($data){
    $info = db_fetch_row("SELECT `$data` FROM `tbl_admins` WHERE `username` = '{$_SESSION['user_login']}'");
    if(!empty($info)) return $info[$data];
    return false;
}
function get_admin_info($username) {
    $result = db_fetch_row("SELECT * FROM `tbl_admins` WHERE `username` = '{$username}'");
    return $result['fullname'];
}