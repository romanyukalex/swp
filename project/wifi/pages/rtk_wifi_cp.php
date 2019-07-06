<? # В РТК это 

if($_REQUEST['ms']){$_SESSION['next_page']=$_REQUEST['ms'];}?>
<div class="units-box-row units-box-row_botborder-gray">
     <article class="unit-content-1">
     <img alt="" src="/project/wifi/templates/rtkwifi/files/lko_1000.jpg" class="content-img-1">
     
	<div class="content-block-2">
		<h1 class="content-head-30">Вход в интернет</h1>

		
					<!-- КНОПКИ -->
					<div id="next_page_button" <?if(!$_SESSION['wifi_logged_in']){?>style="display:none;"<?}?>>
						<br><br><br>
						<a target="_blank" href='<? 
							if($_SESSION['next_page']) {
								if(mb_substr($_SESSION['next_page'],0,4)=="http") echo $_SESSION['next_page'];
								else echo "//".$_SESSION['next_page'];
								unset($_SESSION['next_page']);
							}	else echo"//google.ru";?>'>
						<div class="modal-form__row modal-form__row_stand-last">
							<div class="modal-form__block modal-form__block_pos-l">
								<button id="cabinet-auth-continue" class="button-3 modal-form__btn modal-form__btn_width-full">
									<div class="spinner-circle-blue"></div>
									Продолжить
								</button>
							</div>
						</div>
						</a>
					
						<br><br><br>
						<a onClick="ajax_rq ('project_script','Access_stop','wifi_cp_ok_ap','wifi_cp_ok_ap'); return false;">
						<div class="modal-form__row modal-form__row_stand-last">
							<div class="modal-form__block modal-form__block_pos-l">
								<button id="logout_button" class="button-3 modal-form__btn modal-form__btn_width-full">
									<div class="spinner-circle-blue"></div>
									Закончить сессию
								</button>
							</div>
						</div>
						</a>
					
					
					
					
					</div>
		
		<!-- ФОРМА -->
		
		<p class="content-p-0 content-txt-14">
		<div id="wifi_cp_ok_ap"></div>
		<form id="login-form"<?if($_SESSION['wifi_logged_in']){?> style="display:none;"<?}?> onSubmit="saveform3('','login-form','wifi_cp_ok_ap','wifi_cp_ok_ap','project_script','access_grant','resetform','hideform');return false;">
			<div class="modal-form__row">
				<div class="modal-form__block modal-form__block_pos-l">
					<label class="modal-form__label" for="elkLogin">Логин</label>
					<input name="username" id="username" placeholder="79876543210" pattern="7[0-9]{10}" class="modal-form__input" style="background-color:#FFF"type="text">
				</div>
				<div class="modal-form__block modal-form__block_pos-l" style="float:none">
					<label class="modal-form__label" for="elkPasswd">Пароль</label>
					<div class="btn-group btn-group_width-full">
						<input  style="background-color:#FFF" class="modal-form__input modal-form__input_type-pass hideShowPassword-field hideShowPassword-hidden" type="password" name="password" id="password" required autocomplete="off">
					</div>
				</div>
			</div>
			<div class="modal-form__row modal-form__row_stand-last">
				<div class="modal-form__block modal-form__block_pos-l">
					
					<input type="submit" value="Войти" id="cabinet-auth-submit" class="button-3 modal-form__btn modal-form__btn_width-full">
				
				</div>
			</div>
		</form>
		<div id="wifi_cp_nok_ap"></div>
   </div>
