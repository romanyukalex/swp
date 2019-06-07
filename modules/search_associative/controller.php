<?php
 /**************************************************************\
  * Modulename	: modulename				 					* 
  * Part		: controller									*
  * Scripted By	: RomanyukAlex		           					* 
  * Website		: http://popwebstudio.ru	   					* 
  * Email		: admin@popwebstudio.ru     					* 
  * License		: GPL (General Public License)					* 
  * Purpose		: control all operations						*
  * Access		: include									 	*
  * if its needed to return some data just add $return_data																			*
  * insert_module("search_associative","get_assoc","word",array('isSafe'=>0,'gender'=>'no'))										*
  * gender - no, male, female																										*
  * $assoc_arr=insert_module("search_associative","get_assoc",$base_word,array('isSafe'=>1,'gender'=>'no','weight_limit'=>'0.5'));	*
  \*************************************************************/
$log->LogInfo('Got this file with params - '.implode(',',$param));
if($nitka=='1'){
	insert_function('process_user_data');
	// Перенести это в insert_module и ajaxapi
	if(isset($param[1])) $contact=$param[1]; // Вызвали как модуль
	elseif(isset($_REQUEST['action'])) $contact=process_data($_REQUEST['action'],30);
	
	if(!isset($contact)){$contact=$default_action;}
	$log->LogDebug('Action is '.$contact);
	
	if ($contact=='get_assoc'){# Страничка с продуктом
	
		$search_word=$param[2];
		$isSafe=$param[3]['isSafe'];
		$gender=$param[3]['gender'];
		if ($param[3]['weight_limit']) $weight_limit=$param[3]['weight_limit']; else $weight_limit=0;
		if($param[3]['return']) $what_return=$param[3]['return']; else $what_return='only_words';
		
		#Запрос ассоциаций
		if($isSafe==1) $assoc_q_safe=" and `is_safe`='1'";
		$assoc_q=mysql_query("SELECT * FROM `$tableprefix-associative-main` WHERE `word`='$search_word' $assoc_q_safe;");
		
		while($assoc=mysql_fetch_assoc($assoc_q)){
			if ((!$weight_limit or $weight_limit<$assoc['weight']) and $assoc['assoc']) { #Надо вернуть этот результат
				if($what_return=="only_words") $return_data[]=$assoc['assoc'];
				elseif ($what_return=="words_weights") $return_data[$search_word][$assoc['weight']]=$assoc['assoc'];
			}
		}
		$return_data = array_diff($return_data, array(''));
		//$return_data=$assoc_arr;
		/*
		if($gender=="male" or $gender=="female") {$fname=dirname(__FILE__).'/assoc_gender.csv';}
		else $fname=dirname(__FILE__).'/assoc.csv';
		
		if (!file_exists($fname))$log->LogError('File is not exist - '.$fname);
		
		
		$fp = fopen ($fname, 'r');
		$buffer = fread($fp, filesize($fname));
		fclose ($fp);
		$prev = 0;
		$i=0;
		$p=array();
		while ($next = mb_strpos($buffer,"\n",$prev+1))
		{
			$i++;
			$a = mb_substr($buffer, $prev+1, $next-$prev);
			preg_match_all("/n*?$search_word.*?\\n/im",$text,$p);
			//preg_match_all("/.*?$search_word.*?\\./im",$a,$p[]);
			$prev = $next;
		}
		
		echo $i."<br>RESULT - ";
		var_dump($p);
		*/
		//$return_data='';
	}
}
?>