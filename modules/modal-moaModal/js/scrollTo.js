(function($){
    var SW = Sweefty();
    var scroll_options = {
        speed : 250,
        on : 'click',
        easing : 'linear'
    }
    
    SW.trigger('scrollTo',function(ele,obj){
        
        obj = $.extend({},scroll_options, obj);
        var target = $(obj.scrollTo);
        ele.on(obj.on,function(){
            $('body,html').animate({
                'scrollTop' : target.offset().top
            }, parseInt(obj.speed),obj.easing);
        });
    });
    
}(jQuery));
