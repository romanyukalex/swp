<? $log->LogInfo('Got '.(__FILE__));
if($nitka=='1'){
	
	// Вид правильной ссылки такой: /?page=unsubscribe&subscr_id=11&action=remove_email&code=md5(user_id+ps)
	
?>
<div class="row" style="padding-top:20px;">


<div class="col-md-10">

 
<?
# Страница при подделке URI
 if($_REQUEST['code'] and $_REQUEST['action']and $_REQUEST['subscr_id']){
	 
	 ?>
	 <div class="row">
	<section class="col-md-12">
		<h2 class="maintitle">Отписаться от рассылки</h2>
	</section>
	 <?
	$code=process_data($_REQUEST['code'],32);
	$action=process_data($_REQUEST['action'],15);
	$subscr_id=process_data($_REQUEST['subscr_id'],15);
	
	$ch_q=mysql_query("SELECT * FROM  `freecon-newsletter-users` WHERE `id`='$subscr_id';");
	
	if(mysql_num_rows($ch_q)==1){#Подписка найдена
		
		$subscr_info=mysql_fetch_assoc($ch_q);
		//var_dump($subscr_info);
		#Проверка правильности code
		$right_code=md5($subscr_info['user_id']."ps");
		if($right_code==$code){ #Код верный
			
			#Удаляем подписку
			$post_rules=json_decode($subscr_info['post_to'],TRUE);
			if ($post_rules['email'] and $action=='remove_email') unset ($post_rules['email']);
			
			mysql_query("UPDATE `freecon-newsletter-users` SET `post_to`='".json_encode($post_rules)."' WHERE `id`='$subscr_id';");
			
			echo "Отписка успешно произведена";
			
		} else echo sitemessage('system','Unknown_error')."(2)" ;
		
	} else {
		echo sitemessage('system','Unknown_error')."(1)" ;
	}
	
	 
	?>
	
</div>
		<?

		
} else { echo sitemessage('system','Unknown_error')."<br><br><br><br><br><br>";

}


?>


</div>
</div>


<? } //nitka