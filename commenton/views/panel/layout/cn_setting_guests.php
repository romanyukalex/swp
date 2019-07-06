<form name="cn_form_guest">
    <div class="cn_setting_section clearfix">
        <div class="cn_section_title"><?php echo CN_GUESTS; ?></div>
        <div class="cn_section_param">
            <input id="cn_set_guest" name="cn_set_guest"
                   type="checkbox" <?php if (CN_SET_GUEST == 'on') echo 'checked'; ?>>
            <label for="cn_set_guest"></label>
            <i><?php echo CN_GUEST_NOTE; ?></i>
        </div>
    </div>

    <div class="cn_setting_section clearfix">
        <div class="cn_section_title"><?php echo CN_EMAIL; ?></div>
        <div class="cn_section_param">
            <input id="cn_set_guest_email" name="cn_set_guest_email"
                   type="checkbox" <?php if (CN_SET_GUEST_EMAIL == 'on') echo 'checked'; ?>>
            <label for="cn_set_guest_email"></label>
            <i><?php echo CN_GUEST_EMAIL_NOTE; ?></i>
            <br>
            <br>
            <input id="cn_set_guest_email_required" name="cn_set_guest_email_required" type="checkbox" <?php if (CN_SET_GUEST_EMAIL_REQUIRED == 'on') echo 'checked'; ?>>
            <label for="cn_set_guest_email_required"></label>
            <i><?php echo CN_SET_GUEST_EMAIL_REQUIRED_NOTE; ?></i>
        </div>
    </div>

    <div class="cn_setting_section clearfix">
        <div class="cn_section_title">reCaptcha</div>
        <div class="cn_section_param">
            <input id="cn_set_recaptcha" name="cn_set_recaptcha"
                   type="checkbox" <?php if (CN_SET_RECAPTCHA == 'on') echo 'checked'; ?>>
            <label for="cn_set_recaptcha"></label>
            <i><?php echo CN_RECAPTCHA_NOTE_1; ?></i>
            <br>
            <br>
            <label>
                <i><?php echo CN_KEY; ?></i>
                <br>
                <input id="cn_set_recaptcha_key" name="cn_set_recaptcha_key" type="text" value="<?php echo CN_SET_RECAPTCHA_KEY;  ?>">
            </label>
            <br>
            <br>
            <label>
                <i><?php echo CN_SECRET_KEY; ?></i>
                <br>
                <input id="cn_set_recaptcha_secret_key" name="cn_set_recaptcha_secret_key" type="text" value="<?php echo CN_SET_RECAPTCHA_SECRET_KEY;  ?>">
                <br>
                <i><?php echo CN_RECAPTCHA_NOTE_2; ?></i>
            </label>
        </div>
    </div>
</form>