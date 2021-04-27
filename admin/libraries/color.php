<?php
function text_color_status($status){
    if(!empty($status) && $status == 'Approved' || $status == 'Đang vận chuyển'){
        echo 'text-primary';
    } else if(!empty($status) && $status == 'Waitting...' || $status == 'Chờ duyệt'){
        echo 'text-success';
    } else{
        echo 'text-danger';
    }
}