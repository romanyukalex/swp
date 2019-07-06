<? $log->LogInfo('Got '.(__FILE__));
if($nitka=='1'){
	
	#Получаем подробности о существующей подписке, чтобы расставить галочки
	$subscr_q=mysql_query("SELECT * FROM `$tableprefix-newsletter-users` WHERE `user_id`='$userid';");
	
	if(mysql_num_rows($subscr_q)==1){
		$subscr_info=mysql_fetch_array($subscr_q);
		$subscr_arr=json_decode($subscr_info['themes'],true);
	}
	?>
<script>
	function clear_subscr_form(){
		jQuery('#request_form').trigger('reset');
	}
</script>
<div class="row">


<div class="col-md-6"> 
<div id="form" class="div-form" style="padding:0">
            <div class="container" id="form_container">
           
<form action="/" method="POST" class="direct" id="request_form" onsubmit="alert('Пожалуйста, дождитесь загрузки страницы и попробуйте нажать кнопку ещё раз'); return false;">
    <div class="post">
        <div class="b_form_content">
                    <ul>
                        <li>  <div class="field_name">Вы хотите получать письма со следующим содержанием</div>
						
							<div class="leftRadio" style="padding:15px 0 0 40px">
                                <input id="contenttype4" type="checkbox" name="contenttype[]" value="jokes"<?if($subscr_arr['jokes']){?>checked<?}?>>
                                <label for="contenttype4"style="font-size:16px;">Шутки о психологах, психиатрах и их пациентах</label>
                            </div>
							
							<div class="leftRadio" style="padding:0 0 0 40px">
                                <input id="contenttype1" type="checkbox" name="contenttype[]" value="articles"<?if($subscr_arr['articles']){?>checked<?}?>>
                                <label for="contenttype1" style="font-size:16px;">Статьи о психологии</label>
                            </div>
							<div class="rightRadio" style="padding:0 0 0 40px">
                                <input id="contenttype3" type="checkbox" name="contenttype[]" value="videos"<?if($subscr_arr['videos']){?>checked<?}?>>
                                <label for="contenttype3"style="font-size:16px;">Видеоролики</label>
                            </div>
							<div class="rightRadio" style="padding:0 0 0 40px">
                                <input id="contenttype2" type="checkbox" name="contenttype[]" value="books"<?if($subscr_arr['books']){?>checked<?}?>>
                                <label for="contenttype2"style="font-size:16px;">Книги</label>
                            </div>
							
							

                        </li>
						
                        <li>
                            <div class="field_name">Фильтровать контент по следующим ключевым словам (через пробел)</div>
                            <div class="field_option">
                                <input type="text" placeholder="Введите слова для отбора через пробел (например, 'НЛП Эриксон')" name="keywords_filter" maxlength="30" value="<?if($subscr_arr['filter_kw'])echo $subscr_arr['filter_kw'];?>">
                            </div>
                        </li>
						
						<li><hr></li>
						
                        <li>
                            <div class="field_name">Введите Ваш E-mail</div>
                            <div class="field_option">
                                <input type="text" placeholder="<? if($contactmail) echo $contactmail; else echo "ivanov@ivan.ru";?>" name="email" maxlength="40" data-validator="email" <? 
								if($subscr_info['mail']){?>value="<?=$subscr_info['mail']?>"<?}?>
                            </div>
                        </li>
                       
                         	  		  
						
                        <li class="sbm">
							<a class="btn_yellow xlarge"
							onclick="saveform3('','request_form','new_order_form_div_ap','new_order_form_div_ap','project_script','update_subsctipt');return false;"><?
							if(!$subscr_info['mail']){?>Подписаться на рассылку<?} else {?>Обновить параметры подписки<?}?></a>
							
							<a class="btn_red xlarge" style="color:#FFF"
							onclick="saveform3('','request_form','new_order_form_div_ap','new_order_form_div_ap','project_script','delete_subsctipt');return false;">Отписаться от рассылки</a>
						</li>
                    </ul>
					
          </div>
    </div>
   
    
    </form>


</div>

</div>

</div>

</div>
<div class="modal fade" id="new_order_form_div" tabindex="-1" role="dialog" aria-labelledby="new_order_form_div" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Заявка на подписку обработана</h4></span>
      </div>
      <div class="modal-body">
	  <div id="new_order_form_div_ap"></div>
	  
      </div>
    </div>
  </div>
</div>
<? }?>