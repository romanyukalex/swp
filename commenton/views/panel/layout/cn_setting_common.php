<form name="cn_form_common">
    <div class="cn_setting_section clearfix">
        <div class="cn_section_title"><?php echo CN_LEVEL_INPUT; ?></div>
        <div class="cn_section_param">
            <label><input id="cn_set_level_input" name="cn_set_level_input" type="number"
                          value="<?php echo CN_SET_LEVEL_INPUT; ?>"></label>
        </div>
    </div>

    <div class="cn_setting_section clearfix">
        <div class="cn_section_title"><?php echo CN_LIMIT_COMMENTS; ?></div>
        <div class="cn_section_param">
            <label>
                <input id="cn_set_limit_comments" name="cn_set_limit_comments" type="number"
                       value="<?php echo CN_SET_LIMIT_COMMENTS; ?>">
                <br>
                <i><?php echo CN_LIMIT_COMMENTS_NOTE; ?></i>
            </label>
        </div>
    </div>

    <div class="cn_setting_section clearfix">
        <div class="cn_section_title"><?php echo CN_LIMIT_ANSWER; ?></div>
        <div class="cn_section_param">
            <label>
                <input id="cn_set_limit_answer" name="cn_set_limit_answer" type="number"
                       value="<?php echo CN_SET_LIMIT_ANSWER; ?>">
                <br>
                <i><?php echo CN_LIMIT_ANSWER_NOTE; ?></i>
            </label>
        </div>
    </div>

    <div class="cn_setting_section clearfix">
        <div class="cn_section_title"><?php echo CN_COUNT_CHARS_COMMENTS; ?></div>
        <div class="cn_section_param">
            <label>
                <input id="cn_set_count_chars_comments" name="cn_set_count_chars_comments" type="number"
                       value="<?php echo CN_SET_COUNT_CHARS_COMMENTS; ?>">
                <br>
            </label>
        </div>
    </div>

    <div class="cn_setting_section clearfix">
        <div class="cn_section_title"><?php echo CN_COUNT_CHARS_ANSWER; ?></div>
        <div class="cn_section_param">
            <label>
                <input id="cn_set_count_chars_answer" name="cn_set_count_chars_answer" type="number"
                       value="<?php echo CN_SET_COUNT_CHARS_ANSWER; ?>">
                <br>
            </label>
        </div>
    </div>

    <div class="cn_setting_section clearfix">
        <div class="cn_section_title"><?php echo CN_SORT_DEFAULT; ?></div>
        <div class="cn_section_param">
            <label>
                <select id="cn_set_sort" name="cn_set_sort">
                    <?php
                    $setSelect = array(
                        'new' => CN_SORT_NEW,
                        'old' => CN_SORT_OLD,
                        'best' => CN_SORT_BEST,
                    );
                    foreach ($setSelect as $key => $val): ?>
                        <option <?= (CN_SET_SORT == $key) ? 'selected' : ''; ?> value="<?= $key; ?>"><?= $val; ?></option>
                    <? endforeach; ?>
                </select>
            </label>
        </div>
    </div>

    <div class="cn_setting_section clearfix">
        <div class="cn_section_title"><?php echo CN_MODERATION; ?></div>
        <div class="cn_section_param">
            <input id="cn_set_moderation" name="cn_set_moderation"
                   type="checkbox" <?php if (CN_SET_MODERATION == 'on') echo 'checked'; ?>>
            <label for="cn_set_moderation"></label>
            <i><?php echo CN_MODERATION_NOTE; ?></i>
        </div>
    </div>

    <div class="cn_setting_section clearfix">
        <div class="cn_section_title"><?php echo CN_LIKE; ?></div>
        <div class="cn_section_param">
            <input id="cn_set_hype" name="cn_set_hype"
                   type="checkbox" <?php if (CN_SET_HYPE == 'on') echo 'checked'; ?>>
            <label for="cn_set_hype"></label>
            <i><?php echo CN_LIKE_NOTE; ?></i>
        </div>
    </div>

    <div class="cn_setting_section clearfix">
        <div class="cn_section_title"><?= CN_HANDLER_SESSION; ?></div>
        <div class="cn_section_param">
            <label>
                <select id="cn_set_session" name="cn_set_session">
                    <?php
                    $setSelect = array(
                        'standard' => CN_STANDARD,
                        'joomla' => 'Joomla',
                        'modxrevo' => 'MODX REVO',
                        'modxevo' => 'MODX EVO',
                        'hostcms' => 'HostCMS',
                        'bitrix' => 'Bitrix'
                    );
                    foreach ($setSelect as $key => $val): ?>
                        <option <?= (CN_SET_SESSION == $key) ? 'selected' : ''; ?> value="<?= $key; ?>"><?= $val; ?></option>
                    <? endforeach; ?>
                </select>
                <br>
                <i><?= CN_HANDLER_SESSION_NOTE; ?></i>
            </label>
        </div>
    </div>

    <div class="cn_setting_section clearfix">
        <div class="cn_section_title"><?= CN_GET ?></div>
        <div class="cn_section_param">
            <input id="cn_set_get" name="cn_set_get"
                   type="checkbox" <?php if (CN_SET_GET == 'on') echo 'checked'; ?>>
            <label for="cn_set_get"></label>
            <i><?php echo CN_GET_ACCESS; ?></i>
        </div>
    </div>
</form>