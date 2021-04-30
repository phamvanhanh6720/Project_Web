<?php
function redirect_to($url){
    if(!empty($url)){
        header("location: {$url}");
    }
}

