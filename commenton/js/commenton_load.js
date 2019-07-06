(function($) {
    function commentonLoad() {
        var url = document.location.pathname + document.location.search;
        $.ajax({
            type: 'POST',
            url: '/commenton/components/script_load.php',
            dataType: 'json',
            data: {
                'action': 'load_script',
                'url': url
            },
            beforeSend: function () {
                $('#commenton_script').after('<div class="cn_loading_block"><div class="cn_loading"></div></div>');
            },
            complete: function () {
                $('.cn_loading_block').remove();
            },
            success: function (response) {
                $('#commenton_script').html(response);
            }
        });
    }

    $(document).ready(function () {
        commentonLoad();
    });
})(jQuery);


