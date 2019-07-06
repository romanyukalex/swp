<h2><?php echo CN_COMMENTS; ?></h2>

<a class="cn_top_menu" href="?u=page_list"><?php echo CN_PAGES_BY; ?></a>
<?php $countNewComments = CnComment::getCountNewComments(); ?>
<?php if ($countNewComments > 0): ?>
    <a class="cn_top_menu" href="?u=new"><?php echo CN_NEW . ': <span>' . $countNewComments . '</span>'; ?></a>
<? endif; ?>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/views/panel/layout/cn_action_panel.php'; ?>
<div class="commenton cn_comments_block">
    <?php if ($this->cnComments) {
        include_once $_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/views/panel/layout/cn_comments.php';
        $pagination = new CnPagination('common');
        $pagination->navigationView($_SERVER['SCRIPT_NAME'] . '?');
    } else {
        echo '<div class="cn_empty_block">' . CN_EMPTY . '</div>';
    }
    ?>
</div>