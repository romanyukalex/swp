(function(){Videorent=function(){var _this=this;if(window.history.emulate){var params="",show=null;$.each($.getUrlVars(),function(idx,param){if(param!=="show"){params+=((!!params?"&":"?")+param+"="+$.getUrlVar(param))}else{if(!utils.isEmpty($.getUrlVar(param))){show=param+"="+$.getUrlVar(param)}}});if(show){window.location.href=window.location.pathname+(utils.isEmpty(params)?"":"?"+params)+("#"+window.location.pathname+"?"+show)}}this.init=function(){this.tpl=new TemplateClass("/tpls/movie_card.hbs");this.tplSerial=new TemplateClass("/tpls/serial_card.hbs");this.tplSeason=new TemplateClass("/tpls/season_card.hbs");this.tplSubscribe=new TemplateClass("/tpls/subscribe_card.hbs");this.tplFindMoviesResult=new TemplateClass("/tpls/find_movie_result.hbs");this.tpl.load();this.tplSerial.load();this.tplSeason.load();this.tplSubscribe.load();this.subscribeInfo=[{name:"Picture Box",id:60162,cost:180,image:"videoprokat-subscription-picturebox.jpg",content:"Если Вы любите голливудское кино, то Picture Box создан специально для Вас! Фильмы и сериалы от голливудской киностудии NBCUniversal представлены в одном разделе Вашего телевизора. Все – от классики кино до современных мультфильмов – для самых взыскательных зрителей! Нажмите «Подключить» всего 1 раз и устройте киномарафон уже сегодня!",contentLast:"",faq:[{q:"Где смотреть?",a:["После подключения Подписки для просмотра фильмов и сериалов пройдите в главное меню, найдите «Видеопрокат», далее «Подписки на видео», выберите из списка слева «Picture Box» и смотрите столько фильмов, сколько Вы хотите. Все уже оплачено!"]},{q:"Что смотреть?",a:["35 фильмов (еженедельно в каталоге обновляются 7 фильмов);","4 сериала (сезоны обновляются раз в 2-4 месяца)."]},{q:"Сколько стоит?",a:["Стоимость подписки – 180 рублей в месяц."]},{q:"Как отключить подписку?",a:["Вне зависимости от того, в какой день месяца будет подана заявка на отключение подписки, с Вашего лицевого счета будет списана стоимость за полный месяц пользования услугой (180 руб.). Услуга будет отключена в последний день месяца."]}]},{name:"Детский клуб",id:60161,cost:180,image:"videoprokat-subscription-kidsclub.jpg",content:"Чем порадовать ребенка? Конечно, добрыми и развивающими мультфильмами! Детский клуб – это подборка лучших мультфильмов и анимационных сериалов в одном разделе Вашего телевизора. «Свинка Пеппа», «Маша и Медведь», «Смешарики» уже ждут Вас! Нажмите «Подключить» прямо сейчас и смело оставляйте детей с их лучшими мульт-друзьями.",contentLast:"",faq:[{q:"Где смотреть?",a:["После подключения Подписки для просмотра мультфильмов пройдите в главное меню, найдите «Видеопрокат», далее ─ «Подписки на видео», выберите из списка слева «Детский клуб» и смотрите столько мультфильмов, сколько Вы хотите. Все уже оплачено!"]},{q:"Что смотреть?",a:["В подписке в любой момент доступно около 40 мультсериалов, а также полнометражные анимационные фильмы."]},{q:"Сколько это стоит?",a:["Стоимость подписки – 180 рублей в месяц."]},{q:"Как отключить подписку?",a:["Вне зависимости от того, в какой день месяца будет подана заявка на отключение подписки, с Вашего лицевого счета будет списана стоимость за полный месяц пользования услугой (180 руб.). Услуга будет отключена в последний день месяца."]}]},{name:"Волшебный мир Disney",id:23639655,cost:250,image:"videoprokat-subscription-disney.jpg",content:"Это предложение для истинных поклонников Disney! Коллекция анимационных и художественных фильмов от знаменитой студии в одном разделе Вашего телевизора. «Корпорация монстров», «Тачки», «В поисках Немо» и другие шедевры! Нажмите кнопку «Подключить» и смотрите мультики и фильмы целый месяц без остановки!",contentLast:"",faq:[{q:"Где смотреть?",a:["После подключения Подписки для просмотра фильмов и мультфильмов пройдите в главное меню, найдите «Видеопрокат», далее ─ «Подписки на видео», выберите из списка слева «Волшебный мир Disney» и смотрите столько мультиков и фильмов, сколько Вы хотите. Все уже оплачено!"]},{q:"Что смотреть?",a:["В подписку входит 60 фильмов, 6 из которых ежемесячно заменяются новыми. "]},{q:"Сколько стоит?",a:["Стоимость подписки – 250 рублей в месяц."]},{q:"Как отключить подписку?",a:["Вне зависимости от того, в какой день месяца будет подана заявка на отключение подписки, с Вашего лицевого счета будет списана стоимость за полный месяц пользования услугой (250 руб.). Услуга будет отключена в последний день месяца."]}]},{name:"AMEDIA Premium",id:23402486,cost:300,image:"videoprokat-subscription-amedia.jpg",content:"Устали скачивать сериалы? С подпиской AMEDIA Premium об этом можно забыть! Последние серии и сезоны лучших сериалов в одном разделе Вашего телевизора с шикарной озвучкой – «Игра престолов», «Карточный домик», «Страшные сказки» и многие другие! Нажмите «Подключить» всего 1 раз и смотрите первыми сериалы, о которых говорит весь мир.",contentLast:"",faq:[{q:"Где смотреть?",a:["После подключения Подписки для просмотра сериалов пройдите в главное меню, найдите «Видеопрокат», далее ─ «Подписки на видео», выберите из списка слева «Подписка AMEDIA Premium» и смотрите столько сериалов, сколько Вы хотите. Все уже оплачено!"]},{q:"Что смотреть?",a:["В подписке доступно не менее 50 сериалов разных жанров."]},{q:"Сколько стоит?",a:["Стоимость подписки – 300 рублей в месяц."]},{q:"Как отключить подписку?",a:["Вне зависимости от того, в какой день месяца будет подана заявка на отключение подписки, с Вашего лицевого счета будет списана стоимость за полный месяц пользования услугой (300 руб.). Услуга будет отключена в последний день месяца."]},{q:"Как получить бесплатный доступ к сайту и приложениям Amediateka?",a:["Зайдите на портал Amediateka.ru по адресу promo.amediateka.ru/rt и зарегистрируйтесь, указав логин своей приставки Интерактивного ТВ Ростелеком (Главное меню – Настройки – Системная информация) и регион проживания.","Доступ к Amediateka.ru будет продлеваться каждый день, пока подключена Подписка Amedia Premium в Интерактивном ТВ."]},]},{name:"TV1000PLAY",id:23546019,cost:0,image:"videoprokat-subscription-tv1000play.jpg",content:"Viasat Премиум HD – уникальное предложение, сочетающее в себе пакет телеканалов высокой четкости и возможность просмотра фильмов и передач в «Видеопрокате» Интерактивного ТВ и на любом мобильном устройстве с помощью сервиса TV1000Play. В пакет каналов Viasat Премиум HD входят фильмовые каналы TV1000 Premium HD, TV1000 Megahit HD, TV1000 Comedy HD, спортивные каналы Viasat Sport HD и Viasat Golf HD; познавательные Viasat Nature HD/Viasat History HD.\r\n",contentLast:"БОНУС для абонентов Viasat Премиум HD: возможность за 0 руб. смотреть более 100 фильмов с еженедельным обновлением в подписке TV1000Play в разделе Видеопрокат – Подписки на видео – TV1000Play, а также тысячи фильмов на сайте www.TV1000Play.ru после регистрации на сайте www.TV1000Play.ru/partner (следуйте инструкциям на кнопках со знаком «?»).",faq:[]},{name:"Женский мир",id:28554700,cost:150,image:"videoprokat-subscription-women_world.jpg",content:"Путь к сердцу мужчины лежит через желудок. А еще – через правильный макияж, красивую фигуру и багаж знаний! Советы, как лучше пройти этот путь, собраны в одном разделе Вашего телевизора в подписке «Женский мир»! Лучшие сюжеты о моде, красоте, воспитании детей, кулинарии, фитнесе и хобби от известных блогеров и звезд ТВ-экранов. Нажмите «Подключить» и начните путь к лучшей версии себя.",contentLast:"",faq:[{q:"Где смотреть?",a:["После подключения Подписки для просмотра роликов пройдите в главное меню, найдите «Видеопрокат», далее «Подписки на видео», выберите из списка слева «Женский мир» и смотрите столько роликов, сколько Вы хотите. Все уже оплачено!"]},{q:"Что смотреть?",a:["10 разделов, которые еженедельно пополняются новыми роликами! Спешите раскрыть все женские секреты."]},{q:"Сколько стоит?",a:["Стоимость подписки – 150 рублей в месяц."]},{q:"Как отключить подписку?",a:["Вне зависимости от того, в какой день месяца будет подана заявка на отключение подписки, с Вашего лицевого счета будет списана стоимость за полный месяц пользования услугой (150 руб.). Услуга будет отключена в последний день месяца."]}]},{name:"Сделано в России",id:32671652,cost:250,image:"videoprokat-subscription-made-in-russia.jpg",content:"Если Вы устали искать свой любимый фильм или сериал на ТВ-каналах, то Вам нужна подписка «Сделано в России». Советская классика, современные фильмы и известные сериалы, собранные в одном разделе на Вашем телевизоре.\r\nНажмите кнопку «Подключить» 1 раз и смотрите «Любовь и голуби», «Горько!», «Ликвидация» и другие киношедевры весь месяц без забот и дополнительных трат! ",contentLast:"",faq:[{q:"Где смотреть?",a:["После подключения Подписки для просмотра фильмов и сериалов пройдите в главное меню, найдите «Видеопрокат», далее ─ «Подписки на видео», выберите из списка слева «Сделано в России» и смотрите столько фильмов и сериалов, сколько Вы хотите. Все уже оплачено!"]},{q:"Что смотреть?",a:["В подписку входит более 50 фильмов, а также несколько десятков сериалов, которые регулярно обновляются."]},{q:"Сколько стоит?",a:["Стоимость подписки – 250 рублей в месяц."]},{q:"Как отключить подписку?",a:["Вне зависимости от того, в какой день месяца будет подана заявка на отключение подписки, с Вашего лицевого счета будет списана стоимость за полный месяц пользования услугой (250 руб.). Услуга будет отключена в последний день месяца."]}]}];if(typeof app!=="undefined"){app.videorent=this;if(window.subId!=null){$.each(_this.subscribeInfo,function(i,item){if(item.id==window.subId){$(".video-subscription").html(_this.tplSubscribe.render(item));$(".video-subscription").find(".v-tabs").accordion({oneOpenedItem:true,easing:false,scrollEasing:false,itemClass:"v-tabs__item",headClass:"v-tabs__head",contentClass:"v-tabs__content"});$(".video-subscription").show();if(utils.isEmpty(item.faq)){$(".v-tabs__item").hide()}else{$(".v-tabs__item").show()}return false}})}initMagnificPopup();var blurMovieTimeout=null;$("#findMovieInput").bind({input:function(){findMovieHandler(1000)},focus:function(){var $wrap=$(this).parent();clearTimeout(blurMovieTimeout);$wrap.removeClass("help-search_state").addClass("help-search_state-focus");if($("#findMoviesResults").size()==0){findMovieHandler(0)}else{$("#findMoviesResults").show()}},blur:function(){var $wrap=$(this).parent();clearTimeout(blurMovieTimeout);blurMovieTimeout=(function(){$wrap.removeClass("help-search_state-focus").addClass("help-search_state");$("#findMoviesResults").hide()},300)}});setTimeout(function(){$("#isHD, #is3D").unbind("ifChecked ifUnchecked").bind("ifChecked ifUnchecked",function(){onSubmit(this)})},800);if($.getUrlVar("show")!=null){var id=$.getUrlVar("show").split("_")[1];$("#byAnchor").data("movieid",id);switch($.getUrlVar("show").split("_")[0]){case"serial":$("#byAnchor").data("type","serial");$("#byAnchor").click();break;case"film":$("#byAnchor").click();break;default:break}}$("#btnSearch").click(function(){if($("#findMovieInput").val().length>=3){submitForm({findValue:$("#findMovieInput").val()})}})}};var findMovieTimeout=null;function findMovieHandler(timeout){var $this=$("#findMovieInput");var value=$.trim($this.val());var type=$this.data("type");$("#findMoviesResults").remove();clearTimeout(findMovieTimeout);if(value.length>=3){findMovieTimeout=setTimeout(function(){findMovieResult(type,value)},timeout)}}function findMovieResult(type,value){$.ajax({url:type=="serial"?"/ajax/video/FindSerials":"/ajax/video/FindMovies",type:"post",dataType:"json",data:{findValue:value,selectedType:window.selectedType},async:true,cache:false,success:function(resp){utils.log(resp);var $wrap=$("#findMovieInput").parent();$wrap.append(_this.tplFindMoviesResult.render(resp.result));initScroll($("#findMoviesResults"),10);$wrap.find(".help-search__item").click(function(){submitForm({findValue:$(this).data("name")})});$wrap.find(".help-search__item").on("mouseout",function(){$(this).removeClass("help-search__item_active")});$wrap.find(".help-search__item").on("mouseover",function(){$(this).addClass("help-search__item_active")});var movieIndex=-1;var movieCount=$("#findMoviesResults").find(".help-search__item").length;var changed=false;$("#findMovieInput").unbind("keydown.arrow-handler").bind("keydown.arrow-handler",function(e){var $helplist=$("#findMoviesResults").find(".help-search__list");if($helplist.size()>0){if(e.which==13){if(movieIndex>-1){$helplist.find("li").eq(movieIndex).trigger("mousedown").trigger("click")}else{submitForm({findValue:$(this).val()})}}if(movieCount>0){if(e.which==38){movieIndex=Math.max(movieIndex-1,0);changed=true}else{if(e.which==40){movieIndex=Math.min(movieIndex+1,movieCount-1);changed=true}}if(changed){checkScroll($helplist.find("li").removeClass("help-search__item_active").eq(movieIndex).addClass("help-search__item_active"),$helplist.parent(".help-search__listwrap"))}}}})}})}function checkScroll($current,$container){if($container.data("has-scroll")){var oldScrollTop=$container.find("ul").scrollTop(),newScrollTop=$current.offset().top-$container.offset().top+oldScrollTop;if(newScrollTop<oldScrollTop||(newScrollTop>oldScrollTop+$container.innerHeight()-$current.outerHeight(true))){$container.find("ul").scrollTop(newScrollTop)}}}function initScroll($list,limit){var $ul=$list.find("ul"),allHeight=0,maxHeight=0;$ul.find("li").each(function(i,li){var delta=$(li).outerHeight(true);allHeight+=delta;if(i<limit){maxHeight+=delta}});var cssMaxHeight=utils.toInt($ul.css("max-height"));if(cssMaxHeight&&maxHeight>cssMaxHeight){maxHeight=cssMaxHeight}if(allHeight>maxHeight){$list.data("has-scroll",true);$list.css({"max-height":maxHeight,overflow:"auto"})}else{$list.data("has-scroll",false);$list.css({"max-height":"auto"})}}function popupHandler(e){var $this=$(this);var data={};var func;if($this.data("type")==="serial"){func=showSerialPopup;data.movieId=$this.data("movieid");data.bundleNum=$this.data("bundlenum")}else{func=showMoviePopup;data.movieId=$this.data("movieid")}func(data)}function searchHandler(e){var $this=$(this);submitForm({selectedGenre:$this.data("selectedgenre"),country:$.trim($this.data("country")),year:$this.data("year"),yearEnd:$this.data("yearEnd")||$this.data("year"),findValue:$this.data("findValue")})}function submitForm(data){var $form=$("#films-rent-form");$form.find('[name="selectedType"]').val("-1");$form.find('[name="selectedGenre"]').val(data.selectedGenre||"0");$form.find('[name="country"]').val(data.country||"");$form.find('[name="year"]').val(data.year||"");$form.find('[name="yearEnd"]').val(data.yearEnd||"");$form.find('[name="findValue"]').val(data.findValue||"");$form.submit()}function showMoviePopup(data){$.ajax({url:"/ajax/video/GetMovie",type:"post",dataType:"json",data:data,async:true,cache:false,timeout:5000,success:function(resp){if(resp.isError){$("#videoprokat__popup").magnificPopup("close");utils.Error(resp.errorMsg,"Ошибка");return}$("#videoprokat__popup").find(".videoprokat-popup__bwrap.clearfix").html(_this.tpl.render(resp.result));if(!resp.result.cost&&resp.result.saleCost){$("#terms").hide()}else{$("#terms").show()}$("#videoprokat__popup").find(".videoprokat-popup__tabs").hide();$("#videoprokat__popup").find(".videoprokat-search").click(searchHandler);$(".button-watchtv").click(function(e){window.open("http://www.zabava.ru/films/"+resp.result.id,"_blank")});socialShare(resp.result.name,resp.result.description,"http://85.94.1.18:8098/images/hd/vod/normal/"+resp.result.logo);$(window).unbind("load.movable resize.movable");window.construct.reloadByName(["moveableUnits"],true);$(window).trigger("resize.movable");if($.getUrlVar("show")==null&&utils.isset(resp.result.id)){var overrideUrl=document.location.pathname+(!!document.location.search?(document.location.search+"&"):"?")+"show=film_"+resp.result.id;window.history.pushState(null,null,overrideUrl)}},error:function(){$("#videoprokat__popup").magnificPopup("close");utils.Error("Ошибка доступа к сервису","Ошибка")}})}function showSerialPopup(data){$.ajax({url:"/ajax/video/GetSerial",type:"post",dataType:"json",data:data,async:true,cache:false,success:function(resp){if(resp.isError){$("#videoprokat__popup").magnificPopup("close");utils.Error(resp.errorMsg,"Ошибка");return}$("#videoprokat__popup").find(".videoprokat-popup__bwrap.clearfix").html(_this.tplSerial.render(resp.result));if(resp.result.bundle&&!resp.result.bundle.cost&&resp.result.bundle.saleCost){$("#terms").hide()}else{$("#terms").show()}if(resp.result.bundle&&!utils.isEmpty(resp.result.bundle.movies)){$("#videoprokat__popup").find(".videoprokat-popup__tabs-head").children().first().html("Список серий: "+resp.result.bundle.number+" сезон ("+resp.result.bundle.movies.length+" серий)");$("#videoprokat__popup").find(".videoprokat-popup__minitabs").html(_this.tplSeason.render(resp.result)).find(".js-watch-link").toggle($.inArray($("#films-rent-form").find('[name="subscriptionId"]').val(),["28554700","23402486"])==-1&&resp.result.hasZabavaLink);$(".videoprokat-popup__tabs.st-open .videoprokat-popup__tabs-head").triggerHandler("click");$("#videoprokat__popup").find(".videoprokat-popup__minitab-head").eq(0).triggerHandler("click");$("#videoprokat__popup").find(".videoprokat-popup__tabs").show();$(".color-gray").each(function(){var str=$(this).text().replace("%season%",resp.result.bundle.number);$(this).text(str)})}else{$("#videoprokat__popup").find(".videoprokat-popup__tabs").hide()}$("#videoprokat__popup").find(".videoprokat-bundle-link").click(popupHandler);$("#videoprokat__popup").find(".videoprokat-search").click(searchHandler);$(".button-watchtv").click(function(e){window.open("http://www.zabava.ru/films/"+resp.result.id,"_blank")});socialShare(resp.result.name,resp.result.description,"http://85.94.1.18:8098/images/hd/vod/normal/"+resp.result.logo);$(window).unbind("load.movable resize.movable");window.construct.reloadByName(["moveableUnits"],true);$(window).trigger("resize.movable");if($.getUrlVar("show")==null){var overrideUrl=document.location.pathname+(!!document.location.search?(document.location.search+"&"):"?")+"show=serial_"+resp.result.id;window.history.pushState(null,null,overrideUrl)}},error:function(){$("#videoprokat__popup").magnificPopup("close");utils.Error("Ошибка доступа к сервису","Ошибка")}})}this.getMoreMovies=function(selectedType,subId,genre,country,year,yearEnd,movieCnt,isHD,is3D,findValue,group,ignoreSubscribe){$.ajax({url:"/ajax/video/GetMoreMovies",type:"post",dataType:"json",data:{selectedType:selectedType,subscriptionId:subId,genre:genre,country:country,year:year,yearEnd:yearEnd,movieCnt:movieCnt,isHD:isHD,is3D:is3D,findValue:findValue,group:group,ignoreSubscribe:ignoreSubscribe},async:true,cache:false,success:function(resp){if(resp.isLastPage){var $spoiler=$();if(utils.isset(group)){$spoiler=$(".btn-more-films-wrapper").has('.btn-more-films[data-group="'+group+'"]')}if($spoiler.size()==0){$spoiler=$(".btn-more-films-wrapper")}$spoiler.hide()}var _html="";for(var movie in resp.result){if(resp.result[movie].isMovie){_html+="<div class='tiles-view-adaptive__item tiles-view-adaptive__item_view-category videoprokat__link-to-popup' data-movieid='"+resp.result[movie].movie.id+"'>";_html+="<figure class='tiles-view-adaptive__poster'>";if(resp.result[movie].movie.logo=="notfound"){_html+="<span class='poster-wrap'><img class='tiles-view-adaptive__pic' src='/data/img/poster-no-poster.jpg' alt='"+resp.result[movie].movie.id+"'></span>"}else{_html+="<span class='poster-wrap'><img class='tiles-view-adaptive__pic' src='http://85.94.1.18:8098/images/hd/vod/normal/"+resp.result[movie].movie.logo+"' alt='"+resp.result[movie].movie.id+"'></span>"}_html+="<figcaption class='tiles-view-adaptive__name'><span class='film-name-wrap'>"+resp.result[movie].movie.name+"</span></figcaption>";_html+="</figure>";var cost=resp.result[movie].movie.cost,saleCost=resp.result[movie].movie.saleCost;if((!utils.isEmpty(cost)||!utils.isEmpty(saleCost))&&window.selectedType!==5&&!resp.result[movie].movie.inSubscription){_html+="<p class='tiles-view-adaptive__status'>";_html+=(utils.isEmpty(cost)?saleCost:cost)+" <span class='film-cost-unit'>Руб.</span>";_html+="</p><br>"}if(resp.result[movie].movie.inSubscription&&window.selectedType!==5){_html+="<p class='tiles-view-adaptive__status'>По подписке</p>";var packageId="";if(resp.result[movie].movie.packageID!=undefined&&resp.result[movie].movie.packageID!=""){packageId=resp.result[movie].movie.packageID}switch(packageId){case"60162":_html+="<a class='film-subscibtion-label' href='javascript:void(0)' title='Picture Box'><img src='/data/img/subscribtion-label-3.png' alt='Picture Box'></a>";break;case"60161":_html+="<a class='film-subscibtion-label' href='javascript:void(0)' title='Детский клуб'><img src='/data/img/subscribtion-label-1.png' alt='Детский клуб'></a>";break;case"23639655":_html+="<a class='film-subscibtion-label' href='javascript:void(0)' title='Волшебный мир Disney'><img src='/data/img/subscribtion-label-5.png' alt='Волшебный мир Disney'></a>";break;case"23402486":_html+="<a class='film-subscibtion-label' href='javascript:void(0)' title='AMEDIA Premium'><img src='/data/img/subscribtion-label-4.png' alt='AMEDIA Premium'></a>";break;case"23546019":_html+="<a class='film-subscibtion-label' href='javascript:void(0)' title='Подписка TV1000PLAY'><img src='/data/img/subscribtion-label-2.png' alt='Подписка TV1000PLAY'></a>";break;case"28554700":_html+="<a class='film-subscibtion-label' href='javascript:void(0)' title='Подписка «Женский мир»'><img src='/data/img/subscribtion-label-6.png' alt='Подписка «Женский мир»'></a>";break;case"32671652":_html+="<a class='film-subscibtion-label' href='javascript:void(0)' title='Подписка «Сделано в России»'><img src='/data/img/subscribtion-label-7.png' alt='Подписка «Сделано в России»'></a>";break}}_html+="</div>"}else{_html+="<div class='tiles-view-adaptive__item tiles-view-adaptive__item_view-category videoprokat__link-to-popup' data-movieid='"+resp.result[movie].series.id+"' data-type='serial'>";_html+="<figure class='tiles-view-adaptive__poster'>";if(resp.result[movie].series.logo=="notfound"){_html+="<span class='poster-wrap'><img class='tiles-view-adaptive__pic' src='/data/img/poster-no-poster.jpg' alt='"+resp.result[movie].series.id+"'></span>"}else{_html+="<span class='poster-wrap'><img class='tiles-view-adaptive__pic' src='http://85.94.1.18:8098/images/hd/vod/normal/"+resp.result[movie].series.logo+"' alt='"+resp.result[movie].series.id+"'></span>"}_html+="<figcaption class='tiles-view-adaptive__name'><span class='film-name-wrap'>"+resp.result[movie].series.name+"</span></figcaption>";_html+="</figure>";_html+="</div>"}}if(utils.isset(group)){var $spoiler=$(".btn-more-films-wrapper").has('.btn-more-films[data-group="'+group+'"]');if($spoiler.size()>0){$spoiler.prev().append(_html)}else{$(".tiles-view-adaptive_view-category").last().append(_html)}}else{$(".tiles-view-adaptive_view-category").append(_html)}initMagnificPopup(".tiles-view-adaptive_view-category")}})};this.getMoreSerials=function(genre,country,year,yearEnd,movieCnt,isHD,is3D,findValue){$.ajax({url:"/ajax/video/GetMoreSerials",type:"post",dataType:"json",data:{genre:genre,country:country,year:year,yearEnd:yearEnd,movieCnt:movieCnt,isHD:isHD,is3D:is3D,findValue:findValue},async:true,cache:false,success:function(resp){if(resp.isLastPage){$(".btn-more-films-wrapper").hide()}var _html="";for(var movie in resp.result){_html+="<div class='tiles-view-adaptive__item tiles-view-adaptive__item_view-category videoprokat__link-to-popup' data-movieid='"+resp.result[movie].id+"' data-type='serial'>";_html+="<figure class='tiles-view-adaptive__poster'>";if(resp.result[movie].logo=="notfound"){_html+="<span class='poster-wrap'><img class='tiles-view-adaptive__pic' src='/data/img/poster-no-poster.jpg' alt='"+resp.result[movie].id+"'></span>"}else{_html+="<span class='poster-wrap'><img class='tiles-view-adaptive__pic' src='http://85.94.1.18:8098/images/hd/vod/normal/"+resp.result[movie].logo+"' alt='"+resp.result[movie].id+"'></span>"}_html+="<figcaption class='tiles-view-adaptive__name'><span class='film-name-wrap'>"+resp.result[movie].name+"</span></figcaption>";_html+="</figure>";_html+="</div>"}$(".tiles-view-adaptive_view-category").append(_html);initMagnificPopup(".tiles-view-adaptive_view-category")}})};function initMagnificPopup(ctx){$(".videoprokat__link-to-popup",ctx||document).filter(function(){var $this=$(this);if($this.data("has-videoprokat-mfp")){return false}$this.data("has-videoprokat-mfp",true);return true}).magnificPopup({items:{src:"#videoprokat__popup",type:"inline"},closeBtnInside:false,showCloseBtn:false,callbacks:{close:function(){$("#videoprokat__popup").find(".videoprokat-popup__bwrap.clearfix").html("");$("#videoprokat__popup").find(".videoprokat-popup__tabs").hide();$("#videoprokat__popup").find(".videoprokat-popup__tabs-head").children().first().html("");$("#videoprokat__popup").find(".videoprokat-popup__minitabs").html("");if($("#videoprokat__popup").find(".videoprokat-popup__tabs").hasClass("st-open")){$("#videoprokat__popup").find(".videoprokat-popup__tabs-head").click()}var overrideUrl=document.location.pathname;var params="";$.each($.getUrlVars(),function(idx,param){if(param!=="show"){params+=((!!params?"&":"?")+param+"="+$.getUrlVar(param))}});window.history.pushState(null,null,overrideUrl+params)}}}).click(popupHandler)}function socialShare(text,desc,img){window.social.init(text,desc,img)}$(function(){var tiles_filters=$(".tiles-view-filters").eq(0);if(!tiles_filters.length){return false}var show_filters_btn=tiles_filters.elem("turn"),show_filters_btn_txt=["Спрятать фильтры","Показать фильтры"];show_filters_btn.on("click.videofilters",function(){if($(this).hasMod("active")){$(this).text(show_filters_btn_txt[0])}else{$(this).text(show_filters_btn_txt[1])}})})}})();