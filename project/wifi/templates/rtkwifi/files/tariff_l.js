(function(){var tariffsLoaded={totalCount:0,loadedCount:0,loadFailCount:0,loadPonTariff:false,loadDslTariff:false,sectionsList:[]};TariffList=function(options){this.options=(typeof options!=="undefined")?options:{};this.orderPriority={141:2,218:6,219:4,223:10,224:8,229:1};this.allPlans=[];this.choiceTariffId=0;this.klRegion="";this.mpzCode="";tariffsLoaded.totalCount++;this.tariffsLoaded=tariffsLoaded;this.init=function(){this.tariffsLoaded.sectionsList.push(this.el);var _this=this;if(typeof window.adrMgr!=="undefined"){this.selectedCity=window.adrMgr.selectedCity;this.mpzCode=window.adrMgr.getSelectedCode();this.klRegion=this.selectedCity.klRegion}this.tagId=(typeof this.options.tag!=="undefined")?parseInt(this.options.tag):0;this.showMode=(typeof this.options.mode!=="undefined")?this.options.mode:"partial";this.mpzCode=(typeof this.options.mpzCode!=="undefined")?this.options.mpzCode:this.mpzCode;this.klRegion=(typeof this.options.kl_region!=="undefined")?this.options.kl_region:this.klRegion;if(typeof app!=="undefined"&&typeof app.tariffSectionTpl==="undefined"){app.tariffSectionTpl=new TemplateClass("/tpls/tariff_section.hbs");app.tariffSectionTpl.load()}this.sectionTpl=app.tariffSectionTpl;if(this.tagId!=0){this.loadData();if(this.tagId==218){$("#link-to-archive").show()}}};this.loadData=function(){var _this=this;var pkg_summary="/pages/proxy.jsp?proxyType=agent&proxyMethod=GET&urlCode=pkg_summary&tag="+this.tagId+"&local_id="+this.mpzCode;$.ajax(pkg_summary,{dataType:"json"}).done(function(data){var $section=_this.el.parents(".p-section");$(".js-tariff-loader").hide();if(data==null||isEmpty(data)){_this.el.data("tariff-loaded",false);_this.tariffsLoaded.loadFailCount++;_this.el.remove()}else{if(adrMgr.selectedRegion.klRegion==50&&_this.tagId==289){_this.tagId=312;data["312"]=data["289"];delete data["289"]}_this.el.data("tariff-loaded",true);_this.tariffsLoaded.loadedCount++;if(_this.tagId==330){_this.tariffsLoaded.loadPonTariff=true}if(_this.tagId==329){_this.tariffsLoaded.loadDslTariff=true}}if(_this.tariffsLoaded.loadFailCount==_this.tariffsLoaded.totalCount){$(".js-tariff-loader").hide();var msgDiv=$("#tariffLoadFail");if(msgDiv.length&&$(".tariff-desc.units-row").length==0){msgDiv.show()}var addTariffsDiv=null;for(var sect in _this.tariffsLoaded.sectionsList){sect=_this.tariffsLoaded.sectionsList[sect];var prnt=sect.parent();if(prnt.hasClass("none-elem")){if(!addTariffsDiv){addTariffsDiv=prnt}}if(addTariffsDiv){addTariffsDiv.show();$(".js-showbox").hide()}}if($(".tariff-desc").size()==0){if(msgDiv.length>0){_this.el.parents(".p-section.p-section_bg-lightgray.p-section_bg-fadewhite").hide()}else{$section.hide()}}}else{if(_this.tariffsLoaded.loadFailCount+_this.tariffsLoaded.loadedCount==_this.tariffsLoaded.totalCount){var mainTariffLoaded=false;var addTariffsDiv=null;for(var sect in _this.tariffsLoaded.sectionsList){sect=_this.tariffsLoaded.sectionsList[sect];var prnt=sect.parent();if(prnt.hasClass("none-elem")){if(!addTariffsDiv){addTariffsDiv=prnt}}else{if(sect.data("tariff-loaded")){mainTariffLoaded=true}}}if(!mainTariffLoaded){addTariffsDiv.show();$(".js-showbox").hide()}$('[data-tag*="312"]').each(function(){if($(this).find(".tariff-desc").size()==0){$(this).hide()}});if(mrf.isVt(adrMgr.selectedRegion.klRegion)){if(_this.tariffsLoaded.loadDslTariff){$('.init-module[data-tag="330"]').remove()}}else{if(_this.tariffsLoaded.loadPonTariff){$('.init-module[data-tag="329"]').remove()}}$(".correct_price").first().show();for(var i=1;i<$(".correct_price").length;i++){$($(".correct_price")[i]).hide()}if($("#hidden-units-box").children().length==0){$("#hidden-units-box").prev().hide()}_this.alternativeInit()}}if(data==null||isEmpty(data)){}else{_.each(data,function(section,tag){section.tag=parseInt(tag);section.order=(typeof _this.orderPriority[section.tag]!=="undefined")?_this.orderPriority[section.tag]:99});if([289,312].indexOf(_this.tagId)>-1){if(adrMgr.selectedRegion.klRegion==50){_this.options.tag=312}var prefix="максимальный";if(_this.options.url.indexOf("optimal")>=0){prefix="оптимальный"}for(var i=0;i<data[_this.tagId].tariffs.length;i++){if(data[_this.tagId].tariffs[i].title.toLowerCase().indexOf(prefix)==-1){data[_this.tagId].tariffs.splice(i,1);i--}}}data=_.sortBy(data,function(section){return section.order});_.each(data,function(section){for(var t in section.tariffs){section.tariffs[t].feeWithIPTV=section.items[section.tariffs[t].id].fee;section.tariffs[t].feeAfterWithIPTV=section.items[section.tariffs[t].id].feeAfter;section.tariffs[t].channelsCount=section.items[section.tariffs[t].id].channelsCount;section.items[section.tariffs[t].id]}var data={title:section.title,type:section.type,spec_icon:section.spec_icon,tag_id:section.tag,action:section.action,is_load:false,load_ch:false,addr_code:_this.selectedCity.klCode,addr_level:_this.selectedCity.klLvl,reg_id:_this.selectedCity.klRegion,url:_this.options.url};var tp=new TariffPlan({id:"tariff-plan-"+section.tag,"class":"",tag_id:section.tag,tpl:_this.sectionTpl,data:data});_.each(section.tariffs,function(trf){trf.ver=2;trf.action=section.items[trf.id].isAction;trf.descrAction=section.items[trf.id].comment;if(utils.isEmpty(trf.descrAction)){trf.descrAction=trf.comment}trf.deviceComment=section.items[trf.id].deviceComment;trf.tariffComment=section.items[trf.id].tariffComment;if(!!section.items[trf.id].comment&&section.items[trf.id].comment.length>0){if(trf.tariffComment.length>0){trf.tariffComment=section.items[trf.id].comment}}trf.isShowTariffComment=true;for(var t in trf.tags){if($.inArray(trf.tags[t].id,[224,282])>-1){trf.isShowTariffComment=false;break}}tp.addTariff(trf)});_this.allPlans.push(tp)})}_this.el.find("h1 .loading").hide();if(_this.tagId==224){_this.el.find("h1").append('<span class="content-default-txt">Подключение по телефонной линии (технология ADSL).</span>')}if(_this.tagId==223){_this.el.find("h1").append('<span class="content-default-txt">Подключение по оптической линии (технология FTTx/xPON).</span>')}_this.el.find(".section-list").empty();_.each(_this.allPlans,function(plan){_this.el.find(".section-list").append(plan.render().el)});if(_this.tagId==286){var _html="";if(mrf.isSouth(adrMgr.selectedRegion.klRegion)){_html="Тариф действителен в течение 120 календарных дней с даты подключения."}else{_html="Тариф действителен в течение 4 календарных месяцев с даты подключения."}var synonym=(utils.isEmpty(adrMgr.selectedCity.synonym)?"":"/"+adrMgr.selectedCity.synonym);_html+='<br><br><a href="'+synonym+'/packages/tariffs/strong">Подключайте Пакет</a> Интернет+ТВ и сохраните скидку 50% на высокоскоростной Интернет навсегда!';$(".strongComment").html(_html)}_this.binds();_this.el.show();var $alternativeSelector=$(".js-alternative-group-selector").filter(function(){return $.inArray(_this.tagId,$(this).data("tags"))!=-1});if($alternativeSelector.size()==0){var $alternative=$(".js-alternatives").find(".js-alternative").filter(function(){return $.inArray(_this.tagId,$(this).data("tags"))!=-1});if($alternative.size()>0){$alternativeSelector=$alternative.closest(".js-alternative-group-selector")}}if($alternativeSelector.size()>0){$alternativeSelector.parent().find(".js-alternative-groups").filter(function(){return $.inArray(_this.tagId,$(this).data("tags"))!=-1}).append(_this.el.find(".section-list").data("tag",_this.tagId).hide());_this.el.remove()}}).fail(function(){if(!app.unloading){_this.tariffsLoaded.loadFailCount++;if(_this.tariffsLoaded.loadFailCount==_this.tariffsLoaded.totalCount){$(".js-tariff-loader").hide();var msgDiv=$("#tariffLoadFail");if(msgDiv.length&&$(".tariff-desc.units-row").length==0){msgDiv.show()}var addTariffsDiv=null;for(var sect in _this.tariffsLoaded.sectionsList){sect=_this.tariffsLoaded.sectionsList[sect];var prnt=sect.parent();if(prnt.hasClass("none-elem")){if(!addTariffsDiv){addTariffsDiv=prnt}}if(addTariffsDiv){addTariffsDiv.show();$(".js-showbox").hide()}}}else{if(_this.tariffsLoaded.loadFailCount+_this.tariffsLoaded.loadedCount==_this.tariffsLoaded.totalCount){var mainTariffLoaded=false;var addTariffsDiv=null;for(var sect in _this.tariffsLoaded.sectionsList){sect=_this.tariffsLoaded.sectionsList[sect];var prnt=sect.parent();if(prnt.hasClass("none-elem")){if(!addTariffsDiv){addTariffsDiv=prnt}}else{if(sect.data("tariff-loaded")){mainTariffLoaded=true}}}if(!mainTariffLoaded){addTariffsDiv.show();$(".js-showbox").hide()}}}_this.el.data("tariff-loaded",false);_this.el.hide().find(".section-list").html("Произошла ошибка при загрузке информации о тарифных планах")}})};this.binds=function(){$(".js-suggest-packet").on("click",function(e){e.preventDefault();e.stopPropagation();$(".confirm-popup").removeClass("is-visible").addClass("none-elem");var elm=$(e.currentTarget);var par=elm.parents(".tariff-desc__set-tariff");var box=par.find(".confirm-popup");box.removeClass("none-elem").addClass("is-visible");$(".confirm-popup.more-sale-popup.is-visible").hover(function(){$("body").unbind("click")},function(){$("body").click(function(){$(".confirm-popup.more-sale-popup.is-visible").removeClass("is-visible").addClass("none-elem")})})});stat.bindMouseClick($(".js-forward-to-form,.js-suggest-packet"));window.construct.reloadByName(["tariffByHash"],false);window.construct.reloadByName(["showPromoBlock"],false)};this.alternativeInit=function(){var $selectors=$(".js-alternative-group-selector");$selectors.each(function(){var $selector=$(this),$radios=$selector.find("input.js-alternative");function getLists(tags){var $lists=$selector.parent().find(".js-alternative-groups").find(".section-list");return tags?$lists.filter(function(){return $.inArray($(this).data("tag"),tags)!=-1}):$lists}$selector.find("input.js-open-alternatives").iCheck("uncheck").on("ifChanged",function(){$selector.find(".js-alternatives").toggle($(this).is(":checked"));$radios.iCheck("uncheck")});$radios.iCheck("uncheck").on("ifChanged",function(){var $current=$(this);if($current.data("force")){return}getLists().hide();if($current.is(":checked")){var $others=$radios.filter(":checked").not($current);$others.data("force",true).iCheck("uncheck").data("force",false);getLists($current.data("tags")).show()}else{getLists($selector.data("tags")).show()}});$selector.closest(".init-module").show();getLists($selector.data("tags")).show()});if($selectors.size()>0){actions.configChoise()}}}})();