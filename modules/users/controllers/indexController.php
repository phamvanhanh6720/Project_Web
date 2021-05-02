<?php
function construct(){
    load_model('index');
}
function indexAction(){
    $list_users = get_list_users();
    $data['list_users'] = $list_users;
//    show_array($list_users);
    load('helper', 'format');
    load_view('index', $data);
}