<? //ms={ORIG_URI} - страничка, к которой обращались
if($_REQUEST['ms']){$_SESSION['next_page']=$_REQUEST['ms'];}
?>
<div class="units-box-row units-box-row_botborder-gray">
     <article class="unit-content-1">
     <img alt="" src="/project/wifi/templates/rtkwifi/files/lko_1000.jpg" class="content-img-1">
     
	<div class="content-block-2">
		<h1 class="content-head-30">Регистрация в системе WiFi</h1>
		<form id="wifi_reg_form" onSubmit="saveform3('','wifi_reg_form','reg_ap','reg_ap','project_script','register','resetform','');return false;">
		<p class="content-p-0 content-txt-14">
		Для того, чтобы воспользоваться доступом в интернет, Вам необходимо зарегистрироваться. Пожалуйста, введите номер телефона:
		<div class="modal-form__row">
			<div class="modal-form__block modal-form__block_pos-l">
				<label class="modal-form__label" for="elkLogin">Номер телефона</label>
				<input name="new_customer_phone" id="username" placeholder="79876543210" pattern="7[0-9]{10}" class="modal-form__input" style="background-color:#FFF"type="text">
			</div>
		</div>
		<div id="reg_ap"></div>
		<div class="modal-form__row modal-form__row_stand-last">
			<div class="modal-form__block modal-form__block_pos-l">
				<input type="submit" id="cabinet-auth-submit" class="button-3 modal-form__btn modal-form__btn_width-full filter-submit js-submit-auth" value="Зарегистрироваться">				
			</div>
		</div>
		</form>
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
	</div>
</div>