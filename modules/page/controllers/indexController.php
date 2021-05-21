<?php
function construct(){
    load_model('index');
}
function indexAction(){
    if(isset($_GET['menu_id']) && !empty($_GET['menu_id'])){
        $menu_id = $_GET['menu_id'];
        $menu_title = get_info_menu('menu_title', $menu_id);
        if($menu_title == 'Giới thiệu'){
            load_view('commend');
        }
        if($menu_title == 'Liên hệ'){
            load_view('contract');
        }
    }
}
function detailAction(){
    load_view('index');
}