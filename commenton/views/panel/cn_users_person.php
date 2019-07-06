<h2><?php echo CN_USERS . ' : ID' . $this->cnPerson[CN_T_ID]; ?></h2>

<?php if (isset($_GET['i'])): ?>
    <a class="cn_top_menu" href="?u=users"><?php echo CN_BACK; ?></a>
<?php endif; ?>

<div class="cn_users_block">
    <table>
        <tr>
            <td>ID</td>
            <?php if ($this->cnPerson[CN_T_ID] !== 0): ?>
                <td><?= CN_REGISTRATION_DATE; ?></td>
            <? endif; ?>
            <td><?= CN_AVATAR; ?></td>
            <?php if ($this->cnPerson[CN_T_ID] !== 0): ?>
                <td><?= CN_SOCIAL_NETWORK; ?></td>
            <? endif; ?>
            <td><?= CN_NAME; ?></td>
            <?php if ($this->cnPerson[CN_T_ID] !== 0): ?>
                <td>IP</td>
            <? endif; ?>
            <td><?= CN_COMMENTS; ?></td>
            <?php if ($this->cnPerson[CN_T_ID] !== 0): ?>
                <td><?= CN_STATUS; ?></td>
                <td></td>
            <? endif; ?>
        </tr>
        <?php if ($this->cnPerson): ?>
            <tr <?php if ($this->cnPerson[CN_T_BAN] == 1) echo 'style="background: #ffefef;"'; ?>
                class="cn_user_str_table" data-cn-user-id="<?php echo $this->cnPerson[CN_T_ID]; ?>">
                <td><?php echo $this->cnPerson[CN_T_ID]; ?></td>
                <?php if ($this->cnPerson[CN_T_ID] !== 0): ?>
                    <td>
                        <?php if (isset($this->cnPerson[CN_T_DATE_REG])) echo date('d.m.Y', strtotime($this->cnPerson[CN_T_DATE_REG])); ?>
                        <br>
                        <?php if (isset($this->cnPerson[CN_T_DATE_REG])) echo date('H:i:s', strtotime($this->cnPerson[CN_T_DATE_REG])); ?>
                    </td>
                <? endif; ?>
                <td>
                    <?php if ($this->cnPerson[CN_T_AUTH_VIA] == 'guest'): ?>
                        <div class="cn_table_avatar" style="background: <?php echo $this->cnPerson[CN_T_AVATAR]; ?>">
                            <?php echo mb_substr($this->cnPerson[CN_T_NAME], 0, 1, CN_SET_ENCODING); ?>
                        </div>
                    <?php else: ?>
                        <img class="cn_table_avatar" src="<?php echo $this->cnPerson[CN_T_AVATAR]; ?>" alt="">
                    <? endif; ?>
                </td>
                <?php if ($this->cnPerson[CN_T_ID] !== 0): ?>
                    <td>
                        <div
                            style="background:url(<?php echo '/' . CN_FOLDER_SCRIPT . '/img/' . $this->cnPerson[CN_T_AUTH_VIA]; ?>.png) center / cover;width:20px;height:20px;"></div>
                    </td>
                <? endif; ?>
                <td>
                    <div class="cn_user_name_table"><a
                            href="?u=person&i=<?php echo $this->cnPerson[CN_T_ID]; ?>"><?php echo $this->cnPerson[CN_T_NAME]; ?></a>
                    </div>
                    <div class="cn_user_email_table"><?php echo $this->cnPerson[CN_T_EMAIL]; ?></div>
                </td>
                <?php if ($this->cnPerson[CN_T_ID] !== 0): ?>
                    <td><?php echo $this->cnPerson[CN_T_UIP]; ?></td>
                <? endif; ?>
                <td><?php echo CnComment::getCountByCondition('person', $this->cnPerson[CN_T_ID]); ?></td>
                <?php if ($this->cnPerson[CN_T_ID] !== 0): ?>
                    <td><?php echo $this->cnPerson[CN_T_STATUS]; ?></td>
                    <td>
                        <div class="cn_user_ban_table"
                            <?php if ($this->cnPerson[CN_T_BAN] == 1): ?>
                                style="background: url(<?php echo '/' . CN_FOLDER_SCRIPT; ?>/img/check.png) center / cover;"
                            <? endif; ?>
                             title="<?php echo ($this->cnPerson[CN_T_BAN] == 1) ? CN_UNBLOCK : CN_BLOCK ?>"></div>
                        <div class="cn_users_delete_table" title="<?php echo CN_DELETE; ?>"></div>
                    </td>
                <? endif; ?>
            </tr>
        <? endif; ?>
    </table>
</div>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/views/panel/layout/cn_action_panel.php'; ?>

<div class="commenton cn_comments_block">
    <?php
    if ($this->cnComments) {
        include_once $_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/views/panel/layout/cn_comments.php';
        $pagination = new CnPagination('person', $this->cnPerson[CN_T_ID]);
        $pagination->navigationView($_SERVER['SCRIPT_NAME'] . '?u=person&i=' . $this->cnPerson[CN_T_ID] . '&');
    } else {
        echo '<div class="cn_empty_block">' . CN_EMPTY . '</div>';
    }
    ?>
</div>