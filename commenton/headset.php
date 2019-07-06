<?php

define('CN_FOLDER_SCRIPT', basename(__DIR__));

//ini_set('log_errors', 'On');
//ini_set('error_log', $_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/logs.log');

include_once($_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/config/config.php'); //В пproject moduledata
include_once($_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/config/session_config.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/config/setting.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/config/social_key.php');//В пproject moduledata
include_once($_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/config/db_table.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/config/language/ru-Ru.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/components/auto_load.php');