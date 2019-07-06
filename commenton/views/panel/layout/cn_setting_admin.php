<form name="cn_form_admin">
    <div class="cn_setting_section clearfix">
        <div class="cn_section_title"><?= CN_AVATAR; ?></div>
        <div class="cn_section_param">
            <img class="cn_set_ava_admin" src="<?php echo CN_SET_ADMIN_AVATAR; ?>" width="41" height="41" alt="img"/>
            <input class="cn_select_avatar" type="button" value="<?php echo CN_SELECT_AVATAR; ?>">
            <label><input id="cn_set_admin_avatar_upload" name="cn_set_admin_avatar_upload" type="file"></label>
            <p><?php echo CN_OR_ENTER_URL; ?></p>
            <label><input id="cn_set_admin_avatar" name="cn_set_admin_avatar" type="text"
                          value="<?php echo CN_SET_ADMIN_AVATAR; ?>"></label>
        </div>
    </div>

    <div class="cn_setting_section clearfix">
        <div class="cn_section_title"><?php echo CN_NAME; ?></div>
        <div class="cn_section_param">
            <label><input id="cn_set_admin_name" name="cn_set_admin_name" type="text"
                          value="<?php echo CN_SET_ADMIN_NAME; ?>"></label>
        </div>
    </div>

    <div class="cn_setting_section clearfix">
        <div class="cn_section_title"><?php echo CN_EMAIL; ?></div>
        <div class="cn_section_param">
            <label><input id="cn_set_admin_mail" name="cn_set_admin_mail" type="text"
                          value="<?php echo CN_SET_ADMIN_MAIL; ?>"></label>
        </div>
    </div>

    <div class="cn_setting_section clearfix">
        <div class="cn_section_title"><?php echo CN_NOTIFY; ?></div>
        <div class="cn_section_param">
            <input id="cn_set_send_admin_notice" name="cn_set_send_admin_notice"
                   type="checkbox" <?php if (CN_SET_SEND_ADMIN_NOTICE == 'on') echo 'checked'; ?>>
            <label for="cn_set_send_admin_notice"></label>
            <i><?php echo CN_SEND_ADMIN_NOTICE; ?></i>
        </div>
    </div>
</form>