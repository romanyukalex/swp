(function(isTest){var stat={};stat.urls_list={"/homeinternet/order_internet/homeinternet_fast":{page:"homeinternetfast"},"/hometv/tariff":{page:"iptv"},"/homeinternet/order_internet/home":{page:"homeinternet"},"/packages/tariffs/triple":{page:"triple"},"/packages/tariffs/triple_optimal":{page:"triple_optimal"},"/packages/tariffs/tvin_fast":{page:"tvin_fast"},"/packages/tariffs/tvin":{page:"tvin"},"/homeinternet/tariff/line_city":{page:"line_city"},"/homeinternet/tariff/line_city_m":{page:"line_city_m"},"/homeinternet/tariff/line_city_l":{page:"line_city_l"},"/homeinternet/tariff/social":{page:"social"},"/homeinternet/tariff/line_city_xl":{page:"social"},"/homeinternet/tariff/gamer_plus":{page:"gamer_plus"},"/homeinternet/tariff/line_city_s":{page:"line_city_s"},"/homeinternet/tariff/constructor":{page:"constructor"},"/packages/tariffs/triple_optimal1":{page:"triple_optimal1"},"/packages/tariffs/triple_optimal2":{page:"triple_optimal2"},"/packages/tariffs/triple_optimal3":{page:"triple_optimal3"},"/packages/tariffs/triple_optimal4":{page:"triple_optimal4"},"/packages/tariffs/triple_optimal5":{page:"triple_optimal5"},"/packages/tariffs/triple_optimal6":{page:"triple_optimal6"},"/packages/tariffs/triple_optimal7":{page:"triple_optimal7"},"/packages/tariffs/triple_optimal8":{page:"triple_optimal8"},"/packages/tariffs/triple1":{page:"triple1"},"/packages/tariffs/triple2":{page:"triple2"},"/packages/tariffs/triple3":{page:"triple3"},"/packages/tariffs/triple4":{page:"triple4"},"/packages/tariffs/triple5":{page:"triple5"},"/packages/tariffs/triple6":{page:"triple6"},"/packages/tariffs/triple7":{page:"triple7"},"/packages/tariffs/triple8":{page:"triple8"},"/packages/tariffs/double_package":{page:"double_package"},"/homeinternet/order_internet/summerHolidays":{page:"easy_choice"},"/packages/tariffs/correct_price_1":{page:"correct_price_1"},"/packages/tariffs/correct_price_1_pon":{page:"correct_price_1_pon"},"/packages/tariffs/correct_price_2":{page:"correct_price_2"},"/packages/tariffs/correct_price_3":{page:"correct_price_3"},"/homeinternet/order_internet/strong":{page:"internet_strong"},"/packages/tariffs/strong":{page:"pkg_strong"},"/hometel/local":{page:"local"}};stat.stat_config={connect_panel:{"default":{gaq_page:"/connect_panel",ya:"connect_panel"}},connect_down:{"default":{gaq_page:"/connect_down",ya:"connect_down"}},change_region:{"default":{gaq_event:["change_region","change_region_region"]}},change_city:{"default":{gaq_event:["change_region","change_region_city"]}},gduzvonka:{"default":{gaq_event:["gdu","gduzvonka"],ya:"zhdu_zvonka"}},fast_order:{"default":{gaq_event:["fast_order","fast_order_click"],ya:"fast_order_click"}},multi_screen:{click:{gaq_event:["multi_screen","multi_screen_click"],ya:"multiscreen_click"}},about:{click:{gaq_event:["about","about_us"],ya:"about_us"}},press:{click:{gaq_event:["press","press_center"],ya:"press_center"}},corp:{click:{gaq_event:["corp","corp_site"],ya:"corp_site"}},contacts:{click:{gaq_event:["contacts","our_contacts"],ya:"our_contacts"}},offices:{click:{gaq_event:["offices","sales_offices"],ya:"sales_offices"}},service:{click:{gaq_event:["service","customer_service"],ya:"customer_service"}},vk:{click:{gaq_event:["vk","vk_click"],ya:"vk_click"}},facebook:{click:{gaq_event:["facebook","facebook_click"],ya:"facebook_click"}},twitter:{click:{gaq_event:["twitter","twitter_click"],ya:"twitter_click"}},viasat:{click:{gaq_event:["viasat","viasat_click"],ya:"viasat_click"}},correct_price:{click:{gaq_event:["correct_price","correct_price_click"],ya:"correct_price"}},feedback:{open:{gaq_page:"/feedback_form"},click:{gaq_page:"/feedback_click",ya:"feedback_click"},done:{gaq_page:"/feedback_done"}},zerosearch:{click:{gaq_page:"/zero_click",ya:"zero_click"},done:{gaq_page:"/zero_done",ya:"zero_done"}},makeSite:{open:{gaq_event:["make_site","site_click"]},click:{gaq_event:["make_site","make_site_click"]},click_plus:{gaq_event:["make_site","make_site_click_plus"]}},payment:{yandexmoney:{gaq_event:["payment","payment_yandexmoney"],ya:"payment_yandexmoney"},webmoney:{gaq_event:["payment","payment_webmoney"],ya:"payment_webmoney"},bank:{gaq_event:["payment","payment_bank"],ya:"payment_bank"}},b2b_packages:{view:{gaq_page:"/b2b/packages",ya:"b2b/packages"}},b2b_packages_tag_1:{select:{gaq_page:"/bazis_1",ya:"bazis_1"},order:{gaq_page:"/bazis_1_click",ya:"bazis_1_click"},done:{gaq_page:"/bazis_1_done"}},b2b_packages_tag_2:{select:{gaq_page:"/bazis_2",ya:"bazis_2"},order:{gaq_page:"/bazis_2_click",ya:"bazis_2_click"},done:{gaq_page:"/bazis_2_done"}},b2b_packages_tag_3:{select:{gaq_page:"/bazis_3",ya:"bazis_3"},order:{gaq_page:"/bazis_3_click",ya:"bazis_3_click"},done:{gaq_page:"/bazis_3_done"}},b2b_packages_individual:{select:{gaq_page:"/ndividual_offer_click"},order:{gaq_page:"/individual_offer_click",ya:"individual_offer_click"},done:{gaq_page:"/individual_offer_done"}},b2b_iptv:{small_view:{gaq_page:"/b2b/corp_iptv",ya:"b2b/corp_iptv"},big_view:{gaq_page:"/b2bcorp/corp_iptv",ya:"b2bcorp/corp_iptv"},small_select_restaurant:{gaq_page:"/restaurant",ya:"restaurant"},big_select_restaurant:{gaq_page:"/restaurant",ya:"restaurant"},small_order_restaurant:{gaq_page:"/restaurant_click",ya:"restaurant_click"},big_order_restaurant:{gaq_page:"/restaurant_click",ya:"restaurant_click"},small_done_restaurant:{gaq_page:"/restaurant_done"},big_done_restaurant:{gaq_page:"/restaurant_done"},small_select_office:{gaq_page:"/office",ya:"office"},big_select_office:{gaq_page:"/office",ya:"office"},small_order_office:{gaq_page:"/office_click",ya:"office_click"},big_order_office:{gaq_page:"/office_click",ya:"office_click"},small_done_office:{gaq_page:"/office_done"},big_done_office:{gaq_page:"/office_done"},small_select_hotel:{gaq_page:"/hotel",ya:"hotel"},big_select_hotel:{gaq_page:"/hotel",ya:"hotel"},small_order_hotel:{gaq_page:"/hotel_click",ya:"hotel_click"},big_order_hotel:{gaq_page:"/hotel_click",ya:"hotel_click"},small_done_hotel:{gaq_page:"/hotel_done"},big_done_hotel:{gaq_page:"/hotel_done"}},b2b_sip_devices:{click:{gaq_page:"/sip_devices_click",ya:"sip_devices_click"},done:{gaq_page:"/sip_devices_done"}},b2b_service:{small_order_view:{gaq_page:"/b2b/order_link",ya:"b2b/order_link"},big_order_view:{gaq_page:"/b2bcorp/order_link",ya:"b2bcorp/order_link"},small_order_request:{gaq_page:"/order_link_click",ya:"order_link_click"},small_order_done:{gaq_page:"/order_link_done"},big_order_request:{gaq_page:"/order_link_click",ya:"order_link_click"},big_order_done:{gaq_page:"/order_link_done"},small_number_b2b:{gaq_event:["number_b2b","order"],ya:"number_b2b"},big_number_b2b:{gaq_event:["number_b2bcorp","order"],ya:"number_b2bcorp"},gov_number_b2b:{gaq_event:["number_b2bgov","order"],ya:"number_b2bgov"},small_intednet_b2b:{gaq_event:["intednet_b2b","order"],ya:"intednet_b2b"},big_intednet_b2b:{gaq_event:["intednet_b2bcorp","order"],ya:"intednet_b2bcorp"},gov_intednet_b2b:{gaq_event:["intednet_b2bgov","order"],ya:"intednet_b2bgov"},small_videoconference_b2b:{gaq_event:["videoconference_b2b","order"],ya:"videoconference_b2b"},big_videoconference_b2b:{gaq_event:["videoconference_b2bcorp","order"],ya:"videoconference_b2bcorp"},gov_videoconference_b2b:{gaq_event:["videoconference_b2bgov","order"],ya:"videoconference_b2bgov"},small_videoconference_enter_b2b:{gaq_event:["videoconference_b2b","enter"]},big_videoconference_enter_b2b:{gaq_event:["videoconference_b2bcorp","enter"]},gov_videoconference_enter_b2b:{gaq_event:["videoconference_b2bgov","enter"]},big_audioconference_b2b:{gaq_event:["audioconference_b2bcorp","order"],ya:"audioconference_b2bcorp"},gov_audioconference_b2b:{gaq_event:["audioconference_b2bgov","order"],ya:"audioconference_b2bgov"},small_virtual_cod_b2b:{gaq_event:["virtual_cod_b2b","order"],ya:"virtual_cod_b2b"},big_virtual_cod_b2b:{gaq_event:["virtual_cod_b2bcorp","order"],ya:"virtual_cod_b2bcorp"},gov_virtual_cod_b2b:{gaq_event:["virtual_cod_b2bgov","order"],ya:"virtual_cod_b2bgov"},small_virtuall_office_b2b:{gaq_event:["virtuall_office_b2b","order"],ya:"virtuall_office_b2b"},big_virtuall_office_b2b:{gaq_event:["virtuall_office_b2bcorp","order"],ya:"virtuall_office_b2bcorp"},gov_virtuall_office_b2b:{gaq_event:["virtuall_office_b2bgov","order"],ya:"virtuall_office_b2bgov"},big_cdn_b2b:{gaq_event:["cdn_b2bcorp","order"],ya:"cdn_b2bcorp"},big_data_center_b2b:{gaq_event:["data_center_b2bcorp","order"],ya:"data_center_b2bcorp"},gov_data_center_b2b:{gaq_event:["data_center_b2bgov","order"],ya:"data_center_b2bgov"},big_reg_domen_b2b:{gaq_page:"/reg_domen_b2bcorp",ya:"reg_domen_b2bcorp"},big_rent_server_b2b:{gaq_event:["rent_server_b2bcorp","order"],ya:"rent_server_b2bcorp"},gov_rent_server_b2b:{gaq_event:["rent_server_b2bgov","order"],ya:"rent_server_b2bgov"},big_rentserver_b2b:{gaq_event:["rentserver_b2bcorp","send"]},gov_rentserver_b2b:{gaq_event:["rentserver_b2bgov","send"]},big_collocation_b2b:{gaq_event:["collocation_b2bcorp","order"],ya:"collocation_b2bcorp"},gov_collocation_b2b:{gaq_event:["collocation_b2bgov","order"],ya:"collocation_b2bgov"},big_web_hosting_b2b:{gaq_event:["web_hosting_b2bcorp","order"],ya:"web_hosting_b2bcorp"},gov_web_hosting_b2b:{gaq_event:["web_hosting_b2bgov","order"],ya:"web_hosting_b2bgov"},big_change_tarif_b2b:{gaq_page:"/change_tarif_b2bcorp",ya:"change_tarif_b2bcorp"},small_new_Telephony_b2b:{gaq_event:["new_Telephony_b2b","order"],ya:"new_Telephony_b2b"},big_new_Telephony_b2b:{gaq_event:["new_Telephony_b2bcorp","order"],ya:"new_Telephony_b2bcorp"},gov_new_Telephony_b2b:{gaq_event:["new_Telephony_b2bgov","order"],ya:"new_Telephony_b2bgov"},gov_ebook_b2b:{gaq_event:["ebook_b2b","order"],ya:"ebook_b2b"},small_collocation_form_b2b:{gaq_event:["collocation_form_b2b","send"]},big_collocation_form_b2b:{gaq_event:["collocation_form_b2bcorp","send"]},gov_collocation_form_b2b:{gaq_event:["collocation_form_b2bgov","send"]},big_webhosting_b2b:{gaq_event:["webhosting_b2bcorp","send"]},gov_webhosting_b2b:{gaq_event:["webhosting_b2bgov","send"]},small_vpn_b2b:{gaq_event:["vpn_b2b","order"],ya:"vpn_b2b"},big_vpn_b2b:{gaq_event:["vpn_b2bcorp","order"],ya:"vpn_b2bcorp"},gov_vpn_b2b:{gaq_event:["vpn_b2bgov","order"],ya:"vpn_b2bgov"}}};stat.setYaCounter=function(url){if(typeof window.yaCounterCommon!=="undefined"){window.yaCounterCommon.reachGoal(url);utils.log("yaCounterCommon reach goal: "+url)}if(window.yaCounterReg){window.yaCounterReg.reachGoal(url);utils.log("yaCounterReg reach goal: "+url)}};stat.gaqEvent=function(page,action){if(typeof _gaq!=="undefined"){_gaq.push(["_trackEvent",page,action]);utils.log("gaq track event, page "+page+", event: "+action)}if(utils.isFunction(window.ga)){ga("send","event",page,action);utils.log("ga track event, page "+page+", event: "+action)}};stat.piwikEvent=function(page,action){if(typeof _paq!=="undefined"){_paq.push(["trackEvent",page,action]);utils.log("piwik track event, page "+page+", event: "+action)}};stat.gaqPageView=function(page){if(typeof _gaq!=="undefined"){if(typeof page!=="undefined"){_gaq.push(["_trackPageview",page]);utils.log("gaq track page view, page "+page)}else{_gaq.push(["_trackPageview"]);utils.log("gaq track page view")}}if(utils.isFunction(window.ga)){if(page){ga("send","pageview",{page:page});utils.log("ga track page view, page "+page)}else{ga("send","pageview");utils.log("ga track page view")}}};stat.piwikPageView=function(page){if(typeof _paq!=="undefined"){if(typeof page!=="undefined"){_paq.push(["setCustomUrl",page]);_paq.push(["trackPageView",page]);utils.log("piwik track page view, page "+page)}else{_paq.push(["trackPageView"]);utils.log("piwik track page view")}}};stat.trackFormSentSuccessful=function(){if(typeof tat!=="undefined"&&ATInternet!=="undefined"){try{var tag=new ATInternet.Tracker.Tag();return tat.click.send({name:"request_form",chapter1:document.location.host,chapter2:"successful_submit",chapter3:"popup",level2:"",type:"action"})}catch(error){utils.error(error)}}};stat.gtmEvent=function(event){if(window.dataLayer&&utils.isFunction(dataLayer.push)&&!utils.isEmpty(event)){dataLayer.push({event:event});utils.log("gtm event "+event)}};stat.fixStat=function(statName,action){if(isTest){utils.log("try send gaq & ya stats with name: "+statName+" & action: "+action);return}try{if(!action){action="default"}var statItem=stat.stat_config[statName];if(!statItem){return}var item=statItem[action];if(!item){return}if(item.gaq_page){stat.gaqPageView(item.gaq_page);stat.piwikPageView(item.gaq_page)}if(item.gaq_event&&item.gaq_event.length>=2){stat.gaqEvent(item.gaq_event[0],item.gaq_event[1]);stat.piwikEvent(item.gaq_event[0],item.gaq_event[1])}if(item.ya){stat.setYaCounter(item.ya)}}catch(error){utils.log("ERROR: "+error)}};stat.b2bServiceFixStat=function(service){try{var prefix="";if(location.pathname.indexOf("b2b/")>=0){prefix="small"}else{if(location.pathname.indexOf("b2bcorp/")>=0){prefix="big"}else{if(location.pathname.indexOf("b2bgov/")>=0){prefix="gov"}}}this.fixStat("b2b_service",prefix+"_"+service)}catch(error){utils.log("ERROR: "+error)}};$("#connect_up").click(function(){stat.fixStat("connect_panel")});$(".p-section-title__item a.singlepagenav__button").click(function(){stat.fixStat("connect_down")});$("#about-us-link").click(function(){stat.fixStat("about","click")});$("#press-center-link").click(function(){stat.fixStat("press","click")});$("#corp-site-link").click(function(){stat.fixStat("corp","click")});$("#contacts-link").click(function(){stat.fixStat("offices","click")});$("#customer-service-link").click(function(){stat.fixStat("service","click")});$(".soc-link_fb").click(function(){stat.fixStat("facebook","click")});$(".soc-link_tw").click(function(){stat.fixStat("twitter","click")});stat.sendStat=function(syffix){if(isTest){return}var page=this.urls_list[window.location.pathname];if(window.location.pathname.indexOf("/"+adrMgr.selectedCity.synonym)>=0){page=this.urls_list[window.location.pathname.substr(adrMgr.selectedCity.synonym.length,window.location.pathname)]}if(page){stat.gaqPageView("/"+page.page+syffix);stat.piwikPageView("/"+page.page+syffix);stat.setYaCounter(page.page+syffix)}};stat.createOrderClick=function(){if(!this.urls_list[window.location.pathname]){this.sendStatUniversal("_click")}else{this.sendStat("_click")}};stat.createOrderDone=function(){if(!this.urls_list[window.location.pathname]){this.sendStatUniversal("_done")}else{this.sendStat("_done")}if(isTest){return}var goal="b2c_order";if(document.location.pathname.indexOf("/b2b")>-1){goal="b2b_order"}stat.gaqPageView("/"+goal);stat.piwikPageView("/"+goal);stat.setYaCounter(goal);utils.fireEvent(window,"atinternetFormSubmit");stat.gtmEvent(goal)};stat.basketClick=function(){if(!this.urls_list[window.location.pathname]){this.sendStatUniversal("_basket")}else{this.sendStat("_basket")}};stat.sendStatUniversal=function(suffix){var url=location.pathname.split("/");var goal=url[url.length-1];if(isTest){utils.log("try send gaq & ya stats with goal: "+goal+" & suffix: "+suffix);return}stat.gaqPageView("/"+goal+suffix);stat.piwikPageView("/"+goal+suffix);stat.setYaCounter(goal+suffix);if(suffix=="_done"){utils.fireEvent(window,"atinternetFormSubmit")}};stat.sendCustomStat=function(goal,suffix){if(isTest){utils.log("try send gaq & ya stats with goal: "+goal+" & suffix: "+suffix);return}else{if(utils.isEmpty(goal)){return}}goal=$.trim(goal);suffix=$.trim(suffix);stat.gaqPageView("/"+goal+suffix);stat.piwikPageView("/"+goal+suffix);stat.setYaCounter(goal+suffix);if(suffix=="_done"){utils.fireEvent(window,"atinternetFormSubmit");var goal="b2c_order";if(document.location.pathname.indexOf("/b2b")>-1){goal="b2b_order"}stat.sendCustomStat(goal);stat.gtmEvent(goal)}};function sendMouseUpStat(event,prefix){var goal=null;switch(event.which){case 2:goal=prefix+"mouse_middle";break;case 3:goal=prefix+"mouse_right";break;default:}if(isTest){utils.log("try send mouse up stats: "+goal);return}else{if(goal){try{stat.setYaCounter(goal);stat.gaqEvent(goal,"click")}catch(error){}}}}stat.bindMouseClick=function($elements,prefix){if(!prefix){var paths=window.location.pathname.split("/");prefix=paths[paths.length-1]}prefix=prefix+"_";$elements.unbind("mouseup.stat").bind("mouseup.stat",function(e){sendMouseUpStat(e,prefix)})};stat.sendMouseUp=function(e){var paths=window.location.pathname.split("/");var prefix=paths[paths.length-1]+"_";sendMouseUpStat(e,prefix)};stat.bindMouseClick($(".second-nav__ico_connect").parents("a").add($("a.mobile-menu_ico-callorder")),"fastorder");stat.bindMouseClick($(".js-send-connect-stat"));stat.set_sess_cookie=function(goal){try{if($.cookie("goal_"+goal)===undefined){if(isTest){utils.log("try send ya stats with goal: "+goal)}else{OrderAPI.prototype.setYaCounter(goal)}var date=new Date(new Date().getTime()+30*60*1000);document.cookie="goal_"+goal+"=is_set; domain=."+docContext.properties.shortUrl+"; path=/; expires="+date.toUTCString()}}catch(error){}};window.stat=stat})(window.isTest);