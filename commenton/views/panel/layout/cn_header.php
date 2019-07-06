<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="/<?php echo CN_FOLDER_SCRIPT; ?>/favicon.ico" type="image/x-icon">
    <meta charset="<?php echo CN_SET_ENCODING; ?>">
    <link href="/<?php echo CN_FOLDER_SCRIPT; ?>/style/panel_view.css" rel="stylesheet" type="text/css">
    <title><?php echo (isset($_GET['u']) && isset($title[$_GET['u']])) ? $title[$_GET['u']] : CN_COMMENTS; ?></title>
</head>
<body>
<div class="cn_panel_block"  data-time-zone="<?php echo (isset($_SESSION[CN_S_TIME_ZONE])) ? $_SESSION[CN_S_TIME_ZONE] : ''; ?>">
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/views/panel/layout/cn_menu.php'; ?>
    <div class="cn_content_block">
    