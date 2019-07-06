<?php

class CnLog
{
    public static function writeLog($data)
    {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/logs.log', PHP_EOL . $data, FILE_APPEND);
    }
}