<? 
/*****************************************************************************************************************************
  * Snippet Name : adminpanel:users-management.php																					 * 
  * Scripted By  : RomanyukAlex		           																				 * 
  * Website      : http://popwebstudio.ru	   																				 * 
  * Email        : admin@popwebstudio.ru    					 														     * 
  * License      : License on popwebstudio.ru	from autor		 															 *
  * Purpose 	 : 											 					 *
  * Insert		 : 														 *
  ***************************************************************************************************************************/ 

if(($userrole=="admin" or $userrole=="root")and $adminpanel==1){
	?>
Здравствуйте, <?=$nickname?><br><br>
Добро пожаловать на страницу администрирования сайтом <?=$sitedomainname?><br>

<span style='font:14;'>Ваша роль на сайте: <?=$userrole?><br>
Вы пользуетесь браузером <?=$browser?> версии <?=$browserversion?><br>
Ваш IP = <?=$ip?><br>
<a href="#" onClick="serverinfo();return false;">О сервере</a></span>
<?}?>