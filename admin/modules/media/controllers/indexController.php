<?php
function construct(){
    load('helper', 'format');
    load_model('index');
}
//=================
//  INDEX  MEDIA
//=================
function indexAction(){
    load_view('list_media');
}
//======================
// APPLY-MEDIAS
//======================
function apply_mediasAction(){
    if(isset($_POST['sm_action'])){
        Global $error;
        if(is_login() && check_role($_SESSION['user_login']) == 1){
            $error = array();
            if(!empty($_POST['checkItem'])){
                $list_media_id = $_POST['checkItem'];
            }
            if(!empty($_POST['actions'])){
                if($_POST['actions'] == 1){
                    if(isset($_POST['checkItem'])){
                        foreach($list_media_id as $media_id){
                        delete_media($media_id);  
                        }
                        load_view('list_media');
                    } else{
                        $error['select'] = "Bạn chưa lựa chọn hình ảnh cần áp dụng";
                        load_view('list_media');
                    }
                }
            } else{
                $error['select'] = 'Bạn chưa lựa chọn tác vụ';
                load_view('list_media');
            }
        } else{
            $error['select'] = "Bạn không có quyền thực hiện thao tác này!";
            load_view('list_media');
        }
    }
}
//================
// SEARCH MEDIAS
//================
function search_mediasAction(){
    global $error, $value, $num_page;
    if (isset($_GET['sm_s'])) {
        if(!empty($_GET['value'])){
            $value = $_GET['value'];
            // $num_per_page = 3;
            // #Tổng số bản ghi
            // $list_medias_all = db_search_all_medias($value);
            // $total_row = count($list_medias_all);
            // #Số trang
            // $num_page = ceil($total_row / $num_per_page);
            load_view('search_media');
        } else{
            $error['error'] = 'Bạn cần nhập thông tin MEDIA cần tìm kiếm!';
            load_view('list_media');
        }
    }
}
function result_searchAction(){
    global $value;
    if(!empty($_GET['value'])){
        $value = $_GET['value'];
    }
    load_view('search_medias');
}
