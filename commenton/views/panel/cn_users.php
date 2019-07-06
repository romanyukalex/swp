<h2><?php echo CN_USERS;
    if (isset($_GET['b']) && $_GET['b'] == 'banned') echo ' : ' . CN_BLOCKED_TITTLE; ?>
</h2>

<?php if (isset($_GET['b']) && $_GET['b'] == 'banned'): ?>
    <a class="cn_top_menu" href="?u=users"><?php echo CN_BACK; ?></a>
<?php else: ?>
    <a class="cn_top_menu" href="?u=person&i=0"><?php echo CN_ADMINISTRATOR; ?></a>
    <a class="cn_top_menu" href="?u=users&b=banned"><?php echo CN_BLOCKED_TITTLE; ?></a>
<?php endif; ?>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/views/panel/layout/cn_action_panel.php'; ?>

<div class="cn_users_block">
    <table>
        <tr>
            <td>ID</td>
            <td><?= CN_REGISTRATION_DATE; ?></td>
            <td><?= CN_AVATAR; ?></td>
            <td><?= CN_SOCIAL_NETWORK; ?></td>
            <td><?= CN_NAME; ?></td>
            <td>IP</td>
            <td><?= CN_COMMENTS; ?></td>
            <td><?= CN_STATUS; ?></td>
            <td></td>
        </tr>
        <?php if ($this->cnUsers): ?>
            <?php foreach ($this->cnUsers as $key => $val): ?>
                <tr <?php if ($val[CN_T_BAN] == 1) echo 'style="background: #ffefef;"'; ?> class="cn_user_str_table"
                                                                                           data-cn-user-id="<?php echo $val[CN_T_ID]; ?>">
                    <td><?php echo $val[CN_T_ID]; ?></td>
                    <td>
                        <?php echo date('d.m.Y', strtotime($val[CN_T_DATE_REG])); ?>
                        <br>
                        <?php echo date('H:i:s', strtotime($val[CN_T_DATE_REG])); ?>
                    </td>
                    <td>
                        <?php if ($val[CN_T_AUTH_VIA] == 'guest'): ?>
                            <div class="cn_table_avatar" style="background: <?php echo $val[CN_T_AVATAR]; ?>">
                                <?php echo mb_substr($val[CN_T_NAME], 0, 1, CN_SET_ENCODING); ?>
                            </div>
                        <?php else: ?>
                            <img class="cn_table_avatar" src="<?php echo $val[CN_T_AVATAR]; ?>" alt="">
                        <? endif; ?>
                    </td>
                    <td>
                        <div
                            style="background:url(<?php echo '/' . CN_FOLDER_SCRIPT . '/img/' . $val[CN_T_AUTH_VIA]; ?>.png) center / cover;width:20px;height:20px;"></div>
                    </td>
                    <td>
                        <div class="cn_user_name_table"><a
                                href="?u=person&i=<?php echo $val[CN_T_ID]; ?>"><?php echo $val[CN_T_NAME]; ?></a></div>
                        <div class="cn_user_email_table"><?php echo $val[CN_T_EMAIL]; ?></div>
                    </td>
                    <td><?php echo $val[CN_T_UIP]; ?></td>
                    <td><?php echo CnComment::getCountByCondition('person', $val[CN_T_ID]); ?></td>
                    <td><?php echo $val[CN_T_STATUS]; ?></td>
                    <td>
                        <div class="cn_user_ban_table"
                            <?php if ($val[CN_T_BAN] == 1): ?>
                                style="background: url(<?php echo '/' . CN_FOLDER_SCRIPT; ?>/img/check.png) center / cover;"
                            <? endif; ?>
                             title="<?php echo ($val[CN_T_BAN] == 1) ? CN_UNBLOCK : CN_BLOCK ?>"></div>
                        <div class="cn_users_delete_table" title="<?php echo CN_DELETE; ?>"></div>
                    </td>
                </tr>
            <? endforeach; ?>
        <? endif; ?>
    </table>
    <?php
    $pagination = new CnPagination('users');
    if (isset($_GET['b']) && $_GET['b'] == 'banned') {
        $uriNavigation = $_SERVER['SCRIPT_NAME'] . '?u=users&b=banned&';
    } else {
        $uriNavigation = $_SERVER['SCRIPT_NAME'] . '?u=users&';
    }
    $pagination->navigationView($uriNavigation);

    ?>
    <div class="cn_screen_delete_confirm">
        <div class="cn_user_delete_confirm_block">
            <div class="cn_delete_confirm_title"><?php echo CN_DELETE . '?'; ?></div>
            <div class="cn_user_delete_confirm_submit cn_animate"><?php echo CN_YES; ?></div>
            <div class="cn_user_delete_confirm_cancel cn_animate"><?php echo CN_NO; ?></div>
        </div>
    </div>
</div>
