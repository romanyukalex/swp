$(function() {
    $(document).on('click', '.js-text-show-more', function() {
        $(this).next('.more').removeClass('hidden');
        $(this).remove();
    });

    $(document).on('click', '.js-slider-show-more', function() {
        var $button = $(this),
            $item = $button.parents('.description__item'),
            $buttonText = $button.find('.text'),
            $text = $item.find('.more-text');

        if ($text.is(':visible')) {
            $buttonText.text('Подробнее');
        } else {
            $buttonText.text('Свернуть');
        }

        $text.fadeToggle(400);
    });

    $('.js-fancybox').fancybox({
        maxWidth: 800,
        padding: 0,
        height: 'auto',
        width: 'auto',
        openEffect: 'none',
        closeEffect: 'none',
        autoSize: true,
        fitToView: false,
        scrolling: false
    });

    // slider
    $('.js-slider').each(function(){
        var $slider = $(this),
            $list = $slider.find('.list'),
            $description = $slider.find('.description'),
            items = $slider.find('.item').length,
            start = $slider.data('start'),
            width = $slider.find('.item:first').outerWidth();

        for (var i = 0; i < items; i++) {
            $list.children('.item:eq(' + i + ')').attr('data-item', Number(i + 1));
            $description.children('.description__item:eq(' + i + ')').attr('data-item', Number(i + 1));
        }

        $list.css({
            left: -Number(start - 2) * width
        }).children('.item[data-item="' + start + '"]').addClass('active');
        $description.children('.description__item[data-item="' + start + '"]').addClass('active');
    });
    $(document).on('click', '.js-slider .prev, .js-slider .next', function() {
        var $slider = $(this).parents('.js-slider'),
            $list = $slider.find('.list'),
            current = $slider.find('.item.active').data('item'),
            next = $(this).hasClass('next'),
            count = $slider.find('.item').length,
            width = $slider.find('.item:first').outerWidth();

        $slider.find('.item, .description__item').removeClass('active');

        if (next) {
            if (current >= count) {
                current = 1;
            } else {
                current++;
            }
        } else {
            if (current === 1) {
                current = count;
            } else {
                current--;
            }
        }

        $list.css({
            left: -Number(current - 2) * width
        });

        $slider.find('.item[data-item="' + current + '"]').addClass('active');
        $slider.find('.description__item[data-item="' + current + '"]').addClass('active');
    });
});