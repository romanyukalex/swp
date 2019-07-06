<?php foreach ($this->cnComments as $key => $val): ?>
    <div id="<?php echo (isset($val[CN_T_MCID]) ? 'cna-' : 'cnm-') . $val[CN_T_ID]; ?>" class="cn_comment_box"
         data-cn-comment-type="<?php echo isset($val[CN_T_MCID]) ? 'answer' : 'main'; ?>"
         data-cn-main-comment-id="<?php echo isset($val[CN_T_MCID]) ? $val[CN_T_MCID] : $val[CN_T_ID]; ?>">
        <form name="cn_comment_select_form">
            <input id="cn_select_<?php echo (isset($val[CN_T_MCID]) ? 'cna-' : 'cnm-') . $val[CN_T_ID]; ?>"
                   class="cn_comment_select" name="cn_comment_select" type="checkbox"
                   value="<?php echo (isset($val[CN_T_MCID]) ? 'cna-' : 'cnm-') . $val[CN_T_ID]; ?>">
            <label for="cn_select_<?php echo (isset($val[CN_T_MCID]) ? 'cna-' : 'cnm-') . $val[CN_T_ID]; ?>"></label>
        </form>
        <div class="cn_avatar"
             style="
             background: <?php
             if ($this->cnUsers[$val[CN_T_UID]][CN_T_AUTH_VIA] == 'guest') {
                 echo $this->cnUsers[$val[CN_T_UID]][CN_T_AVATAR];
             } else {
                 echo 'url(' . $this->cnUsers[$val[CN_T_UID]][CN_T_AVATAR] . ') center / cover no-repeat;';
             }
             ?>">
            <?php
            if ($this->cnUsers[$val[CN_T_UID]][CN_T_AUTH_VIA] == 'guest') {
                echo mb_substr($this->cnUsers[$val[CN_T_UID]][CN_T_NAME], 0, 1, CN_SET_ENCODING);
            }
            ?>
        </div>
        <div class="cn_comment">
            <div class="cn_string_1">
                <div class="cn_name" dir="ltr"><a
                            href="?u=person&i=<?php echo $val[CN_T_UID]; ?>"><?php echo $this->cnUsers[$val[CN_T_UID]][CN_T_NAME]; ?></a>
                </div>
                <div
                        class="cn_date" data-time-second="<?php echo strtotime($val[CN_T_DATE_PUBLISHED]); ?>"
                        title="<?php echo (isset($_SESSION[CN_S_TIME_ZONE])) ? CnComment::changeDate(date('d.m.Y H:i', strtotime($val[CN_T_DATE_PUBLISHED]) + ($_SESSION[CN_S_TIME_ZONE] * 60 * 60))) : CnComment::changeDate(date('d.m.Y H:i T', strtotime($val[CN_T_DATE_PUBLISHED]))); ?>">
                    <?php echo CnComment::changeTime($val[CN_T_DATE_PUBLISHED]); ?></div>
                <?php if ($val[CN_T_MODERATION] == 1): ?>
                    <div class="cn_moderation_notice"><?php echo CN_MODERATION; ?></div>
                <? elseif ($val[CN_T_NEW] == 1 && $this->cnUsers[$val[CN_T_UID]][CN_T_AUTH_VIA] !== 'admin'): ?>
                    <div class="cn_new_notice"><?php echo 'NEW' ?></div>
                <? endif; ?>
                <?php if ($val[CN_T_COMPLAIN] != null): ?>
                    <?php
                    $complaintsArr = unserialize(base64_decode($val[CN_T_COMPLAIN]));
                    $countComplaints = count($complaintsArr);
                    ?>
                    <div class="cn_complaints_block">
                        <div
                                class="cn_complaints_title"><?php echo CN_COMPLAINTS . ' (' . $countComplaints . ')'; ?></div>
                        <div class="cn_complaints">
                            <?php foreach ($complaintsArr as $complaints): ?>
                                <div class="cn_complaints_notice">
                                    <div class="cn_complaints_author">
                                        <?php
                                        if ($complaints[CN_T_UID] != 0) {
                                            $authorName = CnUser::getUserById($complaints[CN_T_UID]);
                                            echo $authorName[CN_T_NAME];
                                        } else {
                                            echo $this->cnAdmin[CN_T_NAME];
                                        }
                                        ?>
                                    </div>
                                    <div
                                            class="cn_complaints_time"><?php echo date('d.m.Y H:m', strtotime($complaints['time'])); ?></div>
                                    <div class="cn_complaints_message"><?php echo $complaints['notice']; ?></div>
                                </div>
                            <? endforeach; ?>
                        </div>
                    </div>
                <? endif; ?>
                <a class="cn_uri" target="_blank"
                   href="<?php echo $val[CN_T_PID] . '#' . (isset($val[CN_T_MCID]) ? 'cna-' : 'cnm-') . $val[CN_T_ID]; ?>"
                   data-cn-page-uri="<?php echo $val[CN_T_PID]; ?>"><?php echo $val[CN_T_PAGE_TITLE]; ?></a>
            </div>
            <div class="cn_string_2">
                <?php if (isset($val[CN_T_QUOTE])): ?>
                    <blockquote class="cn_quote">
                        <?php
                        $quote = unserialize(base64_decode($val[CN_T_QUOTE]));
                        echo '<span>' . $quote[CN_T_NAME] . '</span> <i>' . CnComment::filterCommentsView($quote[CN_T_TEXT]) . '</i>';
                        ?>
                    </blockquote>
                <? endif; ?>
                <div class="cn_content_comment">
                    <div class="cn_text">
                        <?= CnComment::filterCommentsView($val[CN_T_TEXT]); ?>
                    </div>
                </div>
            </div>
            <div class="cn_string_3">
                <?php if ($val[CN_T_MODERATION] == 1): ?>
                    <div class="cn_button_control cn_approve_button"><? echo CN_APPROVE; ?></div>
                <?php elseif ($val[CN_T_POSTED] == 0): ?>
                    <div class="cn_button_control cn_recover_button"><? echo CN_RESTORE; ?></div>
                <?php else: ?>
                    <div class="cn_button_control cn_answer_button"><? echo CN_REPLY; ?></div>
                    <div class="cn_button_control cn_trash_button" data-cn-area="panel"><? echo CN_IN_TRASH; ?></div>
                <? endif; ?>
                <?php if ($val[CN_T_COMPLAIN] != null): ?>
                    <div class="cn_button_control cn_clean_complain_button"><? echo CN_CLEAN_COMPLAIN; ?></div>
                <? endif; ?>
                <div class="cn_button_control cn_delete_button"><? echo CN_DELETE; ?></div>
                <a class="cn_button_control cn_chain_button"
                   href="?u=chain&i=<?php echo isset($val[CN_T_MCID]) ? $val[CN_T_MCID] : $val[CN_T_ID]; ?>"><? echo CN_LOOK_CHAIN; ?></a>
                <?php if ($val[CN_T_NEW] == 1 && $val[CN_T_MODERATION] != 1 && $this->cnUsers[$val[CN_T_UID]][CN_T_AUTH_VIA] !== 'admin'): ?>
                    <div class="cn_button_control cn_read_button"><? echo CN_READ; ?></div>
                <? endif; ?>
            </div>
        </div>
    </div>
