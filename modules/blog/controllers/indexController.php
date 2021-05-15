<?php
function construct(){
    load_model('index');
}
function indexAction(){
    load_view('index');
}
function mainAction(){
    load_view('index');
}
function detail_blogAction(){
    load_view('detail_blog');
}
function pagination_postAction(){
    $result_post = '';
    $query = "SELECT* FROM `tbl_posts` WHERE `post_status` = 'Approved' ORDER BY `post_id` DESC";
    $list_posts = db_fetch_array($query);
    # Pagination
    #Số bản ghi/trang
    $num_per_page = 5;
    #Tổng số bản ghi
    $total_row = count($list_posts);
    #Số trang
    $num_page = ceil($total_row / $num_per_page);
    if(isset($_POST['page_num'])){
        $page_num = (int) $_POST['page_num'];
        if($_POST['page_num'] == '<<'){
            if($page_num < 1){
                $page_num = 1;
            } else{
                $page_num -= 1;
            }                }
        if($_POST['page_num'] == '>>'){
            if($page_num = $num_page){
                $page_num = $num_page;
            } else{
                $page_num += 1;
            }
        }
    } else{
        $page_num = 1;
    }
    $start = ($page_num - 1) * $num_per_page;
    $list_posts_by_page = array_slice($list_posts, $start, $num_per_page);
    $result_post .= '
        <div class="section-detail">
            <ul class="list-item">
    ';
    if (!empty($list_posts_by_page)) {
        foreach($list_posts_by_page as $post){
            $result_post .= '
            <li class="clearfix">
                <a href="?mod=blog&action=detail_blog&post_id='.$post['post_id'].'" title="" class="thumb fl-left">
                    <img src="admin/'.$post['post_thumbnail'].'" alt="">
                </a>
                <div class="info fl-right">
                    <a href="?mod=blog&action=detail_blog&post_id='.$post['post_id'].'" title="" class="title">'.$post['title'].'</a>
                    <span class="create-date">'.$post['created_date'].'</span>
                    <p class="desc">'.$post['post_desc'].'</p>
                </div>
            </li>
        ';
        }
    }
    $result_post .= '
                </ul>
            </div>';
    if (!empty($list_posts_by_page)){
        $result_post .= '
        <div class="section" id="paging-wp">
            <div class="section-detail">
                <ul class="list-item clearfix">
                    '.get_pagging_post($num_page, $page_num).'
                </ul>
            </div>
        </div>
        ';
    }
            
    $data = array(
        'result_post' => $result_post,
    );
    echo json_encode($data);
} 