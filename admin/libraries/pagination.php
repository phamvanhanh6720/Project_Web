<?php
function get_pagging($num_page, $page, $base_url = ''){
    $str_pagging = "<ul class='pagging fl-right' id='list-paging'>";
    if($page > 1){
        $page_prev = $page-1;
        $str_pagging .= "<li><a href = \"{$base_url}&page_id'={$page_prev}\"><<</a></li>";
    }
    for($i = 1; $i <= $num_page; $i++){
       $active = "";
       if($page == $i){
           $active = "class = 'active-num-page'";
       }
       $str_pagging .= "<li {$active}><a href = \"{$base_url}&page_id={$i}\">$i</a></li>";
    }
    if($page < $num_page){
        $page_next = $page+1;
        $str_pagging .= "<li><a href = \"{$base_url}&page_id'={$page_next}\">>></a></li>";
    }
    $str_pagging .= "</ul>";
    return $str_pagging;
}
function db_num_page($tbl, $record){
    global $conn;
    #Số lượng trang
    $sql = "SELECT* FROM $tbl";
    $num_rows = db_num_rows($sql);
    $num_page = ceil($num_rows / $record);
    # danh sách số thứ tự trang 1,2,3,4....
    $list_num_page = array();
    for ($i = 1; $i <= $num_page; $i++) {
        $list_num_page[] = $i;
    }
    return $list_num_page;
}
// // Pagination view more
// function get_pagging_more($num_page, $page){
//     $str_pagging = "<ul class='pagging fl-right' id='list-paging'>";
//     if($page > 1){
//         $page_prev = $page-1;
//         $str_pagging .= "<li><a href = \"{$base_url}&page_id'={$page_prev}\"><<</a></li>";
//     }
//     for($i = 1; $i <= $num_page; $i++){
//        $active = "";
//        if($page == $i){
//            $active = "class = 'active-num-page'";
//        }
//        $str_pagging .= "<li {$active}><a href = \"{$base_url}&page_id={$i}\">$i</a></li>";
//     }
//     if($page < $num_page){
//         $page_next = $page+1;
//         $str_pagging .= "<li><a href = \"{$base_url}&page_id'={$page_next}\">>></a></li>";
//     }
//     $str_pagging .= "</ul>";
//     return $str_pagging;
// }
?>