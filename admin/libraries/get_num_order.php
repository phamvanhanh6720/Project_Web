<?php
# get num order
function get_num_order($parent_id, $data){
    foreach($data as $item){
        if($parent_id == $item['cat_id']){
            return $item['num_order'];
        }
    }
}