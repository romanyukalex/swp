var cnjQuery = jQuery.noConflict();
var CN_ANSWER_UNDER_BLOCK = false;

(function ($) {
    $(document).ready(function () {

        var bodyDirect = $('body');

        resizeTextInput();

        /************** Окно для ввода ответа/жалобы на комментарий ***************/
        bodyDirect.on('click', '.cn_answer_button, .cn_complain', function () {
            var inputBox;
            if ($(this).hasClass('cn_answer_button') === true) {
                if (CN_ANSWER_UNDER_BLOCK) {
                    if ($(this).parents('.cn_comment_box').find('.cn_answer_input_box').length > 0) {
                        return false;
                    }
                    var cloneAnswerBlock = $('.cn_screen_answer').find('.cn_answer_input_box').clone();
                    $(this).parents('.cn_comment_box').append(cloneAnswerBlock);

                    inputBox = $(this).parents('.cn_comment_box').find('.cn_answer_input_box');
                    inputBox.addClass('cn_answer_input_box_alternative');
                } else {
                    inputBox = $('.cn_answer_input_box');
                    $('.cn_screen_answer').show();
                }

            }
            if ($(this).hasClass('cn_complain') === true) {
                inputBox = $('.cn_complain_box');
                $('.cn_screen_complain').show();
            }

            var commentId = $(this).parents('.cn_comment_box').attr('id');
            var commentType = $(this).parents('.cn_comment_box').data('cnCommentType');
            var mainCommentId = $(this).parents('.cn_main_comment_block').data('cnMainCommentId') || $(this).parents('.cn_comment_box').data('cnMainCommentId');
            var pageUri = $(this).parents('.cn_comment_box').find('.cn_uri').data('cnPageUri') || document.location.pathname + document.location.search;
            var pageTitle = $(this).parents('.cn_comment_box').find('.cn_uri').text() || $('head').find('title').text();

            inputBox.data('cnParentId', commentId);
            inputBox.data('cnCommentType', commentType);
            inputBox.data('cnMainCommentId', mainCommentId);
            inputBox.data('cnPageUri', pageUri);
            inputBox.data('cnPageTitle', pageTitle);

            inputBox.find('.cn_complain_input, .cn_enter_answer_input').focus();

            resizeBox(inputBox);
        });

        /************** Закрыть окно для ввода ответа/жалоб ***************/
        bodyDirect.on('click', '.cn_answer_close, .cn_complain_close', function () {
            var inputBox;
            if ($(this).hasClass('cn_answer_close') === true) {
                if (CN_ANSWER_UNDER_BLOCK) {
                    inputBox = $(this).parents('.cn_comment_box').find('.cn_answer_input_box');
                    inputBox.remove();
                    return false;
                } else {
                    inputBox = $('.cn_answer_input_box');
                    $('.cn_screen_answer').hide();
                }
            }
            if ($(this).hasClass('cn_complain_close') === true) {
                inputBox = $('.cn_complain_box');
                $('.cn_screen_complain').hide();
            }

            inputBox.data('cnParentId', '');
            inputBox.data('cnCommentType', '');
            inputBox.data('cnMainCommentId', '');
            inputBox.data('cnPageUri', '');
            inputBox.data('cnPageTitle', '');
        });


        /************** Подтвердить удаление комментария ***************/
        bodyDirect.on('click', '.cn_delete_button', function () {
            var deleteConfirm = $('.cn_delete_confirm_block');

            $('.cn_screen_delete_confirm').show();

            var commentId = $(this).parents('.cn_comment_box').attr('id');
            var commentType = $(this).parents('.cn_comment_box').data('cnCommentType');
            var mainCommentId = $(this).parents('.cn_main_comment_block').data('cnMainCommentId') || $(this).parents('.cn_comment_box').data('cnMainCommentId');

            deleteConfirm.data('cnCommentId', commentId);
            deleteConfirm.data('cnCommentType', commentType);
            deleteConfirm.data('cnMainCommentId', mainCommentId);
        });

        /************** Отменить удаление комментария ***************/
        bodyDirect.on('click', '.cn_delete_confirm_cancel', function () {
            var deleteConfirm = $('.cn_delete_confirm_block');

            $('.cn_screen_delete_confirm').hide();

            deleteConfirm.data('cnCommentId', '');
            deleteConfirm.data('cnCommentType', '');
            deleteConfirm.data('cnMainCommentId', '');
        });


        /************** Окно авторизации ***************/
        bodyDirect.on('click', '.cn_social_button', function (e) {
            e.preventDefault();
            var sW = (screen.width - 800) / 2;
            var sH = (screen.height - 600) / 2;
            var urlAuth = $(this).data('cnLink');

            window.open(urlAuth, 'authorize', 'width=840, height=620, top=' + sH + ', left=' + sW + '');
        });


        /************** Показать ответы ***************/
        bodyDirect.on('click', '.cn_show_answer_button', function () {
            var input = $(this).next().next('.cn_answer_hidden');
            input.css({'visibility': 'visible', 'height': 'auto', 'overflow': 'auto'});
            $(this).hide();
            $(this).next().show();
        });
        /************** Скрыть ответы ***************/
        bodyDirect.on('click', '.cn_hide_answer_button', function () {
            var input = $(this).next('.cn_answer_hidden');
            input.removeAttr('style');
            $(this).hide();
            $(this).prev().show();
        });


        /************** Показать опции ***************/
        bodyDirect.on('click', '.cn_options_button', function () {
            var parent = $(this).parent();
            var input = $(this).next('.cn_options_box');

            if (input.is(':visible') === false) {
                $(this).addClass('cn_options_button_hover');
                input.show();
                parent.css({'display': 'block'});
            } else {
                $(this).removeClass('cn_options_button_hover');
                input.hide();
                parent.removeAttr('style');
            }
        });


        /************** Считать кол-во вводимых символов ***************/
        bodyDirect.on('input', '.cn_complain_input', function () {
            var lengthString = $('.cn_length_string');
            var string = $(this).val();

            lengthString.text(string.length + '/150');

            if (string.length > 150) {
                lengthString.css({'color': 'red'});
            } else {
                lengthString.removeAttr('style');
            }
        });

        /************** Окно поделиться ***************/
        bodyDirect.on('click', '.cn_share_box span', function (e) {
            e.preventDefault();
            var sW = (screen.width - 800) / 2;
            var sH = (screen.height - 400) / 2;
            var urlSocial = $(this).data('cnSh');
            window.open(urlSocial, 'share', 'width=840, height=420, top=' + sH + ', left=' + sW + '');
        });


        /************** Авто ресайз textarea ***************/
        bodyDirect.on('input', '.cn_enter_text_input', function () {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        });
        bodyDirect.on('input', '.cn_enter_answer_input, .cn_complain_input', function () {
            if (this.scrollHeight <= Math.round((window.innerHeight / 100 * 60) - ($(this).next().height() | 0))) {
                this.style.height = 'auto';
                this.style.height = this.scrollHeight + 'px';
            } else {
                this.style.overflow = 'auto';
                this.style.height = Math.round((window.innerHeight / 100 * 60) - ($(this).next().height() | 0)) + 'px';
            }
        });


        /************** Показать/Скрыть кнопку "Отправить" ***************/
        bodyDirect.on('focus', '.cn_enter_text_input', function () {
            var enterTextSubmit = $('.cn_enter_text_submit');
            visibleButton(enterTextSubmit);
        });
        bodyDirect.on('focus', '.cn_enter_answer_input', function () {
            var enterTextSubmit;
            if (CN_ANSWER_UNDER_BLOCK) {
                enterTextSubmit = $(this).parents('.cn_comment_box').find('.cn_enter_answer_submit');
            } else {
                enterTextSubmit = $('.cn_enter_answer_submit');
            }
            visibleButton(enterTextSubmit);
        });
        bodyDirect.on('focus', '.cn_complain_input', function () {
            var enterTextSubmit = $('.cn_complain_submit');
            visibleButton(enterTextSubmit);
        });


        /************** Читать дальше (развернуть комментарий) ***************/
        bodyDirect.on('click', '.cn_more_text', function () {
            var countBlockText = this.previousSibling.scrollHeight;
            $(this).prev().animate({'max-height': countBlockText + 'px'}, 200);
            $(this).removeClass('cn_more_text');
            $(this).addClass('cn_more_text_close');
            $(this).prev().children('.cn_more_text_details').animate({'height': '0'}, 400);
        });
        bodyDirect.on('click', '.cn_more_text_close', function () {
            var className = this.previousSibling.className;
            var maxHeight = 204;
            if (className === 'cn_content_comment') {
                maxHeight = 126;
            }
            $(this).prev().animate({'max-height': maxHeight + 'px'}, 200);
            $(this).removeClass('cn_more_text_close');
            $(this).addClass('cn_more_text');
            $(this).prev().children('.cn_more_text_details').animate({'height': '100px'}, 400);
        });
        bodyDirect.on('click', '.cn_more_text_details', function () {
            var countBlockText = this.parentNode.scrollHeight;
            if (countBlockText !== undefined && countBlockText != null) {
                $(this).parent().next().removeClass('cn_more_text');
                $(this).parent().next().addClass('cn_more_text_close');
                $(this).parent().animate({'max-height': countBlockText + 'px'}, 200);
                $(this).animate({'height': '0'}, 400);
            }
        });


        /************** Подсветить родительский коммент ***************/
        bodyDirect.on('click', '.cn_name_quote', function () {
            var parentId = $(this).data('parentId');
            var parentComment = $('#' + parentId);
            var positionParent = parentComment.offset().top - 200;
            parentComment.addClass('cn_animate');
            parentComment.css({'border-left-color': '#ffc004'});
            $('html,body').stop(true, true).animate({scrollTop: positionParent}, 1000);
            setTimeout(function () {
                $('#' + parentId).removeAttr('style');
            }, 2000);
        });

    });
})(cnjQuery);


