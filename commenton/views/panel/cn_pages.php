<h2><?php echo CN_PAGES_BY; ?></h2>

<?php if (!isset($_GET['pid'])): ?>
    <a class="cn_top_menu"
       href="<?php echo '/' . CN_FOLDER_SCRIPT . '/' . CN_PANEL_SCRIPT . '.php' . (isset($_GET['f']) ? '?u=page_list' : '') ?>"><?php echo CN_BACK; ?></a>
    <div class="cn_pages_block">
        <div class="cn_pages_filter_block">
            <form name="cn_pages_filter_form" action="" method="get">
                <label for="cn_pages_filter_url"><?= CN_PAGES_FILTER; ?></label><br>
                <input id="cn_pages_filter_url" name="f" placeholder="<?= CN_ENTER_PID; ?>" value="<?= (isset($_GET['f']) ? $_GET['f'] : '') ?>" required type="text">
                <input name="u" value="page_list" type="hidden">
                <input id="cn_pages_filter_button" value="<?= CN_FIND; ?>" type="submit">
            </form>
        </div>
        <?php if (isset($_GET['f'])) : ?>
            <b><?= CN_RESULT_FILTER ?>:</b>
        <? endif; ?>
        <?php if ($pageList): ?>
            <?php foreach ($pageList as $val):
                $countCommentsPage = CnComment::getCountByCondition('page', $val[CN_T_PID]);
                if ($countCommentsPage > 0): ?>
                    <div class="cn_page_item">
                        <a href="<?php echo urldecode($_SERVER['REQUEST_URI']); ?>&pid=<?php echo $val[CN_T_PID]; ?>"><?php echo $val[CN_T_PAGE_TITLE]; ?></a>
                        (<?php echo $countCommentsPage; ?>)
                        <div class="cn_page_item_options">
                            <span class="cn_pid_edit" data-alert="<?= CN_ENTER_NEW_PID ?>"
                                  data-pid="<?php echo $val[CN_T_PID]; ?>" title="<?= CN_PID_EDIT ?>"></span>
                        </div>
                    </div>
                <? endif;
            endforeach; ?>
            <?php
            $pagination = new CnPagination('page_list');
            $pagination->navigationView($_SERVER['SCRIPT_NAME'] . '?u=page_list&');
            ?>
        <? else: ?>
            <?php echo '<div class="cn_empty_block">' . CN_NOT_FOUND . '</div>'; ?>
        <? endif; ?>
    </div>
<?php else: ?>
    <a class="cn_top_menu"
       href="<?php echo '/' . CN_FOLDER_SCRIPT . '/' . CN_PANEL_SCRIPT . '.php?u=page_list' . (isset($_GET['pl']) ? '&pl=' . $_GET['pl'] : '') . (isset($_GET['f']) ? '&f=' . $_GET['f'] : '') ?>"><?php echo CN_BACK; ?></a>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/views/panel/layout/cn_action_panel.php'; ?>
    <div class="commenton cn_comments_block">
        <?php if ($this->cnComments) {
            include_once $_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/views/panel/layout/cn_comments.php';
            $pagination = new CnPagination('page', $_GET['pid']);
            $pagination->navigationView($_SERVER['SCRIPT_NAME'] . '?u=page_list' . (isset($_GET['pl']) ? '&pl=' . $_GET['pl'] : '') . '&pid=' . $_GET['pid'] . '&');
        } else {
            echo '<div class="cn_empty_block">' . CN_EMPTY . '</div>';
        }
        ?>
    </div>
<? endif; ?>