<?php

use WindowsAzure\ServiceRuntime\Internal\GoalState;

function construct(){
    load_model('index');
}
function indexAction(){
    load_view('postIndex');
}
//=================
// ADD POSTS
//=================

function add_postAction(){
    load('helper', 'image');
    load('helper', 'slug');
    global $error, $title, $slug, $post_content, $desc, $parent_cat, $data, $creator, $type, $size;
    if(isset($_POST['btn-add-post'])){
        $error = array();
        // check title post
        if(empty($_POST['title'])){     
            $error['title'] = '(*) Bạn cần nhập tiêu đề bài viết';
        } else{
            if(is_exists('tbl_posts', 'title', $_POST['title'])){
                $error['title'] = '(*) Tiêu đề bài viết đã tồn tại';
            } else{
                $title = $_POST['title'];
            }
        }
        // check slug
        if(empty($_POST['slug'])){                                                    
            $error['slug'] = '(*) Bạn cần nhập đường link thân thiện';
        } else{
            if(is_exists('tbl_posts', 'slug', $_POST['slug'])){
                $error['slug'] = '(*) Slug đã tồn tại';
            } else{
                $slug = create_slug($_POST['slug']);
            }
        }
        // check post content
        if(empty($_POST['post_content'])){                                             
            $error['post_content'] = '(*) Bạn cần nhập nội dung bài viết';
        } else{
            $post_content = $_POST['post_content'];
        }
        // check desc post
        if(empty($_POST['desc'])){                                             
            $error['desc'] = '(*) Bạn cần nhập nội dung bài viết';
        } else{
            $desc = $_POST['desc'];
        }
        // check parent cat
        if (empty($_POST['parent_cat'])) {                                                                      
            $error['parent_cat'] = "(*) Không được bỏ trống danh mục bài viết";
        } else {
            $parent_cat = $_POST['parent_cat'];
        }
        // check upload file
        if(isset($_FILES['file']) && !empty($_FILES['file']['name'])){
            $type = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $size = $_FILES['file']['size'];
            if (!is_image($type, $size)) {
                $error['upload_image'] = "kích thước hoặc kiểu ảnh không đúng";
            }
        } else{
            $error['upload_image'] = "(*) Bạn chưa upload tệp";
        }
        // check not error
        if(empty($error)){
            if(is_login() && check_role($_SESSION['user_login']) == 1){
                $post_status = 'Approved';
            } else{
                $post_status = 'Waitting...';
            }
            $post_thumbnail = upload_image('public/images/upload/posts/', $type);
            $creator =  get_admin_info($_SESSION['user_login']);
            $data = array(
                'title' => $title,
                'slug' => $slug,
                'post_content' => $post_content,
                'post_desc' => $desc,
                'post_thumbnail' => $post_thumbnail,
                'post_status' => $post_status,
                'creator'=>$creator,
                'created_date'=> date('d/m/y h:m'),
                'parent_cat' => $parent_cat,
            );
            add_post($data);
            $error['post'] = 'Thêm bài viết mới thành công'."<br>"."<a href='?mod=post&controller=index&action=index'>Trở về danh sách bài viết</a>";
        }
    }

    if (isset($_POST['btn-upload-thumb'])) {
        if (isset($_FILES['file']) && !empty($_FILES['file']['name'])) {
            $type = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $size = $_FILES['file']['size'];
            if (!is_image($type, $size)) {
                $error['upload_image'] = "kích thước hoặc kiểu ảnh không đúng";
            } else {
                $post_thumbnail = upload_image('public/images/upload/posts/', $type);
            }
        } else {
            $error['upload_image'] = "Bạn chưa chọn tệp ảnh";
        }
    }
    load_view('add_post');
}
//======================
//UPDATE-POST
//======================

