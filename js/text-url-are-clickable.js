// Делает все текстовые ссылки на странице кликабельными
$.fn.replaceUrl = function() {  
        var regexp = /((ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?)/gi;  
        this.each(function() {  
            $(this).html(  
                $(this).html().replace(regexp,'<a href="$1">$1</a>') 
            ); 
        }); 
        return $(this); 
    }

$(document).ready(function(){
	$('div, span, td,p').replaceUrl(); 
});