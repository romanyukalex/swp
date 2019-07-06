<div id="cna-<?php echo $dataComment['cnAnswer'][CN_T_ID]; ?>" class="cn_comment_box" data-cn-comment-type="answer">
    <div class="cn_avatar_block">
        <div
                class="cn_avatar <?php echo 'cn_icon_' . strtolower($dataComment['cnUsers'][$dataComment['cnAnswer'][CN_T_UID]][CN_T_AUTH_VIA]); ?>"
                style="background: <?php
                if ($dataComment['cnUsers'][$dataComment['cnAnswer'][CN_T_UID]][CN_T_AUTH_VIA] == 'guest') {
                    echo $dataComment['cnUsers'][$dataComment['cnAnswer'][CN_T_UID]][CN_T_AVATAR];
                } else {
                    echo 'url(' . $dataComment['cnUsers'][$dataComment['cnAnswer'][CN_T_UID]][CN_T_AVATAR] . ') center / cover no-repeat;';
                }
                ?>
                        ">
            <?php
            if ($dataComment['cnUsers'][$dataComment['cnAnswer'][CN_T_UID]][CN_T_AUTH_VIA] == 'guest') {
                echo mb_substr($dataComment['cnUsers'][$dataComment['cnAnswer'][CN_T_UID]][CN_T_NAME], 0, 1, CN_SET_ENCODING);
            }
            ?>
        </div>

        <?php if ($dataComment['cnUsers'][$dataComment['cnAnswer'][CN_T_UID]][CN_T_AUTH_VIA] == 'guest'): ?>
            <div class="cn_guest_identify"><?php echo CN_GUEST; ?></div>
        <?php elseif ($dataComment['cnUsers'][$dataComment['cnAnswer'][CN_T_UID]][CN_T_AUTH_VIA] == 'admin'): ?>
            <div class="cn_admin_identify"><?php echo CN_ADMIN; ?></div>
        <? endif; ?>
    </div>

    <div class="cn_comment">
        <div class="cn_string_1">
            <div class="cn_name"
                 dir="ltr"><?php echo $dataComment['cnUsers'][$dataComment['cnAnswer'][CN_T_UID]][CN_T_NAME]; ?></div>
            <div class="cn_date"
                 data-time-second="<?php echo strtotime($dataComment['cnAnswer'][CN_T_DATE_PUBLISHED]); ?>"
                 title="<?php echo (isset($_SESSION[CN_S_TIME_ZONE])) ? CnComment::changeDate(date('d.m.Y H:i', strtotime($dataComment['cnAnswer'][CN_T_DATE_PUBLISHED]) + ($_SESSION[CN_S_TIME_ZONE] * 60 * 60))) : CnComment::changeDate(date('d.m.Y H:i T', strtotime($dataComment['cnAnswer'][CN_T_DATE_PUBLISHED]))); ?>">
                <?php echo CnComment::changeTime($dataComment['cnAnswer'][CN_T_DATE_PUBLISHED]); ?></div>
            <br>
            <div class="cn_options">
                <div class="cn_options_button"></div>
                <div class="cn_options_box">
                    <?php if (isset($_SESSION[CN_S_LOGGED_ADMIN])): ?>
                        <div class="cn_item_options cn_trash_button"><? echo CN_IN_TRASH; ?></div>
                    <? else: ?>
                        <div class="cn_item_options cn_complain"><?php echo CN_TO_COMPLAINT; ?></div>
                    <? endif; ?>
                </div>
            </div>
        </div>

        <?php $quote = unserialize(base64_decode($dataComment['cnAnswer'][CN_T_QUOTE])); ?>

        <div class="cn_string_2">
            <div class="cn_text">
                <?php $quoteParentType = preg_replace('/-.+/', '', $quote[CN_T_PARENT_ID]); ?>
                <?php if ($quoteParentType !== 'cnm' && ($indexVal > CN_SET_LEVEL_INPUT || $indexVal <= 1)): ?>
                    <div class="cn_name_quote"
                         data-parent-id="<?php echo $quote[CN_T_PARENT_ID]; ?>"><?php echo $quote[CN_T_NAME]; ?> </div>
                <? endif; ?>
                <?= CnComment::filterCommentsView($dataComment['cnAnswer'][CN_T_TEXT]); ?>
            </div>
        </div>
        <div class="cn_string_3">
            <?php if ($dataComment['cnLogin'] && $dataComment['cnThisUser'][CN_T_BAN] == 0): ?>
                <div class="cn_answer_button"><?php echo CN_REPLY; ?></div>
                <?php if ((isset($_SESSION[CN_S_USER_ID]) && $dataComment['cnAnswer'][CN_T_UID] == $_SESSION[CN_S_USER_ID]) || isset($_SESSION[CN_S_LOGGED_ADMIN])): ?>
                    <div class="cn_delete_button"><?php echo CN_DELETE; ?></div>
                <? endif; ?>
            <? endif; ?>
            <div class="cn_share_block"><?php echo CN_SHARE; ?>
                <div class="cn_share_box">
                    <?php
                    $share = new CnShare();
                    $image = ($dataComment['cnUsers'][$dataComment['cnAnswer'][CN_T_UID]][CN_T_AUTH_VIA] != 'guest') ? 'http://' . $_SERVER['HTTP_HOST'] . '/' . $dataComment['cnUsers'][$dataComment['cnAnswer'][CN_T_UID]][CN_T_AVATAR] : '';
                    echo $share->getLink($dataComment['cnAnswer'][CN_T_PID], $dataComment['cnUsers'][$dataComment['cnAnswer'][CN_T_UID]][CN_T_NAME], CnComment::filterCommentsView($dataComment['cnAnswer'][CN_T_TEXT]), $image);
                    ?>
                </div>
            </div>
            <?php if (CN_SET_HYPE == 'on'): ?>
                <div class="cn_like_box">
                    <div class="cn_like_meter">
                        <?php if ($dataComment['cnAnswer'][CN_T_HYPE] > 0): ?>
                            <div class="cn_like_cool"><?php echo $dataComment['cnAnswer'][CN_T_HYPE]; ?></div>
                        <?php elseif ($dataComment['cnAnswer'][CN_T_HYPE] < 0): ?>
                            <div class="cn_like_bad"><?php echo $dataComment['cnAnswer'][CN_T_HYPE]; ?></div>
                        <? endif; ?>
                    </div>
                    <?php
                    $checkRating = 0;
                    if (isset($dataComment['cnThisUser'][CN_T_ID])) {
                        if (isset($dataComment['cnRating']) && $dataComment['cnRating'] != null) {
                            foreach ($dataComment['cnRating'] as $val) {
                                if ($val[CN_T_CID] == 'cna-' . $dataComment['cnAnswer'][CN_T_ID] && $val[CN_T_UID] == $dataComment['cnThisUser'][CN_T_ID]) {
                                    $checkRating = $val[CN_T_SCORE];
                                }
                            }
                        }
                    }
                    ?>
                    <div class="cn_like" <? echo ($checkRating > 0) ? 'style="opacity:0.5;"' : ''; ?>
                         data-cn-hype="like"></div>
                    <div class="cn_dislike" <? echo ($checkRating < 0) ? 'style="opacity:0.5;"' : ''; ?>
                         data-cn-hype="dislike"></div>
                </div>
            <? endif; ?>
        </div>
    </div>
</div>