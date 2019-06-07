<?php
 /****************************************************************
  * Snippet Name : module template (ajax part) 					 * 
  * Scripted By  : RomanyukAlex		           					 * 
  * Website      : http://popwebstudio.ru	   					 * 
  * Email        : admin@popwebstudio.ru     					 * 
  * License      : GPL (General Public License)					 * 
  * Purpose 	 : some ajax functions							 *
  * Access		 : include									 	 *
  
  
  
  ВСЕ ПЕРЕНЕСЕНО В КОНТРОЛЛЕР
  
  
  
  
  
  ***************************************************************/

$log->LogInfo("Got ".basename (__FILE__));
if($nitka=="1"){
	insert_function("process_user_data");
	include($_SERVER["DOCUMENT_ROOT"]."/core/checkuserrole.php"); // Определяем userrole и получаем права
	if (process_data($_REQUEST['action'],10)=="to_order"){ // Добавляют вариант в корзину
		$order_type="subscription_request";
		if($_REQUEST['variantid']){
			$needvariant=process_data($_REQUEST['variantid'],6);// Отрезали лишее
			$log->LogDebug("Choosen variant is ".$needvariant);
			
			# Доступен ли вариант юзеру?
			$varrightgiven=0;//Флаг успешного заказа
			# Среди выделенных для него
			while ($userrights=mysql_fetch_array($userrightsreq)){
				if ($userrights['table']=="$moduletableprefix-product-variants" and $userrights['oid']==$needvariant) {
					# Этот вариант доступен
					$varrightgiven=1;
				}
			}
			
			# Среди is_public=1 и is_custom
			$other_vars_req=mysql_query("SELECT * FROM `$companiesprefix-product-variants` WHERE `variant_id`='$needvariant' and (`is_public`=1 or `is_custom`=0);");
			if(mysql_num_rows($other_vars_req)>0){$varrightgiven=1;}
			
			
			if($varrightgiven==0){# Среди доступных вариантов нет запрашиваемого
				$order_message = $sitemessage["$modulename"]["variant_isnt_found"];
				$order_status="nok";
				$log->LogError("Choosen variant is not found in available lists");
			} elseif($varrightgiven==1){# Права на вариант есть
				#Получаем детали варианта
				$varianddetail=mysql_fetch_array(mysql_query("select * from `$moduletableprefix-product-variants`
				where `variant_id`='$needvariant'"));
				
				if(!$varianddetail[charging_aligment]) $varianddetail[charging_aligment]="NULL";
				if(!$varianddetail[charging_period_days])$varianddetail[charging_period_days]="NULL";
				if(!$varianddetail[charging_period_months])$varianddetail[charging_period_months]="NULL";
				if(!$varianddetail[is_charging_prepaid])$varianddetail[is_charging_prepaid]="NULL";
				
				#Генерируем order_group
				if(!$_SESSION['order_group']) { 
					insert_function("abracadabra");
					$hhuh=1;
					$order_group=abracadabra(8,'digits');
					while($hhuh==1){
						
						
						#Проверяем, нет ли такого номера заказали
						$check_ord_group=mysql_fetch_assoc(mysql_query("SELECT count(*) as ORDCNT FROM `$moduletableprefix-orders` WHERE `order_group`='$order_group' and `status`!='resolved' and `creations_ts` BETWEEN '".date("Y-m-d")." 00:00:00' AND '".date("Y-m-d")." 23:59:59';"));
						
						if($check_ord_group['ORDCNT']>0) {#Номер уже занят
							$order_group=abracadabra(8,'digits'); //Генерируем новый номер заказа
						} else {#Номер свободен, оставляем его как номер заказа
							$_SESSION['order_group']=$order_group;
							$hhuh=2;// Выходим из цикла
						}
					}
				} else $order_group=$_SESSION['order_group'];
				
				
				$inserttoorder=mysql_query("INSERT INTO `$tableprefix-orders` (	`order_group`,`order_type`,`client_id`,`user_id` ,`product_variant_id`,`status`,`creations_ts` ,`last_status_change_ts`,`chat_id` )
					VALUES ( '$order_group','$order_type', '$company_id', '$userid', '$needvariant', 'opened', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP , NULL 	);");
				
				$order_id=mysql_insert_id();
				
				if($inserttoorder==1){
					$order_message = $sitemessage["$modulename"]["order_succ"];
					$order_status="ok";
					//$order_function="closeblock('variant_form_1')";
					$order_function="showHideSelectionSoft('variant_form_1',1500)";
					$inseredorderrawid=mysql_insert_id();
					# Отправляем письмо
					insert_function("send_letter");
					$subject="Новая заявка на сайте ".$sitedomainname." - ".$order_group.'['.$order_id.']';				
					$message="На портале ".$sitedomainname." оформлена заявка. Тип - ".$order_type."<br><br>Данные по заявке:<br>".$userid." ".$fullname." (".$userrole.") из компании ". $company_id.". ".$companyinfo['company_full_name']."<br><br>";
					$message.="Интересующий вариант - ".$needvariant;
					$message.="<bR><br>С наилучшими пожеланиями.<br><b>Администрация сайта ".$sitedomainname;
			
					sendletter($$modulenameordernotify,$subject,$message);
					$log->LogDebug("Order was created sucessfully");
					if($varianddetail["activation_string"]){
						#Парсим строчку
						insert_function("isJSON");
						if(isJSON($varianddetail["activation_string"])){
							$log->LogDebug("Variant config is correct JSON");
							//{"script":"/project/tscloud/scripts/BMC_activation.php","param":{"balancerip":"172.35.1.12","balancerport":"80","soap_path":"/arsys/services/ARService?server=itsm&webService=SAS_CompanyCreateWS"}}

							$act_string_arr=json_decode($varianddetail["activation_string"], true);
							
							if($act_string_arr["script"]){// Активация из скрипта
								exec("/usr/bin/php ".$fullpath.$act_string_arr["script"]." $projectname $inseredorderrawid > /dev/null &");	// то есть скрипт должен стукнуться в табличку orders, найти там заказ, найти variant_id, найти активационную строчку и активировав, перевести order в статус исполнено
								$log->LogDebug("Auto activation started with string: /usr/bin/php ".$fullpath.$act_string_arr["script"]." $projectname $inseredorderrawid > /dev/null &");
							}
							
						} else $log->LogError("Variant config is incorrect JSON. Auto activation is impossible");
						
					}
				} else {$order_message = $sitemessage["$modulename"]["order_unsucc"];
					$order_status="nok";
					$log->LogError("Order was not created sucessfully. Query was: INSERT INTO `$tableprefix-orders` (`order_type`,`client_id`,`user_id` ,`product_variant_id`,`status`,`creations_ts` ,`last_status_change_ts`,`chat_id` ) VALUES ( '$order_type', '$company_id', '$userid', '$needvariant', 'opened', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP , NULL 	); ");
				}
			}
			
		} else {
			$order_message = $sitemessage["$modulename"]["variant_isnt_ch"]; 
			$order_status="nok";
			$log->LogError("Variant is not choosen");
		}
		
		$aRes = array('status' => $order_status, 'message' => $order_message, 'getfunction'=>$order_function);
		echo json_encode($aRes);
	}
	elseif (process_data($_REQUEST['someid'],27)=="modify_subscription_request"){
		$request_text=process_data( $_REQUEST['request_text'],3000);
		$subscription_id=process_data( $_REQUEST['subscription_id'],7);
		$order_type='modify_subscription_request';
		$modifysubscrreq=mysql_query("INSERT INTO `$tableprefix-orders` (`order_type`,`client_id`,`user_id` ,`subscription_id`,`order_text`,`status`,`creations_ts` ,`last_status_change_ts`,`chat_id` )
				VALUES ('$order_type', '$company_id', '$userid', '$subscription_id','$request_text', 'opened', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP , NULL 
				);");
		$order_id=mysql_insert_id();
		insert_function ("send_letter");
		
		if($modifysubscrreq){
			echo "<span style='color:green'>".$sitemessage["$modulename"]["mdfy_sbscr_ordr_succ_crtd"]." Статус заявки можно отслеживать в разделе ";
			if($userrole=="superuser") echo "ЗАЯВКИ КОМПАНИИ"; elseif($userrole=="user"){echo "МОИ ЗАЯВКИ";} 
			echo "</span>";
			
			$subject="Новая заявка на сайте ".$sitedomainname." - ".$order_id;
			$message="На портале ".$sitedomainname." оформлена заявка. Тип - ".$order_type."<br><br>Данные по заявке:<br>".$userid." ".$fullname." (".$userrole.") из компании ". $company_id.". ".$companyinfo['company_full_name']."<br><br>Номер подписки = ".$subscription_id."<br> Текст запроса:<br>".$request_text."<bR><br>С наилучшими пожеланиями.<br><b>Администрация сайта ".$sitedomainname;
			$log->LogDebug("New order (".$order_type.") was successfully created. Administrator was notified");
		
		} else {echo "<span style='color:red'>".$sitemessage["$modulename"]["mdfy_sbscr_ordr_not_crtd"]."</span>";
			$log->LogError("Modify request was not created sucessfully. Query was: INSERT INTO `$tableprefix-orders` (`order_type`,`client_id`,`user_id` ,`subscription_id`,`order_text`,`status`,`creations_ts` ,`last_status_change_ts`,`chat_id` )
				VALUES ('$order_type', '$company_id', '$userid', '$subscription_id','$request_text', 'opened', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP , NULL 
				);");
			$subject="Ошибка при создании новой заявки на портале ".$sitedomainname;
			$message="На портале ".$sitedomainname." была осуществлена попытка оформления заявки. Тип - ".$order_type."<br><br>Данные по заявке:<br>".$userid." ".$fullname." (".$userrole.") из компании ". $company_id.". ".$companyinfo['company_full_name']."<br><br>Номер подписки = ".$subscription_id."<br> Текст запроса:<br>".$request_text."
			<br><b>ЗАЯВКА НЕ БЫЛА СОЗДАНА В БД. ОШИБКА</b>
			<bR><br>С наилучшими пожеланиями.<br><b>Администрация сайта ".$sitedomainname;
		}
		sendletter($$modulenameordernotify,$subject,$message);	
	}
	elseif(process_data($_REQUEST['subscr_action'],27)=="add_user_to_product_managem"){// Добавляют юзера в группу управления продуктом
		if($userrole=="superuser"){
			$neededuserid=process_data($_REQUEST['userid'],7);
			$neededproductid=process_data($_REQUEST['product_id'],6);
			if($neededproductid and $neededuserid){
				# Запрос номера группы управления продуктом для данной компании
				$manageproduct=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-users-groups` g,`$tableprefix-users-grouprights` gr WHERE g.`groupname` LIKE '%product$neededproductid%' and g.`groupname` LIKE '%manage%' and g.`groupname` LIKE '%company".$company_id."p%' and g.`onoff`='on' and g.`group_id`=gr.`group_id` and gr.`oid`='$neededproductid' and gr.`table`='$moduletableprefix-product' limit 0,1"));
				if($manageproduct['group_id'])	{#Группа управления продуктом найдена
					$log->LogDebug($modulename."/".basename (__FILE__)." | Group for manage of this product was found - ".$manageproduct['group_id']);
					
					$addtogroupreq=mysql_query("INSERT INTO `$tableprefix-users-groupmembers` (`group_id` ,`userid`) VALUES ('$manageproduct[group_id]', '$neededuserid');");
					if($addtogroupreq){
						$log->LogDebug($modulename."/".basename (__FILE__)." | User was inserted into group");
						echo $sitemessage["$modulename"]["user_added_prodmanage_group"].
						"<script>$(document).ready(function(){ajaxreq('".$neededproductid."','','show_product_managem_users','useracesstable".$neededproductid."','$modulename');})</script>";
					} else $log->LogDebug($modulename."/".basename (__FILE__)." | But user was NOT inserted into group by reason ".$addtogroupreq);
				} else $log->LogDebug($modulename."/".basename (__FILE__)." | Group for manage of this product was NOT found");
			} else { echo $sitemessage["$modulename"]["right_add_error"];
				$log->LogDebug($modulename."/".basename (__FILE__)." | Rights were not changed. Post user_id=".$neededuserid.". Post product_id=".$neededproductid);
			}
		}
	}
	elseif(process_data($_REQUEST['action'],27)=="del_user_from_product_manag"){// Удаляют юзера из группы управления продуктом
		if($userrole=="superuser"){
			$neededuserid=process_data($_REQUEST['someid2'],7);
			$neededproductid=process_data($_REQUEST['someid1'],6);
			# Запрос номера группы управления продуктом для данной компании
			$manageproduct=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-users-groups` g,`$tableprefix-users-grouprights` gr WHERE g.`groupname` LIKE '%product$neededproductid%' and g.`groupname` LIKE '%manage%' and g.`groupname` LIKE '%company".$company_id."p%' and g.`onoff`='on' and g.`group_id`=gr.`group_id` and gr.`oid`='$neededproductid' and gr.`table`='$moduletableprefix-product' limit 0,1"));
			
			$delfromgroupreq=mysql_query("DELETE FROM `$tableprefix-users-groupmembers` WHERE `group_id`='$manageproduct[group_id]' and `userid`='$neededuserid' LIMIT 1 ; ");
			
			if($delfromgroupreq){echo $sitemessage["$modulename"]["us_remov_fr_group_success"].
			"<script>$(document).ready(function(){ajaxreq('".$neededproductid."','','show_product_managem_users','useracesstable".$neededproductid."','$modulename');})</script>";
			}
		}
	}
	elseif(process_data($_REQUEST['action'],27)=="show_product_managem_users"){ // Показать тех, кто может управлять продуктом и форму добавления пользователей
		
		if($userrole=="superuser"){
			$neededproductid=process_data($_REQUEST['someid1'],7);
			# Запрос номера группы управления продуктом для данной компании
			$manageproduct_qt="SELECT * FROM `$tableprefix-users-groups` g,`$tableprefix-users-grouprights` gr WHERE g.`groupname` LIKE '%product$neededproductid%' and g.`groupname` LIKE '%manage%' and g.`groupname` LIKE '%company".$company_id."p%' and g.`onoff`='on' and g.`group_id`=gr.`group_id` and gr.`oid`='$neededproductid' and gr.`table`='$moduletableprefix-product' limit 0,1";
			$manageproduct=mysql_fetch_array(mysql_query($manageproduct_qt));
			
			# Список пользователей со всеми правами, чтобы узнать, кому даны права на доступ к управлению продуктом и подписками
			$useraccessreq=mysql_query("SELECT * FROM `$tableprefix-users` u,`$tableprefix-users-groups` g,`$tableprefix-users-groupmembers` gm WHERE u.`company_id`='$company_id' and u.`userrole`='user' and gm.`userid`=u.`userid` and gm.`group_id`=g.`group_id`;");
			# Список всех пользователей компании
			$userlistreq=mysql_query("SELECT * FROM `$tableprefix-users` WHERE `company_id`='$company_id' and `userrole`='user'");
			$userlistcount=mysql_num_rows($userlistreq);// Число юзеров с ролью user в компании
			?>
			<tr><td width="250px">Доступ к управлению продуктом</td><td width="30px"><b>:</b></td><td><? 

			//mysql_data_seek($useraccessreq,0);
			while ($useraccess=mysql_fetch_array($useraccessreq)){
				if($useraccess['group_id']==$manageproduct['group_id']){echo $useraccess['fullname']."<a  href='/' title='Исключить из группы' onclick='ajaxreq(".'"'.$neededproductid.'","'.$useraccess['userid'].'","del_user_from_product_manag","'.$neededproductid.'messageplace","$modulename");'.";return false;'><img src='/22_files/close.png' style='vertical-align:middle'></a><br>";
					$userexceplist[$manageproduct['oid']][$useraccess['userid']]=1; //echo "Исключен из списка добавления id=".$useraccess['userid'];
				}	
			}
			if (count($userexceplist[$manageproduct['oid']])==0){echo $sitemessage["$modulename"]["no_accss_users"];}
			?></td></tr><? 
			if($userlistcount>0){?>
			<? 	mysql_data_seek($userlistreq,0);
				if($userlistcount-count($userexceplist[$manageproduct['oid']])>1){?>
					<tr><td>Добавить пользователя</td><td><b>:</b></td><td>
					<form id="addtoproductform"><select name="userid"><? 
					while ($userlist=mysql_fetch_array($userlistreq)){
						if($userexceplist[$manageproduct['oid']][$userlist['userid']]!==1){?>
						<option value="<?=$userlist['userid']?>"><?=$userlist['fullname']?></option>
				<?		}
					}?></select>
				<input value="add_user_to_product_managem" name="subscr_action" type="hidden">
				<input value="<?=$manageproduct['oid']?>" name="product_id" type="hidden">
				<a href="/" onclick="saveform('','addtoproductform','<?=$manageproduct['oid']?>messageplace','$modulename');return false;"><img src='/files/plus0000.png' style="vertical-align:middle" width="20px"></a>
				</form></td></tr>
			<? 	}
				elseif(($userlistcount-count($userexceplist[$manageproduct['oid']]))==1) {// Есть всего один из списка юзеров компании, кого нет в ексепшн списке
					while($userlist=mysql_fetch_array($userlistreq)){ // Перебираем весь список
						if($userexceplist[$manageproduct['oid']][$userlist['userid']]!==1){// Нашелся нужный юзер?>
							<tr><td>Добавить пользователя</td><td><b>:</b></td><td><?=$userlist['fullname'];?><a  href="/" onclick="saveform('','addtoproductform','<?=$manageproduct['oid']?>messageplace','$modulename');return false;"><img src='/project/tscloud/files/plus0000.png' style="vertical-align:middle" width="20px"></a>
							<form id="addtoproductform"><input value="<?=$userlist['userid']?>" name="userid" type="hidden">
							<input value="add_user_to_product_managem" name="subscr_action" type="hidden">
							<input value="<?=$manageproduct['oid']?>" name="product_id" type="hidden">
							</form></td></tr><?
						}
					}
				}					
			}
		}
	}
	elseif(process_data($_REQUEST['action'],27)=="check_order_status"){/*
		$order_ids=process_data($_REQUEST['someid1'],200);
		$order_id=explode(";",$order_ids);
		foreach($order_id as $oid){
			//$query.=
		}
		$order_status=mysql_fetch_array(mysql_query("SELECT `order_id`,`status` FROM `$tableprefix-orders` WHERE `order_id`='$order_id'"));
		if($order_status['status']){
			if($order_status['status']=="opened"){$humread_status = "В работе";}
			elseif($order_status['status']=="droped"){$humread_status = "Сброшена";}
			elseif($order_status['status']=="admin_suspended"){$humread_status = "Приостановлена администратором";}
			elseif($order_status['status']=="resolved"){$humread_status = "Успешно отработана";}
			elseif($order_status['status']=="inprogress"){$humread_status = "На исполнении";}
			elseif($order_status['status']=="wait_user"){$humread_status = "Ожидание ответа пользователя";}
			$aRes = array('status' => 'ok', 'message' => $humread_status);
		
		
		} else{
			$aRes = array('status' => 'nok', 'message' => "Ошибка при обновлении статуса");
			$log->LogError("Can't get status of order_id - ".$order_id);
		}
		echo json_encode($aRes);*/
	}
	elseif(process_data($_REQUEST['action'],27)=="check_vendor_domain"){
		ini_set('default_socket_timeout', '10');
		$need_vendor_id=$_REQUEST['someid1'];
		$req_lang=$_REQUEST['someid2'];
		$vendorinfo=mysql_fetch_array(mysql_query("select * from  `$moduletableprefix-product-vendors` where `vendor_id`='$need_vendor_id'  LIMIT 0,1;"));
		$fp = fopen($vendorinfo['vendor_domain_'.$req_lang], "r");
		$res = fread($fp, 500);
		fclose($fp);
		if (strlen($res) > 0)
			{
				?><script>showblock("vendor_link_button",0,'show');</script><?
			}
	}
}
?>