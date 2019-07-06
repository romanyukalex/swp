<div id="form" class="div-form">
            <div class="container" id="form_container">
                <div class="div-form__title">
                    Регистрация<br><? $actions_data=insert_module("actions","get_actions_data_by_type","nlp-practitioner");
						$action_data=mysql_fetch_array($actions_data);
						echo $action_data['type_title_'.$language];// Название типа события
						
					?>
                </div>
                <div class="div-form__text"><? echo mb_strtolower(rus_date("j F Y",strtotime($next_act_date)));?></div>
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
                                            <div class="counter_price_form green">
                    <div class="priceTimer" id="new_order_form_ap1" style="color:white;padding-left:20px">
                        <p>Подайте заявку и мы напомним Вам о мероприятии за 1 неделю</p>
                    </div>
                </div>
                    <ul>
                        <!--li>
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
                        </li-->
                        <li>
                            <div class="field_name">Введите Ваше имя</div>
                            <div class="field_option">
                                <input type="text" placeholder="Иван" name="1" maxlength="30" value>
                            </div>
                        </li>
						<li>
                            <div class="field_name">Введите Фамилию</div>
                            <div class="field_option">
                                <input type="text" placeholder="Здоровый" name="10" maxlength="30" value>
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
                                                                                                           
                        <li class="sbm">
							<a class="btn_yellow xlarge"
							onclick="saveform2('egypt_order','request_form','new_order_form_ap','form_generator','add','resetform','');
							jQuery('#new_order_form_div').arcticmodal();
							return false;">Подать заявку</a>
						</li>
                    </ul>
            <div class="form-agreement">
    
            <label class="form-agreement__label">
               
                <input class="form-agreement__checkbox" type="checkbox" name="5" checked="checked" value="1">
                Нажимая на кнопку "Подать заявку", я даю согласие на обработку персональных данных и соглашаюсь c <a target="_blank" href="" onclick="return hs.htmlExpand(this, { contentId: 'popup_rules',minWidth: 500 } )">правилами клуба </a>
            </label>
        
                <input type="hidden" name="goads" value="<?=$_REQUEST['goads'];?>">
				<input type="hidden" name="yaads" value="<?=$_REQUEST['yaads'];?>">
				<input type="hidden" name="vk" value="<?=$_REQUEST['vk'];?>">
				<input type="hidden" name="action_id" value="<? echo insert_module("actions", "get_next_action_id","nlp-practitioner");?>">
        
        
    </div>        </div>
    </div>
   
    
    </form>



    




                </div>
        </div>