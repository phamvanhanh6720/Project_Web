<?php
function data_tree($data, $parent_id = 1, $level = 0){
    $result = array();
    foreach($data as $item){
        if($item['parent_id'] == $parent_id){
            $item['level'] = $level;
            $result[] = $item;
            // unset($data[$item['cat_id']]);
            $child = data_tree($data, $item['cat_id'], $level+1);
            $result = array_merge($result, $child);
        }
    }
    return $result;
}