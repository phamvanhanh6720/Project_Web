<?php
//===========
//  media
//===========
# update media
function update_media($data, $media_id){
    db_update('tbl_medias', $data, "`media_id`='{$media_id}'");
}
# delete media
function delete_media($media_id) {
    db_delete("tbl_medias", "`media_id` = {$media_id}");
}
# get info media
function get_info_media($field, $media_id){
    $info_media = db_fetch_row("SELECT `$field` FROM `tbl_medias` WHERE `media_id` = '{$media_id}'");
    if(!empty($info_media)){
        return  $info_media[$field];
    }
}

# show status
function show_status_active($data){
    if($data == 1){
        $data = 'Approved';
        return $data;
    } else if($data == 2){
        $data = 'Waitting...';
        return $data;
    } else{
        $data = 'Trash';
        return $data;
    }
}
# get_name_img
function get_name_img($url){
    if(!empty($url)){
        $array_name_img = explode('/', $$url);
        return[$array_name_img ];
    }
}
//=============
//ADD media
//=============
function add_media($data){
    db_insert("tbl_medias", $data);
}
//==============
// PHÂN TRANG
//==============
function get_medias($start = 1, $num_per_page = 10, $where = ''){
    if(!empty($where)){
        $where = "WHERE {$where}";
    }
    $list_medias = db_fetch_array("SELECT* FROM `tbl_medias` {$where} LIMIT {$start}, {$num_per_page}");
    return $list_medias;
} 
