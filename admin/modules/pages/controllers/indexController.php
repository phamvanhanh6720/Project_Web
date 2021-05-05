<?php
function construct() {
    load_model('index');
}
function indexAction(){
    load_view('pageIndex');
}
//================
// ADD PAGE
//================
function add_pageAction(){
    global $title, $error, $category, $slug, $page_content, $data;
    load('helper', 'slug');
    if (isset($_POST['btn-add_page'])) {
        $error = array();
        if (empty($_POST['title'])) {
            $error['title'] = 'Bạn chưa nhập tiêu đề';
        } else {
            $title = $_POST['title'];
        }
        if (empty($_POST['slug'])) {
            $error['slug'] = 'Bạn chưa nhập đường link thân thiện';
        } else {
            $slug = create_slug($_POST['slug']);
        }
        if (empty($_POST['page_content'])) {
            $error['page_content'] = 'Bạn chưa nhập nội dung trang';
        } else {
            $page_content = $_POST['page_content'];
        }
        if (empty($_POST['category'])) {
            $error['category'] = 'Bạn chưa chọn danh mục';
        } else {
            $category = $_POST['category'];
        }
        
        if (empty($error)) {
            $creator = $_SESSION['user_login'];
            $data = array(
            'title' => $title,
            'category' => $category,
            'slug'=> $slug,
            'page_content' => $page_content,
            'page_status' => 'Waitting...',
            'creator' => $creator,
            'created_date' => date("d/m/Y"),
            );
            insert_page($data);
            $error['page'] = "Thêm trang mới thành công";
        }
    }
    load_view('add_page');
}
//================
// UPDATE PAGE
//================
function update_pageAction(){
    global $title, $error, $category, $data;
    $page_id = $_GET['page_id'];
    if (isset($_POST['btn-update-page'])) {
        $error = array();
        //check title
        if (empty($_POST['title'])) {
            $error['title'] = 'Bạn chưa nhập tiêu đề trang';
        } else {
            $old_title = get_info_page('title', $page_id);
            if($_POST['title'] == $old_title){
                $data = array(
                    'title' => '',
                );
                update_page($data, $page_id);
            }
            if(is_exists('tbl_pages', 'title', $_POST['title'])){
                $error['title'] = '(*) Tên trang đã tồn tại';
            } else{
                $title = $_POST['title'];
            }
        }
        //check slug
        if (empty($_POST['slug'])) {
            $error['slug'] = 'Bạn chưa nhập đường dẫn thân thiện';
        } else {
            $old_slug = get_info_page('slug', $page_id);
            if($_POST['slug'] == $old_slug){
                $data = array(
                    'slug' => '',
                );
                update_page($data, $page_id);
            }
            if(is_exists('tbl_pages', 'slug', $_POST['slug'])){
                $error['slug'] = '(*) Đường link đã tồn tại';
            } else{
                $slug = $_POST['slug'];
            }
        }
        if (empty($_POST['page_content'])) {
            $error['page_content'] = 'Bạn chưa nhập nội dung trang';
        } else {
            $old_page_content = get_info_page('page_content', $page_id);
            $page_content = $_POST['page_content'];
        }
        if (empty($_POST['category'])) {
            $error['category'] = 'Bạn chưa chọn danh mục';
        } else {
            $old_category = get_info_page('category', $page_id);
            $category = $_POST['category'];
        }
        // check not change
        if(($title ==  $old_title) && ($category == $old_category) && ($slug == $old_slug) && ($page_content == $old_page_content)){
            $data = array(
                'title' => $old_title,
                'slug' => $old_slug,
            );
            update_page($data, $page_id);
            $error['page'] = "Trang chưa có thay đổi gì!";
        }
        if (empty($error)) {
            $data = array(
            'title' => $title,
            'slug'=> $slug,
            'page_content'=> $page_content,
            'category' => $category,
            );
            update_page($data, $page_id);
            $error['page'] = "Cập nhật thành công"."<br>"."<a href='?mod=pages&controller=index&action=index'>Trở về danh sách bài viết</a>";
        }
    }
    load_view('update_page');
}
//================
// APPLY PAGES
//================
function apply_pagesAction(){
    if(isset($_POST['sm_action'])){
        Global $error, $data;
        if(is_login() && check_role($_SESSION['user_login']) == 1){
            $error = array();
            if(!empty($_POST['checkItem'])){
                $list_page_id = $_POST['checkItem'];
            }
            if(!empty($_POST['actions'])){
                if($_POST['actions'] == 1){
                    if(isset($_POST['checkItem'])){
                        $data = array(
                            'page_status'=> 'Approved',
                        );
                        foreach($list_page_id as $page_id){
                        update_page($data, $page_id);  
                        }
                        if(isset($_GET['value'])){
                            load_view('search_pages');
                        } else{
                            load_view('pageIndex');
                        }
                    } else{
                        $error['select'] = "Bạn chưa lựa chọn trang cần áp dụng";
                        if(isset($_GET['value'])){
                            load_view('search_pages');
                        } else{
                            load_view('pageIndex');
                        }
                    }
                }
                if($_POST['actions'] == 2){
                    if(isset($_POST['checkItem'])){
                        $data = array(
                            'page_status'=> 'Waitting...',
                        );
                        foreach($list_page_id as $page_id){
                        update_page($data, $page_id);  
                        }
                        if(isset($_GET['value'])){
                            load_view('search_pages');
                        } else{
                            load_view('pageIndex');
                        }
                    } else{
                        $error['select'] = "Bạn chưa lựa chọn trang cần áp dụng";
                        if(isset($_GET['value'])){
                            load_view('search_pages');
                        } else{
                            load_view('pageIndex');
                        }
                    }
                }
                if($_POST['actions'] == 3){
                    if(isset($_POST['checkItem'])){
                        $data = array(
                            'page_status'=> 'Trash',
                        );
                        foreach($list_page_id as $page_id){
                        update_page($data, $page_id);  
                        }
                        if(isset($_GET['value'])){
                            load_view('search_pages');
                        } else{
                            load_view('pageIndex');
                        }
                    } else{
                        $error['select'] = "Bạn chưa lựa chọn trang cần xóa";
                        if(isset($_GET['value'])){
                            load_view('search_pages');
                        } else{
                            load_view('pageIndex');
                        }
                    }
                }
            } else{
                $error['select'] = 'Bạn chưa lựa chọn tác vụ';
                if(isset($_GET['value'])){
                    load_view('search_pages');
                } else{
                    load_view('pageIndex');
                }
            }
        } else{
            $error['select'] = "Bạn không có quyền thực hiện thao tác này!";
            if(isset($_GET['value'])){
                load_view('search_pages');
            } else{
                load_view('pageIndex');
            }
        }
    }
}
//================
// DELETE PAGE
//================
function delete_pageAction(){
    $page_id = $_GET['page_id'];
    delete_page($page_id);
    redirect_to('?mod=pages&controller=index&action=index');
}
//================
// SEARCH PAGES
//================
function search_pagesAction(){
    global $error, $value, $num_page;
    if (isset($_GET['sm_s'])) {
        if(!empty($_GET['value'])){
            $value = $_GET['value'];
            // $num_per_page = 3;
            // #Tổng số bản ghi
            // $list_pages_all = db_search_all_pages($value);
            // $total_row = count($list_pages_all);
            // #Số trang
            // $num_page = ceil($total_row / $num_per_page);
            load_view('search_pages');
        } else{
            $error['error'] = 'Bạn cần nhập thông tin TRANG cần tìm kiếm!';
            load_view('pageIndex');
        }
    }
}
function result_searchAction(){
    global $value;
    if(!empty($_GET['value'])){
        $value = $_GET['value'];
    }
    load_view('search_pages');
}