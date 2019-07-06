<? 
/*****************************************************************************************************************************
  * Snippet Name : adminpanel:users-management.php																					 * 
  * Scripted By  : RomanyukAlex		           																				 * 
  * Website      : http://popwebstudio.ru	   																				 * 
  * Email        : admin@popwebstudio.ru    					 														     * 
  * License      : License on popwebstudio.ru	from autor		 															 *
  * Purpose 	 : 											 					 *
  * Insert		 : 		ПЕРЕДЕЛАТЬ, чтобы такая разметка с левым меню была везде на сайте												 *
  ***************************************************************************************************************************/ 
if($adminpanel==1) {
	if($userrole=="admin" or $userrole=="root") {
	//	@include_once($_SERVER['DOCUMENT_ROOT']."/core/db/dbconn.php");
		
		//$query_groups = mysql_query("SELECT group_id, groupname, onoff FROM `$tableprefix-users-groups` WHERE 1 ORDER BY `group_id` ASC"); 

		
?>
	<div class="row">
	
		<div class="col-xs-2 col-lg-2 col-md-2" id="users_management_menu">
			
				<div style="border-bottom: 2px solid black;" class="h5">Пользователи</div>
				<a id="users_management_users_button" class="users-management-menu-button">Управление пользователями</a><br>
				<a id="users_management_company_button" class="users-management-menu-button">Управление компаниями</a><br>
				<div style="border-bottom: 2px solid black;"class="h5">Группы</div>
				<a id="users_management_groups_button" class="users-management-menu-button">Управление группами</a><br>
				<a id="users_management_groups_right_button" class="users-management-menu-button">Права групп</a><br>
				<a id="users_management_groups_member_button" class="users-management-menu-button button1">Участники групп</a>
			
		</div>
		<div id="users_management_container" class="col-xs-10 col-lg-10 col-md-10">
			<div id="messages"></div>
			<div id="users_management_content"></div>
		</div>

	</div>
<?	}
}
?>