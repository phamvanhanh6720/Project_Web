<?php
function construct(){
    load('helper', 'format');
    load_model('index');
}
//===============
//  INDEX  slider
//===============
function indexAction(){
    load_view('sliderIndex');
}
//===============
//  ADD  SLIDER
//===============
function add_sliderAction(){
    load('helper', 'image');
    load('helper', 'slug');
    // load('helper', 'format');
    global $error, $title, $slider_status, $slug, $num_order, $desc, $slider_thumb, $slider_status, $data, $creator, $type, $size;
    if (isset($_POST['btn-add-slider'])) {
        $error = array(); 
        // check title slider
        if (empty($_POST['title'])) {
            $error['title'] = '(*) Bạn cần nhập tên slider';
        } else {
            if (is_exists('tbl_sliders', 'slider_title', $_POST['title'])) {
                $error['title'] = '(*) Tên slider đã tồn tại';
            } else {
                $title = $_POST['title'];
            }
        }
        // check slider link
        if (empty($_POST['slug'])) {
            $error['slug'] = '(*) Bạn cần nhập đường link slider';
        } else {
            if (is_exists('tbl_sliders', 'slider_slug', $_POST['slug'])) {
                $error['slug'] = '(*) Slug đã tồn tại';
            } else {
                $slug = create_slug($_POST['slug']);
            }
        }
        // check silder desc 
        if (empty($_POST['desc'])) {
            $error['desc'] = '(*) Bạn cần nhập mô tả ngắn silder';
        } else {
            $desc = $_POST['desc'];
        }
        // check silder num_order
        if (empty($_POST['num_order'])) {
            $error['num_order'] = '(*) Bạn cần nhập thứ tự slider';
        } else if(is_number($_POST['num_order'])){
            $num_order = $_POST['num_order'];
        } else {
            $error['num_order'] = '(*) Thứ tự chưa đúng định dạng';
        }
        // check upload file
        if (isset($_FILES['file']) && !empty($_FILES['file']['name'])) {
            $type = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $size = $_FILES['file']['size'];
            if (!is_image($type, $size)) {
                $error['upload_image'] = "kích thước hoặc kiểu ảnh không đúng";
            }
        } else {
            $error['upload_image'] = "(*) Bạn chưa upload tệp";
        }
        // check parent cat
        if (empty($_POST['status'])) {
            $error['status'] = "(*) Không được bỏ trống trạng thái slider";
        } else {
            $slider_status = $_POST['status'];
        }
        // check not error
        if (empty($error)) {
            if (is_login() && check_role($_SESSION['user_login']) != 1) {
                $slider_status = '2';
            }
            $slider_thumb = upload_image('public/images/upload/sliders/', $type);
            $creator =  get_admin_info($_SESSION['user_login']);
            $data = array(
                'slider_title' => $title,
                'slider_slug' => $slug,
                'slider_desc' => $desc,
                'slider_ordinal' => $num_order,
                'slider_thumb' => $slider_thumb,
                'slider_status' => $slider_status,
                'creator' => $creator,
                'created_date' => date('d/m/y h:m'),
            );
            add_slider($data);
            $error['slider'] = 'Thêm slider mới thành công'."<br>"."<a href='?mod=slider&controller=index&action=index'>Trở về danh sách slider</a>";
        }
    }
    if (isset($_POST['btn-upload-thumb'])) {
        if (isset($_FILES['file']) && !empty($_FILES['file']['name'])) {
            $type = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $size = $_FILES['file']['size'];
            if (!is_image($type, $size)) {
                $error['upload_image'] = "kích thước hoặc kiểu ảnh không đúng";
            } else {
                $slider_thumb = upload_image('public/images/upload/sliders/', $type);
            }
        } else {
            $error['upload_image'] = "Bạn chưa chọn tệp ảnh";
        }
    }
    load_view('add_slider');
}

