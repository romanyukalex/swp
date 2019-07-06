<?
/*****************************************************************************************************************************
  * Snippet Name : adminpanel-settings.php																					 *
  * Scripted By  : RomanyukAlex		           																				 *
  * Website      : http://popwebstudio.ru	   																				 *
  * Email        : admin@popwebstudio.ru    					 														     *
  * License      : License on popwebstudio.ru	from autor		 															 *
  * Purpose 	 : Скрипт обработки изменений настроек сайта											 					 *
  * Insert		 : include_once('Adminpanel-siteconfig_Creator.php');														 *
  ***************************************************************************************************************************/
if($userrole=="root" and $adminpanel==1){?>


	<div id='exportsiteblock'>
		<h1><img src="/adminpanel/pics/backup-restore256.png" height="64px" class="imgmiddle">Экспорт системы на другой сервер</h1><br>

	<a onclick="ajaxreq('','','export_db','export_ap','adminpanel')" id="dbexportlink" style="margin-left:100px">
		<img src="/adminpanel/pics/Extract-object256.png" height="48px" class="imgmiddle">Экспорт базы данных
	</a><br>
	<div id="export_ap"></div>
	<a onClick="ajaxreq('','','export_code','code_export_ap','adminpanel')" id="savecodelink" style="margin-left:100px">
		<img src="/adminpanel/pics/Save256.png" height="48px" class="imgmiddle">Экспорт кода платформы
	</a>
	<div id="code_export_ap"></div>
	</div>




<script type="text/javascript" src="js/ColorPicker2/farbtastic.js"></script>
<link rel="stylesheet" href="js/ColorPicker2/farbtastic.css" type="text/css"/>
<? }//Нитка adminpanel?>