<?php
//========================
// Function global for all
//========================



//===============
// PHÂN TRANG
//===============
function get_posts($start = 1, $num_per_page = 10, $where = ''){
    if(!empty($where)){
        $where = "WHERE {$where}";
    }
    $list_posts = db_fetch_array("SELECT* FROM `tbl_posts` {$where} LIMIT {$start}, {$num_per_page}");
    return $list_posts;
} 

//==============
// POST
//==============

# get num posts

# add post
function add_post($data) {
    db_insert('tbl_posts', $data);
}
# update post
function update_post($data, $post_id){
    db_update('tbl_posts', $data, "`post_id`='{$post_id}'");
}
# get info post
function get_info_post($field, $post_id){
    $info_post_id = db_fetch_row("SELECT `$field` FROM `tbl_posts` WHERE `post_id` = '{$post_id}'");
    return  $info_post_id[$field];
}
# delete post
function delete_post($post_id) {
    db_delete("tbl_posts", "`post_id` = {$post_id}");
}

//==================
// DANH MỤC BÀI VIẾT
//==================

# get list post cat
function get_list_post_cat() {
    $list_cat = db_fetch_array("SELECT * FROM `tbl_post_cat`");
    if (!empty($list_cat)) {
        foreach ($list_cat as &$cat) {
            $cat['url_delete'] = "?mod=posts&action=deleteCat&cat_id={$cat['cat_id']}";
            $cat['url_update'] = "?mod=posts&action=updateCat&cat_id={$cat['cat_id']}";
        }
        return $list_cat;
    }
}
function get_cats($start = 1, $num_per_page = 10, $where = ''){
    if(!empty($where)){
        $where = "WHERE {$where}";
    }
    $list_cats = db_fetch_array("SELECT* FROM `tbl_post_cat` {$where} LIMIT {$start}, {$num_per_page}");
    return $list_cats;
} 
function text_color_cat_status($status){
    if(!empty($status)&& $status == 'Approved'){
        echo 'text-primary';
    } else if(!empty($status)&& $status == 'Waitting...'){
        echo 'text-success';
    } else{
        echo 'text-danger';
    }
}
# add cat
function add_cat($data) {
    db_insert('tbl_post_cat', $data);
}
# update cat
function update_cat($data, $cat_id){
    db_update('tbl_post_cat', $data, "`cat_id` = '{$cat_id}'");
}
# delete cat
function delete_cat($cat_id){
    db_delete('tbl_post_cat', "`cat_id` = '{$cat_id}'");
}
# get info cat
function get_info_cat($field, $cat_id){
    $info_cat = db_fetch_row("SELECT `$field` FROM `tbl_post_cat` WHERE `cat_id` = '{$cat_id}'");
    return  $info_cat[$field];
}
# get info cat by parent_id
function get_info_by_parent_id($field, $parent_id){
    $info_parent_id = db_fetch_array("SELECT `$field` FROM `tbl_post_cat` WHERE `parent_id` = '{$parent_id}'");
    return  $info_parent_id;
}