//=================
// UPDATE SLIDERS
//=================
function update_slidersAction(){
    // load('helper', 'format');
    load('helper', 'image');
    load('helper', 'slug');
    global $data, $slider_id, $error, $old_thumb, $title, $num_order, $slider_thumb, $slug, $old_num_order, $old_slider_status, $desc, $data, $editor, $type, $size, $old_title, $old_slug, $old_desc;
    $slider_id = $_GET['slider_id'];
    if (isset($_POST['btn-update-slider'])) {
        $error = array();
        // check title post
        if(empty($_POST['title'])){     
            $error['title'] = '(*) Bạn cần nhập tên slider';
        } else{
            $old_title = get_info_slider('slider_title', $slider_id);
            if($_POST['title'] == $old_title){
                $data = array(
                    'slider_title' => '',
                );
                update_slider($data, $slider_id);
            }
            if(is_exists('tbl_sliders', 'slider_title', $_POST['title'])){
                $error['title'] = '(*) Tên slider đã tồn tại';
            } else{
                $title = $_POST['title'];
            }
        }
        
        // check slug
        if(empty($_POST['slug'])){                                                    
            $error['slug'] = '(*) Bạn cần nhập đường link thân thiện';
        } else{
            $old_slug = get_info_slider('slider_slug', $slider_id);
            if($_POST['slug'] == $old_slug){
                $data = array(
                    'slider_slug' => '',
                );
                update_slider($data, $slider_id);
            }
            if(is_exists('tbl_sliders', 'slider_slug', $_POST['slug'])){
                $error['slug'] = '(*) Slug đã tồn tại';
            } else{
                $slug = create_slug($_POST['slug']);
            }
        }
        // check desc slider
        if(empty($_POST['desc'])){                                                        
            $error['desc'] = '(*) Bạn cần nhập mô tả slider';
        } else{
            $desc = $_POST['desc'];
            $old_desc = get_info_slider('slider_desc', $slider_id);
        }
        // check status
        if (empty($_POST['status'])) {                                                                      
            $error['status'] = "(*) Không được bỏ trống trạng thái slider";
        } else {
            $slider_status = $_POST['status'];
            $old_slider_status = get_info_slider('slider_status', $slider_id);
        }
        // check silder num_order
        if (empty($_POST['num_order'])) {
            $error['num_order'] = '(*) Bạn cần nhập thứ tự slider';
        } else if(is_number($_POST['num_order'])){
            $num_order = $_POST['num_order'];
            $old_num_order = get_info_slider('slider_ordinal', $slider_id);
        } else {
            $error['num_order'] = '(*) Thứ tự chưa đúng định dạng';
        }
        // check upload file
        if(isset($_FILES['file']) && !empty($_FILES['file']['name'])){
            $type = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $size = $_FILES['file']['size'];
            if (!is_image($type, $size)) {
                $error['upload_image'] = "kích thước hoặc kiểu ảnh không đúng";
            } else {
                $old_thumb = get_info_slider('slider_thumb', $slider_id);
                if(!empty($old_thumb)){
                    delete_image($old_thumb);
                    $slider_thumb = upload_image('public/images/upload/sliders/', $type); 
                } else {
                    $slider_thumb = upload_image('public/images/upload/sliders/', $type);
                }
            }
        } else{
            $slider_thumb = get_info_slider('slider_thumb', $slider_id);
        }
        // check not change
        if(($title ==  $old_title) && ($slug == $old_slug) && ($desc == $old_desc) && ($slider_status == $old_slider_status) && ($num_order == $old_num_order) && !(isset($_FILES['file']) && !empty($_FILES['file']['name']))){
            $data = array(
                'slider_title' => $old_title,
                'slider_slug' => $old_slug,
            );
            update_slider($data, $slider_id);
            $error['slider'] = "Slider chưa có thay đổi gì!";
        }
        // check not error
        if(empty($error)){
            $slider_status = '2';
            $editor =  get_admin_info($_SESSION['user_login']);
            $data = array(
                'slider_title' => $title,
                'slider_slug' => $slug,
                'slider_desc' => $desc,
                'slider_thumb' => $slider_thumb,
                'slider_status'=> $slider_status,
                'editor'=> $editor,
                'edit_date'=> date('d/m/y h:m'),
            );
            update_slider($data, $slider_id);
            $error['slider'] = "Cập nhật slider thành công"."<br>"."<a href='?mod=slider&controller=index&action=index'>Trở về danh sách SLIDER</a>";
        }
    }
    load_view('update_slider');
}


