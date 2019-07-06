<? 
if ($nitka=="1"){ $log->LogInfo("Got ".(__FILE__)); ?>
	<div id="regform_answer">
		<h1>Пользователь успешно активирован<? if($_REQUEST['action2']!==2 and $_REQUEST['action2']){?>:<? }?></h1>
<?		if($set_status =='active') echo sitemessage("$modulename",'activation_complete');
		elseif($set_status =='admin_suspensed') echo sitemessage("$modulename",'waiting_admin');
		?><br>
		<?	if($usrcntctafteractiv=='Показывать') {
				if($user['login']) echo $user['login'].'<br>';
				if($user['contact_phone']) echo $user['contact_phone'].'<br>';
				if($user['contactmail']) echo $user['contactmail'].'<br>';
			}?></p><? 
		}?>
	</div>
<? } ?>