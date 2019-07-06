<?php
include 'headset.php';

if (CN_TIME_ZONE !== '') {
    date_default_timezone_set(CN_TIME_ZONE);
}

CnSession::start();

$cnPanel = new CnPanelController();

if (!isset($_GET['u'])) $action = 'view';
else $action = $_GET['u'];

$panelConnect = 'action' . ucwords($action);

if (method_exists($cnPanel, $panelConnect)) {
    $title = array(
        'moderation' => CN_MODERATION,
        'users' => CN_USERS,
        'person' => CN_USERS,
        'complaints' => CN_COMPLAINTS,
        'trash' => CN_TRASH,
        'setting' => CN_SETTING,
        'page_list' => CN_PAGES_BY
    );
    include_once $_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/views/panel/layout/cn_header.php';
    $cnPanel->$panelConnect();
    include_once $_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/views/panel/layout/cn_footer.php';
} else {
    include_once($_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/error_404.php');
}