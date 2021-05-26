<?php
function get_title($mod, $action){
    if($mod == 'product'){
        return 'Sản phẩm';
    }
    if($mod == 'Blog'){
        return 'Blog';
    }
    if($mod == 'page' && $action == 'commend'){
        return 'Giới thiệu';
    }
    if($mod == 'page' && $action == 'contract'){
        return 'Liên hệ';
    }
}