function update_postsAction(){
    load('helper', 'image');
    load('helper', 'slug');
    global $post_id, $error, $old_thumbnail, $title, $slug, $post_content, $desc, $parent_cat, $data, $editor, $type, $size, $old_title, $old_slug, $old_post_content, $old_desc, $old_parent_cat;
    $post_id = $_GET['post_id'];
    if (isset($_POST['btn-update-post'])) {
        $error = array();
        // check title post
        if(empty($_POST['title'])){     
            $error['title'] = '(*) Bạn cần nhập tiêu đề bài viết';
        } else{
            $old_title = get_info_post('title', $post_id);
            if($_POST['title'] == $old_title){
                $data = array(
                    'title' => '',
                );
                update_post($data, $post_id);
            }
            if(is_exists('tbl_posts', 'title', $_POST['title'])){
                $error['title'] = '(*) Tiêu đề bài viết đã tồn tại';
            } else{
                $title = $_POST['title'];
            }
        }
        // check slug
        if(empty($_POST['slug'])){                                                    
            $error['slug'] = '(*) Bạn cần nhập đường link thân thiện';
        } else{
            $old_slug = get_info_post('slug', $post_id);
            if($_POST['slug'] == $old_slug){
                $data = array(
                    'slug' => '',
                );
                update_post($data, $post_id);
            }
            if(is_exists('tbl_posts', 'slug', $_POST['slug'])){
                $error['slug'] = '(*) Slug đã tồn tại';
            } else{
                $slug = create_slug($_POST['slug']);
            }
        }
        // check post content
        if(empty($_POST['post_content'])){                                             
            $error['post_content'] = '(*) Bạn cần nhập nội dung bài viết';
        } else{
            $old_post_content = get_info_post('post_content', $post_id);
            $post_content = $_POST['post_content'];
        }
        // check desc post
        if(empty($_POST['desc'])){                                                        
            $error['desc'] = '(*) Bạn cần nhập mô tả bài viết';
        } else{
            $old_desc = get_info_post('post_desc', $post_id);
            $desc = $_POST['desc'];
        }
        // check parent cat
        if (empty($_POST['parent_cat'])) {                                                                      
            $error['parent_cat'] = "(*) Không được bỏ trống danh mục bài viết";
        } else {
            $old_parent_cat = get_info_post('parent_cat', $post_id);
            $parent_cat = $_POST['parent_cat'];
        }
        // check upload file
        if(isset($_FILES['file']) && !empty($_FILES['file']['name'])){
            $type = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $size = $_FILES['file']['size'];
            if (!is_image($type, $size)) {
                $error['upload_image'] = "kích thước hoặc kiểu ảnh không đúng";
            } else {
                $old_thumbnail = get_info_post('post_thumbnail', $post_id);
                if(!empty($old_thumbnail)){
                    delete_image($old_thumbnail);
                    $post_thumbnail = upload_image('public/images/upload/posts/', $type); 
                } else {
                    $post_thumbnail = upload_image('public/images/upload/posts/', $type);
                }
            }
        } else{
            $post_thumbnail = get_info_post('post_thumbnail', $post_id);
        }
        // check not change
        if(($_POST['title'] ==  $old_title) && ($_POST['slug'] == $old_slug) && ($_POST['post_content'] == $old_post_content) && ($_POST['desc'] == $old_desc) && ($_POST['parent_cat'] == $old_parent_cat) && !(isset($_FILES['file']) && !empty($_FILES['file']['name']))){
            $data = array(
                'title' => $old_title,
                'slug' => $old_slug,
            );
            update_post($data, $post_id);
            $error['post'] = "Bài viết chưa có thay đổi gì!";
        }
        // check not error
        if(empty($error)){
            if(is_login() && check_role($_SESSION['user_login']) == 1){
                $post_status = 'Approved';
            } else{
                $post_status = 'Waitting...';
            }
            $editor =  get_admin_info($_SESSION['user_login']);
            $data = array(
                'title' => $title,
                'slug' => $slug,
                'post_content' => $post_content,
                'post_desc' => $desc,
                'post_thumbnail' => $post_thumbnail,
                'post_status'=> $post_status,
                'editor'=> $editor,
                'edit_date'=> date('d/m/y h:m'),
                'parent_cat' => $parent_cat,
            );
            update_post($data, $post_id);
            $error['post'] = 'Cập nhật bài viết thành công'."<br>"."<a href='?mod=post&controller=index&action=index'>Trở về danh sách bài viết</a>";
        }
    }
    load_view('update_post');
}
//======================
// DELETE-POST
//======================
function delete_postsAction(){
    $post_id = $_GET['post_id'];
    delete_post($post_id);
    redirect_to('?mod=post&controller=index&action=index');
}
//======================
// APPLY-POST
//======================
function apply_postsAction(){
    if(isset($_POST['sm_action'])){
        Global $error, $data;
        if(is_login() && check_role($_SESSION['user_login']) == 1){
            $error = array();
            if(!empty($_POST['checkItem'])){
                $list_post_id = $_POST['checkItem'];
            }
            if(!empty($_POST['actions'])){
                if($_POST['actions'] == 1){
                    if(isset($_POST['checkItem'])){
                        $data = array(
                            'post_status'=> 'Approved',
                        );
                        foreach($list_post_id as $post_id){
                        update_post($data, $post_id);  
                        }
                        if(isset($_GET['value'])){
                            load_view('search_posts');
                        } else{
                            load_view('postIndex');
                        }
                    } else{
                        $error['select'] = "Bạn chưa lựa chọn bài viết cần áp dụng";
                        if(isset($_GET['value'])){
                            load_view('search_posts');
                        } else{
                            load_view('postIndex');
                        }
                    }
                }
                if($_POST['actions'] == 2){
                    if(isset($_POST['checkItem'])){
                        $data = array(
                            'post_status'=> 'Waitting...',
                        );
                        foreach($list_post_id as $post_id){
                        update_post($data, $post_id);  
                        }
                        if(isset($_GET['value'])){
                            load_view('search_posts');
                        } else{
                            load_view('postIndex');
                        }
                    } else{
                        $error['select'] = "Bạn chưa lựa chọn bài viết cần áp dụng";
                        if(isset($_GET['value'])){
                            load_view('search_posts');
                        } else{
                            load_view('postIndex');
                        }
                    }
                }
                if($_POST['actions'] == 3){
                    if(isset($_POST['checkItem'])){
                        $data = array(
                            'post_status'=> 'Trash',
                        );
                        foreach($list_post_id as $post_id){
                        update_post($data, $post_id);  
                        }
                        if(isset($_GET['value'])){
                            load_view('search_posts');
                        } else{
                            load_view('postIndex');
                        }
                    } else{
                        $error['select'] = "Bạn chưa lựa chọn bài viết cần bỏ vào thùng rác";
                        if(isset($_GET['value'])){
                            load_view('search_posts');
                        } else{
                            load_view('postIndex');
                        }
                    }
                }
            } else{
                $error['select'] = 'Bạn chưa lựa chọn tác vụ';
                if(isset($_GET['value'])){
                    load_view('search_posts');
                } else{
                    load_view('postIndex');
                }
            }
        } else{
            $error['select'] = "Bạn không có quyền thực hiện thao tác này!";
            if(isset($_GET['value'])){
                load_view('search_posts');
            } else{
                load_view('postIndex');
            }
        }
    }
}
//================
// SEARCH POSTS
//================
function search_postsAction(){
    global $error, $value, $num_page;
    if (isset($_GET['sm_s'])) {
        if(!empty($_GET['value'])){
            $value = $_GET['value'];
            $num_per_page = 3;
            #Tổng số bản ghi
            $list_posts_all = db_search_all_posts($value);
            $total_row = count($list_posts_all);
            #Số trang
            $num_page = ceil($total_row / $num_per_page);
            load_view('search_posts');
        } else{
            $error['error'] = 'Bạn cần nhập thông tin BÀI VIẾT cần tìm kiếm!';
            load_view('postIndex');
        }
    }
}
function result_searchAction(){
    global $value;
    if(!empty($_GET['value'])){
        $value = $_GET['value'];
    }
    load_view('search_posts');
}


