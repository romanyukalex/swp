<?php

function commentonAutoload($className)
{
    $arrPath = array(
        '/components/',
        '/controllers/',
        '/models/',
        '/components/social/'
    );

    foreach ($arrPath as $path) {
        $path = $_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . $path . $className . '.php';
        if (is_file($path)) {
            include_once $path;
        }
    }
}

spl_autoload_register('commentonAutoload');