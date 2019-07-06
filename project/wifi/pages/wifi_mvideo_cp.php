<? //ms={ORIG_URI} - страничка, к которой обращались
if($_REQUEST['ms']){$_SESSION['next_page']=$_REQUEST['ms'];}
?>

   
<br>
<h1>	Войти в интернет через сеть WiFi М.Видео
</h1>
<div class="content-frame-responsive login-content-frame">
	<div class="login-fields-block">
		
		<div data-init="switchLoginType" data-init-param=".login-returning-customer, .switch-login-type-link" class="login-returning-customer login-by-email-phone-state">
			<div data-init="validationHandler" data-init-param="#login-form" class="login-returning-customer-wrap login-by-email-phone">
				
				
				<h2>Вход в интернет</h2>
	
				<div id="wifi_cp_ok_ap"></div>
	
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
								Закончить сессию интернет
							</button>
						</div>
					</div>
					</a>
				
				<br><br><br>
					<a href="http://cp2.lan/?page=rtk_wifi_sc">
					<div class="modal-form__row modal-form__row_stand-last">
						<div class="modal-form__block modal-form__block_pos-l">
							<button id="logout_button" class="button-3 modal-form__btn modal-form__btn_width-full">
								<div class="spinner-circle-blue"></div>
								Войти в личный кабинет (сменить тариф)
							</button>
						</div>
					</div>
					</a>
				
				
				</div>
				
				<form id="login-form" onSubmit="saveform3('','login-form','wifi_cp_ok_ap','wifi_cp_ok_ap','project_script','access_grant','resetform','hideform');return false;" name="login-form"<?if($_SESSION['wifi_logged_in']){?>style="display:none;"<?}?>>	
					
					<div class="control-group" id="frm-email-group">
						
						<label for="frm-email" class="required-field control-label">Номер телефона</label>	

						<div class="input ">
							<input id="frm-email" data-msg-required="Укажите номер телефона" pattern="7[0-9]{10}" maxlength="15" placeholder="Телефон" name="username" type="text">
							
						</div>	
								<label for="frm-email" class="text-error"></label>	
						<div class="field-note body-text">Для авторизации введите номер телефона в формате: 7XXXXXXXXXX</div>
					</div>
					<div class="control-group">
						
						<label class="required-field control-label" for="frm-password">Пароль</label>	

						<div class="input ">
							<input id="frm-password" data-msg-required="Укажите пароль" maxlength="256" placeholder="Пароль*" name="password" value data-rule-required="true" type="password">
						</div>
						
						<div id="wifi_cp_nok_ap"></div>
						
						<label for="frm-password" class="text-error"></label>	</div>	
						<input name="loginEmailPhone" value="Войти" type="submit" class="btn btn-fluid">
						
					<!--p class="forgot-password-link">
						<a href="https://www.mvideo.ru/forgot-password">Восстановить пароль</a>	</p-->
				</form>
			</div>	
		</div>

		<div class="login-new-customer">
			<div class="login-new-customer-wrap">
				
				<h2>Регистрация</h2>
					<div class="login-new-customer-description">
					
					<!--p>Быстро, удобно, легко!</p>	<ul>	<li>Используйте введённые ранее данные</li>	<li>Отслеживайте статус заказа</li>	<li>Получайте персонализированные предложения</li>	<li>Накапливайте и тратьте бонусные рубли</li>	<li>Сохраняйте историю заказов</li>	</ul-->
					</div>	
					<div id="reg_ap"></div>
					<form id="wifi_reg_form" onSubmit="saveform3('','wifi_reg_form','reg_ap','reg_ap','project_script','register','resetform','');return false;">
					
						<div class="control-group" id="frm-email-group">
							
							<label for="frm-email" class="required-field control-label">Номер телефона</label>	

							<div class="input ">
								<input id="frm-email" data-msg-required="Укажите номер телефона" pattern="7[0-9]{10}" maxlength="15" placeholder="Телефон" name="new_customer_phone" type="text">
								
							</div>	
									<label for="frm-email" class="text-error"></label>	
							<div class="field-note body-text">Для регистрации введите номер телефона в формате: 7XXXXXXXXXX</div>
							
						</div>
					
					<input type="submit" value="Зарегистрироваться"class="btn btn-fluid" style="margin-top:9.6rem">
					</form>
					<? /*<a href="/" onclick="saveform3('','wifi_reg_form','reg_ap','reg_ap','project_script','register','resetform','');return false;" class="btn btn-fluid" style="margin-top:9.6rem">Зарегистрироваться</a>*/?>	
			
			</div>
		</div>
	</div>
</div>