<? $log->LogInfo("Got ".(__FILE__)); 
 if($nitka=="1"){
	global $company_id,$userrole,$userrightsreq;
	if(isset($userrole) and $userrole!=="guest"){
		if($subscriptionslistlength>0){
			mysql_data_seek($subscriptionslistreq,0);
			while ($subscriptionslist=mysql_fetch_array($subscriptionslistreq)){?>
			<div class="b-other-projects b-text mb services_item">
				<div class="wrap">                 
				<h2>Подписка <?=$parproductid[$subscriptionslist['product_variant_id']]."-".$subscriptionslist['product_variant_id']."-".$company_id."-".$subscriptionslist['subscription_id']?></h2>
				<div class="b-text_2col">
			<table>
			<? if($subscriptionslist['product_variant_id']){?>

			<tr><td width="250px">Продукт</td><td width="30px"><b>:</b></td><td><?=$varproductfulltitle[$subscriptionslist['product_variant_id']]?></td></tr>
			<tr><td>Вариант продукта</td><td><b>:</b></td><td><?=$vardescription[$subscriptionslist['product_variant_id']]?></td></tr>
			<? }?>
			<tr><td>Дата создания</td><td><b>:</b></td><td><?=$subscriptionslist['creations_ts']?></td></tr>
			<!--tr><td>Статус</td><td><b>:</b></td><td><?=$subscriptionslist['status']?></td></tr-->
			<? if ($subscriptionslist['charging_aligment']){?><tr><td>Тарификация в начале месяца</td><td><b>:</b></td><td><? if ($subscriptionslist['charging_aligment']==1) echo "Да"; else echo "Нет";?></td></tr><? }

			if ($subscriptionslist['charging_period_days']){?><tr><td>Длительность тарификационного периода</td><td><b>:</b></td><td><?=$subscriptionslist['charging_period_days'];?> дн.</td></tr><? }

			if ($subscriptionslist['charging_period_months']){?><tr><td>Длительность тарификационного периода</td><td><b>:</b></td><td><?=$subscriptionslist['charging_period_months'];?> мес.</td></tr><? }

			if ($subscriptionslist['is_charging_prepaid']){?><tr><td>Подписка оплачивается</td><td><b>:</b></td><td><? if ($subscriptionslist['is_charging_prepaid']==1) echo "В начале"; else echo "В конце";?> месяца</td></tr><? }

			?><tr><td>Стоимость за период</td><td><b>:</b></td><td><?=$subscriptionslist['price']." ".$subscriptionslist['currency'];?> </td></tr>
			<? 
			if($subscriptionslist['script']){ # Пользовательский скрипт после подписки
				$log->LogInfo("Trying to include user script"); 
				include($_SERVER["DOCUMENT_ROOT"].$subscriptionslist['script']);
				}?>
			<tr><td colspan="3"><?
			//echo "Относится к продукту ".$parproductid[$subscriptionslist['product_variant_id']];
			
			if($userrole=="superuser"){$show_this_modi_link=1;}
			else{ # Посмотрим в правах юзера
				mysql_data_seek($userrightsreq,0);
				while ($userrights=mysql_fetch_array($userrightsreq)){
					//echo "<br>Сравниваем правило на ".$userrights['table']." продуктID=".$userrights['oid']." менаджед=".$$managedgroups[$userrights['group_id']];
					if (($userrights['table']=="$moduletableprefix-product-variants" and $userrights['oid']==$parproductid[$subscriptionslist['product_variant_id']] and $managedproductgroups[$userrights['group_id']]==1) 
					or 
					($userrights['table']=="$moduletableprefix-subscriptions" and $userrights['oid']==$subscriptionslist['subscription_id'] and $userrights['grant']=="1" and $managedsubscriptiongroups[$userrights['group_id']]==1)
					){ // К этому продукту доступ на manage дан
						$show_this_modi_link=1;
						break; //Хватит перебирать userright для этой подписки	
					}
				}
			}
			if($show_this_modi_link==1){?><ul><li>
					<a onclick="$('#modify_subscr<?=$subscriptionslist['subscription_id']?>_form_div').show();return false;">Изменить параметры подписки</a></li>
					<!--li><a onclick="$('#modify_subscr<?=$subscriptionslist['subscription_id']?>_form_div').show();return false;">Приостановить подписку</a></li-->
					</ul><?
			}?></td></tr>
			<tr id="modify_subscr<?=$subscriptionslist['subscription_id']?>_form_div" style="display:none"><td colspan="3">
				<div id="modify_subscr<?=$subscriptionslist['subscription_id']?>_form_message_place"></div>
				<form id="modify_subscr<?=$subscriptionslist['subscription_id']?>_form">
				<input name="subscription_id" value="<?=$subscriptionslist['subscription_id']?>" type="hidden">
				<textarea  size="3000" style="width:400px;height=100px" name="request_text" onblur="if (value == '') {value = 'Опишите изменение, в котором Вы заинтересованы'}" onfocus="if (value == 'Опишите изменение, в котором Вы заинтересованы') {value ='';}">Опишите изменение, в котором Вы заинтересованы</textarea>
				<br><input type="image" src="/project/tscloud/files/send.png" onclick="saveform('modify_subscription_request','modify_subscr<?=$subscriptionslist['subscription_id']?>_form','modify_subscr<?=$subscriptionslist['subscription_id']?>_form_message_place','$modulename'); return false;">
				</form>
				
			</td></tr>
			</table>
			</div></div></div>
			
			<? 
			}
			//insert_module("arcticmodal");
		}else {
			echo "<br><br>Подписки не найдены<br><br";	
		}
	} else{?><script>changerazdel("login");</script><?}
}//nitka?>