function visibleButton(elem) {
    elem.css({'visibility': 'visible'}).animate({'opacity': '1'}, 400);
}

function hiddenButton(elem) {
    elem.css({'opacity': '0', 'visibility': 'hidden'});
}

function resizeTextInput() {
    var enterBox = cnjQuery('.cn_enter_text_input');
    if (enterBox.html() !== '' && enterBox.length > 0) {
        enterBox[0].style.height = 'auto';
        enterBox[0].style.height = enterBox[0].scrollHeight + 'px';

        var enterTextSubmit = cnjQuery('.cn_enter_text_submit');
        visibleButton(enterTextSubmit);
    }
}

function cnMoreText(item) {
    var moreText = function (elem) {
        if (elem.scrollHeight > 204) {
            if (cnjQuery(elem).next('.cn_more_text').length === 0 && cnjQuery(elem).next('.cn_more_text_close').length === 0) {
                cnjQuery(elem).after('<div class="cn_more_text"></div>');
                cnjQuery(elem).append('<div class="cn_more_text_details"></div>');
            }
        }
    };
    item.each(function (i, e) {
        moreText(e);
        if (cnjQuery(e).find('img').length > 0) {
            cnjQuery(e).find('img').on('load', function () {
                moreText(e);
            });
        }
    });
}

