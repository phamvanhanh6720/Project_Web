<?php

function base_url($url = "") {
    global $config;
    return $config['base_url'].$url;
}