<? endforeach; ?>
<div class="cn_screen_answer">
    <div class="cn_answer_input_box clearfix">
        <div class="cn_answer_close" title="<?php echo CN_CLOSE; ?>"></div>
        <div class="cn_answer_box_title"><?php echo CN_NOTICE; ?>:</div>
        <div class="cn_avatar"
             style="background: url(<?php echo $this->cnAdmin[CN_T_AVATAR]; ?>) center no-repeat; background-size: cover;"></div>
        <div class="cn_enter_answer_box">
            <div class="cn_enter_answer_panel">
                <textarea class="cn_enter_answer_input" rows='1'
                          placeholder="<?php echo CN_ENTER_COMMENT; ?>"></textarea>
            </div>
            <div class="cn_enter_answer_submit" data-cn-area="panel"><? echo CN_SUBMIT; ?></div>
        </div>
    </div>
</div>

<div class="cn_screen_delete_confirm">
    <div class="cn_delete_confirm_block">
        <div class="cn_delete_confirm_title"><?php echo CN_DELETE . '?'; ?></div>
        <div class="cn_delete_confirm_submit cn_animate" data-cn-area="panel"><?php echo CN_YES; ?></div>
        <div class="cn_delete_confirm_cancel cn_animate"><?php echo CN_NO; ?></div>
    </div>
</div>