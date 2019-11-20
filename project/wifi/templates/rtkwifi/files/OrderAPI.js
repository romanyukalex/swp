(function(){function OrderAPI(tag,yaGaGoals){if(yaGaGoals){this.yaGaGoals=yaGaGoals}if(!window.statistic){window.statistic={goal:null}}if(!tag&&!(yaGaGoals||window.statistic.goal)){return}this.tag=tag;this.formName=null;this.clear();this.fixStat()}OrderAPI.prototype.clear=function(){this.address={};this.tabs=[];this.orderData={firstName:"",lastName:"",middleName:"",homePhone:"",cellPhone:"",dopInfo:"",email:"",notifyByEmail:0,notifyBySMS:0,callTimeFrom:"",callTimeTill:"",orderChannel:31,region:"",tabCount:0,params:{}};this.params={};if(window.traffic){for(var field in window.traffic){if(window.traffic[field]!==""){this.params[field]=window.traffic[field];this.orderData.params[field]=window.traffic[field]}}}var city=window.adrMgr.other||window.adrMgr.selectedCity;this.statData={user_id:window.docContext.userUuid,region:city.klRegion,city:city.name,order_type:0,referer:window.location.host+window.location.pathname,mpz_request:null,mpz_answer:null,mpz_order_num:null,step:"view",form_version:window.testFormVersion?window.testFormVersion:1,mpz_tag_id:this.tag?this.tag:0,form_url:location.pathname}};OrderAPI.prototype.SHPD=1;OrderAPI.prototype.IPTV=2;OrderAPI.prototype.PHONE=3;OrderAPI.prototype.SHPD_BASE_OPTION="base";OrderAPI.prototype.IPTV_BASE_OPTION="iptv_popular";OrderAPI.prototype.PHONE_BASE_OPTION="base_personal";OrderAPI.prototype.fixStat=function(){$.extend(this.statData,construct.prepare_utm());$.ajax({url:"/pages/proxy.jsp?proxyType=agent&proxyMethod=GET&urlCode=save_stat",data:this.statData,dataType:"json",type:"GET"}).done(function(data){utils.log(data)})};OrderAPI.prototype.addTab=function(svcClassId,tarPlan){var tab={svcClassId:svcClassId,options:[]};if(svcClassId===this.SHPD){tab.options.push(this.SHPD_BASE_OPTION)}if(svcClassId===this.IPTV){tab.options.push(this.IPTV_BASE_OPTION)}if(svcClassId===this.PHONE){tab.options.push(this.PHONE_BASE_OPTION)}if(tarPlan){tab.tarPlan=tarPlan}this.tabs.push(tab);this.orderData.tabCount++;return tab};OrderAPI.prototype.getTab=function(svcClassId){for(var tabIdx=0;tabIdx<this.tabs.length;tabIdx++){if(this.tabs[tabIdx].svcClassId===svcClassId){return this.tabs[tabIdx]}}return};OrderAPI.prototype.createOrder=function(){this.orderData.orderChannel=31};OrderAPI.prototype.resetTabForCallBack=function(){for(var i in this.tabs){var tab=this.tabs[i];delete tab.tarPlan;delete tab.options;delete tab.devices;tab.productState=17}};OrderAPI.prototype.createCallBack=function(){this.orderData.orderChannel=30;if(!this.orderData.params){this.orderData.params={}}this.orderData.params.callback_request=1};OrderAPI.prototype.setFio=function(fio){if(!fio){return}var mass_name=fio.split(" ");if(mass_name.length===1){this.orderData.firstName=mass_name[0];this.orderData.lastName="";this.orderData.middleName=""}else{if(mass_name.length===2){this.orderData.lastName=mass_name[0];this.orderData.firstName=mass_name[1];this.orderData.middleName=""}else{this.orderData.lastName=mass_name[0];this.orderData.firstName=mass_name[1];this.orderData.middleName=mass_name[2]}}};OrderAPI.prototype.setNames=function(firstName,lastName){if(!firstName||!lastName){return}this.orderData.firstName=firstName;this.orderData.middleName="";this.orderData.lastName=lastName};OrderAPI.prototype.setAddress=function(address){if(!address&&app.addr){address=app.addr.address_process()}if(address.region){this.orderData.region=address.region}this.address.city=address.city;this.address.cityId=address.cityId;this.address.street=address.street;this.address.streetId=address.streetId;this.address.house=address.house;this.address.houseId=address.houseId;this.address.flat=address.flat};OrderAPI.prototype.send=function(callback,addAttr,isNeedUtm,urlCode){var postData={};for(var field in this.orderData){postData[field]=this.orderData[field]}if(urlCode!="create_corp_ats_order"){postData={order:postData}}var $callTime=$("#cart-tiletime :selected");var hf=$callTime.val();var ht=$callTime.data("hour-max");if(hf){if(hf==-1){var hour=utils.getNowHour();if(hour<9||hour>=19){postData.order.callTimeFrom=9;postData.order.callTimeTill=10}else{postData.order.callTimeFrom=hour+1;postData.order.callTimeTill=hour+2}}else{postData.order.callTimeFrom=hf;postData.order.callTimeTill=ht}}postData.tabs=[];for(var i=0;i<this.tabs.length;i++){var tab={};for(var field in this.tabs[i]){tab[field]=this.tabs[i][field]}for(var field in this.address){tab[field]=this.address[field]}tab.params={};try{var form_url=location.pathname.split("/");tab.params.form_name=this.formName?this.formName:form_url[form_url.length-1]}catch(error){}tab.params.utm_stat_tag=this.tag?this.tag:0;for(var field in this.params){tab.params[field]=this.params[field]}tab.connChecks=app.addr.getConnChecks(tab.svcClassId);if(isNeedUtm){construct.utm_tag(tab)}postData.tabs.push(tab)}try{if(addAttr){for(field in addAttr){postData[field]=addAttr[field]}}}catch(error){}postData.proxyType="mpz";postData.urlCode="create_order";if(urlCode){postData.urlCode=urlCode}postData.proxyMethod="POST";var postCallback=callback;this.statData.step="request";this.fixStat();if(this.yaGaGoals){this.sendCustomStat(this.yaGaGoals.orderRequest)}else{if(window.statistic.goal){this.sendCustomStat(window.statistic.goal,"_click")}}var thus=this;$.ajax({url:"/pages/proxy.jsp",type:"post",data:postData,dataType:"json",async:true,cache:false}).done(function(data){if(data.result&&(data.result.packetId||data.result.orderId)){thus.statData.step="done";thus.statData.mpz_order_num=data.result.packetId||data.result.orderId;thus.fixStat();if(thus.yaGaGoals){thus.sendCustomStat(thus.yaGaGoals.orderDone)}else{if(window.statistic.goal){thus.sendCustomStat(window.statistic.goal,"_done")}}app.addr.resetConnChecks()}postCallback(data)}).fail(function(){utils.log("tech_poss")}).complete(function(){app.addr.check_reset()})};OrderAPI.prototype.setYaCounter=function(url){if(typeof window.yaCounterCommon!=="undefined"){window.yaCounterCommon.reachGoal(url);utils.log("yaCounterCommon reach goal: "+url)}if(window.yaCounterReg){window.yaCounterReg.reachGoal(url);utils.log("yaCounterReg reach goal: "+url)}};OrderAPI.prototype.gaqEvent=function(page,action){isGa=true;if(typeof _gaq!=="undefined"){_gaq.push(["_trackEvent",page,action]);utils.log("gaq track event, page "+page+", event: "+action)}else{isGa=false}if(utils.isFunction(window.ga)){ga("send","event",page,action);utils.log("ga track event, page "+page+", event: "+action)}else{isGa=false}if(!isGa){utils.log("try send ga track event, page: "+page+" & action: "+action)}};OrderAPI.prototype.piwikEvent=function(page,action){if(isTest){utils.log("piwik track event, page "+page+", event: "+action)}if(typeof _paq!=="undefined"){_paq.push(["trackEvent",page,action]);utils.log("piwik track event, page "+page+", event: "+action)}};OrderAPI.prototype.gaqPageView=function(page){if(typeof _gaq!=="undefined"){if(typeof page!=="undefined"){_gaq.push(["_trackPageview",page]);utils.log("gaq track page view, page "+page)}else{_gaq.push(["_trackPageview"]);utils.log("gaq track page view")}}if(utils.isFunction(window.ga)){if(page){ga("send","pageview",{page:page});utils.log("ga track page view, page "+page)}else{ga("send","pageview");utils.log("ga track page view")}}else{utils.log("try send ga track page view, page: "+page)}};OrderAPI.prototype.piwikPageView=function(page){if(typeof _paq!=="undefined"){if(typeof page!=="undefined"){_paq.push(["setCustomUrl",page]);_paq.push(["trackPageView",page]);utils.log("piwik track page view, page "+page)}else{_paq.push(["trackPageView"]);utils.log("piwik track page view")}}};OrderAPI.prototype.gtmEvent=function(event){if(window.dataLayer&&utils.isFunction(dataLayer.push)&&!utils.isEmpty(event)){dataLayer.push({event:event});utils.log("gtm event "+event)}};OrderAPI.prototype.sendStatUniversal=function(suffix){var goal=location.pathname.split("/");if(goal.length==0){return}goal=goal[goal.length-1];try{switch(goal){case"line_city_xl":goal="social";break}if(location.pathname=="/homeinternet/order_internet/strong"){goal="internet_strong"}if(location.pathname=="/packages/tariffs/strong"){goal="pkg_strong"}}catch(error){}OrderAPI.prototype.sendCustomStat(goal,suffix)};OrderAPI.prototype.sendYaStatsAndGagEvent=function(questuinTarget){var yaCounter=questuinTarget.yaCounter;var gaCategory=questuinTarget.gaCategory;var gaEvent=questuinTarget.gaEvent;if(utils.isEmpty(yaCounter)){utils.log("Goal undefined stats not send!!! CHECK");return}OrderAPI.prototype.gaqEvent(gaCategory,gaEvent);if(isTest){utils.log("piwik track page view, page "+yaCounter);utils.log("yaCounterCommon reach goal: "+yaCounter)}else{OrderAPI.prototype.piwikPageView("/"+yaCounter);OrderAPI.prototype.setYaCounter(yaCounter)}};OrderAPI.prototype.sendCustomStat=function(goal,suffix,isAdditional){if(utils.isEmpty(goal)){utils.log("Goal undefined stats not send!!! CHECK");return}suffix=suffix||"";if(isTest){utils.log("try send stats with goal: "+goal+suffix)}else{OrderAPI.prototype.gaqPageView("/"+goal+suffix);OrderAPI.prototype.piwikPageView("/"+goal+suffix);OrderAPI.prototype.setYaCounter(goal+suffix)}if(!isAdditional&&(suffix=="_done"||goal.indexOf("_done")>-1)){var goalCommon="b2c_order";if(document.location.pathname.indexOf("/b2b")>-1){goalCommon="b2b_order"}if(isTest){utils.log("try send stats with goal: "+goalCommon)}else{OrderAPI.prototype.gaqPageView("/"+goalCommon);OrderAPI.prototype.piwikPageView("/"+goalCommon);OrderAPI.prototype.setYaCounter(goalCommon);utils.fireEvent(window,"atinternetFormSubmit");OrderAPI.prototype.gtmEvent(goalCommon)}}};OrderAPI.bindCallTime=function(){var $callTime=$("#cart-tiletime");if($callTime){var hour=(new Date()).getHours();$callTime.find("option").each(function(){$(this).removeAttr("selected");if($(this).data("hour-max")<=hour){$(this).text("завтра "+$(this).text());$(this).appendTo($callTime)}});$callTime.find("option:first").attr("selected","selected")}$(".js-selectric2, .js-selectric0").selectric("refresh")};OrderAPI.prototype.getFIO=function(){return $.trim([this.orderData.lastName,this.orderData.firstName,this.orderData.middleName].join(" "))};OrderAPI.prototype.bindCallTime=OrderAPI.bindCallTime;window.OrderAPI=OrderAPI})();