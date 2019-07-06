<?php

include 'headset.php';

if (CN_TIME_ZONE !== '') {
    date_default_timezone_set(CN_TIME_ZONE);
}

if (urldecode($_SERVER['REQUEST_URI']) == '/' . CN_FOLDER_SCRIPT . '/' || urldecode($_SERVER['REQUEST_URI']) == '/' . CN_FOLDER_SCRIPT . '/index.php') {
    header("HTTP/1.0 404 Not Found");
    include 'error_404.php';
    exit;
}

$cn_connect = new Commenton();
$cn_connect->run();