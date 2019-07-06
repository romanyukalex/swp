<? $log->LogInfo('Got '.(__FILE__));
if($nitka=="1"){
	if($userrole and $userrole!=="guest"){
		if($orderlistlength>0){
			while ($orderlist=mysql_fetch_array($orderlistreq)){?>
				<div class="b-other-projects b-text mb services_item">
				<div class="wrap">
				<h2>Заявка <?=$orderlist['order_group']?></h2>
				 <div class="b-text_2col">
				<table>

				<? if($userrole=="superuser"){?><tr><td width="200px">Заявитель</td><td width="30px"><b>:</b></td><td><?=$fullname?></td></tr><? }?>
				<tr><td>Тип заявки</td><td width="20px"><b>:</b></td><td>
					<?if($orderlist['order_type']=="modify_subscription_request"){?>Заявка на изменение параметров подписки<? }
					elseif($orderlist['order_type']=="subscription_request"){?>Подписка на вариант продукта<? }
					elseif($orderlist['order_type']=="company_creation_request"){?>Заявка на создание компании<? }
					elseif($orderlist['order_type']=="delete_subscription_request"){?>Заявка на удаление подписки<? }
					elseif($orderlist['order_type']=="halt_subscription_request"){?>Заявка на приостановление подписки<? }
					elseif($orderlist['order_type']=="simple_order"){?>Заказ инфопродуктов<? }
					else echo $orderlist['order_type'];
					?></td></tr>
				<? if($orderlist['product_variant_id']){?>
					<tr><td>Продукт</td><td><b>:</b></td><td title='<?=$productvar[$orderlist['product_variant_id']]['product_id']?>'><?=$productvar[$orderlist['product_variant_id']]['product_full_title_'.$language]?></td></tr>
					<tr><td>Вариант продукта</td><td><b>:</b></td><td title='<?=$orderlist[$orderlist['product_variant_id']]['product_variant_id']?>'><?=$productvar[$orderlist['product_variant_id']]['description_'.$language]?></td></tr>
				<? }
				if($orderlist['subscription_id']){?>
					<tr><td>Номер подписки</td><td><b>:</b></td><td title='<?=$orderlist['subscription_id']?>'><?=$orderlist['subscription_id']?></td></tr>
				<? }?>
				<tr><td>Дата</td><td><b>:</b></td><td><?=$orderlist['creations_ts']?></td></tr>
				<tr><td>Статус<div id="order_ap_<?=$orderlist['order_id']?>"></div></td><td><b>:</b></td><td><div id="order_status_<?=$orderlist['order_id']?>">
					<? if($orderlist['status']=="opened"){echo "В работе";}
					elseif($orderlist['status']=="droped"){echo "Сброшена";}
					elseif($orderlist['status']=="admin_suspended"){echo "Приостановлена администратором";}
					elseif($orderlist['status']=="resolved"){echo "Успешно отработана";}
					elseif($orderlist['status']=="inprogress"){echo "На исполнении";}
					elseif($orderlist['status']=="wait_user"){echo "Ожидание ответа пользователя";}
					?></div>
				</td></tr>
				<?
				if($orderlist['status']=="resolved" or $orderlist['status']=="inprogress"){?>
				<tr><td>Ссылка на инфопродукт</td><td><b>:</b></td><td><a target="_blank" class="justlink" href="<?=$productvar[$orderlist['product_variant_id']]['activation_string']?>"><?=$productvar[$orderlist['product_variant_id']]['activation_string']?></a></td></tr>
				<? }
				if($orderlist['order_text']){?>
					<tr><td>Текст заявки</td><td><b>:</b></td><td title='<?=substr($orderlist['order_text'],0,200)?>'>
					<? if(substr($orderlist['order_text'],-4)==".pdf" or substr($orderlist['order_text'],-4)==".doc" or substr($orderlist['order_text'],-5)==".docx"){ // Это ссылка на PDF или Word документ
						?><a href="<?=$orderlist['order_text']?>" target="_blank">Посмотреть текст</a><?
					} else echo	substr($orderlist['order_text'],0,200);?>
					</td></tr>
				<? }?>
				</table>
				</div></div></div><?
			}
		}else echo '<br><br>'.sitemessage("$modulename",'my_orders_are_not_found').'<br><br>';
		if ($userrole=="superuser"){
			if($orderlist_su_length>0){
				while ($orderlist=mysql_fetch_array($orderlist_su_req)){?>
					<div class="b-other-projects b-text mb">
					<div class="wrap">
					<h2>Заявка <?=$company_id."-".$orderlist['order_id']?></h2>
					 <div class="b-text_2col">
					<table>
					<tr><td>Заявитель</td><td width="30px"><b>:</b></td><td title="<?=$userinfo[$orderlist['user_id']]['userid']?>"><?=$userinfo[$orderlist['user_id']]['fullname']?></td></tr>
					<? if($orderlist['product_variant_id']){?>
						<tr><td>Продукт</td><td><b>:</b></td><td title='<?=$productvar['product_id']?>'><?=$productvar['product_full_title']?></td></tr>
						<tr><td>Вариант продукта</td><td><b>:</b></td><td title='<?=$orderlist['product_variant_id']?>'><?=$productvar['description_'.$language]?></td></tr>
					<? }?>
					<? if($orderlist['subscription_id']){?>
					<tr><td>Номер подписки</td><td><b>:</b></td><td title='<?=$orderlist['subscription_id']?>'><?=$orderlist['subscription_id']?></td></tr>
					<? }?>
					<tr><td>Дата создания</td><td><b>:</b></td><td><?=$orderlist['creations_ts']?></td></tr>
					<tr><td>Статус</td><td><b>:<div class="hidden"><?=$orderlist['status']?></div></b></td><td>
						<? if($orderlist['status']=="opened"){echo "В работе";}
						elseif($orderlist['status']=="droped"){echo "Сброшена";}
						elseif($orderlist['status']=="admin_suspended"){echo "Приостановлена администратором";}
						elseif($orderlist['status']=="resolved"){echo "Успешно отработана";}
						elseif($orderlist['status']=="inprogress"){echo "На исполнении";}
						elseif($orderlist['status']=="wait_user"){echo "Ожидание ответа пользователя";}?>
					</td></tr>
					<? if($orderlist['order_text']){?>
					<tr><td>Текст заявки</td><td><b>:</b></td><td title='<?=substr($orderlist['order_text'],0,200)?>'><?=substr($orderlist['order_text'],0,200)?></td></tr>
					<? }?>
					</table>
					<script>
					$(document).ready(function(){
						check_order_status('<?=$orderlist['order_id']?>');
					}
					</script>
					</div></div></div>
			<?	}
			} echo '<br><br>'.sitemessage("$modulename",'company_orders_are_not_found').'<br><br>';
		}
		if($order_list){?>
		<script>
			var auto_refresh = setInterval(
			function ()
			{
			check_order_status("<?=$order_list?>");
			}, 10000);
		</script><?
		}
	}else{?><script>
	$(document).ready(function(){changerazdel("login");});
		changerazdel("login");
	</script><?}
}?>

