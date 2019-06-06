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

if(($userrole=="admin" or $userrole=="root") and $adminpanel==1){
	$pageshtrih="HACTPOuKu";
	?><div style= "margin:0 25% 0 25%; width:50%;"><?insert_module("change_password");?></div><?
}?>