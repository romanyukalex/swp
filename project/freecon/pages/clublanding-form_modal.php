<div class="div-form" style="padding:0;">
            <div class="container" id="form_container" style="padding:0;">
                <div class="div-form__title">
                    Регистрация в клуб НЛП
                </div>
                <!--div class="div-form__text">Старт ближайшего потока - 27 июня</div-->
              <script>
    $("a[href='#form']").click(function(){
        if ($('#request_form').data('hasrequest')) {
            $('#request_form').submit();
        }
    });
</script>
<form action="/" method="POST" class="direct" id="request_form" onsubmit="alert('Пожалуйста, дождитесь загрузки страницы и попробуйте нажать кнопку ещё раз'); return false;">
    <div class="post">
        <div class="b_form_content">
                    <ul>
                        <li stle="margin-bottom:0;">
							<div class="leftRadio">
                                
                                <input id="10ticket" type="radio" name="price" value="7999">
                                <label for="10ticket">10 занятий - 7 999 р  (1 занятие - 799 р)</label>
                            </div>
							<div class="rightRadio">
                                <input id="5ticket" type="radio" name="price" value="4250">
                                <label for="5ticket">5 занятий - 4 250 р (1 занятие - 850 р)</label>
                            </div>
                            <div class="rightRadio">
							<input id="1ticket" type="radio" name="price" value="999" checked="checked">
                                <label for="1ticket">1 занятие - 999 р</label>
                            </div>
                                                                    </li>
                                                                            <li>
                            <div class="field_name">Введите Ваше имя</div>
                            <div class="field_option">
                                <input type="text" placeholder="Иван" name="1" maxlength="30" value>
                            </div>
                        </li>
                                                                                    <li>
                            <div class="field_name">Введите Ваш E-mail</div>
                            <div class="field_option">
                                <input type="text" placeholder="ivanov@ivan.ru" name="9" maxlength="40" data-validator="email" value>
                            </div>
                        </li>
                                                                <li class="phone">
                            <div class="field_name">Введите Ваш телефон</div>
                            <div class="field_option clear">
                                <input type="text" class="pre" placeholder="+7" name="4" maxlength="5" data-validator="phone_code" value="+7">
                                <input type="text" class="code" placeholder="123" name="7" maxlength="5" data-validator="phone" value>
                                <input type="text" class="num" placeholder="4567890" name="8" maxlength="7" data-validator="phone" value>
                            </div>
                        </li>
                     
            <div class="form-agreement">
    
            <label class="form-agreement__label">
               
                <input class="form-agreement__checkbox" type="checkbox" name="5" checked="checked" value="1">
                Нажимая на кнопку "Подать заявку", я даю согласие на обработку персональных данных и соглашаюсь c <a target="_blank" href="" onclick="return hs.htmlExpand(this, { contentId: 'popup_rules',minWidth: 500 } )">правилами клуба </a>
            </label>
        
                <input type="hidden" name="goads" value="<?=$_REQUEST['goads'];?>">
				<input type="hidden" name="yaads" value="<?=$_REQUEST['yaads'];?>">
        
        
			</div>     

					 
                        <li class="sbm">
							<button type="submit" class="btn_yellow xlarge" onclick="saveform2('egypt_order','request_form','new_order_form_ap','form_generator','add','resetform','');
							<?//return hs.htmlExpand(this, { contentId: 'new_order_form_ap' } );?>							
							$('#new_order_form_div').arcticmodal();
							return false;">Подать заявку</button>
						</li>
                    </ul>
   
		</div>
    </div>
   
    
    </form>



    




                </div>
        </div>