<section class="commenton commenton_block">
    <div class="commenton_box"
         data-time-zone="<?php echo (isset($_SESSION[CN_S_TIME_ZONE])) ? $_SESSION[CN_S_TIME_ZONE] : ''; ?>">

        <div class="cn_head">
            <div class="clearfix">
                <div class="cn_count_box"><? echo CN_COMMENTS; ?>
                    ( <span class="cn_count"><?php echo $this->countMainComments + $this->countAnswerComments; ?></span>
                    )
                </div>
                <?php if ($this->cnLogin): ?>
                    <div class="cn_author">
                        <div class="cn_author_name" title="<?php echo $this->user[CN_T_NAME]; ?>">
                            <?php echo $this->user[CN_T_NAME]; ?>
                        </div>
                        <div class="cn_menu_author_block">
                            <div class="cn_menu_author_box">
                                <?php if (!empty($this->user[CN_T_EMAIL])): ?>
                                    <div class="cn_menu_point"><?php echo $this->user[CN_T_EMAIL]; ?></div>
                                <? endif; ?>
                                <div id="cn_logout" class="cn_menu_point"><?php echo CN_LOGOUT; ?></div>
                            </div>
                        </div>
                    </div>
                <? endif; ?>
            </div>
            <hr>
            <div class="cn_sort">
                <?= CnComment::getSortView(); ?>
            </div>
            <br>
        </div>

        <div class="cn_enter_text_block clearfix">
            <div class="cn_author_avatar" style="
            <?php
            if ($this->cnLogin) {
                if ($this->user[CN_T_AUTH_VIA] == 'guest') {
                    echo 'background: ' . $this->user[CN_T_AVATAR];
                } else {
                    echo 'background: url(' . $this->user[CN_T_AVATAR] . ') center / contain no-repeat;';
                }
            }
            ?>
                    ">
                <?php
                if ($this->user[CN_T_AUTH_VIA] == 'guest') {
                    echo mb_substr($this->user[CN_T_NAME], 0, 1, CN_SET_ENCODING);
                }
                ?>
            </div>
            <div class="cn_enter_text_box">
                <div class="cn_enter_text_panel">
                    <label>
                        <textarea class="cn_enter_text_input" rows='1'
                                  placeholder="<?php echo CN_ENTER_COMMENT; ?>"><?= isset($_SESSION[CN_S_TEXT_ENTERED][md5(CnComment::urlMod($_SERVER['REQUEST_URI']))]) ? $_SESSION[CN_S_TEXT_ENTERED][md5(CnComment::urlMod($_SERVER['REQUEST_URI']))] : '' ?></textarea>
                    </label>
                </div>
                <?php if ($this->cnLogin): ?>
                    <div class="cn_enter_text_submit"><? echo CN_SUBMIT; ?></div>
                <? endif; ?>
            </div>
        </div>

        <?php if (!$this->cnLogin): ?>
            <div class="cn_authorize_box">
                <div class="cn_authorize_social">
                    <div class="cn_authorize_tittle"><? echo CN_AUTHORIZE_TITLE; ?></div>
                    <?php if ($this->vkontakte): ?>
                        <span class="cn_vk cn_social_button" data-cn-link="<? echo $this->vkontakte->getUri(); ?>"></span>
                    <? endif; ?>
                    <?php if ($this->odnoklassniki): ?>
                        <span class="cn_ok cn_social_button" data-cn-link="<? echo $this->odnoklassniki->getUri(); ?>"></span>
                    <? endif; ?>
                    <?php if ($this->facebook): ?>
                        <span class="cn_fb cn_social_button" data-cn-link="<? echo $this->facebook->getUri(); ?>"></span>
                    <? endif; ?>
                    <?php if ($this->google): ?>
                        <span class="cn_g cn_social_button" data-cn-link="<? echo $this->google->getUri(); ?>"></span>
                    <? endif; ?>
                    <?php if ($this->mail): ?>
                        <span class="cn_mail cn_social_button" data-cn-link="<? echo $this->mail->getUri(); ?>"></span>
                    <? endif; ?>
                    <?php if ($this->yandex): ?>
                        <span class="cn_ya cn_social_button" data-cn-link="<? echo $this->yandex->getUri(); ?>"></span>
                    <? endif; ?>
                </div>

                <?php if (CN_SET_GUEST == 'on'): ?>
                    <div class="cn_authorize_guest">
                        <div class="cn_authorize_tittle"><? echo CN_AUTHORIZE_TITLE_2; ?></div>
                        <input class="cn_guest_name_input" name="cn_guest_name_input" placeholder="<? echo CN_NAME; ?>"
                               type="text">
                        <?php if (CN_SET_GUEST_EMAIL == 'on'): ?>
                            <br>
                            <input class="cn_guest_email_input" name="cn_guest_email_input"
                                   placeholder="<? echo CN_EMAIL; ?>"
                                   type="email">
                        <? endif; ?>
                        <?php if (CN_SET_RECAPTCHA == 'on'): ?>
                            <div class="cn_recaptcha">
                                <div class="g-recaptcha" data-sitekey="<? echo CN_SET_RECAPTCHA_KEY; ?>"></div>
                            </div>
                        <? endif; ?>
                        <div class="cn_authorize_guest_submit"><? echo CN_LOGIN; ?></div>
                    </div>
                <? endif; ?>
            </div>
        <? endif; ?>

        <div class="cn_comments_block">
            <?php
            if ($this->cnComments):
                $dataComment['cnAnswer'] = $this->cnAnswer;
                $dataComment['cnUsers'] = $this->cnUsers;
                $dataComment['cnLogin'] = $this->cnLogin;
                $dataComment['cnThisUser'] = $this->user;
                $dataComment['cnRating'] = $this->cnRating;
                foreach ($this->cnComments as $key => $val):
                    $dataComment['cnMain'] = $val;
                    echo CnComment::getCommentsMainView($dataComment);
                endforeach;
            endif;
            ?>
        </div>

        <?php if ($this->countMainComments > $this->limit): ?>
            <div class="cn_more_comments"
                 data-cn-more="<?php echo CN_SET_LIMIT_COMMENTS; ?>"></div>
            <?php
            unset($_SESSION[CN_S_LIMIT_MAX]);
        else:
            if (isset($_SESSION[CN_S_LIMIT_LOAD])) {
                $_SESSION[CN_S_LIMIT_MAX] = $_SESSION[CN_S_LIMIT_LOAD];
            }
            unset($_SESSION[CN_S_LIMIT_LOAD]);
        endif;
        ?>

        <?php if ($this->cnLogin): ?>

            <div class="cn_screen_complain">
                <div class="cn_complain_box clearfix">
                    <div class="cn_complain_close" title="<?php echo CN_CLOSE; ?>"></div>
                    <div class="cn_complain_box_title"><?php echo CN_COMPLAINT; ?>:</div>
                    <div class="cn_author_avatar" style="
                    <?php
                    if ($this->cnLogin) {
                        if ($this->user[CN_T_AUTH_VIA] == 'guest') {
                            echo 'background: ' . $this->user[CN_T_AVATAR];
                        } else {
                            echo 'background: url(' . $this->user[CN_T_AVATAR] . '); background-size: contain;';
                        }
                    }
                    ?>
                            ">
                        <?php
                        if ($this->user[CN_T_AUTH_VIA] == 'guest') {
                            echo mb_substr($this->user[CN_T_NAME], 0, 1, CN_SET_ENCODING);
                        }
                        ?>
                    </div>
                    <div class="cn_enter_complain_box">
                        <div class="cn_complain_input_panel">
                            <textarea class="cn_complain_input" rows='1' placeholder="<?php echo ''; ?>"></textarea>
                        </div>
                        <div class="cn_length_string">0/150</div>
                        <div class="cn_complain_submit"><? echo CN_SUBMIT; ?></div>
                    </div>
                </div>
            </div>

            <div class="cn_screen_answer">
                <div class="cn_answer_input_box clearfix">
                    <div class="cn_answer_close" title="<?php echo CN_CLOSE; ?>"></div>
                    <div class="cn_answer_box_title"><?php echo CN_NOTICE; ?>:</div>
                    <div class="cn_author_avatar" style="
                    <?php
                    if ($this->cnLogin) {
                        if ($this->user[CN_T_AUTH_VIA] == 'guest') {
                            echo 'background: ' . $this->user[CN_T_AVATAR];
                        } else {
                            echo 'background: url(' . $this->user[CN_T_AVATAR] . '); background-size: contain;';
                        }
                    }
                    ?>
                            ">
                        <?php
                        if ($this->user[CN_T_AUTH_VIA] == 'guest') {
                            echo mb_substr($this->user[CN_T_NAME], 0, 1, CN_SET_ENCODING);
                        }
                        ?>
                    </div>
                    <div class="cn_enter_answer_box">
                        <div class="cn_enter_answer_panel">
                            <textarea class="cn_enter_answer_input" rows='1'
                                      placeholder="<?php echo CN_ENTER_COMMENT; ?>"></textarea>
                        </div>
                        <?php if ($this->cnLogin): ?>
                            <div class="cn_enter_answer_submit"><? echo CN_SUBMIT; ?></div>
                        <? endif; ?>
                    </div>
                </div>
            </div>

            <div class="cn_screen_delete_confirm">
                <div class="cn_delete_confirm_block">
                    <div class="cn_delete_confirm_title"><?php echo CN_DELETE . '?'; ?></div>
                    <div class="cn_delete_confirm_submit cn_animate"><?php echo CN_YES; ?></div>
                    <div class="cn_delete_confirm_cancel cn_animate"><?php echo CN_NO; ?></div>
                </div>
            </div>

        <? endif; ?>

        <div class="cn_block_notice_modal">
            <div class="cn_notice_modal"></div>
        </div>

        <div class="cn_loaded_by_link"><?= CN_LOADED_BY_LINK; ?></div>

    </div>
</section>


<script src="/<?php echo CN_FOLDER_SCRIPT; ?>/js/jquery-3.2.1.min.js"></script>
<script src="/<?php echo CN_FOLDER_SCRIPT; ?>/js/view.min.js"></script>
<script src="/<?php echo CN_FOLDER_SCRIPT; ?>/js/common_view.min.js"></script>
<script src="/<?php echo CN_FOLDER_SCRIPT; ?>/js/ajax.min.js"></script>
<?php if (CN_SET_RECAPTCHA == 'on'): ?>
    <script src='https://www.google.com/recaptcha/api.js'></script>
<? endif; ?>