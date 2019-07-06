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

if(($userrole=="admin" or $userrole=="root") and $adminpanel==1){?>
		<a onClick="showHideSelectionSoft('pages_management_container',1000)" id="pages_management_link">
			<img src="pics/HTML256.png" style="vertical-align:middle;" height="64px" class="imgmiddle">Cтраницы</h3></a>
	<? # Табличка со страницами ?>
		<div id="messages"></div>
		<div id="pages_management_container" style="border-left: solid white; background: white;display: none;">
			<table id="pagestable" align="center" class="zebra">
				<tr><th>Название</th><th>URL(?page=)</th><th>Источник</th><th>Действия</th></tr><?
			@include_once($_SERVER['DOCUMENT_ROOT']."/core/db/dbconn.php");
			$pagequery=mysql_query("SELECT * FROM `$tableprefix-pages` WHERE 1 ;");
			while($pagedata=mysql_fetch_array($pagequery)){
				?>
				<tr id="<?=$pagedata[page]?>_raw">
				<td><?=$pagedata[pagetitle_ru]?></td>
				<td><?=$pagedata[page]?></td>
				<td><?=$pagedata[folder]?><?echo $pagedata[filename]?></td>
				<td class="actionstd"><? if($userrole=="admin" or $pagedata[canbechanged]=="1"){?><a id="<?=$pagedata[page]?>" class="admindeletelink" title="Удалить страницу '<?=$pagedata[pagetitle_ru]?>'"><img src="/files/simplicio/button_cancel.png" border="0"></a>
			   <a onClick="editpage('<?=$pagedata[page]?>_raw');return false;" title="Правка страницы '<?=$pagedata[pagetitle_ru]?>'"><img src="/files/simplicio/file_edit.png" border="0"></a><? }?></td>
				</tr>
				<?
				}?>
				<tr id="newpageform" style="display:none;">
					<td><input name="newpagetitle" value="" id="newpagetitle"></td>
					<td><input name="newpagepage" value="" id="newpagepage"></td>
					<td><select name="newpagefolder" id="newpagefolder"><option value="1">/page</option><option value="2">/</option></select></td>
					<td><input name="newpagefilenameext" value="" id="newpagefilenameext"></td>
					<td><a href="#" onClick="createpage();return false;"><img src="/adminpanel/pics/Save-as256.png" width="32"></a></td>
				</tr>
			</table>
		
		
		
			<a class="menulink" style="margin-left:18;" onClick="showHideTr('newpageform');" ><img src="/adminpanel/pics/blue-newpage.png" class="smallimg">Создать страницу</a><br><br><br>
			
			<h3><img src="pics/blue-pageedit.png">Редактор страницы</h3>
			<div id="pageeditor">
		</div>
	</div>
	


	<a onClick="showHideSelectionSoft('templates_management_container',1000)" id="pages_management_link">
			<img src="pics/template128.png" style="vertical-align:middle;" height="64px" class="imgmiddle">Шаблоны</h3></a>
		<div id="templ_messages"></div>
		<div id="templates_management_container" style="border-left: solid white; background: white;display: none;">
			<table id="templates_table" align="center" class="zebra">
				<tr id="th"></tr>
		
		
			</table>
		</div>
		<script>
		$(document).ready(function(){
			get_table_data("adminpanel","get_templates","templ_messages","templates_table");
		})
		</script>
		<?
		$param_array=array(
				"table_id"=>"templates_table",
				"table_design_css"=>"Office",
				"table_width"=> 900, 
				"table_height"=> 500,
				"table_title"=> "Шаблоны",
				"module"=>"adminpanel",
				"module_action"=>"get_templates_grid"
				
			);
			/*"rule_id"=>"hide_id",
					"template"=>"Шаблон",
					"domain"=>"Домен",
					"mainpage"=>"Главная страница",
					"company_id"=>"Компания",
					"onoff"=>"Включен",
					"comment"=>"Комментарий"*/
		//insert_module("grid",$param_array);?>
		<?
}?>