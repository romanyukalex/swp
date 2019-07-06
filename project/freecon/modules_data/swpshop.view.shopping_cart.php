<? $log->LogInfo('Got '.(__FILE__));
if($nitka=="1"){
	if($userrole and $userrole!=="guest"){
		if($orderlistlength>0){
			?>
			
			<script>
			function renew_shoppingcart_summ(){
					
					//Обновляем сумму заказа на страничке в input
					module="swpshop";
					someaction="order_count_summ";
					ok_answerplace="shoppingcartItemCount_ap";
					nok_answerplace="swpshop_ap";
					some_id1="<?=$_SESSION['order_group']?>";
					

					$.ajax({
						dataType: 'json',
						type: 'POST',
						url: '/core/ajaxapi.php',
						data: 'action='+someaction+'&mod='+module+'&someid1='+some_id1+'&rand='+Math.random(),
						success: function(answer){
							//Пишем сообщение
							if(answer.status=='ok'){
								var summa=answer.message;
								$("#shoppingcartItemCount_ap").val(summa);//обновили сумму в input
								//var isTest=1;
								//var order_desc='Доступ к инфорпродуктам';
								//ajax_req("robokassa","show_that_button_ajax","pay_button_place",isTest,summa,<?=$_SESSION['order_group']?>,order_desc);
								
							}
							else {$("#"+nok_answerplace).html(answer.message);}
							
						}
						
					});
					
					
					//Обновляем сумму в форме Робокассы или Яндекс.Деньги
					
			}
			
			</script>
			
			<h2>Заявка <?=$_SESSION['order_group']?></h2>
				
				<table id="swpshop_order_table">
				<div id="swpshop_ap"></div>
				<tr><th>Продукт</th><th>Вариант</th><th>Стоимость</th><th>Действия</td></tr>
				<?
			while ($orderlist=mysql_fetch_array($orderlistreq)){?>
				
				<tr id="row<?=$orderlist['order_id'];?>">
					<td title='<?=$productvar[$orderlist['product_variant_id']]['product_id']?>'><?=$productvar[$orderlist['product_variant_id']]['product_full_title_'.$language]?></td>
					<td title='<?=$orderlist[$orderlist['product_variant_id']]['product_variant_id']?>'><?=$productvar[$orderlist['product_variant_id']]['description_'.$language]?></td>
					<td>
						<?=$productvar[$orderlist['product_variant_id']]['price']?>
					</td>
					<td>
						<a style="cursor:pointer" onclick="ajax_rq ('swpshop','del_from_order','swpshop_ap','swpshop_ap','<?=$orderlist['product_variant_id'];?>','<?=$_SESSION['order_group']?>','<?=$orderlist['order_id']?>')" title="Удалить из заказа"><img src="/files/simplicio/notification_error.png" width="20px"></a>
					</td>
				</tr>
				<?
			}
			?>
			</table>
			<br><br>
			
			
			
			<div class="b_form_content" style="background:#FFF">
					<form method="POST" action="https://money.yandex.ru/quickpay/confirm.xml">
					<ul>
					  <li>
                            <div class="field_name">Стоимость заказа</div>
                            <div class="field_option">
								<div id="shoppingcartItemCount_ap_hdn" style="visibility:hidden"></div>
                                <input readonly id="shoppingcartItemCount_ap" type="text" name="sum" placeholder="Стоимость заказа" name="1" maxlength="30" value="<?=$order_summ;?>">
                            </div>
                        </li>
					 
                        <li>
                            <div class="field_name">Приобретатель инфопродукта</div>
                            <div class="field_option">
                                <input type="text" placeholder="Иван" name="1" maxlength="30" value="<?=$fullname?>" readonly>
                            </div>
                        </li>
					
<?/* if(!$contactmail) {?>
			                       
					   <li>
                            <div class="field_name">E-mail для получения ссылок на просмотр/скачивание</div>
                            <div class="field_option">
                                <input type="text" placeholder="ivanov@ivan.ru" name="9" maxlength="40" data-validator="email" value="">
                            </div>
                        </li>
<? }*/?>
                        <li  id="pay_button_place">
							<?
							/*
							if($_SERVER['HTTP_HOST']=='psy-space.ru') $shop_id="Psy-space";
							else $shop_id='nlp-course.ru';
							
							$pay_detail_arr=array(
							'button_type'=>'with_label',
							'method'=>'POST',
							'order_id'=>$_SESSION['order_group'],
							'order_desc'=>'Доступ к инфорпродуктам',
							'summ'=>"$order_summ",
							'button_text'=>'Оплатить заявку',
							'button_form'=>'M', 
							'shop_id'=>$shop_id,
							'IsTest'=>'1' //0;1
							);
							insert_module('robokassa','get_pay_button',$pay_detail_arr);
							
							<a class="btn_yellow xlarge" style="background:#00c48a; color:white" href="/?page=robokassa_page&action=show_pay_page_by_order&order_desc=Доступ к инфопродуктам">Оплатить [Робокасса]</a>
							*/?>
							<div class="field_name">Оплатить</div>
							
							    
							<input type="hidden" name="receiver" value="410013101641394">    
							<input type="hidden" name="formcomment" value="Клуб здорового сознания">    
							<input type="hidden" name="short-dest" value="Клуб здорового сознания">   
							<input type="hidden" name="label" value="<?$order_id=$_SESSION['order_group'];echo $order_id;?>">    
							<input type="hidden" name="quickpay-form" value="donate">   
							<input type="hidden" name="targets" value="Транзакция <?=$order_id?>">   
							<!--input type="hidden" name="sum" value="<?=$order_summ?>" data-type="number"-->   
							<input type="hidden" name="need-fio" value="false">    
							<input type="hidden" name="need-email" value="true">    
							<input type="hidden" name="need-phone" value="true">    
							<input type="hidden" name="need-address" value="false"> 
							<input type="hidden" name="successURL" value="https://<?=$sitedomainname;?>/?page=yamoney_page&result=success">
							<label><input type="radio" name="paymentType" value="PC">Яндекс.Деньгами</label>   <br>
							<label><input type="radio" name="paymentType" value="AC">Банковской картой</label>  <br> 
							<input type="submit" class="btn_yellow xlarge"style="background:#00c48a; color:white" value="Перевести">
							
							
						</li>
                    </ul>
					</form>
					
          </div>
		  <br><br>
			<? 
			
			
		}else echo '<br><br>'.sitemessage("$modulename",'my_orders_are_not_found').'<br><br>';
		
	
	}else{?><script>
	$(document).ready(function(){changerazdel("login");});
		changerazdel("login");
	</script><?}
	

	#Оповестим админа о том, что зашли в корзину
	if(!$bot_name){
		insert_function("send_letter");
		$subject="Зашли в свою корзину";
		$message="Пользователь (ip ".$ip.' зашел на страничку '.$_SERVER['REQUEST_URI'];
		if($_SESSION['prev_page']) $message.=' со страницы '.$_SESSION['prev_page'];
		$message.='<br>Время - '.date("Y-m-d H:i:s").'<br>'.$_SERVER['HTTP_USER_AGENT'];
		sendletter_to_admin($subject,$message);
	}
}?>

