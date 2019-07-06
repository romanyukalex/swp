<div class="cn_last_comments_block">
    <?php if (is_array($dataComment) && !empty($dataComment)): ?>
        <?php foreach ($dataComment['cnComments'] as $value): ?>
            <?php if (!empty($value[CN_T_PAGE_TITLE])): ?>
                <!--<a href="<?= $value[CN_T_PID] ?>"><?= $value[CN_T_PAGE_TITLE] ?></a>-->
            <? endif; ?>
            <div class="cn_last_comments_box">
                <div class="cn_last_comments_avatar_box">
                    <div class="cn_last_comments_avatar <?php echo 'cn_icon_' . strtolower($dataComment['cnUsers'][$value[CN_T_UID]][CN_T_AUTH_VIA]); ?>"
                         style="background: <?php
                         if ($dataComment['cnUsers'][$value[CN_T_UID]][CN_T_AUTH_VIA] == 'guest') {
                             echo $dataComment['cnUsers'][$value[CN_T_UID]][CN_T_AVATAR];
                         } else {
                             echo 'url(' . $dataComment['cnUsers'][$value[CN_T_UID]][CN_T_AVATAR] . ') center no-repeat; background-size: cover;';
                         }
                         ?>
                                 ">
                        <?php
                        if ($dataComment['cnUsers'][$value[CN_T_UID]][CN_T_AUTH_VIA] == 'guest') {
                            echo mb_substr($dataComment['cnUsers'][$value[CN_T_UID]][CN_T_NAME], 0, 1, CN_SET_ENCODING);
                        }
                        ?>
                    </div>

                    <?php if ($dataComment['cnUsers'][$value[CN_T_UID]][CN_T_AUTH_VIA] == 'guest'): ?>
                        <div class="cn_last_comments_guest_identify"><?php echo CN_GUEST; ?></div>
                    <?php elseif ($dataComment['cnUsers'][$value[CN_T_UID]][CN_T_AUTH_VIA] == 'admin'): ?>
                        <div class="cn_last_comments_admin_identify"><?php echo CN_ADMIN; ?></div>
                    <? endif; ?>
                </div>
                <div class="cn_last_comments">
                    <div class="cn_last_comments_head">
                        <div class="cn_last_comments_name"><?= $dataComment['cnUsers'][$value[CN_T_UID]][CN_T_NAME] ?></div>
                        <div class="cn_last_comments_date"
                             title="<?php echo (isset($_SESSION[CN_S_TIME_ZONE])) ? CnComment::changeDate(date('d.m.Y H:i', strtotime($value[CN_T_DATE_PUBLISHED]) + ($_SESSION[CN_S_TIME_ZONE] * 60 * 60))) : CnComment::changeDate(date('d.m.Y H:i T', strtotime($value[CN_T_DATE_PUBLISHED]))); ?>">
                            <?php echo CnComment::changeTime($value[CN_T_DATE_PUBLISHED]); ?></div>
                    </div>
                    <div class="cn_last_comments_content">
                        <?php
                        $text = CnComment::filterCommentsView(mb_substr($value[CN_T_TEXT], 0, 228, CN_SET_ENCODING));
                        $text .= ((mb_strlen($text, CN_SET_ENCODING) >= 228) ? "..." : "");
                        $text = preg_replace("/<a[^<]+<\/a>\.\.\.$/ui", "...", $text);
                        echo $text
                        ?>
                    </div>
                    <div class="cn_last_comments_footer">
                        <a href="<?= $value[CN_T_PID] . "/#" . ((is_null($value[CN_T_MCID])) ? "cnm-" : "cna-") . $value[CN_T_ID] ?>"><?= CN_LOCK ?></a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>