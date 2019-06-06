<?
/*****************************************************************************************************************************
  * Snippet Name : adminpanel-siteconfig_creator.php																		 * 
  * Scripted By  : RomanyukAlex		           																				 * 
  * Website      : http://popwebstudio.ru	   																				 * 
  * Email        : admin@popwebstudio.ru    					 														     * 
  * License      : License on popwebstudio.ru	from autor		 															 *
  * Purpose 	 : Предназначено для добавления новых параметров в конфиг платформы (site-config.php)	 					 *
  * Insert		 : include_once('adminpanel-siteconfig_creator.php');														 *
  ***************************************************************************************************************************/ 
$log->LogInfo('Got '.(__FILE__));
  if($adminpanel==1){
insert_function("add_to_end_of_file");

/*$file1="siteconfig.php"; // дб 777
$correct_return = "\r\n";
function add1($paramname,$paramvalue){
	global $newvarID;
	$data="$".$paramname."[".$newvarID."]=".'"'.$paramvalue.'";'."\r\n";
	return $data;
	}*/
if ($_POST['new_var_describe'])
	{ # Пришел новый параметр
	$new_var_describe=substr($_POST['new_var_describe'],0,300);
	$new_vartype=substr($_POST['new_vartype'],0,10);
	$new_var_value=substr($_POST['new_var_value'],0,500);
	$new_var_value_variants=substr($_POST['new_var_value_variants'],0,1500);
	$new_var_formmaxlegth=substr($_POST['new_var_formmaxlegth'],0,5);
	$new_var_system_param_name=substr($_POST['new_var_system-param-name'],0,30);
	//$new_var_system_param_describe=substr($_POST['new_var_system-param-describe'],0,100);
	$new_var_depend=substr($_POST['new_var_depend'],0,16);
	$new_var_ShowToSiteAdmin= substr($_POST['new_var_ShowToSiteAdmin'],0,10);
	$new_var_maybeempty= substr($_POST['new_var_maybeempty'],0,1);
	
	$new_var_id=substr($_POST['new_var_id'],0,4);
	//$new_var_formsize=substr($_POST['new_var_formsize'],0,4);
	$new_var_example=substr($_POST['new_var_example'],0,500);
	//Отрежем пробелы
	$new_var_describe=trim($new_var_describe);
	$new_vartype=trim($new_vartype);
	$new_var_value=trim($new_var_value);
	$new_var_value_variants=trim($new_var_value_variants);
	$new_var_formmaxlegth=trim($new_var_formmaxlegth);
	$new_var_system_param_name=trim($new_var_system_param_name);
	//$new_var_system_param_describe=trim($new_var_system_param_describe);
	$new_var_depend=trim($new_var_depend);
	$new_var_ShowToSiteAdmin=trim($new_var_ShowToSiteAdmin);
	$new_var_id=trim($new_var_id);
	//$new_var_formsize=trim($new_var_formsize);
	$new_var_example=trim($new_var_example);
	//Проверка полученного:
	/// Все ли данные передались/передали?
	$errfield="";$err=0;
	if (empty($new_var_value) or empty($new_var_system_param_name)) 
		{/*Если чтото из них пустое - это не все поля заполнил юзер или ошибка на сети или хакер. */
	 	$err=1;
		$showmessage="Не все обязательные поля заполнены.<br>";
		}
	else{$new_var_value= str_replace ("\n","<br>",$new_var_value);// Заменили энтеры на <br>
		$new_var_example= str_replace ("\n","<br>",$new_var_example);// Заменили энтеры на <br>
		}
	if (!$err)
		{
		# Номер переменной
		if(!$new_var_id){$newvarID=count($var); /* или ++*/}
		else{$newvarID=$new_var_id;}
		# Формируем данные для вставки в siteconfig
		$data1=add1("var",$new_var_value);
		$data1.=add1("vartype",$new_vartype);
		$data1.=add1("describe",$new_var_describe);
		if ($new_vartype=="select"){$data1.=add1("varpossible",$new_var_value_variants);}
		elseif($new_vartype=="input"){$data1.=add1("formmaxlegth",$new_var_formmaxlegth);}
		if(!$new_var_example){$new_var_example=$new_var_value;}
		$data1.=add1("example",$new_var_example);
		if($new_var_ShowToSiteAdmin=="no"){$data1.=add1("ShowToSiteAdmin",$new_var_ShowToSiteAdmin);}
		if($new_var_maybeempty=="y" and $new_vartype=="input"){$data1.=add1("maybeempty",$new_var_maybeempty);}
		$data1.=add1("depend",$new_var_depend);
		$data1.=add1("systemparamname",$new_var_system_param_name);
		# Отправляем в siteconfig
		if (add_to_end_of_file($data1, $file1)){$showmessage="Добавлено успешно в $file1.<br>";$messagecolor="green";}
		else {$showmessage="В файл $file1 не записано!<br>";$messagecolor="red";}
		}	
	}// Закрыли 'Пришел новый параметр'
if ($showmessage){echo "<span style='color:".$messagecolor."'".$showmessage."</span><br>";}
?>
<form>
<table class="settings_table">

<tr class="gradient_to_top_green">
<th width="25%">Свойство</th>
<th width="60%">Значение</th>
<th width="15%">Обязательность заполнения</th>
</tr>
<tr><td class="barrel-rounded">
<label>Описание параметра</label></td><td class="heavy-rounded"><input type="text" name="new_var_describe" size="<?=$formsize_standart?>"></td><td><img src="/adminpanel/pics/required_param.jpg"></td></tr>
<tr><td class="barrel-rounded"><label>Тип параметра</label></td><td class="heavy-rounded"><select name="new_vartype"><option value="input">Input</option><option value="select">Select</option><option value="color">Color</option></select></td><td><img src="/adminpanel/pics/required_param.jpg"></td></tr>
<tr><td class="barrel-rounded"><label>Значение параметра*</label></td><td class="heavy-rounded"><input type="text" name="new_var_value" title="Если тип input, пишем что угодно. Если color, то пишем цвет в формате '#f7f2e6'" size="<?=$formsize_standart?>"></td><td><img src="/adminpanel/pics/required_param.jpg"></td></tr>
<tr><td class="barrel-rounded"><label>Варианты значений параметра*</label></td><td class="heavy-rounded"><input type="text" name="new_var_value_variants" title="Указывается, если тип select, перечисляем значения через ';;'" size="<?=$formsize_standart?>"></td><td><img src="/adminpanel/pics/required_param.jpg"></td></tr>
<tr><td class="barrel-rounded"><label>Максим количество символов</label></td><td class="heavy-rounded"><input type="text" name="new_var_formmaxlegth" title="Указывается для input. Для select будет считать количество, исходя из вариантов выборки" size="<?=$formsize_standart?>"></td><td><img src="/adminpanel/pics/required_param.jpg"></td></tr>
<tr><td class="barrel-rounded"><label>Как будет называться переменная в API</label></td><td class="heavy-rounded"><input type="text" name="new_var_system-param-name" size="<?=$formsize_standart?>"></td><td><img src="/adminpanel/pics/required_param.jpg"></td></tr>
<tr><td>
<!--<label>Описание переменной в API*</label></td><td class="heavy-rounded"><input type="text" name="new_var_system-param-describe"></td><td><img src="/adminpanel/pics/required_param.jpg"></td></tr><tr><td>-->
<label>Относится к</label></td><td class="heavy-rounded"><select name="new_var_depend"><option value="design">Design</option><option value="user">User parameters</option><option value="system">System</option><option value="SEO">SEO</option><option value="other" selected>Other</option></select></td><td><img src="/adminpanel/pics/required_param.jpg"></td></tr>
<tr><td class="barrel-rounded"><label>Показывать админу сайта</label></td><td class="heavy-rounded"><select name="new_var_ShowToSiteAdmin"><option value="y">Показывать</option><option value="no">Не показывать</option></select></td><td><img src="/adminpanel/pics/required_param.jpg"></td></tr>
<tr><td class="barrel-rounded"><label>Может быть пустым?</label></td><td class="heavy-rounded"><select name="new_var_maybeempty"><option value="y">Может</option><option value="n">Не может</option></select></td><td><img src="/adminpanel/pics/required_param.jpg"></td></tr>
<tr><td><label>Номер параметра</label></td><td class="heavy-rounded"><input type="text" name="new_var_id"  size="<?=$formsize_standart?>"></td><td><img src="/adminpanel/pics/non_required_param.jpg"></td></tr>
<tr><td class="barrel-rounded">
<!--<label>Размер size для формы в админке</label></td><td class="heavy-rounded"><input type="text" name="new_var_formsize">-->
<label>Пример</label></td><td class="heavy-rounded"><input type="text" name="new_var_example" title="Если не указать явно, то будет равно 'Значению параметра'" size="<?=$formsize_standart?>"></td><td><img src="/adminpanel/pics/non_required_param.jpg"></td></tr>
<tr><td></td><td>
</td><td><a href="/" class="large button orange light-rounded" onclick="">Создать новый параметр системы</a>
</td></tr></table>
</form>
<? }?>