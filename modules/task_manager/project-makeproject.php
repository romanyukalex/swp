<?
# Добавление проекта
if ($_REQUEST["new_proj_name"])
	{@include($_SERVER["DOCUMENT_ROOT"]."/core/db/dbconn.php");
	$new_proj_name=process_data($_REQUEST["new_proj_name"],30);
	$activate_newpr=process_data($_REQUEST["activate_newpr"],1);

	mysql_query("INSERT INTO `task-projects` (`id` ,`name` ,`company`,`on`)VALUES(NULL , '$new_proj_name', '$companyid', '$activate_newpr');");
	$newprojectid= mysql_insert_id();
	mysql_query("INSERT INTO `task-projectmembers` (`projectid` ,`memberid` ,`roleinproject` ,`mailnotification`)
	VALUES ('$newprojectid', '$userid', '4', '1');");


	if($gettype=="ajax"){echo "<h2>Проект был успешно добавлен</h2>";}// если запрос из ajax, надо оповестить юзера об усп. добавлении
}?>