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
  * if its needed to return some data just add $return_data		*
  * $word_Bases=insert_module("search_morph","get_Base",$some_array);
  * $word_Bases=insert_module("search_morph","get_Base","сияешь","стали","колоть","сталеварил","all","fdfsd","замок"); 
  \*************************************************************/
$log->LogInfo('Got this file with params - '.implode(',',$param));
if($nitka=='1'){
	insert_function('process_user_data');
	// Перенести это в insert_module и ajaxapi
	if(isset($param[1])) $contact=$param[1]; // Вызвали как модуль
	elseif(isset($_REQUEST['action'])) $contact=process_data($_REQUEST['action'],30);
	
	if(!isset($contact)){$contact=$default_action;}
	$log->LogDebug('Action is '.$contact);
	
	
	
	require_once(dirname(__FILE__) . '/phpmorphy/src/common.php');// first we include phpmorphy library
	$opts = array(
		// storage type, follow types supported
		// PHPMORPHY_STORAGE_FILE - use file operations(fread, fseek) for dictionary access, this is very slow...
		// PHPMORPHY_STORAGE_SHM - load dictionary in shared memory(using shmop php extension), this is preferred mode
		// PHPMORPHY_STORAGE_MEM - load dict to memory each time when phpMorphy intialized, this useful when shmop ext. not activated. Speed same as for PHPMORPHY_STORAGE_SHM type
		'storage' => PHPMORPHY_STORAGE_FILE,
		// Enable prediction by suffix
		'predict_by_suffix' => true, 
		// Enable prediction by prefix
		'predict_by_db' => true,
		// TODO: comment this
		'graminfo_as_text' => true,
	);
	$dir = dirname(__FILE__) . '/phpmorphy/dicts';// Path to directory where dictionaries located


	// All words in dictionary in UPPER CASE, so don`t forget set proper locale via setlocale(...) call
	// $morphy->getEncoding() returns dictionary encoding
	
	
	
	
	
	
	if ($contact=='form'){# Страничка с продуктом
	
		include($_SERVER["DOCUMENT_ROOT"]."/project/" .$projectname. '/modules_data/'.$modulename.".".$param[2].'.php');
		?><script>
	$( ".<?=$modulename?>_search_button" ).click(function() {
		submit_search();
	});
	$( ".<?=$modulename?>_search_button" ).submit(function() {
		submit_search();
	});
	function submit_search(){
		saveform2('','<?=$modulename?>_form',"<?=$param[3]?>","<?=$modulename?>","find_it",'resetform','');
		softblockshow("content1","content");
		set_title("Результаты поиска");
	}
	</script>
	<?
	}
	elseif($contact=='build_index'){ #Построить индекс
		include(dirname(__FILE__) . '/action.build_index.php');
		$return_data=$return_var;
	}
	elseif($contact=='get_Base' or $contact=='get_Base_inArray' or $contact=='get_partOfSpeech'){ #Получить данные о слове
		include(dirname(__FILE__) . '/action.get_Base.php');
	}
}
?>