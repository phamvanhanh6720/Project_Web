<?php
function get_pagging($num_page, $page)
{
    $str_pagging = "<ul class='pagging fl-right' id='list-paging'>";
    $str_pagging .= "<li><a class = 'common_selector'><<</a></li>";
    for ($i = 1; $i <= $num_page; $i++) {
        $active = "";
        if ($page == $i) {
            $active = 'active-num-page';
        }
        $str_pagging .= "<li><a class = 'common_selector $active'>$i</a></li>";
    }
    $str_pagging .= "<li><a class = 'common_selector'>>></a></li>";
    $str_pagging .= "</ul>";
    return $str_pagging;
}
function get_pagging_all($num_page, $page, $cat_id)
{
    $str_pagging = "<ul class='pagging fl-right' id='list-paging'>";
    $str_pagging .= "<li><a  class = 'num-page' cat-id = '$cat_id'><<</a></li>";
    for ($i = 1; $i <= $num_page; $i++) {
        $active = "";
        if ($page == $i) {
            $active = 'active-num-page';
        }
        $str_pagging .= "<li><a  class = 'num-page $active' cat-id = '$cat_id'>$i</a></li>";
    }
    $str_pagging .= "<li><a  class = 'num-page' cat-id = '$cat_id'>>></a></li>";
    $str_pagging .= "</ul>";
    return $str_pagging;
}
function get_pagging_post($num_page, $page)
{
    $str_pagging = "<ul class='pagging fl-right' id='list-paging'>";
    $str_pagging .= "<li><a  class = 'common_selector_post'><<</a></li>";
    for ($i = 1; $i <= $num_page; $i++) {
        $active = "";
        if ($page == $i) {
            $active = 'active-num-page';
        }
        $str_pagging .= "<li><a  class = 'common_selector_post $active'>$i</a></li>";
    }
    $str_pagging .= "<li><a  class = 'common_selector_post'>>></a></li>";
    $str_pagging .= "</ul>";
    return $str_pagging;
}
function get_pagging_search($num_page, $page, $cat_id, $value)
{
    $str_pagging = "<ul class='pagging fl-right' id='list-paging'>";
    $str_pagging .= "<li><a  class = 'common_selector_search' value='$value' cat-id = '$cat_id'><<</a></li>";
    for ($i = 1; $i <= $num_page; $i++) {
        $active = "";
        if ($page == $i) {
            $active = 'active-num-page';
        }
        $str_pagging .= "<li><a  class = 'common_selector_search $active' value='$value' cat-id = '$cat_id'>$i</a></li>";
    }
    $str_pagging .= "<li><a  class = 'common_selector_search' value='$value' cat-id = '$cat_id'>>></a></li>";
    $str_pagging .= "</ul>";
    return $str_pagging;
}
function db_num_page($tbl, $record)
{
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
