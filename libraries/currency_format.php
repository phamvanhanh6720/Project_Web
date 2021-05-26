<?php
function currency_format($number, $suffix = 'đ'){
    if(empty($number)){
        return false;
    } else{
        return number_format($number).$suffix;
    }
}