<?php
function is_username($username){
    $partten = "/^[A-Za-z0-9_\.]{6,32}$/";
    if(preg_match($partten, $username, $matchs)){
        return true;
    }
}
function is_fullname($fullname) {
    $partten = "/^[A-Z a-z _\.]{6,32}$/";
    if (!preg_match($partten, $fullname, $matchs)) {
        return false;
    }
    return true;
}
function is_password($password){
    $partten = "/^([A-Z]){1}([\w_\.!@#$%^&*()]+){5,31}$/";
    if(preg_match($partten,$password, $matchs)){
        return true;
    }
}
function is_email($email){
    $partten = "/^([A-Z]){1}([\w_\.!@#$%^&*()]+){5,31}$/";
    if(!preg_match($partten, $email , $matchs)){
    return FALSE;
    return true;
    }
}
function is_phone_number($phone) {
    $partten = "/^(09|08|03[2|6|7|8|9])+([0-9]){8}$/";
    if (!preg_match($partten, $phone, $matchs)) {
        return false;
    }
    return true;
}
// check number valid
function is_number($number) {
    $pattern = "/^[0-9]*$/";
    if(preg_match($pattern,$number,$matches)) return true;
    return false;
}
function is_image($file_type, $file_size) {

    $type_allow = array('png', 'jpg', 'gif', 'jpeg');

    if (!in_array(strtolower($file_type), $type_allow)) {
        return false;
    } else {
        if ($file_size > 21000000) {
            return false;
        }
    }
    return true;
}
function form_error($label_field){
    global $error;
    if(!empty($error[$label_field])) return "<p class='error'>{$error[$label_field]}</p>";
}
function set_value($label_field){
    global $label_field;
    if(!empty($$label_field)) return $$label_field;
}
function is_exists($table, $key, $value) {
    $check = db_num_rows("SELECT * FROM `{$table}` WHERE `{$key}` = '{$value}'");
    if ($check > 0) {
        return true;
    }
    return false;
}
function check_role($username) {
    $result = db_fetch_row("SELECT * FROM `tbl_admins` WHERE `username` = '{$username}'");
    return $result['role'];
}
