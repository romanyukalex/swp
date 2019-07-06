jQuery.noConflict();
(function ($) {
    $(document).ready(function () {

        var bodyDirect = $('body');

        /************** Открыть окно выбора изображения ***************/
        bodyDirect.on('click', '.cn_select_avatar', function () {
            $('#cn_set_admin_avatar_upload').click();
        });

        /************** Подтвердить удаление пользователя ***************/
        bodyDirect.on('click', '.cn_users_delete_table', function () {
            var deleteConfirm = $('.cn_user_delete_confirm_block');
            $('.cn_screen_delete_confirm').show();
            var userId = $(this).parents('.cn_user_str_table').data('cnUserId');
            deleteConfirm.data('cnUserId', userId);
        });

        /************** Отменить удаление пользователя ***************/
        bodyDirect.on('click', '.cn_user_delete_confirm_cancel', function () {
            var deleteConfirm = $('.cn_user_delete_confirm_block');
            $('.cn_screen_delete_confirm').hide();
            deleteConfirm.data('cnUserId', '');
        });

        /************** Выбрать все комментарии ***************/
        bodyDirect.on('change', '.cn_select_all', function () {
            var selectAll = $(this).prop("checked");
            if (selectAll === true) {
                $('.cn_comment_select').prop("checked", true);
            }
            if (selectAll === false) {
                $('.cn_comment_select').prop("checked", false);
            }
        });

        bodyDirect.on('change', '.cn_comment_select', function () {
            $('.cn_select_all').prop("checked", false);
        });


        /************** Обрезать большой комментарий ***************/
        cnMoreTextPanel($('.cn_content_comment'));

    });
})(jQuery);