function cnMoreTextPanel(item) {
    var moreText = function (elem) {
        if (elem.scrollHeight > 126) {
            if (cnjQuery(elem).next('.cn_more_text').length === 0 && cnjQuery(elem).next('.cn_more_text_close').length === 0) {
                cnjQuery(elem).after('<div class="cn_more_text"></div>');
                cnjQuery(elem).append('<div class="cn_more_text_details"></div>');
            }
        }
    };
    item.each(function (i, e) {
        moreText(e);
        if (cnjQuery(e).find('img').length > 0) {
            cnjQuery(e).find('img').on('load', function () {
                moreText(e);
            });
        }
    });
}

function sortAnswer() {
    function compareTimeOld(A, B) {
        return A.time - B.time;
    }

    function sortListOld(contain) {
        var listLi = [];
        var result = [];
        contain.children('.cn_comment_box').each(function (i, val) {
            listLi[i] = {value: val, time: cnjQuery(this).find('.cn_date').data('timeSecond')};
        });
        listLi.sort(compareTimeOld);
        for (var i = 0; i < listLi.length; i++) {
            result[i] = listLi[i].value;
        }
        return result
    }

    var contain = cnjQuery('.cn_last_answer');
    contain.each(function () {
        var list = sortListOld(cnjQuery(this));
        cnjQuery(this).empty().append(list);
    });
}

function noticeModal(type, data) {
    var blockNoticeModal = cnjQuery('.cn_block_notice_modal');
    blockNoticeModal.animate({'left': '0'}, 200);
    blockNoticeModal.children('.cn_notice_modal').html('<div class="cn_notice_modal_' + type + '">' + data + '</div>');
    blockNoticeModal.delay(1500).animate({'left': '-280px'}, 200, function () {
        blockNoticeModal.stop(true, true);
    });
}

function resizeBox(box) {
    cnjQuery(window).on('resize', function () {
        var textarea = box.find('textarea');
        var windowHeight = cnjQuery(this).height();
        if (textarea[0].scrollHeight >= Math.round((windowHeight / 100 * 60) - (textarea.next().height() | 0))) {
            textarea.height((windowHeight / 100 * 60) - (textarea.next().height() | 0));
        } else {
            textarea.height(textarea[0].scrollHeight);
        }
    });
}