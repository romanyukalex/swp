<? 
/*****************************************************************************************************************************
  * Snippet Name : adminpanel-ajaxactions.php																				 * 
  * Scripted By  : RomanyukAlex		           																				 * 
  * Website      : http://popwebstudio.ru	   																				 * 
  * Email        : admin@popwebstudio.ru    					 														     * 
  * License      : License on popwebstudio.ru from autor		 															 *
  * Purpose 	 : Прием ajax-запросов из администраторского Веб-интерфейса							 						 *
  * Insert		 : include_once('adminpanel-ajaxactions.php');																 *
  ***************************************************************************************************************************/ 
$log->LogInfo("Got ".(__FILE__));
if($adminpanel==1){

	include($_SERVER['DOCUMENT_ROOT']."/adminpanel/adminpanel-checkuserrole.php"); // Определяем userrole
	@require_once($_SERVER['DOCUMENT_ROOT']."/core/system-param.php");
	if ($userrole!=="admin" and $userrole!=="administrator" and $userrole!=="root"){$block=1;}
	
	if($block!==1){
		insert_function ("process_user_data");
		if ($_REQUEST["action"]=="deletepage"){# Управление страницами - удаление страницы
			$deletepage=process_data($_REQUEST[id],25);
			include_once($_SERVER['DOCUMENT_ROOT']."/core/db/dbconn.php");
			$pagequery=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-pages` WHERE `page` ='$deletepage' LIMIT 0,1;"));
			if ($pagequery['pagetitle']){ // Страница есть, удаляем ее
				mysql_query("DELETE FROM `$tableprefix-pages` WHERE `page` ='$deletepage' LIMIT 1;");
				if ($pagequery['folder']!=="/"){$filefordelete.=substr($pagequery['folder'],1)."/";}
				$filefordelete.=$pagequery['filename'].".".$pagequery['ext'];echo $filefordelete;
				unlink($filefordelete);
				echo "Страница '$pagequery[pagetitle]' успешно удалена
				<script>
				$(document).ready(function(){
					$('tr#".$deletepage."_raw').remove();
				});
				</script>";
			}
		}
		elseif ($_REQUEST["action"]=="createpage"){# Управление страницами - Создание страницы
			$newpagepage=process_data($_REQUEST[pagepage],25);
			$newpagetitle=process_data($_REQUEST[pagetitle],40);
			$newpagefolder=process_data($_REQUEST[pagefolder],1);if($newpagefolder==1){$newpagefolder="/page/";}else{$newpagefolder="/";}
			$newfile = explode(".", $_REQUEST[pagefilenameext]); 
			$newpagefilename=process_data($newfile[0],40);
			$newpageext=process_data($newfile[1],4);
			@include_once($_SERVER['DOCUMENT_ROOT']."/core/db/dbconn.php");
			mysql_query("INSERT INTO `$tableprefix-pages` (`page`, `folder`, `filename`, `ext`, `pagetitle`, `exceptionsscript`, `canbechanged`) VALUES 
			('$newpagepage', '$newpagefolder', '$newpagefilename', '$newpageext', '$newpagetitle', '0', '1');");
			if ($newpagefolder=="/page/"){
				$file=".".$newpagefolder.$newpagefilename.".".$newpageext; echo $file;
				if(!file_exists($file)){
					$fp = fopen($file, "w");
					fwrite($fp, "<!-- Страница $newpagetitle-->");
					fclose (fp);
					}
				}
			echo "Создали страничку '$newpagetitle'<script>
				$(document).ready(function(){
					editpage('$newpagepage');
					//scrollTo на редактирование странички
				});
				</script>";
		}
		elseif ($_REQUEST["action"]=="editpage"){
			$pagefromget=explode("_",$_REQUEST[page]);
			$editpage=process_data($pagefromget[0] ,20);		
			@include_once($_SERVER['DOCUMENT_ROOT']."/core/db/dbconn.php");
			$pagequery=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-pages` WHERE `page` ='$editpage' LIMIT 0,1;"));
			if ($pagequery['pagetitle']){ // Страница есть, показываем ее
				?><script type="text/javascript" src="js/tinymce/tinymce.min.js"></script>
				<script type="text/javascript">tinymce.init({selector: "textarea"});</script>
				<textarea id="elm1" name="elm1" rows="60" cols="130">
				<?include($_SERVER['DOCUMENT_ROOT'].$pagequery['folder'].$pagequery['filename'].".".$pagequery['ext']);?>
				</textarea><br>
				<input style="visibility:hidden" id="editorid" value="<?=$editpage?>"/>
				<a class="large button pink" onClick="saveeditordata('pages');return false;" id="savebutton">Сохранить</a><br><br><br>
				<? //require($_SERVER['DOCUMENT_ROOT']."/wisiwig-menu.php");?><script>$(document).ready(function(){
				<? //include($_SERVER['DOCUMENT_ROOT']."/wisiwig-init-function.php");?>});</script><?
				}
		}
		elseif ($_REQUEST["action"]=="createnews"){ #Создание новости
			$newstitle=process_data($_REQUEST[newstitle],200);
			$newsdate=process_data($_REQUEST[newsdate],15);
			@include_once($_SERVER['DOCUMENT_ROOT']."/core/db/dbconn.php");
			mysql_query("INSERT INTO `$tableprefix-news` (`newsid` ,`date` ,`newsdate` ,`newstitle` ,`fulltext`)
										VALUES (NULL ,CURRENT_TIMESTAMP , '$newsdate', '$newstitle', ' ');");
			$newid=mysql_insert_id();
			echo "Создали новость '$newstitle'<script>
				$(document).ready(function(){
					editnews('$newid');
					//scrollTo на редактирование странички
				});
				</script>";
		}
		elseif ($_REQUEST["action"]=="editnews")
			{$newsidfromget=explode("_",$_REQUEST[id]);
			$editpage=process_data($newsidfromget[0] ,6);		
			@include_once($_SERVER['DOCUMENT_ROOT']."/core/db/dbconn.php");
			$pagequery=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-news` WHERE `newsid` ='$editpage' LIMIT 0,1;"));
			if ($pagequery['newstitle']){ // Страница есть, показываем ее
				?><textarea id="elm1" name="elm1" rows="60" cols="130">
			<?=$pagequery['fulltext'];?>
				</textarea><br><input style="visibility:hidden" id="editorid" value="<?=$pagequery['newsid']?>"/>
				<a class="large button pink" onClick="saveeditordata('news');return false;" id="savebutton">Сохранить</a><br><br><br>
			   <? require($_SERVER['DOCUMENT_ROOT']."/wisiwig-menu.php");?><script>$(document).ready(function(){<? include($_SERVER['DOCUMENT_ROOT']."/wisiwig-init-function.php");?>});</script><?
				}
		}
		elseif ($_REQUEST["action"]=="saveeditor"){// Правка данных в едиторе
			$table=process_data($_REQUEST[whatsave],20);
			$data=$_REQUEST[data];
			$idfromget=process_data($_REQUEST['id'],15);
			@include_once($_SERVER['DOCUMENT_ROOT']."/core/db/dbconn.php");
			if ($table=="news"){mysql_query("UPDATE `$tableprefix-$table` SET `fulltext` = '$data' WHERE `newsid`='$idfromget';");}
			elseif($table=="pages")
				{$pagequery=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-$table` WHERE `page` ='$idfromget' LIMIT 0,1;"));
				if ($pagequery['pagetitle']){ // Страница есть, записываем в нее
					$filetowrite = $fullpath.$pagequery['folder'].$pagequery['filename'].".".$pagequery['ext'];
					$fh = fopen($filetowrite,"w");
					$success = fwrite($fh,$data);
					fclose($fh);
					echo "Успешно исправлено";
					}
				else{echo "Ошибка, объект не найден";}
				}
		}
		elseif ($_REQUEST["action"]=="editconfig")
			{# Исправляют какой-то параметр в siteconfig
			$idfromget=process_data($_REQUEST['someid1'],5);
			$newvalue=process_data($_REQUEST['someid2'],1000);
			@include_once($_SERVER['DOCUMENT_ROOT']."/core/db/dbconn.php");
			$paramdata=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-siteconfig` WHERE `id` ='$idfromget' LIMIT 0,1;"));
			if($paramdata['maybeempty']!=="1" and empty($newvalue))
				{// Пришло пустое, а пустое низя
				$showmessage="Параметр не может быть пустым";$messagecolor="red";
				}
			else{// Все в порядке, исправляем параметр
				mysql_query("UPDATE `$tableprefix-siteconfig` SET `value` = '$newvalue' WHERE `id`='$idfromget';");
				$showmessage="Этот параметр был успешно изменен на ";
				if(!empty($newvalue)){$showmessage.="'".$newvalue."'";}else{$showmessage.="пустое значение";}
				$messagecolor="green";
				}
			if($showmessage){echo "<span style='color:".$messagecolor."'>".$showmessage."</span>";}
		}
		elseif ($_REQUEST["action"]=="upd_message"){# Исправляют какой-то message
			$idfromget=process_data($_REQUEST['someid'],5);
			$newvalue_ru=process_data($_REQUEST['message_ru'],1000);
			$newvalue_en=process_data($_REQUEST['message_en'],1000);
			//@include_once($_SERVER['DOCUMENT_ROOT']."/core/db/dbconn.php");
			mysql_query("UPDATE `$tableprefix-messages` SET `message_ru` = '$newvalue_ru',`message_en` = '$newvalue_en' WHERE `message_id`='$idfromget';");
			$showmessage="Сообщение успешно изменено на ";
			$showmessage.="<br>(RU)'".$newvalue_ru."'<br>(EN)'".$newvalue_en."'";
			$messagecolor="green";
			echo "<span style='color:".$messagecolor."'>".$showmessage."</span>";
		}
		elseif ($_REQUEST["action"]=="add_new_message"){# Добавляют новый message
			$newmes_modulename=process_data($_REQUEST['module'],100);
			$newvalue_ru=process_data($_REQUEST['message_ru'],1000);
			$newvalue_en=process_data($_REQUEST['message_en'],1000);
			$newmes_code=process_data($_REQUEST['message_code'],100);
			$newmes_meaning=process_data($_REQUEST['message_meaning'],1000);
			$newmes_company_id=process_data($_REQUEST['company_id'],5);
			$q_text="INSERT INTO `$tableprefix-messages` (`message_id`, `module_name`, `message_code`, `message_meaning`, `message_ru`, `message_en`, `company_id`) VALUES (NULL, '".$newmes_modulename."', '".$newmes_code."',";
			if($newmes_meaning) $q_text.="'".$newmes_meaning."',";
			else $q_text.="NULL,";
			if($newvalue_ru) $q_text.="'".$newvalue_ru."',";
			else $q_text.="NULL,";
			if($newvalue_en) $q_text.="'".$newvalue_en."',";
			else $q_text.="NULL,";
			if($newmes_company_id) $q_text.="'".$newmes_company_id."')";
			else $q_text.="NULL)";
			
			if(mysql_query($q_text)){
				$aRes = array('status' => 'ok', 'message' => 'The new message was successfully added');
				$log->LogInfo("The new message was successfully added: [".$newmes_modulename."][".$newmes_code."][".$newmes_company_id."]");
			} else{$aRes = array('status' => 'nok', 'message' => 'The new message was NOT added');
				$log->LogError("The new message was NOT added. Query was: ".$q_text);
			}
			echo json_encode($aRes);
			
			
		}
		elseif ($_REQUEST["action"]=="serverinfo" and ($userrole=="admin" or $userrole=="root")){
			$phpinf_data=phpinfo();
			//echo $phpinf_data;
			 //preg_match_all('#<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">(.+?)<body>#is', $phpinf_data, $arr);
			//print_r($arr[1]);
		}
		elseif ($_REQUEST["action"]=="show_module_data"){
			$modulename=process_data($_REQUEST['someid1'],30);
			if (file_exists ( $_SERVER['DOCUMENT_ROOT']."/modules/".$modulename."/admin-scripts.php" )){
				//echo "2";
				include($_SERVER['DOCUMENT_ROOT']."/modules/".$modulename."/admin-scripts.php");
			} else {?> 
			<script>$(document).ready(function(){$('#modules_message_place').html('Обработчик запроса не найден').delay(5000).fadeOut(2000);})</script><?
			}
		}
		elseif ($_REQUEST["action"]=="show_module_settings"){
			$modulename=process_data($_REQUEST['someid1'],30);
			$moduleid=process_data($_REQUEST['someid2'],30);
			echo '<br><br><img class="imgmiddle" height="64px" src="/adminpanel/pics/checklist256.png">Параметры модуля '.$modulename;
			include($_SERVER['DOCUMENT_ROOT']."/adminpanel/adminpanel-siteconfig.php");
			echo '<br><br><img class="imgmiddle" height="64px" src="/adminpanel/pics/NotificationTemplates256.png">Системные сообщения модуля '.$modulename;
			include($_SERVER['DOCUMENT_ROOT']."/adminpanel/adminpanel-messages.php");
		}
		elseif ($_REQUEST["action"] == "export_db") {
			$file=$fullpath."/project/".$projectname."/export/".$projectname.".swp.sql";
			/* //Старая функция
			insert_function("backup_tables");
			backup_tables($file, 'localhost', $dbadmin_login, $dbadmin_pass, $databasename);
			*/
			insert_function("Mysqldump");
			$dumpSettings = array(
			'compress' => Mysqldump::NONE,
			'no-data' => false,
			'add-drop-table' => true,
			'single-transaction' => true,
			'lock-tables' => true,
			'add-locks' => true,
			'extended-insert' => false,
			'disable-keys' => true,
			'skip-triggers' => false,
			'add-drop-trigger' => true,
			'databases' => false,
			'add-drop-database' => false,
			'hex-blob' => true,
			'no-create-info' => false,
			'where' => ''
			);
			$dump = new Mysqldump($databasename,$dbadmin_login,$dbadmin_pass,"localhost","mysql",$dumpSettings);
			$dump->start($file);
			
			if(filesize($file)>0){
				?><a href="/project/<?=$projectname?>/export/<?=$projectname?>.swp.sql">Скачать БД проекта (<? if(filesize($file)>1048576) echo round(filesize($file)/1048576)."МБ"; else echo round(filesize($file)/1024)."кБ";?>)</a><?
			} else{echo "Не удалось создать бекап БД проекта";}
		}
		elseif ($_REQUEST["action"] == "export_code") {
			
			if(exec("tar cvzf ".$fullpath."project/".$projectname."/export/".$projectname.".swp.tar.gz ../adminpanel/  ../core/ ../files/ ../index.php ../js/ ../logout/ ../modules/ ../pages/ ../style/ ../project/".$projectname."/ --exclude='*.log' --exclude='../project/".$projectname."/config.php' --exclude='../project/".$projectname."/backup/*' --exclude='../project/".$projectname."/export/*'",$output,$return_var)) {
			?><a href="/project/<?=$projectname?>/export/<?=$projectname?>.swp.tar.gz">Скачать архив с кодом платформы SWP (<?=round(filesize($fullpath."project/".$projectname."/export/".$projectname.".swp.tar.gz")/1048576)?>МБ)</a><?
			} else{echo "Не удалось создать архив с кодом платформы:".$output."<br><br>".$return_var;}

		}
		elseif($_REQUEST["action"] == "get_templates_grid"){
			$table_id=$_REQUEST['someid2'];
			
			/* Если название хедера hide_id, то оно не выводится */
			$table_config=array(
				"table"=>"$tableprefix-templates_manager",
				"fields"=>array(
					"template"=>'{ title: "Шаблон", width: 100, dataType: "integer" }',
					"domain"=>	'{ title: "Домен", width: 200, dataType: "string" }',
					"mainpage"=>'{ title: "Главная страница", width: 100, dataType: "integer" }',
					"company_id"=>	'{ title: "Компания", width: 200, dataType: "string" }',
					"onoff"=>'{ title: "Включен",width: 200, dataType: "string" }',
					"comment"=>'{ title: "Комментарий",width: 200, dataType: "string" }'
				)
			);
			# Формируем запрос для вывода значений
			foreach($table_config["fields"] as $field=>$field_config){
				$selfields.="`".$field."`,";
				//$header_json.='"'.$field.'":"'.$head_title.'",';
				$colModel.=$field_config.",";
			}
			
			$selfields=substr($selfields,0,-1);
			$colModel=substr($colModel,0,-1);
			$templ_q=mysql_query("SELECT ".$selfields." FROM `".$table_config["table"]."` WHERE 1;");
			$bRes='{"status":"ok",
			"header":['.$colModel.'],"message":';
			$rows = array();
			while($templ=mysql_fetch_assoc($templ_q)){
				$rows[] = $templ;
			}	
			$bRes.=json_encode($rows);
			$bRes.='}';
			echo $bRes;
			
		}
		elseif($_REQUEST["action"] == "get_templates"){ // Стереть, когда напишу модуль grid
			if(isset($_REQUEST["someid2"])) {
				$table_id=$_REQUEST["someid2"];
				/* Если название хедера hide_id, то оно не выводится */
				$table_config=array(
					"table"=>"$tableprefix-templates_manager",
					"fields"=>array(
						"rule_id"=>"hide_id",
						"template"=>"Шаблон",
						"domain"=>"Домен",
						"mainpage"=>"Главная страница",
						"company_id"=>"Компания",
						"onoff"=>"Включен",
						"comment"=>"Комментарий"
					)
				);
				# Формируем запрос для вывода значений
				$selfields=null;$header_json=null;
				foreach($table_config["fields"] as $field=>$head_title){
					$selfields.="`".$field."`,";
					$header_json.='"'.$field.'":"'.$head_title.'",';
				}
				$selfields=substr($selfields,0,-1);
				$header_json=substr($header_json,0,-1);
				$templ_q=mysql_query("SELECT ".$selfields." FROM `".$table_config["table"]."` WHERE 1;");
				$bRes='{"status":"ok",
				"header":{'.$header_json.'},"message":';
				$rows = array();
				while($templ=mysql_fetch_assoc($templ_q)){
					$rows[] = $templ;
				}	
				$bRes.=json_encode($rows);
				$bRes.='}';
				echo $bRes;
			}
		} 
		
		
		
		elseif($_REQUEST["action"] == "add_new_param"){#Добавление параметра в settings
			
			
			
			$new_var_value=process_data($_REQUEST['new_var_value'],2000);
			$new_vartype=process_data($_REQUEST['new_vartype'],1);
			$new_var_describe=process_data($_REQUEST['new_var_describe'],1000);
			$new_var_systemparamname=process_data($_REQUEST['new_var_system-param-name'],30);
			
			//$new_var_formmaxlegth=process_data($_REQUEST['new_var_formmaxlegth'],5);
			$new_var_varpossible=process_data($_REQUEST['new_var_value_variants'],3000);
			$new_var_showtositeadmin= process_data($_REQUEST['new_var_ShowToSiteAdmin'],1);
			$new_var_example=process_data($_REQUEST['new_var_example'],1000);
			$new_var_depend=process_data($_REQUEST['new_var_depend'],16);
			$new_var_maybeempty=process_data($_REQUEST['new_var_maybeempty'],1);
			if($_REQUEST['new_var_module_id']!=="-") $new_var_module_id=process_data($_REQUEST['new_var_module_id'],5);
			$new_var_company_id=process_data($_REQUEST['new_var_company_id'],11);
			//Отрежем пробелы
			$new_var_describe=trim($new_var_describe);
			$new_vartype=trim($new_vartype);
			$new_var_value=trim($new_var_value);
			$new_var_value_variants=trim($new_var_value_variants);
			$new_var_formmaxlegth=trim($new_var_formmaxlegth);
			$new_var_system_param_name=trim($new_var_system_param_name);
			$new_var_depend=trim($new_var_depend);
			$new_var_ShowToSiteAdmin=trim($new_var_ShowToSiteAdmin);
			$new_var_id=trim($new_var_id);
			$new_var_example=trim($new_var_example);
			//Проверка полученного: Все ли данные передались/передали?
			$errfield="";$err=0;
			if (empty($new_var_value) or empty($new_var_systemparamname) or ($new_vartype=="2" and empty($new_var_varpossible))) {//Если чтото из них пустое - это не все поля заполнил юзер или ошибка на сети или хакер.
				$err=1;
				$showmessage="Не все обязательные поля заполнены.<br>";
				$status="nok";
			}
			
			if ($err==0){ #Проверка прошла без ошибок
		
				# Отправляем в siteconfig
				//if (add_to_end_of_file($data1, $file1)){$showmessage="Добавлено успешно в $file1.<br>";$messagecolor="green";}
				//else {$showmessage="В файл $file1 не записано!<br>";$messagecolor="red";}
				mysql_query("INSERT INTO `$tableprefix-siteconfig` 
				(`value`, `vartype`, `describe`, `systemparamname`, `formmaxlegth`, `varpossible`, `showtositeadmin`, `example`, `depend`, `maybeempty`, `module_id`, `company_id`) 
				VALUES 
				('$new_var_value', '$new_vartype', '$new_var_describe', '$new_var_systemparamname', '$new_var_formmaxlegth', '$new_var_varpossible', '$new_var_showtositeadmin', '$new_var_example', '$new_var_depend', '$new_var_maybeempty', '$new_var_module_id', '$new_var_company_id');");
				
				$status="ok";
				$showmessage="Параметр успешно добавлен";
			}
			
			$aRes = array('status' => "$status", 'message' => "$showmessage");
			echo json_encode($aRes);
		}
		else{echo "Неизвестный тип действия (action unknown)";}
	}
} ?>