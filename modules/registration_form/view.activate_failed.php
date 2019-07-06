<? $log->LogInfo("Got ".(__FILE__));
if ($nitka=="1"){ ?>
<div id="regform_answer" class="checkbox-radio-css3-show">
	<h1>Пользователь не активирован:</h1>
		<p><?=sitemessage("$modulename",'wrong_activation_qry');//Неправильная строка активации или пользователь уже был активирован ранее?></p>
</div>
<? } ?>