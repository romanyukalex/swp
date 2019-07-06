<?php

class CnDb
{
    public static function getConnect()
    {
        $params = include $_SERVER['DOCUMENT_ROOT'] . '/project/freecon/modules_data/commenton.config.db_config.php';
        $mysqli = new mysqli($params['host'], $params['user'], $params['password'], $params['base_name']);
        $mysqli->set_charset($params['charset']);
        return $mysqli;
    }
}