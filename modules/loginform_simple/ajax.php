<?php
/****************************************************************
 * Snippet Name : module template (ajax part) 					* 
 * Scripted By  : RomanyukAlex		           					* 
 * Website      : http://popwebstudio.ru	   					* 
 * Email        : admin@popwebstudio.ru     					* 
 * License      : GPL (General Public License)					* 
 * Purpose 	 : some ajax functions							 	*
 * Access		 : via /ajax/								 	*
 ***************************************************************/
if($nitka=="1"){
	if ($requestaction=="checklogin"){
		$log->LogDebug("ajaxapi.php | ".(__LINE__)." | Trying to check userrole");
		$ok_page=$_REQUEST['someid2'];
		$logdata=explode("№№",$_REQUEST['someid1']);
		$_REQUEST['login']=$logdata[0];
		$_REQUEST['password']=$logdata[1];
		include($_SERVER["DOCUMENT_ROOT"]."/core/checkuserrole.php"); // Определяем userrole
		if($showmessage){$log->LogDebug($modulename."/ajax.php | ".(__LINE__)." | Message has been shown: ".$showmessage);
			echo "<span style='color:".$messagecolor."'>".$showmessage."</span>";
			if ($userrole!=="guest" and $userrole) echo "<br><br><a href='/logout/' onclick='logout();return false;'>Покинуть кабинет</a>";
		}
		if($userrole!=="guest" and $userrole){?>
		<script>
			/*
			closelogin();
			showmenu('cabinet','leftmenutab');//Поправить
			changerazdel('<?=$ok_page?>');*/
		$(document).ready(function(){
			closelogin();
			//showmenu('cabinet','leftmenutab');//Поправить
			changerazdel('<?=$ok_page?>');});
		</script><? }
		$showmessage="";$messagecolor="";
	}
}?>