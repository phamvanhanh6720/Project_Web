<?php

function construct(){
    load_model('index');
}
function indexAction(){
    load_view('list_cat');
}
//=================
// ADD CAT
//=================
function add_catAction(){
    load('helper', 'slug');
    if(isset($_POST['btn-add-cat'])){
        global $error, $title, $slug, $parent_id, $data, $creator, $cat_status;
        $error = array();
        // check title 
        if(empty($_POST['title'])){     
            $error['title'] = '(*) Bạn cần nhập tên danh mục';
        } else{
            if(is_exists('tbl_post_cat', 'title', $_POST['title'])){
                $error['title'] = '(*) Tên danh mục đã tồn tại';
            } else{
                $title = $_POST['title'];
            }
        }
        // check slug
        if(empty($_POST['slug'])){                                                    
            $error['slug'] = '(*) Bạn cần nhập đường link thân thiện';
        } else{
            if(is_exists('tbl_post_cat', 'slug', $_POST['slug'])){
                $error['slug'] = '(*) Slug đã tồn tại';
            } else{
                $slug = create_slug($_POST['slug']);
            }
        }
        // check parent id
        if (empty($_POST['parent_id'])) {                                                                      
            $parent_id = 0;
        } else {
            $parent_id = $_POST['parent_id'];
        }
        // check not error
        if(empty($error)){
            if(is_login() && check_role($_SESSION['user_login']) == 1){
                $cat_status = 'Approved';
            } else{
                $cat_status = 'Waitting...';
            }
            // $num_cat = db_num_rows('SELECT* FROM `tbl_post_cat`');
            $creator =  get_admin_info($_SESSION['user_login']);
            $data = array(
                // 'cat_id' => $num_cat + 1,
                'title' => $title,
                'cat_status' => $cat_status,
                'slug' => $slug,
                'creator'=>$creator,
                'created_date'=> date('d/m/y h:m'),
                'parent_id' => $parent_id,
            );
            add_cat($data);
            $error['cat'] = 'Thêm danh mục mới thành công'."<br>"."<a href='?mod=post&controller=post_cat&action=index'>Trở về danh sách danh mục</a>";
        } 
    }
    load_view('add_cat');
}  

//=================
// UPDATE CAT
//=================
function update_catAction(){
    load('helper', 'slug');
    global $cat_id, $error,$title, $slug, $parent_id, $data, $editor, $old_title, $old_slug, $old_parent_id;
    $cat_id = $_GET['cat_id'];
    if(isset($_POST['btn-update-cat'])){
        $error = array();
        // check title post
        if(empty($_POST['title'])){     
            $error['title'] = '(*) Bạn cần nhập tên danh mục';
        } else{
            $old_title = get_info_cat('title', $cat_id);
            if($_POST['title'] == $old_title){
                $data = array(
                    'title' => '',
                );
                update_cat($data, $cat_id);
            }
            if(is_exists('tbl_post_cat', 'title', $_POST['title'])){
                $error['title'] = '(*) Tên danh mục đã tồn tại';
            } else{
                $title = $_POST['title'];
                // echo $title;
            }
        }
        // check title slug
        if(empty($_POST['slug'])){                                                    
            $error['slug'] = '(*) Bạn cần nhập đường link thân thiện';
        } else{
            $old_slug = get_info_cat('slug', $cat_id);
            if($_POST['slug'] == $old_slug){
                $data = array(
                    'slug' => '',
                );
                update_cat($data, $cat_id);
            }
            if(is_exists('tbl_post_cat', 'slug', $_POST['slug'])){
                $error['slug'] = '(*) Slug đã tồn tại';
            } else{
                $slug = create_slug($_POST['slug']);
                // echo $slug;
            }
        }
        // check parent cat
        if (empty($_POST['parent_id'])) {                                                                      
            $parent_id = 0;
            $old_parent_id = get_info_cat('parent_id', $cat_id);
        } else {
            $old_parent_id = get_info_cat('parent_id', $cat_id);
            $parent_id = $_POST['parent_id'];
        }
        // check not change
        if(($_POST['title'] ==  $old_title) && ($_POST['slug'] == $old_slug) && ($_POST['parent_id'] == $old_parent_id)){
            $data = array(
                'title' => $old_title,
                'slug' => $old_slug,
            );
            update_cat($data, $cat_id);
            $error['cat'] = "Danh mục chưa có thay đổi gì!";
        }
        // check not error
        if(empty($error)){
            if(is_login() && check_role($_SESSION['user_login']) == 1){
                $cat_status = 'Approved';
            } else{
                $cat_status = 'Waitting...';
            }
            $editor =  get_admin_info($_SESSION['user_login']);
            $data = array(
                'title' => $title,
                'slug' => $slug,
                'cat_status'=> $cat_status,
                'editor'=> $editor,
                'edit_date'=> date('d/m/y h:m'),
                'parent_id' => $parent_id,
            );
            update_cat($data, $cat_id);
            $error['cat'] = 'Cập nhật danh mục thành công'."<br>"."<a href='?mod=post&controller=post_cat&action=index'>Trở về danh sách danh mục</a>";
        }
    }
    load_view('update_cat');
}  
//======================
// APPLY-POST-CATS
//======================

