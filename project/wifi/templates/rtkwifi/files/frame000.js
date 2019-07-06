(function() {
    "use strict";

    var options = {
        items:          [{"hidden": false, "test": false, "name": "Услуги связи", "id": 1, "url": "www.rt.ru"}, {"hidden": false, "test": false, "name": "Корпоративный сайт", "id": 3, "url": "http://www.rostelecom.ru"}, {"hidden": false, "test": false, "name": "Zabava.ru", "id": 2, "url": "zabava.ru"}, {"hidden": false, "test": true, "name": "Игры", "id": 6, "url": "games.rt.ru"}, {"hidden": false, "test": false, "name": "Денежные переводы", "id": 10, "url": "https://rt.dengisend.ru/"}, {"hidden": false, "test": false, "name": "Туристический портал", "id": 4, "url": "travel.rt.ru"}, {"hidden": false, "test": true, "name": "ТЧК. Телеграммы", "id": 11, "url": "http://telegraf.ru"}, {"hidden": false, "test": false, "name": "Сервисы Спутника", "id": 5, "url": "http://www.sputnik.ru/"}, {"hidden": true, "test": false, "name": "Азбука Интернета", "id": 7, "url": "http://azbukainterneta.ru"}, {"hidden": true, "test": false, "name": "Безопасный интернет", "id": 9, "url": "http://safe-internet.ru"}, {"hidden": true, "test": false, "name": "История связи", "id": 8, "url": "http://историясвязи.рф/"}],
        baseLoc:        '',
        showLogo:       false,
        withoutActive:  false,
        stressFirst:    true,
        widthoutStat:   true,
        withoutRtk:     false
    };

    var loc = window.location.host.match(/(?:\w+:\/\/)?(?:www\.)?([^\/?#]*)/)[1];

    function domain(url) {
        if (url.indexOf("://") > -1) {
            url = url.split('/')[2];
        } else {
            url = url.split('/')[0];
        }
        url = url.split(':')[0];
        return url;
    }

    function compareDomains(url1, url2) {
        var d1 = domain(url1),
            d2 = domain(url2);
        return d1 == d2 || 'www.' + d1 == d2 || d1 == 'www.' + d2;
    }

    if(options.withoutRtk) {
        var removeIndex = -1;
        for (var i in options.items) {
            var item = options.items[i];
            if(compareDomains(item["url"], "rt.ru")) {
                item["name"] = "Услуги Ростелеком";
            } else if(compareDomains(item["url"], "rostelecom.ru")) {
                removeIndex = i;
            }
        }
        if(removeIndex != -1) {
            options.items.splice(removeIndex, 1);
        }
    }

    var items   = options.items;
    var baseLoc = options.baseLoc;

    var nav = document.getElementById('toolbar-rt-generated');
    if (nav)
        return;

    var html = '<div class="toolbar-rtk-special">';
    html += '<div class="tr-gr-hidrr-tbl">';
    if (options.showLogo) {
        html += '<div class="tr-gr-hidrr-item hide-middesktop">' +
                    '<a style="display: block; height: 36px;" href="//www.rt.ru">' +
                        '<img style="height: 100%;" src="{{logo}}"' +
                    '</a>' +
                '</div>';
    }

    function isActive(url) {
        return (baseLoc.length > 0 ? compareDomains(baseLoc, url) : loc === url.match(/(?:\w+:\/\/)?(?:www\.)?([^\/?#]*)/)[1]) && !options.withoutActive;
    }

    var stylesFrame = [/*{
        main: 'js-nohide',
        add: ''
    }, {
        main: 'js-nohide',
        add: ''
    }, {
        main: 'hide-smallmb',
        add: 'hide-desktop hide-tablet-menu hide-mobile-menu'
    }, {
        main: 'hide-mobile',
        add: 'hide-desktop hide-tablet-menu'
    }, {
        main: 'hide-mobile',
        add: 'hide-desktop hide-tablet-menu'
    }, {
        main: 'hide-tablet',
        add: 'hide-desktop'
    }*/];

    var item, styleFrame, hideClass, scheme, i;

    for (i = 0; i < items.length; i++) {
        item = items[i];
        if (item.hidden) break;
        styleFrame = stylesFrame[i];
        // hideClass = styleFrame ? styleFrame.main : 'hide-tablet';
        scheme = item.url.match(/http[s]?/) ? '' : '//';
        html += '<div class="tr-gr-hidrr-item ' + hideClass + (isActive(item.url) ? ' gr-active' : '') + '">';
        html += '<a title="' + item.name + '" href="' + scheme + item.url + '" class="tr-gr-hidrr-link">' + item.name + '</a>';
        html += '</div>';
    }

    html += '<div class="tr-gr-hidrr-item ' + hideClass + (isActive(item.url) ? ' gr-active' : '') + '">';
    html += '<div class="tr-gr-hidrr-wrap">' + '<span class="tr-gr-hidrr-link">Еще</span>' + '<ul class="tr-gr-hidrr-menu" style="display: none;">';

    for (i = 2; i < items.length; i++) {
        item = items[i];
        styleFrame = stylesFrame[i] || (!item.hidden ? stylesFrame[stylesFrame.length - 1] : null);
        hideClass = styleFrame ? styleFrame.add : '';
        html += '<li class="' + hideClass + '">';
        scheme = item.url.match(/http[s]?/) ? '' : '//';
        html += '<a title="' + item.name + '" href="' + scheme + item.url + '" class="tr-gr-hidrr-link">' + item.name + '</a>';
        html += '</li>';
    }

    html += '</ul>';
    html += '</div>';
    html += '</div>';
    html += '</div></div>';
    var css = '.tr-gr-hidrr{width:100%;padding:0 15px;font:9pt/1 Arial,sans-serif!important;color:#999!important;background:#fff!important;-webkit-box-sizing:border-box;box-sizing:border-box;position:relative;-webkit-box-shadow:1px 0 4px rgba(93,117,139,.5);box-shadow:1px 0 4px rgba(93,117,139,.5);z-index:1000}.tr-gr-hidrr .tr-gr-hidrr-tbl{height:36px!important;margin:auto;display:table;table-layout:fixed}.tr-gr-hidrr .tr-gr-hidrr-item{padding:0 1.3em;display:table-cell;height:36px;vertical-align:middle;text-align:center;border-bottom:4px solid transparent}.tr-gr-hidrr .tr-gr-hidrr-item.always-active,.tr-gr-hidrr .tr-gr-hidrr-item.gr-active{font-weight:700;border-bottom-color:#01abe8}.tr-gr-hidrr .tr-gr-hidrr-item.gr-active>.tr-gr-hidrr-link{color:#01abe8;cursor:default}.tr-gr-hidrr .tr-gr-hidrr-item img{max-width:none;display:block;position:relative;top:2px}.tr-gr-hidrr .tr-gr-hidrr-link,.tr-gr-hidrr .tr-gr-hidrr-wrap{display:inline-block;width:100%;position:relative}.tr-gr-hidrr .tr-gr-hidrr-link{color:#999;white-space:nowrap;cursor:pointer;top:4px;text-decoration:none}.tr-gr-hidrr .tr-gr-hidrr-link:hover{color:#01abe8}.tr-gr-hidrr .tr-gr-hidrr-wrap{height:36px;z-index:9998}.tr-gr-hidrr .tr-gr-hidrr-wrap>.tr-gr-hidrr-link{top:1.3em;border-bottom:1px dotted}.tr-gr-hidrr .tr-gr-hidrr-menu{width:200px;margin:0 0 0 -75pt;padding:25px 0 30px;border:1px solid #baccd8;text-align:left;background:#fff;list-style-type:none!important;position:absolute;top:100%;top:-webkit-calc(100% - -4px);top:calc(100% - -4px);left:50%;z-index:9999}.tr-gr-hidrr .tr-gr-hidrr-menu>li{padding:0 30px;margin-bottom:9pt;background:0 0!important}.tr-gr-hidrr .tr-gr-hidrr-menu>li:last-child{margin-bottom:0}.tr-gr-hidrr .tr-gr-hidrr-menu:after{content:"";width:19px;height:11px;margin-left:-9px;position:absolute;background-image:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABMAAAALCAYAAACd1bY6AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAORJREFUeNpijC3tZmTAA6JCvOWYmZnm/f37L2nZmq2P8KllwicZHuQhDzRov6q0qBOQPgTiE2sYIzIGaWRjZd0HNEhRQUKIAUjLAfkHoQYyomG4YSgCIHaovxvIoIMwg0AA2UCQPLoeEGZCd1WQr4s8Bwf7AZBGmEEwADMQJA9Sh+46JnSDuLk4sRqEbiBIHbqBTEgGyUENksVlEJqBslAD5VAMC/B2ItogbAaC9IPMYVy977QKPx/vPlIMQgYPXrxjuP309eOPnz47sVBiEMyFQCB7m4FhH8P952//UwOAzAEIMAAmWIjgzlgingAAAABJRU5ErkJggg==);top:-11px;left:50%}@media only screen and (min-width:381px){.hide-mobile-menu{display:none!important}}@media only screen and (min-width:910px){.hide-desktop{display:none!important}}@media only screen and (max-width:910px) and (min-width:481px){.hide-tablet-menu{display:none!important}}@media only screen and (max-width:1100px){.hide-middesktop{display:none!important}}@media only screen and (max-width:910px){.hide-tablet{display:none!important}}@media only screen and (max-width:481px){.hide-mobile{display:none!important}}@media only screen and (max-width:381px){.hide-smallmb{display:none!important}}',
        head = document.head || document.getElementsByTagName('head')[0],
        style = document.createElement('style');
    style.type = 'text/css';
    if (style.styleSheet) {
        style.styleSheet.cssText = css;
    } else {
        style.appendChild(document.createTextNode(css));
    }
    head.appendChild(style);
    var tool = document.createElement('div');
    tool.id = 'toolbar-rt-generated';
    tool.className = 'tr-gr-hidrr';
    tool.innerHTML = html;
    var parent = options.stressFirst ? document.getElementsByClassName('p-sideslide__inner')[0] : document.body;
    if(parent) {
        var childrens = parent.children;
        if (childrens && childrens.length) {
            parent.insertBefore(tool, childrens[0]);
        } else {
            parent.appendChild(tool);
        }
    }
    var more_links = document.getElementsByClassName('tr-gr-hidrr-wrap')[0];
    var parent_more_links = more_links.parentNode;
    parent_more_links.className = 'tr-gr-hidrr-item';
    parent_more_links.onmouseover = slide;
    parent_more_links.onmouseout = slide;

    function slide() {
        var ul = document.getElementsByClassName('tr-gr-hidrr-menu')[0];
        var disp = ul.style.display;
        if (disp == "block") {
            ul.style.display = "none";
        } else {
            ul.style.display = "block";
        }
    }

    if (options.stressFirst) {
        var listMenuItem = document.getElementsByClassName("tr-gr-hidrr-item ");
        listMenuItem[options.showLogo ? 1 : 0].className += ' always-active';
    }







    var logoItem = options.showLogo;
    var collectDomRtk = [];
    var menu_items = document.getElementById('toolbar-rt-generated').getElementsByClassName("tr-gr-hidrr-item");
    var slide_menu = document.getElementById('toolbar-rt-generated').getElementsByClassName("tr-gr-hidrr-menu");
    var logo = true;
    var need_show_menu_item = function() {
        var x = menu_items;
        var positionX = x[x.length - 1].getBoundingClientRect();
        var positionBar = document.getElementById("toolbar-rt-generated").getBoundingClientRect();
        if (+positionBar.right - (+positionX.right) > 171) {
            return true;
        }
        return false;
    };
    var show_menu_item_rtk = function() {
        if (!need_show_menu_item()) return false;
        if (collectDomRtk.length == 0) return false;
        var elem = menu_items;
        if ((elem.length - collectDomRtk.length) > 4 && logoItem) {
            logo = true;
        }
        var temp = collectDomRtk.pop();
        if (temp.style.display == "none") {
            temp.style.display = "";
            var show_small_menu = get_equals_element_menu(temp.getElementsByTagName('a')[0].title);
            if (show_small_menu != null) show_small_menu.style.display = "none";
            if ((elem.length - collectDomRtk.length) > 4 && logoItem) {
                logo = true;
            }
            return true;
        }
        return false;
    };
    var hideItemRtk = function() {
        var elem = menu_items;
        if (logo == true && logoItem && (elem.length - collectDomRtk.length) <= 4) {
            elem = elem[0];
            logo = false;
        } else {
            elem = elem[elem.length - collectDomRtk.length - 2];
        }
        var show_small_menu = get_equals_element_menu(elem.getElementsByTagName('a')[0].title);
        if (show_small_menu != null) show_small_menu.style.display = "block";
        collectDomRtk.push(elem);
        elem.style.display = "none";
    };
    var hide_barrier = function() {
        var elem = menu_items;
        var count_show = 0;
        for (var i = 0; i < elem.length; i++) {
            if (elem[i].style.display != "none") count_show += 1;
        }
        if (count_show < 4) return true;
        return false;
    };
    var changeRtkBox = function() {
        var x = menu_items;
        var positionX = x[x.length - 1].getBoundingClientRect();
        var positionBar = document.getElementById("toolbar-rt-generated").getBoundingClientRect();
        if (show_menu_item_rtk()) {
            while(show_menu_item_rtk());
            return true;
        }
        if (hide_barrier()) return false;
        if (+positionBar.right - (+positionX.right) < 11) {
            while(hideItemRtk());
            return true;
        }
        return false;
    };
    var initRtkToolbar = function() {
        collectDomRtk = [];
        for(var i = 2; i < menu_items.length - 1; i++) {
            menu_items[i].setAttribute('style', 'display: none;');
            collectDomRtk.push(menu_items[i]);
        }
        collectDomRtk.reverse();
        var mobile_menu_items = slide_menu[0].getElementsByTagName('li');
        for(var i = 0; i < mobile_menu_items.length; i++) {
            mobile_menu_items[i].setAttribute('style', 'display: block;');
        }
        while (changeRtkBox()) {}
    };
    var get_equals_element_menu = function(text) {
        for (var i = 0, b = slide_menu[0].getElementsByTagName("li"); i < b.length; i++) {
            var c = b[i];
            if (c.getElementsByTagName("a")[0].title == text) {
                return c;
            }
        }
        return null;
    };

    initRtkToolbar();

    window.addEventListener("resize", function(){
        while (changeRtkBox()) {};
    });

    if(!options.widthoutStat) {
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f  = d.getElementsByTagName(s)[0],
                j  = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src = '//www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-K484CH');


        // yaCounter

        (function (d, w, c) {
            var callback = function() {
                var links = document.getElementById('toolbar-rt-generated').getElementsByClassName('tr-gr-hidrr-link');
                for(var i in links) {
                    var link = links[i];
                    if(link.tagName != 'A') continue;
                    link.addEventListener('click', function(){
                        try {
                            new Ya.Metrika({
                                id: 30423872,
                                params: {
                                    host: window.location.host,
                                    link: this.href
                                }
                            });
                        } catch(e) { }
                    });
                }
            };

            if(window.Ya && Ya.Metrika) {
                callback();
            } else {
                (w[c] = w[c] || []).push(callback);
                var n = d.getElementsByTagName("script")[0],
                    s = d.createElement("script"),
                    f = function () { n.parentNode.insertBefore(s, n); };
                s.type = "text/javascript";
                s.async = true;
                s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

                if(document.readyState == "complete" || document.readyState == "loaded") {
                    f();
                } else {
                    if (w.opera == "[object Opera]") {
                        d.addEventListener("DOMContentLoaded", f, false);
                    } else { f(); }
                }
            }
        })(document, window, "yandex_metrika_callbacks");
    }
})();
