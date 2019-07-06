<?php
 /****************************************************************
  * Snippet Name : admin scripts     					 		 * 
  * Scripted By  : RomanyukAlex		           					 * 
  * Website      : http://popwebstudio.ru	   					 * 
  * Email        : admin@popwebstudio.ru     					 * 
  * License      : GPL (General Public License)					 * 
  * Purpose 	 : admin purposes								 *
  * Access		 : include									 	 *
  ***************************************************************/
$log->LogDebug("Got ".(__FILE__));
  if($block!==1 and $adminpanel==1){
	include_once($_SERVER["DOCUMENT_ROOT"]."/modules/".$modulename."/config.php");
	if($_REQUEST[action]=="show_module_data"){
		#Данные модуля
		
		#Табличка с формами
		
		# Запрос за данными формы и полями
		$formgeneratorquery=mysql_query("select * from `$tableprefix-$modulename-fields` flds,`$tableprefix-$modulename-forminfo` frmnfo where 
		frmnfo.`form_name`=flds.`form_name` ORDER BY flds.`ordernum`;");
		
		if(mysql_num_rows($formgeneratorquery)>0){ #Есть данные по формам
			
			#Выведем заголовок таблицы
		
		
		
			while($form_simple_data=mysql_fetch_assoc($formgeneratorquery)){ #Выведем данные по формам
			?>
			
			
			
			<?
			}
		
		} else { #Нет данных по формам
			?>Пока нет данных форм. <a>Создать новую форму</a>
			<?
		}
		
		
	}
}
