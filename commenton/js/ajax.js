var cnjQuery = jQuery.noConflict();
(function ($) {
    $(document).ready(function () {

        var bodyDirect = $('body');

        $.ajaxSetup({
            type: 'POST',
            url: '/commenton/components/ajax.php',
            dataType: 'json',
            beforeSend: function () {

            },
            complete: function () {

            }
        });

        bodyDirect.on('click', '#cn_logout', function (e) {
            e.preventDefault();
            $.ajax({
                data: {
                    'action': 'logout'
                },
                success: function (response) {
                    if (response === true) {
                        document.location.reload();
                    }
                }
            })
        });


        var Data = new Date();
        var Year = Data.getFullYear();
        var Month = Data.getMonth() + 1;
        var Day = Data.getDate();
        var Hour = Data.getHours();
        var Minutes = Data.getMinutes();
        var Seconds = Data.getSeconds();

        if (Day < 10) Day = '0' + Day;
        if (Month < 10) Month = '0' + Month;
        if (Minutes < 10) Minutes = '0' + Minutes;
        if (Seconds < 10) Seconds = '0' + Seconds;

        var userTime = Hour + ':' + Minutes + ':' + Seconds + ' ' + Day + '-' + Month + '-' + Year;

        var tmeZone = $('.commenton_box').data('timeZone') || $('.cn_panel_block').data('timeZone');

        if (tmeZone === '' || tmeZone === undefined) {
            $('.cn_date').each(function (i, v) {
                var timeComment = $(v).data('timeSecond');
                $.ajax({
                    data: {
                        'action': 'user_time_zone',
                        'user_time': userTime,
                        'time_comment': timeComment
                    },
                    success: function (response) {
                        $(v).attr('title', response);
                    }
                });
            });
        }

        /********************** Отправить комментарий **************************/
        bodyDirect.on('click', '.cn_enter_text_submit', function () {
            var item = $(this);
            var enter_text_input = $('.cn_enter_text_input');

            var messageText = enter_text_input.val();

            hiddenButton(item);

            var page_url = document.location.pathname + document.location.search;
            var page_title = $('head').find('title').text();

            if (page_title === '') page_title = page_url;

            $.ajax({
                data: {
                    'action': 'message_submit',
                    'message_text': messageText,
                    'page_url': page_url,
                    'page_title': page_title
                },
                success: function (response) {
                    if (response[0] === 1) {
                        var commentsBlock = $('.cn_comments_block');
                        var moreComments = $('.cn_more_comments');
                        var moreCount = moreComments.data('cnMore');
                        commentsBlock.prepend(response[1]);
                        enter_text_input.val('');
                        enter_text_input.height('auto');
                        $('.cn_count').text(response[2]);
                        moreComments.data('cnMore', moreCount + 1);
                        moreComments.attr('data-cn-more', moreCount + 1);
                        cnMoreText(commentsBlock.children().find('.cn_string_2'));
                    }
                    if (response[0] === 2 || response[0] === 'flood') {
                        enter_text_input.val('');
                        enter_text_input.height('auto');

                        var type = (response[0] === 2) ? 'success' : 'error';
                        noticeModal(type, response[1]);
                    }
                    if (response[0] === 'not_auth') {
                        console.log(response[0]);
                        noticeModal('error', response[1]);
                    }
                    if (response[0] === 'empty_box') {
                        enter_text_input.parents('.cn_enter_text_panel').css({'border-color': 'red'});
                    }
                    if (response[0] === 'error_data' || response[0] === 'long_string') {
                        $('.cn_notice_error').remove();
                        item.parent().append('<div class="cn_notice_error">' + response[1] + '</div>');
                        enter_text_input.parents('.cn_enter_text_panel').css({'border-color': 'red'});
                    }
                }
            });
            enter_text_input.focus(function () {
                enter_text_input.parents('.cn_enter_text_panel').removeAttr('style');
                $('.cn_notice_error').remove();
            });
        });


        /********************** Ответить на комментарий ***************************/
        bodyDirect.on('click', '.cn_enter_answer_submit', function () {
            var item = $(this);
            var answer_input = (CN_ANSWER_UNDER_BLOCK) ? item.parents('.cn_comment_box').find('.cn_enter_answer_input') : $('.cn_enter_answer_input');

            var area = item.data('cnArea');

            var messageText = answer_input.val();

            hiddenButton(item);

            var page_url = $(this).parents('.cn_answer_input_box').data('cnPageUri');
            var page_title = $(this).parents('.cn_answer_input_box').data('cnPageTitle');
            var parent_id = $(this).parents('.cn_answer_input_box').data('cnParentId');
            var main_id = $(this).parents('.cn_answer_input_box').data('cnMainCommentId');
            var comment_type = $(this).parents('.cn_answer_input_box').data('cnCommentType');

            var level = 1;

            if (comment_type === 'answer') {
                var obj = $('#' + parent_id);
                if (obj.parents('#cnab-' + main_id).length !== 0) {
                    while (obj.attr('id') !== 'cnab-' + main_id) {
                        obj = obj.parent();
                        level++;
                    }
                }
            }

            if (page_title === '') page_title = page_url;

            $.ajax({
                data: {
                    'action': 'answer_submit',
                    'message_text': messageText,
                    'page_url': page_url,
                    'page_title': page_title,
                    'parent_id': parent_id,
                    'main_id': main_id,
                    'comment_type': comment_type,
                    'level': level
                },
                success: function (response) {
                    if (response[0] === 1) {
                        if (area === 'panel') {
                            $('.cn_panel_block').load(location.href + ' .cn_panel_block>*', function () {
                                cnMoreTextPanel($('.cn_content_comment'));
                            })
                        } else {
                            var parentElem = $('#' + parent_id);
                            if (parentElem.next('.cn_comments_answer_block').length > 0) {
                                parentElem = parentElem.next('.cn_comments_answer_block');
                            } else if (parentElem.next().next().next('.cn_comments_answer_block').length > 0) {
                                parentElem.next().click();
                                parentElem = parentElem.next().next().next('.cn_comments_answer_block');
                            } else {
                                parentElem = parentElem.parent('.cn_comments_answer_block');
                            }
                            parentElem.append(response[1]);
                            answer_input.val('');
                            answer_input.height('auto');
                            if (CN_ANSWER_UNDER_BLOCK) {
                                item.parents('.cn_comment_box').find('.cn_answer_close').click()
                            } else {
                                $('.cn_answer_close').click();
                            }
                            $('.cn_count').text(response[2]);

                            var position = $('#cna-' + response[3]).offset().top - 200;
                            $('html,body').stop().animate({scrollTop: position}, 1000);

                            cnMoreText(parentElem.find('.cn_string_2'));
                        }
                    }
                    if (response[0] === 2 || response[0] === 'flood') {
                        answer_input.val('');
                        answer_input.height('auto');
                        if (CN_ANSWER_UNDER_BLOCK) {
                            item.parents('.cn_comment_box').find('.cn_answer_close').click()
                        } else {
                            $('.cn_answer_close').click();
                        }

                        var type = (response[0] === 2) ? 'success' : 'error';
                        noticeModal(type, response[1]);
                    }
                    if (response[0] === 'not_auth') {
                        console.log(response[0]);
                        noticeModal('error', response[1]);
                    }
                    if (response[0] === 'empty_box') {
                        answer_input.parents('.cn_enter_answer_panel').css({'border-color': 'red'});
                    }
                    if (response[0] === 'error_data' || response[0] === 'long_string') {
                        $('.cn_notice_error').remove();
                        item.parent().append('<div class="cn_notice_error">' + response[1] + '</div>');
                        answer_input.parents('.cn_enter_answer_panel').css({'border-color': 'red'});
                    }
                }
            });
            answer_input.focus(function () {
                answer_input.parents('.cn_enter_answer_panel').removeAttr('style');
                $('.cn_notice_error').remove();
            });
        });


        /********************** Удалить комментарий ***************************/
        bodyDirect.on('click', '.cn_delete_confirm_submit', function () {
            var item = $(this);

            var comment_id = item.parents('.cn_delete_confirm_block').data('cnCommentId');
            var comment_type = item.parents('.cn_delete_confirm_block').data('cnCommentType');
            var main_id = item.parents('.cn_delete_confirm_block').data('cnMainCommentId');

            var area = item.data('cnArea');
            var page_url = document.location.pathname + document.location.search;

            $.ajax({
                data: {
                    'action': 'delete_comment',
                    'comment_id': comment_id,
                    'comment_type': comment_type,
                    'page_url': page_url
                },
                success: function (response) {
                    if (response[0] === 1) {
                        if (area === 'panel') {
                            $('.commenton').load(location.href + ' .commenton>*', function () {
                                cnMoreTextPanel($('.cn_content_comment'));
                            })
                        } else {
                            if (comment_type === 'main') {
                                var moreComments = $('.cn_more_comments');
                                var moreCount = moreComments.data('cnMore');
                                moreComments.data('cnMore', moreCount - 1);
                                moreComments.attr('data-cn-more', moreCount - 1);
                                $('[data-cn-main-comment-id="' + main_id + '"]').remove();
                            }
                            if (comment_type === 'answer') {
                                var answerItem = $('#' + comment_id);
                                if (answerItem.next('.cn_comments_answer_block').length > 0) {
                                    answerItem.next('.cn_comments_answer_block').remove();
                                    answerItem.remove();
                                } else {
                                    for (var i = 0; i < response[1].length; i++) {
                                        $('#cna-' + response[1][i]).remove();
                                    }
                                }
                            }
                            $('.cn_delete_confirm_cancel').click();
                            $('.cn_count').text(response[2]);
                        }

                    }
                    if (response[0] === 'no_more') {
                        $('.commenton').load(location.href + ' .commenton>*', function () {

                        })
                    }
                    if (response[0] === 'error_mysql' || response[0] === 'error_data') {
                        console.log(response[0]);
                    }
                    if (response[0] === 'not_auth') {
                        console.log(response[0]);
                        noticeModal('error', response[1]);
                    }
                }
            });
        });


        /********************** Сортировка ***************************/
        bodyDirect.on('click', '.cn_sort_point', function () {
            var sort = $(this).data('cnSort');
            var page_url = document.location.pathname + document.location.search;

            $.ajax({
                data: {
                    'action': 'sort',
                    'sort': sort,
                    'page_url': page_url
                },
                success: function (response) {
                    if (response[0] === 1) {
                        $('.cn_sort').html(response['sort']);
                        $('.cn_comments_block').html(response['content']);
                    }
                    if (response[0] === 'error_data') {
                        console.log(response[0]);
                    }
                }
            });
        });


        /********************** Рейтинг ***************************/
        bodyDirect.on('click', '.cn_like, .cn_dislike', function () {
            var hypeType = $(this).data('cnHype');
            var commentId = $(this).parents('.cn_comment_box').attr('id');
            var commentType = $(this).parents('.cn_comment_box').data('cnCommentType');

            $.ajax({
                data: {
                    'action': 'hype',
                    'hype_type': hypeType,
                    'comment_id': commentId,
                    'comment_type': commentType
                },
                success: function (response) {
                    if (response[0] === 1) {
                        if (response[1] !== undefined && response[1] != null) {
                            var like;
                            var itemComment = $('#' + commentId);
                            if (+response[1] > 0) {
                                like = '<div class="cn_like_cool">' + response[1] + '</div>';
                            }
                            if (+response[1] < 0) {
                                like = '<div class="cn_like_bad">' + response[1] + '</div>';
                            }
                            if (+response[1] === 0) {
                                like = '';
                            }

                            if (hypeType === 'like') {
                                itemComment.find('.cn_like').css({'opacity': '0.5'});
                                itemComment.find('.cn_dislike').removeAttr('style');
                            }
                            if (hypeType === 'dislike') {
                                itemComment.find('.cn_dislike').css({'opacity': '0.5'});
                                itemComment.find('.cn_like').removeAttr('style');
                            }

                            itemComment.find('.cn_like_meter').html(like);
                        }
                    }
                    if (response[0] === 'no_more') {
                        $('.commenton').load(location.href + ' .commenton>*', function () {
                            cnMoreText($('.cn_string_2'));
                        })
                    }
                    if (response[0] === 'guest_auth') {
                        noticeModal('error', response[1]);
                    }
                    if (response[0] === 'error_model' || response[0] === 'error_data') {
                        console.log(response[0]);
                    }
                    if (response[0] === 'not_auth') {
                        console.log(response[0]);
                        noticeModal('error', response[1]);
                    }
                }
            });
        });


        /********************** Загрузить ещё ***************************/
        bodyDirect.on('click', '.cn_more_comments', function () {
            var item = $(this);
            var limit = item.data('cnMore');
            var pageUrl = document.location.pathname + document.location.search;

            $.ajax({
                data: {
                    'action': 'more_comments',
                    'limit': limit,
                    'page_url': pageUrl
                },
                beforeSend: function () {
                    item.removeClass('cn_more_comments');
                    item.addClass('cn_loading_block');
                    item.html('<div class="cn_loading"></div>');
                },
                complete: function () {
                    item.removeClass('cn_loading_block');
                    item.addClass('cn_more_comments');
                    item.html('');
                },
                success: function (response) {
                    if (response['limit'] === 'cancel') {
                        item.remove();
                    } else {
                        item.data('cnMore', response['limit']);
                        item.attr('data-cn-more', response['limit']);
                    }
                    $('.cn_comments_block').append(response['data']);

                    cnMoreText($('.cn_string_2'));
                    sortAnswer();
                }
            });
        });


        /********************** Отправить жалобу ***************************/
        bodyDirect.on('click', '.cn_complain_submit', function () {
            var item = $(this);
            var complaint_input = $('.cn_complain_input');

            var message = complaint_input.val();
            var commentId = $(this).parents('.cn_complain_box').data('cnParentId');
            var commentType = $(this).parents('.cn_complain_box').data('cnCommentType');

            $.ajax({
                data: {
                    'action': 'complaint_submit',
                    'message': message,
                    'comment_id': commentId,
                    'comment_type': commentType
                },
                success: function (response) {
                    if (response[0] === 1) {
                        complaint_input.val('');
                        complaint_input.height('auto');
                        $('.cn_complain_close').click();
                        noticeModal('success', response[1]);
                    }
                    if (response[0] === 'no_more') {
                        $('.commenton').load(location.href + ' .commenton>*', function () {
                            cnMoreText($('.cn_string_2'));
                            noticeModal('error', response[1]);
                        })
                    }
                    if (response[0] === 'error_mysql' || response[0] === 'error_data') {
                        console.log(response[0]);
                    }
                    if (response[0] === 'not_auth') {
                        console.log(response[0]);
                        noticeModal('error', response[1]);
                    }
                    if (response[0] === 'empty_box' || response[0] === 'long_string') {
                        $('.cn_notice_error').remove();
                        item.before('<div class="cn_notice_error" style="float: left;">' + response[1] + '</div>');
                    }
                }
            });
            complaint_input.focus(function () {
                $('.cn_notice_error').remove();
            });
        });


        /********************** Очистить от жалоб ***************************/
        bodyDirect.on('click', '.cn_clean_complain_button', function () {
            var commentId = $(this).parents('.cn_comment_box').attr('id');
            var commentType = $(this).parents('.cn_comment_box').data('cnCommentType');

            $.ajax({
                data: {
                    'action': 'clean_complaints',
                    'comment_id': commentId,
                    'comment_type': commentType
                },
                success: function (response) {
                    if (response[0] === 1) {
                        $('.cn_panel_block').load(location.href + ' .cn_panel_block>*', function () {
                            cnMoreTextPanel($('.cn_content_comment'));
                        })
                    }
                    if (response[0] === 'error_mysql' || response[0] === 'error_data') {
                        console.log(response[0]);
                    }
                    if (response[0] === 'not_auth') {
                        console.log(response[0]);
                        noticeModal('error', response[1]);
                    }
                }
            });
        });


        /********************** Гостевой вход ***************************/
        bodyDirect.on('click', '.cn_authorize_guest_submit', function () {
            var itemGuestName = $(this).parents('.cn_authorize_guest').children('.cn_guest_name_input');
            var itemGuestEmail = $(this).parents('.cn_authorize_guest').children('.cn_guest_email_input');
            var itemRecaptcha = $(this).parents('.cn_authorize_guest').children('.cn_recaptcha');
            var guestName = itemGuestName.val();
            var guestEmail = '';
            var gRecaptchaResponse = '';

            if (itemGuestEmail.length !== 0) {
                guestEmail = itemGuestEmail.val();
            }

            if (itemRecaptcha.length !== 0) {
                try {
                    gRecaptchaResponse = grecaptcha.getResponse();
                } catch (err) {
                    return false
                }
            }

            $.ajax({
                data: {
                    'action': 'login_guest',
                    'guest_name': guestName,
                    'guest_email': guestEmail,
                    'g_recaptcha_response': gRecaptchaResponse
                },
                success: function (response) {
                    if (response[0] === 1) {
                        document.location.reload();
                    } else if (response[0] === 'empty_email_box' || response[0] === 'error_email') {
                        $('.cn_notice_error').remove();
                        itemGuestEmail.after('<div class="cn_notice_error">' + response[1] + '</div>');
                    } else if (response[0] === 'empty_box' || response[0] === 'reserved_name'
                        || response[0] === 'small_name' || response[0] === 'long_name'
                        || response[0] === 'unresolved_char') {
                        $('.cn_notice_error').remove();
                        itemGuestName.after('<div class="cn_notice_error">' + response[1] + '</div>');
                    } else if (response[0] === 'error_auth' || response[0] === 'error_recaptcha' || response[0] === 'error_login') {
                        $('.cn_notice_error').remove();
                        itemRecaptcha.after('<div class="cn_notice_error">' + response[1] + '</div>');
                    } else if (response[0] === 'error_data') {
                        console.log(response[1]);
                    }
                }
            });

            itemGuestName.focus(function () {
                $('.cn_notice_error').remove();
            });
        });


        /********************** Вход в админку ***************************/
        bodyDirect.on('click', '.cn_login_submit', function (e) {
            e.preventDefault();

            var item = $(this);

            var login = $('#cn_login').val();
            var password = $('#cn_password').val();

            $.ajax({
                data: {
                    'action': 'login_admin',
                    'login': login,
                    'password': password
                },
                success: function (response) {
                    if (response[0] === 1) {
                        document.location.reload();
                    }
                    if (response[0] === 'error_login') {
                        $('.cn_notice_error').remove();
                        item.after('<b class="cn_notice_error" style="margin-left: 10px;color:red;font-size: 14px;">' + response[1] + '</b>');
                    }
                    if (response[0] === 'error_data') {
                        console.log(response[1]);
                    }
                }
            });

            $('#cn_login, #cn_password').focus(function () {
                $('.cn_notice_error').remove();
            });
        });


        /********************** Одобрить комментарий ***************************/
        bodyDirect.on('click', '.cn_approve_button', function () {
            var commentId = $(this).parents('.cn_comment_box').attr('id');
            var commentType = $(this).parents('.cn_comment_box').data('cnCommentType');

            $.ajax({
                data: {
                    'action': 'approve',
                    'comment_id': commentId,
                    'comment_type': commentType
                },
                success: function (response) {
                    if (response[0] === 1) {
                        $('.cn_panel_block').load(location.href + ' .cn_panel_block>*', function () {
                            cnMoreTextPanel($('.cn_content_comment'));
                        })
                    }
                    if (response[0] === 'error_mysql' || response[0] === 'error_data') {
                        console.log(response[1]);
                    }
                    if (response[0] === 'not_auth') {
                        console.log(response[0]);
                        noticeModal('error', response[1]);
                    }
                }
            });
        });


        /********************** В корзину ***************************/
        bodyDirect.on('click', '.cn_trash_button', function () {
            var item = $(this);

            var commentsId = item.parents('.cn_comment_box').attr('id');
            var commentType = item.parents('.cn_comment_box').data('cnCommentType');
            var main_id = item.parents('.cn_main_comment_block').data('cnMainCommentId') || item.parents('.cn_comment_box').data('cnMainCommentId');

            var area = item.data('cnArea');
            var page_url = document.location.pathname + document.location.search;

            $.ajax({
                data: {
                    'action': 'trash',
                    'comment_id': commentsId,
                    'comment_type': commentType,
                    'page_url': page_url
                },
                success: function (response) {
                    if (response[0] === 1) {
                        if (area === 'panel') {
                            $('.commenton').load(location.href + ' .commenton>*', function () {
                                cnMoreTextPanel($('.cn_content_comment'));
                            })
                        } else {
                            if (commentType === 'main') {
                                $('[data-cn-main-comment-id="' + main_id + '"]').remove();
                            }
                            if (commentType === 'answer') {
                                var answerItem = $('#' + commentsId);
                                if (answerItem.next('.cn_comments_answer_block').length > 0) {
                                    answerItem.next('.cn_comments_answer_block').remove();
                                    answerItem.remove();
                                } else {
                                    for (var i = 0; i < response[1].length; i++) {
                                        $('#cna-' + response[1][i]).remove();
                                    }
                                }
                            }
                            $('.cn_count').text(response[2]);
                        }
                    }
                    if (response[0] === 'no_more') {
                        $('.commenton').load(location.href + ' .commenton>*', function () {
                            if (area === 'panel') {
                                cnMoreTextPanel($('.cn_content_comment'));
                            } else {
                                cnMoreText($('.cn_string_2'));
                            }
                        })
                    }
                    if (response[0] === 'error_mysql' || response[0] === 'error_data') {
                        console.log(response[0]);
                    }
                    if (response[0] === 'not_auth') {
                        console.log(response[0]);
                        noticeModal('error', response[1]);
                    }
                }
            });
        });


        /********************** Восстановить ***************************/
        bodyDirect.on('click', '.cn_recover_button', function () {
            var item = $(this);

            var commentsId = item.parents('.cn_comment_box').attr('id');
            var commentType = item.parents('.cn_comment_box').data('cnCommentType');

            $.ajax({
                data: {
                    'action': 'recover',
                    'comment_id': commentsId,
                    'comment_type': commentType
                },
                success: function (response) {
                    if (response[0] === 1) {
                        $('.commenton').load(location.href + ' .commenton>*', function () {
                            cnMoreTextPanel($('.cn_content_comment'));
                        })
                    }
                    if (response[0] === 'error_mysql' || response[0] === 'error_data') {
                        console.log(response[0]);
                    }
                    if (response[0] === 'not_auth') {
                        console.log(response[0]);
                        noticeModal('error', response[1]);
                    }
                }
            });
        });


        /********************** Настройки ***************************/
        bodyDirect.on('change', '.cn_setting_section input, .cn_setting_section select, .cn_limit_admin select', function () {
            var formCommon = $("form[name='cn_form_common']").serializeArray();
            var formAdmin = $("form[name='cn_form_admin']").serializeArray();
            var formSocial = $("form[name='cn_form_social']").serializeArray();
            var formGuest = $("form[name='cn_form_guest']").serializeArray();
            var formLimitAdmin = $("form[name='cn_form_limit_admin']").serializeArray();
            var formLimitUsers = $("form[name='cn_form_limit_users']").serializeArray();

            $.ajax({
                data: {
                    'action': 'setting',
                    'form_common': formCommon,
                    'form_admin': formAdmin,
                    'form_social': formSocial,
                    'form_guest': formGuest,
                    'form_limit_admin': formLimitAdmin,
                    'form_limit_users': formLimitUsers
                },
                success: function (response) {
                    if (response[1] === 'reload_comments') {
                        $('.commenton').load(location.href + ' .commenton>*', function () {
                            cnMoreTextPanel($('.cn_content_comment'));
                        })
                    }
                    if (response[1] === 'reload_users') {
                        $('.cn_users_block').load(location.href + ' .cn_users_block>*', function () {
                            cnMoreTextPanel($('.cn_content_comment'));
                        })
                    }
                    if (response === 'error_write') {
                        console.log(response);
                    }
                    if (response[0] === 'not_auth') {
                        console.log(response[0]);
                        noticeModal('error', response[1]);
                    }
                }
            });
        });


        /********************** Настройки: Загрузка аватара ***************************/
        bodyDirect.on('change', '#cn_set_admin_avatar', function () {
            $('.cn_set_ava_admin').attr('src', $(this).val());
        });
        bodyDirect.on('change', '#cn_set_admin_avatar_upload', function () {
            var data = new FormData();
            $.each(this.files, function (key, value) {
                data.append('ava_admin_upload', value);
            });

            $.ajax({
                data: data,
                cache: false,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response[0] === 1) {
                        $('.cn_set_ava_admin').attr('src', response[1]);
                        $('#cn_set_admin_avatar').val(response[1]);
                    }
                    if (response[0] === 'error_preload' ||
                        response[0] === 'error_type' || response[0] === 'error_size' ||
                        response[0] === 'error_upload') {
                        console.log(response[0]);
                    }
                    if (response[0] === 'not_auth') {
                        console.log(response[0]);
                        noticeModal('error', response[1]);
                    }
                }
            });
        });


        /********************** Заблокировать пользователя ***************************/
        bodyDirect.on('click', '.cn_user_ban_table', function () {
            var userId = $(this).parents('.cn_user_str_table').data('cnUserId');

            $.ajax({
                data: {
                    'action': 'user_ban',
                    'user_id': userId
                },
                success: function (response) {
                    if (response[0] === 1) {
                        $('.cn_users_block').load(location.href + ' .cn_users_block>*', function () {

                        })
                    }
                    if (response[0] === 'error_mysql' || response[0] === 'error_data') {
                        console.log(response[0]);
                    }
                    if (response[0] === 'not_auth') {
                        console.log(response[0]);
                        noticeModal('error', response[1]);
                    }
                }
            });
        });


        /******************* Удалить пользователя *********************/
        bodyDirect.on('click', '.cn_user_delete_confirm_submit', function () {
            var userId = $(this).parents('.cn_user_delete_confirm_block').data('cnUserId');

            $.ajax({
                data: {
                    'action': 'user_delete',
                    'user_id': userId
                },
                success: function (response) {
                    if (response[0] === 1) {
                        $('.cn_users_block').load(location.href + ' .cn_users_block>*', function () {

                        })
                    }
                    if (response[0] === 'error_mysql' || response[0] === 'error_data') {
                        console.log(response[0]);
                    }
                    if (response[0] === 'not_auth') {
                        console.log(response[0]);
                        noticeModal('error', response[1]);
                    }
                }
            });
        });


        /******************* Пометить все как прочитонное *********************/
        bodyDirect.on('click', '.cn_all_read', function () {
            $.ajax({
                data: {
                    'action': 'all_read'
                },
                success: function (response) {
                    if (response === 1) {
                        $('.commenton').load(location.href + ' .commenton>*', function () {
                            cnMoreTextPanel($('.cn_content_comment'));
                        })
                    }
                    if (response[0] === 'not_auth') {
                        console.log(response[0]);
                        noticeModal('error', response[1]);
                    }
                }
            });
        });


        /************* Пометить комментарий как прочитонный ***************/
        bodyDirect.on('click', '.cn_read_button', function () {
            var item = $(this);

            var commentId = item.parents('.cn_comment_box').attr('id');
            var commentType = item.parents('.cn_comment_box').data('cnCommentType');

            $.ajax({
                data: {
                    'action': 'read_once',
                    'comment_id': commentId,
                    'comment_type': commentType
                },
                success: function (response) {
                    if (response[0] === 1) {
                        $('.commenton').load(location.href + ' .commenton>*', function () {
                            cnMoreTextPanel($('.cn_content_comment'));
                        })
                    }
                    if (response[0] === 'error') {
                        console.log(response[0]);
                    }
                    if (response[0] === 'not_auth') {
                        console.log(response[0]);
                        noticeModal('error', response[1]);
                    }
                }
            });
        });


        /******************* Пакетные действия *********************/
        bodyDirect.on('click', '.cn_action_point', function () {
            var formSelectedComments = $("form[name='cn_comment_select_form']").serializeArray();
            var actionType = $(this).data('actionType');

            $.ajax({
                data: {
                    'action': 'action_selected',
                    'action_type': actionType,
                    'selected_comments': formSelectedComments
                },
                beforeSend: function () {
                    var loading = '<div class="cn_block_loading"><div class="cn_loading"></div></div>';
                    var loadingItem = $('.cn_loading');
                    if ($('.cn_block_loading').length === 0) {
                        $("body").prepend(loading);
                    }
                    loadingItem.stop();
                    loadingItem.animate({'width': '70%'});
                },
                complete: function () {
                    var loadingItem = $('.cn_loading');
                    loadingItem.stop();
                    loadingItem.animate({'width': '100%'});

                    setTimeout(function () {
                        $(".cn_block_loading").remove();
                    }, 800);

                },
                success: function (response) {
                    if (response[0] === 1) {
                        $('.cn_panel_block').load(location.href + ' .cn_panel_block>*', function () {
                            $('.cn_select_all').prop("checked", false);
                            cnMoreTextPanel($('.cn_content_comment'));
                        })
                    }
                    if (response[0] === 'error') {
                        console.log(response[0]);
                    }
                    if (response[0] === 'not_auth') {
                        console.log(response[0]);
                        noticeModal('error', response[1]);
                    }
                }
            });
        });


        /******************* Загрузка комментариев по ссылке *********************/
        if (location.hash) {
            var hash = location.hash;
            var pathname = location.pathname;
            if ($(hash).length > 0) {
                var type = $(hash).data('cnCommentType');

                if (type === 'answer') {
                    var mainBlock = $(hash).parents('.cn_main_comment_block');
                    if (mainBlock.length > 0) {
                        mainBlock.find('.cn_show_answer_button').click();
                    }
                }

                var position = $(hash).offset().top - 200;

                $(hash).addClass('cn_animate');
                $(hash).css({'border-left-color': '#ffc004'});
                $('html,body').stop().animate({scrollTop: position}, 1000);

                setTimeout(function () {
                    $(hash).removeAttr('style');
                }, 2000);
            } else {
                $.ajax({
                    data: {
                        'action': 'load_by_link',
                        'hash': hash,
                        'pathname': pathname + document.location.search
                    },
                    success: function (response) {
                        if (response['link_locate'] != null) {
                            window.location.replace(response['link_locate']);
                        }
                        if (response['data'] != null) {
                            $('.cn_comments_block')
                                .prepend('<div class="cn_loaded_by_link_end">* * *</div>')
                                .prepend(response['data'])
                                .prepend($('.cn_loaded_by_link').detach().css({'display': 'block'}));
                            cnMoreText($('.cn_string_2'));

                            var position = $(hash).offset().top - 200;

                            $(hash).addClass('cn_animate');
                            $(hash).css({'border-left-color': '#ffc004'});
                            $('html,body').stop().animate({scrollTop: position}, 1000);

                            setTimeout(function () {
                                $(hash).removeAttr('style');
                            }, 2000);
                        }
                    }
                });
            }
        }

        bodyDirect.on('input', '.cn_enter_text_input', function () {
            var input = $(this);
            var page_url = document.location.pathname + document.location.search;

            $.ajax({
                data: {
                    'action': 'save_text_entered',
                    'page_url': page_url,
                    'text': input.val()
                }
            });
        });


        /************** Редактировать url страницы  ***************/
        bodyDirect.on('click', '.cn_pid_edit', function () {
            var oldPid = $(this).data('pid') || '';
            var newPid = prompt($(this).data('alert'), oldPid);

            $.ajax({
                data: {
                    'action': 'pid_edit',
                    'old_pid': oldPid,
                    'new_pid': newPid
                },
                success: function (response) {
                    function replaceGetParam(name, value) {
                        var urlVar = window.location.search;
                        var arrayVar = [];
                        var valueAndKey = [];
                        var resultArray = [];
                        var resultStr = '';
                        arrayVar = (urlVar.substr(1)).split('&');
                        if (arrayVar[0] === "") return false;
                        for (i = 0; i < arrayVar.length; i++) {
                            valueAndKey = arrayVar[i].split('=');
                            if (valueAndKey[0] === name) {
                                resultArray[i] = valueAndKey[0] + '=' + value;
                            } else {
                                resultArray[i] = valueAndKey[0] + '=' + valueAndKey[1];
                            }
                        }
                        return resultArray;
                    }

                    var newUrlGet = replaceGetParam('f', newPid);

                    if (response === 1) {
                        window.location.href = window.location.origin + location.pathname + '?' + newUrlGet.join('&');
                    }
                }
            });
        });

    });
})(cnjQuery);