//======================
// APPLY-SLIDERS
//======================

function apply_slidersAction(){
    if(isset($_POST['sm_action'])){
        Global $error, $data;
        if(is_login() && check_role($_SESSION['user_login']) == 1){
            $error = array();
            if(!empty($_POST['checkItem'])){
                $list_slider_id = $_POST['checkItem'];
            }
            if(!empty($_POST['actions'])){
                if($_POST['actions'] == 1){
                    if(isset($_POST['checkItem'])){
                        $data = array(
                            'slider_status'=> '1',
                        );
                        foreach($list_slider_id as $slider_id){
                        update_slider($data, $slider_id);  
                        }
                        if(isset($_GET['value'])){
                            load_view('search_sliders');
                        } else{
                            load_view('sliderIndex');
                        }
                    } else{
                        $error['select'] = "Bạn chưa lựa chọn slider cần áp dụng";
                        if(isset($_GET['value'])){
                            load_view('search_sliders');
                        } else{
                            load_view('sliderIndex');
                        }
                    }
                }
                if($_POST['actions'] == 2){
                    if(isset($_POST['checkItem'])){
                        $data = array(
                            'slider_status'=> '2',
                        );
                        foreach($list_slider_id as $slider_id){
                        update_slider($data, $slider_id);  
                        }
                        if(isset($_GET['value'])){
                            load_view('search_sliders');
                        } else{
                            load_view('sliderIndex');
                        }
                    } else{
                        $error['select'] = "Bạn chưa lựa chọn slider cần áp dụng";
                        if(isset($_GET['value'])){
                            load_view('search_sliders');
                        } else{
                            load_view('sliderIndex');
                        }
                    }
                }
                if($_POST['actions'] == 3){
                    if(isset($_POST['checkItem'])){
                        $data = array(
                            'slider_status'=> '3',
                        );
                        foreach($list_slider_id as $slider_id){
                        update_slider($data, $slider_id);  
                        }
                        if(isset($_GET['value'])){
                            load_view('search_sliders');
                        } else{
                            load_view('sliderIndex');
                        }
                    } else{
                        $error['select'] = "Bạn chưa lựa chọn slider cần xóa";
                        if(isset($_GET['value'])){
                            load_view('search_sliders');
                        } else{
                            load_view('sliderIndex');
                        }
                    }
                }
            } else{
                $error['select'] = 'Bạn chưa lựa chọn tác vụ';
                if(isset($_GET['value'])){
                    load_view('search_sliders');
                } else{
                    load_view('sliderIndex');
                }
            }
        } else{
            $error['select'] = "Bạn không có quyền thực hiện thao tác này!";
            if(isset($_GET['value'])){
                load_view('search_sliders');
            } else{
                load_view('sliderIndex');
            }
        }
    }
}



//======================
// DELETE SLIDER
//======================
function delete_slidersAction(){
    $slider_id = $_GET['slider_id'];
    delete_slider($slider_id);
    load_view('sliderIndex');
}

//================
// SEARCH SLIDER
//================

function search_slidersAction(){
    global $error, $value, $num_page;
    if (isset($_GET['sm_s'])) {
        if(!empty($_GET['value'])){
            $value = $_GET['value'];
            $num_per_page = 3;
            #Tổng số bản ghi
            $list_sliders_all = db_search_all_sliders($value);
            $total_row = count($list_sliders_all);
            #Số trangs
            $num_page = ceil($total_row / $num_per_page);
            load_view('search_sliders');
        } else{
            $error['error'] = 'Bạn cần nhập thông tin SLIDER cần tìm kiếm!';
            load_view('sliderIndex');
        }
    }
}
function result_searchAction(){
    global $value;
    if(!empty($_GET['value'])){
        $value = $_GET['value'];
    }
    load_view('search_sliders');
}