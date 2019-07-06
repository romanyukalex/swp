<? # В РТК это 

if($_REQUEST['ms']){$_SESSION['next_page']=$_REQUEST['ms'];}
if(!$_SESSION['wifi_logged_in']){?>
<div class="units-box-row units-box-row_botborder-gray">
     <article class="unit-content-1">
     <img alt="" src="/project/wifi/templates/rtkwifi/files/lko_1000.jpg" class="content-img-1">
     
	<div class="content-block-2">
		<h1 class="content-head-30">Личный кабинет</h1>

		<p class="content-p-0 content-txt-14">
		<div id="wifi_cp_ap"></div>
		<form id="wifi_cp_form" onSubmit="saveform3('','wifi_cp_form','wifi_cp_ap','wifi_cp_ap','project_script','check_login','resetform','hideform');return false;">
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
					<!--button onClick="submit();" id="cabinet-auth-submit" class="button-3 modal-form__btn modal-form__btn_width-full">
						
						<div class="spinner-circle-blue"></div>
						Войти
					</button-->
					<input type="submit" value="Войти" id="cabinet-auth-submit" class="button-3 modal-form__btn modal-form__btn_width-full">
				</div>
			</div>
		</form>
		<? //insert_module("loginform_simple");?>
		<!--div id="wifi_cp_ap"></div-->
   </div>
</article>
</div>
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
<? }
else {?>
<script>
		$(document).ready(function(){
			changerazdel('wifi_sc_main');});
		//changerazdel('wifi_sc_main');
		</script>

<?}
?>