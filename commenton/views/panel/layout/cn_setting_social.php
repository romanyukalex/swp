<form name="cn_form_social">
    <div class="cn_setting_section clearfix">
        <div class="cn_section_title"><?= CN_VK_RU; ?> <i>oAuth 2.0</i></div>
        <div class="cn_section_param">
            <input id="cn_vk_switch" name="cn_vk_switch" type="checkbox" <?= (CN_VK_SWITCH === 'on') ? 'checked' : '' ?>>
            <label for="cn_vk_switch"></label>
            <i>Вкл</i>
            <br><br>
            <label><input id="cn_set_vk_client_id" name="cn_set_vk_client_id" type="text" value="<?php echo CN_SET_VK_CLIENT_ID; ?>"> <i>client_id</i></label>
            <br><br>
            <label><input id="cn_set_vk_client_secret" name="cn_set_vk_client_secret" type="text" value="<?php echo CN_SET_VK_CLIENT_SECRET; ?>"> <i>client_secret</i></label>
            <br>
            <a href="https://vk.com/apps?act=manage" target="_blank"><?= CN_GET_KEYS ?></a>
        </div>
    </div>

    <hr>

    <div class="cn_setting_section clearfix">
        <div class="cn_section_title"><?= CN_OK_RU; ?> <i>oAuth 2.0</i></div>
        <div class="cn_section_param">
            <input id="cn_ok_switch" name="cn_ok_switch" type="checkbox" <?= (CN_OK_SWITCH === 'on') ? 'checked' : '' ?>>
            <label for="cn_ok_switch"></label>
            <i>Вкл</i>
            <br><br>
            <label><input id="cn_set_ok_client_id" name="cn_set_ok_client_id" type="text" value="<?php echo CN_SET_OK_CLIENT_ID; ?>"> <i>client_id</i></label>
            <br><br>
            <label><input id="cn_set_ok_public_key" name="cn_set_ok_public_key" type="text" value="<?php echo CN_SET_OK_PUBLIC_KEY; ?>"> <i>public_key</i></label>
            <br><br>
            <label><input id="cn_set_ok_client_secret" name="cn_set_ok_client_secret" type="text" value="<?php echo CN_SET_OK_CLIENT_SECRET; ?>"> <i>client_secret</i></label>
            <br>
            <a href="https://ok.ru/dk?st.cmd=appsInfoMyDevList" target="_blank"><?= CN_GET_KEYS ?></a>
        </div>
    </div>

    <hr>

    <div class="cn_setting_section clearfix">
        <div class="cn_section_title"><?= CN_FACEBOOK; ?> <i>oAuth 2.0</i></div>
        <div class="cn_section_param">
            <input id="cn_fb_switch" name="cn_fb_switch" type="checkbox" <?= (CN_FB_SWITCH === 'on') ? 'checked' : '' ?>>
            <label for="cn_fb_switch"></label>
            <i>Вкл</i>
            <br><br>
            <label><input id="cn_set_fb_client_id" name="cn_set_fb_client_id" type="text" value="<?php echo CN_SET_FB_CLIENT_ID; ?>"> <i>client_id</i></label>
            <br><br>
            <label><input id="cn_set_fb_client_secret" name="cn_set_fb_client_secret" type="text" value="<?php echo CN_SET_FB_CLIENT_SECRET; ?>"> <i>client_secret</i></label>
            <br>
            <a href="https://developers.facebook.com/apps/" target="_blank"><?= CN_GET_KEYS ?></a>
        </div>
    </div>

    <hr>

    <div class="cn_setting_section clearfix">
        <div class="cn_section_title">Google <i>oAuth 2.0</i></div>
        <div class="cn_section_param">
            <input id="cn_g_switch" name="cn_g_switch" type="checkbox" <?= (CN_G_SWITCH === 'on') ? 'checked' : '' ?>>
            <label for="cn_g_switch"></label>
            <i>Вкл</i>
            <br><br>
            <label><input id="cn_set_g_client_id" name="cn_set_g_client_id" type="text" value="<?php echo CN_SET_G_CLIENT_ID; ?>"> <i>client_id</i></label>
            <br><br>
            <label><input id="cn_set_g_client_secret" name="cn_set_g_client_secret" type="text" value="<?php echo CN_SET_G_CLIENT_SECRET; ?>"> <i>client_secret</i></label>
            <br>
            <a href="https://console.developers.google.com/iam-admin/projects" target="_blank"><?= CN_GET_KEYS ?></a>
        </div>
    </div>

    <hr>

    <div class="cn_setting_section clearfix">
        <div class="cn_section_title"><?= CN_MY_MAIL_RU; ?> <i>oAuth 2.0</i></div>
        <div class="cn_section_param">
            <input id="cn_mm_switch" name="cn_mm_switch" type="checkbox" <?= (CN_MM_SWITCH === 'on') ? 'checked' : '' ?>>
            <label for="cn_mm_switch"></label>
            <i>Вкл</i>
            <br><br>
            <label><input id="cn_set_mm_client_id" name="cn_set_mm_client_id" type="text" value="<?php echo CN_SET_MM_CLIENT_ID; ?>"> <i>client_id</i></label>
            <br><br>
            <label><input id="cn_set_mm_client_secret" name="cn_set_mm_client_secret" type="text" value="<?php echo CN_SET_MM_CLIENT_SECRET; ?>"> <i>client_secret</i></label>
            <br>
            <a href="http://api.mail.ru/sites/" target="_blank"><?= CN_GET_KEYS ?></a>
        </div>
    </div>

    <hr>

    <div class="cn_setting_section clearfix">
        <div class="cn_section_title"><?= CN_YANDEX_RU; ?> <i>oAuth 2.0</i></div>
        <div class="cn_section_param">
            <input id="cn_ya_switch" name="cn_ya_switch" type="checkbox" <?= (CN_YA_SWITCH === 'on') ? 'checked' : '' ?>>
            <label for="cn_ya_switch"></label>
            <i>Вкл</i>
            <br><br>
            <label><input id="cn_set_ya_client_id" name="cn_set_ya_client_id" type="text" value="<?php echo CN_SET_YA_CLIENT_ID; ?>"> <i>client_id</i></label>
            <br><br>
            <label><input id="cn_set_ya_client_secret" name="cn_set_ya_client_secret" type="text" value="<?php echo CN_SET_YA_CLIENT_SECRET; ?>"> <i>client_secret</i></label>
            <br>
            <a href="https://oauth.yandex.ru/" target="_blank"><?= CN_GET_KEYS ?></a>
        </div>
    </div>
</form>