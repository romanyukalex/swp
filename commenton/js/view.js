var cnjQuery = jQuery.noConflict();
(function ($) {
    $(document).ready(function () {

        var bodyDirect = $('body');

        /************** Обрезать большой комментарий ***************/
        cnMoreText($('.cn_string_2'));

        /************** Сортировать последние ответы на комментарий ***************/
        sortAnswer();

    });
})(cnjQuery);