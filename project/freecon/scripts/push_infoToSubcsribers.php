<? 
#Отправляет оповещения о новом контенте подписчикам
/*//Пример
$subscr_post_txt="Сообщение юзерам";
$subscr_theme='"books":"all"';
include($_SERVER['DOCUMENT_ROOT'].'/project/freecon/scripts/push_infoToSubcsribers.php');

*/
if($nitka=="1"){

	#Получаем подписчиков
	
	$get_subscr_q=mysql_query("SELECT `post_to` FROM `freecon-newsletter-users` WHERE `themes` LIKE '%$subscr_theme%';");
	//echo "Found ".mysql_num_rows($get_subscr_q);
	while($subscbrs=mysql_fetch_assoc($get_subscr_q)){ #Перебираем подписчиков
		$post_to=json_decode($subscbrs['post_to'],TRUE);
		if($post_to['vk']){ //Пишем сообщение в ВК
			
			if($subscr_bottext_added!==1) $subscr_post_txt.="\n\rЧтобы не получать эти сообщения пройдите по ссылке: https://vk.cc/9odKGT";
			$subscr_bottext_added=1;
			if(function_exists("set")) $vkapi_access_token_gr=set('vkapi_access_token_gr');
			$mes_toUser=insert_module("vk-api","send_message",$post_to['vk'],"$subscr_post_txt",$vkapi_access_token_gr);
			
		}
	}

}