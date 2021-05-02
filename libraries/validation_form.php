<?php
function is_username($username){
    $partten = "/^[A-Za-z0-9_\.]{6,32}$/";
    if(preg_match($partten, $username, $matchs)){
        return true;
    }
}
function is_password($password){
    $partten = "/^([A-Z]){1}([\w_\.!@#$%^&*()]+){5,31}$/";
    if(preg_match($partten,$password, $matchs)){
        return true;
    }
}
function is_email($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }
    return true;
}
// check phone number valid
function is_phone($phone) {
    $partten = "/((09|03|07|08|05)+([0-9]{8})\b)/";
    if(preg_match($partten,$phone,$matches)) return true;
    return false;
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
    global $$label_field;
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




