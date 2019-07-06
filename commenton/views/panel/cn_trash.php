<h2><?php echo CN_TRASH; ?></h2>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/views/panel/layout/cn_action_panel.php'; ?>
<div class="commenton cn_comments_block">
    <?php if ($this->cnComments) {
        include_once $_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/views/panel/layout/cn_comments.php';
        $pagination = new CnPagination('trash');
        $pagination->navigationView($_SERVER['SCRIPT_NAME'] . '?u=trash&');
    } else {
        echo '<div class="cn_empty_block">' . CN_EMPTY . '</div>';
    }
    ?>
</div>