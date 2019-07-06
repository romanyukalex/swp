<h2><?php echo CN_CHAIN . ' - ' . $_GET['i']; ?></h2>

<a class="cn_top_menu"
   href="<?php echo (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '/' . CN_FOLDER_SCRIPT . '/' . CN_PANEL_SCRIPT . '.php' ?>"><?php echo CN_BACK; ?></a>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/views/panel/layout/cn_action_panel.php'; ?>
<div class="commenton cn_comments_block cn_new_comments">
    <?php if ($this->cnComments) {
        include_once $_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/views/panel/layout/cn_comments.php';
    } else {
        echo '<div class="cn_empty_block">' . CN_NOT_FOUND . '</div>';
    }
    ?>
</div>