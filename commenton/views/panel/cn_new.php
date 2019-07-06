<h2><?php echo CN_NEW_COMMENTS; ?></h2>

<a class="cn_top_menu" href="<?php echo '/' . CN_FOLDER_SCRIPT . '/' . CN_PANEL_SCRIPT . '.php' ?>"><?php echo CN_BACK; ?></a>
<span class="cn_top_menu cn_all_read"><?php echo CN_MARK_ALL_READ; ?></span>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/views/panel/layout/cn_action_panel.php'; ?>
<div class="commenton cn_comments_block cn_new_comments">
    <?php if ($this->cnComments) {
        include_once $_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/views/panel/layout/cn_comments.php';
        $pagination = new CnPagination('new');
        $pagination->navigationView($_SERVER['SCRIPT_NAME'] . '?u=new&');
    } else {
        echo '<div class="cn_empty_block">' . CN_NOT_FOUND . '</div>';
    }
    ?>
</div>