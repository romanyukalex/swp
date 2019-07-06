<h2>
    <?php
    echo CN_SETTING;
    if (!isset($_GET['s'])) {
        echo ' : ' . CN_COMMON;
    } elseif ($_GET['s'] == 'social') {
        echo ' : ' . CN_SOCIAL;
    } elseif ($_GET['s'] == 'admin') {
        echo ' : ' . CN_ADMINISTRATOR;
    } elseif ($_GET['s'] == 'guests') {
        echo ' : ' . CN_GUESTS;
    }
    ?>
</h2>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/views/panel/layout/cn_menu_setting.php'; ?>
<div class="cn_setting_box">
    <?php
    if (!isset($_GET['s'])) {
        include_once $_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/views/panel/layout/cn_setting_common.php';
    } else {
        $path = $_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/views/panel/layout/cn_setting_'.$_GET['s'].'.php';
        if (file_exists($path)) {
            include_once $path;
        }
    }
    ?>
</div>