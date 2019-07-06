<div class="cn_menu_block">
    <div class="cn_image_icon"></div>
    <div class="cn_menu">
        <a class="cn_menu_comments <?php if (!isset($_GET['u']) || $_GET['u'] == 'page_list') echo 'cn_menu_select' ?>"
           href="<?= CN_PANEL_SCRIPT ?>.php"><span class="cn_menu_item"><?php echo CN_COMMENTS; ?></span></a>
        <a class="cn_menu_moderation <?php if (isset($_GET['u']) && $_GET['u'] == 'moderation') echo 'cn_menu_select' ?>" href="?u=moderation">
            <span class="cn_menu_item"><?php echo CN_MODERATION; ?></span>
            <?php
            $cnCountModeration = CnComment::getCountModeration();
            if ($cnCountModeration > 0) {
                echo '<span class="cn_menu_count">' . $cnCountModeration . '</span>';
            }
            ?>
        </a>
        <a class="cn_menu_users <?php if (isset($_GET['u']) && ($_GET['u'] == 'users' || $_GET['u'] == 'person')) echo 'cn_menu_select' ?>" href="?u=users"><span class="cn_menu_item"><?php echo CN_USERS; ?></span></a>
        <a class="cn_menu_complaints <?php if (isset($_GET['u']) && $_GET['u'] == 'complaints') echo 'cn_menu_select' ?>" href="?u=complaints">
            <span class="cn_menu_item"><?php echo CN_COMPLAINTS; ?></span>
            <?php
            $cnCountComplaints = CnComment::getCountComplaints();
            if ($cnCountComplaints > 0) {
                echo '<span class="cn_menu_count">' . $cnCountComplaints . '</span>';
            }
            ?>
        </a>
        <a class="cn_menu_trash <?php if (isset($_GET['u']) && $_GET['u'] == 'trash') echo 'cn_menu_select' ?>" href="?u=trash"><span class="cn_menu_item"><?php echo CN_TRASH; ?></span></a>
        <a class="cn_menu_setting <?php if (isset($_GET['u']) && $_GET['u'] == 'setting') echo 'cn_menu_select' ?>"
           href="?u=setting"><span class="cn_menu_item"><?php echo CN_SETTING; ?></span></a>
        <a id="cn_logout" class="cn_menu_logout" href=""><span class="cn_menu_item"><?php echo CN_LOGOUT; ?></span></a>
    </div>
</div>