<?php
 /**************************************************************\
  * Modulename	: modulename				 					* 
  * Part		: controller									*
  * Scripted By	: RomanyukAlex		           					* 
  * Website		: http://popwebstudio.ru	   					* 
  * Email		: admin@popwebstudio.ru     					* 
  * License		: GPL (General Public License)					* 
  * Purpose		: control all operations						*
  * Access		: include									 	*
  * if its needed to return some data just add $return_data		*
  \*************************************************************/
$log->LogInfo('Got this file with params - '.implode(',',$param));
if($nitka=='1'){
		/* 
		Webhook сервиса Senler
		API по адресу	https://soznanie.club/modules/webhook_api/?action=senler
		*/
		
	if ($contact=='senler'){# 
	
		$query_body = @file_get_contents("php://input");
		
		$log->LogInfo($query_body);
		$q_json=json_decode($query_body, TRUE);
		if($q_json['type']=="subscribe"){ #Кто то подписался на рассылку VK
			
			//Проверяем, есть ли такая подписка
			
			if(!mysql_num_rows(mysql_query("SELECT * FROM `$tableprefix-newsletter-users` WHERE `post_to`='{". '"vk":"'.$vk_user_id.'"'."}"))>0){
			
				if($q_json['object']['subscription_id']=="313479") $suscr_theme='"books":"all"';
				$vk_user_id=$q_json['object']['vk_user_id'];
				$ins_qt="INSERT INTO `$tableprefix-newsletter-users` (`id`, `user_id`, `post_to`, `mail`, `themes`) VALUES (NULL, NULL, '{". '"vk":"'.$vk_user_id.'"'."}', NULL, '{ $suscr_theme }');";
				mysql_query($ins_qt);
				$log->LogInfo($ins_qt);
			} else {
				$log->LogError("That subscription is not found");
			}
			
		} elseif($q_json['type']=="unsubscribe"){ #Отписались от рассылки VK через Senler
			
			if($q_json['object']['subscription_id']=="313479") $suscr_theme='"books":"all"';
			$vk_user_id=$q_json['object']['vk_user_id'];
			$del_qt="DELETE FROM `$tableprefix-newsletter-users` WHERE `post_to`='{". '"vk":"'.$vk_user_id.'"'."}' and `themes`='{ $suscr_theme }';";
			mysql_query($del_qt);
			$log->LogInfo($del_qt);
			
		}
		
	echo '{"success":true}'; //Чтобы было 200OK
	$log->LogDebug("Answered 200 OK");
	}
}
?>