function apply_post_catsAction(){
    if(isset($_POST['sm_action'])){
        Global $error, $data;
        if(is_login() && check_role($_SESSION['user_login']) == 1){
            $error = array();
            if(!empty($_POST['checkItem'])){
                $list_post_cat_id = $_POST['checkItem'];
            }
            if(!empty($_POST['actions'])){
                if($_POST['actions'] == 1){
                    if(isset($_POST['checkItem'])){
                        $data = array(
                            'cat_status'=> 'Approved',
                        );
                        foreach($list_post_cat_id as $post_cat_id ){
                        update_cat($data, $post_cat_id );  
                        }
                        if(isset($_GET['value'])){
                            load_view('search_post_cat');
                        } else{
                            load_view('list_cat');
                        }
                    } else{
                        $error['select'] = "Bạn chưa lựa chọn danh mục cần áp dụng";
                        if(isset($_GET['value'])){
                            load_view('search_post_cat');
                        } else{
                            load_view('list_cat');
                        }
                    }
                }
                if($_POST['actions'] == 2){
                    if(isset($_POST['checkItem'])){
                        $data = array(
                            'cat_status'=> 'Waitting...',
                        );
                        foreach($list_post_cat_id as $post_cat_id ){
                        update_cat($data, $post_cat_id );  
                        }
                        if(isset($_GET['value'])){
                            load_view('search_post_cat');
                        } else{
                            load_view('list_cat');
                        }
                    } else{
                        $error['select'] = "Bạn chưa lựa chọn danh mục cần áp dụng";
                        if(isset($_GET['value'])){
                            load_view('search_post_cat');
                        } else{
                            load_view('list_cat');
                        }
                    }
                }
                if($_POST['actions'] == 3){
                    if(isset($_POST['checkItem'])){
                        $data = array(
                            'cat_status'=> 'Trash',
                        );
                        foreach($list_post_cat_id as $post_cat_id ){
                        update_cat($data, $post_cat_id );  
                        }
                        if(isset($_GET['value'])){
                            load_view('search_post_cat');
                        } else{
                            load_view('list_cat');
                        }
                    } else{
                        $error['select'] = "Bạn chưa lựa chọn danh mục cần xóa";
                        if(isset($_GET['value'])){
                            load_view('search_post_cat');
                        } else{
                            load_view('list_cat');
                        }
                    }
                }
            } else{
                $error['select'] = 'Bạn chưa lựa chọn tác vụ';
                if(isset($_GET['value'])){
                    load_view('search_post_cat');
                } else{
                    load_view('list_cat');
                }
            }
        } else{
            $error['select'] = "Bạn không có quyền thực hiện thao tác này!";
            if(isset($_GET['value'])){
                load_view('search_post_cat');
            } else{
                load_view('list_cat');
            }
        }
    }
}

//======================
// DELETE-CAT
//======================
function delete_catAction(){
    $cat_id = $_GET['cat_id'];
    delete_cat($cat_id);
    load_view('list_cat');
}

//================
// SEARCH POST CATS
//================
function search_post_catAction(){
    global $error, $value, $num_page;
    if (isset($_GET['sm_s'])) {
        if(!empty($_GET['value'])){
            $value = $_GET['value'];
            // $num_per_page = 5;
            // #Tổng số bản ghi
            // $list_post_cat_all = db_search_all_post_cats($value);
            // $total_row = count($list_post_cat_all);
            // #Số trang
            // $num_page = ceil($total_row / $num_per_page);
            load_view('search_post_cat');
        } else{
            $error['error'] = 'Bạn cần nhập thông tin DANH MỤC cần tìm kiếm!';
            load_view('list_cat');
        }
    }
}
function result_searchAction(){
    global $value;
    if(!empty($_GET['value'])){
        $value = $_GET['value'];
    }
    load_view('search_post_cat');
}

?>