</article>
</div>
<?/*
<!--div id="cabinet-login" class="modal-form mfp-hide">
<form method="POST" id="dynamic_form" action class="modal-form__form validate_form">
        <div class="modal-form-close"></div>
        <h1 class="modal-form__title">Авторизация</h1>

        <p id="authErr" class="modal-form__error-data" style="display: none"></p>

        <div class="modal-form__row">
            <div class="modal-form__block modal-form__block_pos-l">
                <label class="modal-form__label" for="elkLogin">Логин личного кабинета</label>
                <input name="X_Username" id="username" class="modal-form__input" type="text" tabindex="1">
            </div>
            <div class="modal-form__block modal-form__block_pos-r">
                <label class="modal-form__label" for="elkPasswd">Пароль</label>
                <div class="btn-group btn-group_width-full">
                    <input class="modal-form__input modal-form__input_type-pass hideShowPassword-field hideShowPassword-hidden" type="password" name="X_Password" id="password" required autocomplete="off" tabindex="2">
                </div>
            </div>
        </div>
        <div class="modal-form__row modal-form__row_stand-last">
            <div class="modal-form__block modal-form__block_pos-l">
                <button id="cabinet-auth-submit" class="button-3 modal-form__btn modal-form__btn_width-full filter-submit js-submit-auth" data-loader-txt="Подождите" tabindex="3">
                    <div class="spinner-circle-blue"></div>
                    Войти
                </button>
            </div>
        </div>
	
	
	
		<script>
//в массив будут писаться результаты GET запроса
var arrRes = new Array();

var center_name = 'CENTER';
var dal_name = 'DAL';
var nwest_name = 'NWEST';
var siberia_name = 'SIBERIA';
var south_name = 'SOUTH';
var ural_name = 'URAL';
var volga_name = 'VOLGA';
var mmt_name = 'MMT';

var center_url = "https://cabinet.rt.ru/RTCWWW_CENTER/LOGIN";
var dal_url = "https://cabinet.rt.ru/RTCWWW_DAL/LOGIN";
var nwest_url = "https://cabinet.rt.ru/RTCWWW_NWEST/LOGIN";
var siberia_url = "https://cabinet.rt.ru/RTCWWW_SIBERIA/LOGIN";
var south_url = "https://cabinet.rt.ru/RTCWWW_SOUTH/LOGIN";
var ural_url = "https://cabinet.rt.ru/RTCWWW_URAL/LOGIN";
var volga_url = "https://cabinet.rt.ru/RTCWWW_VOLGA/LOGIN";
var mmt_url = "https://cabinet.rt.ru/RTCWWW_MMT/LOGIN";

var brin_url = "/include/personal/get_brin.jsp";

var lst = new Array();

lst["1"] = Array(nwest_name, nwest_url);
lst["2"] = Array(ural_name, ural_url);
lst["3"] = Array(siberia_name, siberia_url);
lst["4"] = Array(dal_name, dal_url);
lst["5"] = Array(mmt_name, mmt_url);
lst["6"] = Array(center_name, center_url);
lst["7"] = Array(volga_name, volga_url);
lst["8"] = Array(south_name, south_url);

//ищем в тексте ответа BRIN_ID
function getBrinID(txt)
{
    var brin_id = 0;

    if (txt.indexOf("USER_BRIN_ID") >= 0) {
        brin_id = txt.substr(txt.indexOf("USER_BRIN_ID") + 13, 1);
    }
    else if (txt.indexOf("ERROR_ID") >= 0) {
        brin_id = -1;
    }
    return brin_id;
}

var getXMLHTTPRequest = (function ()
{
    var XMLHttpFactories = [
        function ()
        {
            return new ActiveXObject("Microsoft.XMLHTTP")
        },
        function ()
        {
            return new ActiveXObject("Msxml2.XMLHTTP")
        },
        function ()
        {
            return new ActiveXObject("Msxml3.XMLHTTP")
        },
        function ()
        {
            return new XMLHttpRequest()
        }
    ];

    var xmlhttp = null;
    for (var i = XMLHttpFactories.length - 1; i >= 0; i--) {
        try {
            xmlhttp = XMLHttpFactories[i]();
        }
        catch (e) {
            continue;
        }

        return XMLHttpFactories[i];
    }
})();


//точка входа
function check(event)
{
    $.ajax({url: '/include/personal/get_brin.jsp',
                type: 'post',
                dataType: 'text',
                async: true,
                cache: false,
                data: {
                    'USER_LOGIN': document.getElementById("username").value
                },
                success: function (data) {
                   var brin_id =  getBrinID(data);
				   if (brin_id && brin_id > 0){
					document.getElementById("dynamic_form").action = lst[brin_id][1];
					document.getElementById("dynamic_form").submit();
				   } else {
					alert("Не удалось получить филиал для заданного пользователя! Обратитесь в службу поддержки.");
					document.getElementById("dynamic_form").action = "";
				   }
                },
                error: function (e) { 
					alert("Неопознанная ошибка!");
                }});
				
	event.preventDefault();
	return false;
	
}

		$("#cabinet-auth-submit").click(function(event){check(event)});
                $(document).ready(function(){var button = $("a[href=#cabinet-login]"),
        modal_top_pos = false,
        auth = false;

    button.magnificPopup({
        preloader: true,
        type: 'inline',
        closeBtnInside: true,
        showCloseBtn: false,
        fixedContentPos: false,
        alignTop: false,
        callbacks: {
            beforeOpen: function () {
                this.bgOverlay.setMod('topshadow');
            },
            open: function () {
                            },
            close: function () {
                this.content.removeAttr('style');
                $(this.ev).off('click.mfphide');
            }
        }
    });

    $('.modal-form-close').on('click', function () {
        $.magnificPopup.close();
    });});


	</script>
	
</form>	
</div>

*/?>

        <div class="units-row units-content-row">
            <article class="units-box-row unit-content unit-content-3">
                <div class="content-block-1">
                    <h1 class="content-head-24">Правила</h1>
                   <ul class="content-list-default content-txt-12">
                    <li>Логин должен содержать 11&nbsp;цифр (соответствует номеру Вашего мобильного телефона в&nbsp;формате [Код страны - 7,Код оператора, Номер] без&nbsp;пробелов, например, 79161234567, или является произвольным набором цифр, сформированным автоматически при&nbsp;регистрации в&nbsp;системе).</li>
                    <li>Пароль должен содержать от&nbsp;4 до&nbsp;8&nbsp;цифр.</li>
                   </ul>
		</div>
            </article>

            <article class="units-box-row unit-content unit-content-3">
                <div class="content-block-1">
                    <h1 class="content-head-24">Если Вы забыли свой логин или пароль</h1>
                  <p class="content-p-0 content-p-0_last content-txt-12">Если Вы забыли свой логин или пароль, пожалуйста, обратитесь в&nbsp;один из&nbsp;<a href="http://moscow.rt.ru/b2b/contacts_b2b">Центров продаж и&nbsp;обслуживания</a> клиентов. Для&nbsp;повторного получения логина/пароля необходимо иметь при&nbsp;себе удостоверяющий личность документ (паспорт). За&nbsp;дополнительной информацией обращайтесь по&nbsp;единому номеру Информационно-справочной службы <nobr>8-800-100-81-88</nobr> (из&nbsp;любого региона России вызов бесплатный).</p>
		</div>
            </article>

            <!--article class="units-box-row unit-content unit-content-3">
                <div class="content-block-1">
                    <h1 class="content-head-24">Документы</h1>
                   <ul class="content-list-default content-txt-12">
                    <li>Правила использования системы<br>
<a class="link-doc-after inline" href="http://www.rt.ru/data/doc/lk_mn_mg_pravila.doc">Загрузить</a> <span class="color-gray normal f-11">~41&nbsp;КБ</span></li>
                    <li>Заявление на&nbsp;предоставление доступа для&nbsp;юридических лиц<br>
<a class="link-doc-after inline" href="http://www.rt.ru/data/doc/lk_mn_mg_jur.doc">Загрузить</a> <span class="color-gray normal f-11">~43&nbsp;КБ</span></li>
                   </ul>
		</div>
            </article-->
        </div>
    </div>