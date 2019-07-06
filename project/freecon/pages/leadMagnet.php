<? #Конструктор lead-magnet
// /?page=lmp&lmn=free_psy_books
// lmn - имя магнита


#Выискиваем lead magnet

insert_function("process_user_data");
$magnet_name=process_data($_REQUEST['lmn'],50);
#Запрос в БД
$lm_q=mysql_fetch_assoc(mysql_query("SELECT * FROM `freecon-leadmagnet` WHERE `lm_name`='".$magnet_name."';")); 

if($lm_q['magnet_id']){
	
	if($userrole!=="guest" or $_SESSION['registered']==1){ #Авторизовались через соцсети
		?><img src="/project/freecon/files/psychologists.jpg"><br><h3>Спасибо, что Вы с нами теперь</h3>
		<br><br>
		<a href="<?=$lm_q['lm_resource']?>" class="super button <? if($_SESSION['user_data']['gender']=="male"){?>blue<?} else{?>pink<?}?>" download>Скачать</a> <?=$lm_q['lm_title_ru'];
		unset($_SESSION['redirect_url']);
	}
	else { #Просто зашли на страницу магнита, предлагаем зарегистрироваться для получения магнита
		
		$_SESSION['leadMagnet_lead']=$lm_q['magnet_id']; //Помечаем его как лид-магнитного юзера
		
		$_SESSION['redirect_url']='/?page='.lmp.'&lmn='.$magnet_name;
		?><div id="lm_html"><?=$lm_q['lm_html'];?></div><?
		
		#Обработаем настройки
		$lm_settings=json_decode($lm_q['settings'],TRUE);
		foreach($lm_settings as $set_type=>$set_value){
			if($set_type=="vk_auditory"){//Настройка показывает всунуть юзера в цель ретаргетинга
				//разобьем на части, если их много
				$vk_auditories=explode(",",$set_value);?>
				<script>
				<? foreach ($vk_auditories as $vk_auditory){?>
					VK.Retargeting.Event('<?=$vk_auditory?>'); 
				<? }?>
				</script><?
			} elseif($set_type=="fb_auditories"){
				$fb_auditories=explode(",",$set_value);?>
				<script>
				<? foreach ($fb_auditories as $fb_auditory){?>
					fbq('track', '<?=$fb_auditory?>');
				<? }?>
				</script><?
			}
		}
		
		insert_module("registration_form","show_registration_form");
		
		#Обработчик клика по регистрационной форме, чтобы сворачивалось описание lm
		?><script>$( ".choose_role" ).click(function() { $( "#lm_html" ).fadeOut(500); });
		
		
		
		
		
		</script>
		
		<?
		

		
	}
} else {
	$page="404";
	include($_SERVER["DOCUMENT_ROOT"]."/core/pagemanage.php"); 
}