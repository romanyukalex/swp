<div class="cn_action_panel clearfix">

    <?php if (isset($_GET['u']) && $_GET['u'] == 'users'): ?>
        <div class="cn_limit_admin">
            <form name="cn_form_limit_users">
                <label>
                    <select name="cn_set_limit_users_admin">
                        <option <?php if (CN_SET_LIMIT_USERS_ADMIN == 25) echo 'selected'; ?> value="25">25</option>
                        <option <?php if (CN_SET_LIMIT_USERS_ADMIN == 50) echo 'selected'; ?> value="50">50</option>
                        <option <?php if (CN_SET_LIMIT_USERS_ADMIN == 100) echo 'selected'; ?> value="100">100
                        </option>
                    </select>
                </label>
            </form>
        </div>
    <? else: ?>

        <span class="cn_select_all_box">
            <input id="cn_select_all" class="cn_select_all" type="checkbox">
            <label for="cn_select_all"></label>
        </span>

        <?php if (!isset($_GET['u']) || (isset($_GET['u']) && $_GET['u'] !== 'moderation' && $_GET['u'] !== 'complaints' && $_GET['u'] !== 'trash')): ?>
            <span class="cn_action_point" data-action-type="read_selected"><?php echo CN_READ; ?></span>
        <? endif; ?>
        <?php if (isset($_GET['u']) && $_GET['u'] == 'moderation'): ?>
            <span class="cn_action_point" data-action-type="approve_selected"><?php echo CN_APPROVE; ?></span>
        <? endif; ?>
        <?php if (isset($_GET['u']) && $_GET['u'] == 'trash'): ?>
            <span class="cn_action_point" data-action-type="recover_selected"><?php echo CN_RESTORE; ?></span>
        <? endif; ?>
        <?php if (isset($_GET['u']) && $_GET['u'] == 'complaints'): ?>
            <span class="cn_action_point" data-action-type="clean_complaints_selected"><?php echo CN_CLEAN_COMPLAINTS; ?></span>
        <? endif; ?>
        <span class="cn_action_point" data-action-type="delete_selected"><?php echo CN_DELETE; ?></span>
        <?php if (!isset($_GET['u']) || (isset($_GET['u']) && $_GET['u'] != 'trash' && $_GET['u'] != 'moderation')): ?>
            <span class="cn_action_point" data-action-type="trash_selected"><?php echo CN_IN_TRASH; ?></span>
        <? endif; ?>

        <div class="cn_limit_admin">
            <form name="cn_form_limit_admin">
                <label>
                    <select name="cn_set_limit_comments_admin">
                        <option <?php if (CN_SET_LIMIT_COMMENTS_ADMIN == 25) echo 'selected'; ?> value="25">25
                        </option>
                        <option <?php if (CN_SET_LIMIT_COMMENTS_ADMIN == 50) echo 'selected'; ?> value="50">50
                        </option>
                        <option <?php if (CN_SET_LIMIT_COMMENTS_ADMIN == 100) echo 'selected'; ?> value="100">100
                        </option>
                    </select>
                </label>
            </form>
        </div>
    <? endif; ?>
</div>