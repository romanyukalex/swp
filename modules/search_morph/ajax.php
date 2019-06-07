<?php
/****************************************************************
 * Snippet Name : search_morph (ajax part) 					* 
 * Scripted By  : RomanyukAlex		           					* 
 * Website      : http://popwebstudio.ru	   					* 
 * Email        : admin@popwebstudio.ru     					* 
 * License      : GPL (General Public License)					* 
 * Purpose 	 : some ajax functions							 	*
 * Access		 : via /ajax/								 	*
 ***************************************************************/
if($nitka=="1"){
	if($requestaction=="find_it"){
		$search_text=process_data($_REQUEST['q'],200);
		# Разбиваем на слова
		$search_text_arr=explode(" ",$search_text);
		$search_text_arr_one_str=str_replace(" ", "@", $search_text);
		# Находим базовые формы слов
		$log->LogDebug("start_platform_scripts | ".(__LINE__)." | Trying to insert insert_module function");
		insert_function("insert_module");
		$log->LogDebug("start_platform_scripts | ".(__LINE__)." | Trying to check available modules");
		@require($_SERVER["DOCUMENT_ROOT"]."/core/check_avail_modules.php");
		$word_Bases=insert_module("search_morph","get_Base",$search_text_arr_one_str);
		//var_dump($word_Bases);
		$result_q_text="SELECT r.`result_id`,`weight`,`url`,`title`,`shorttext` FROM `$moduletableprefix-".$modulename."_indexing_word` w, `$moduletableprefix-".$modulename."_index` i, `$moduletableprefix-".$modulename."_results`r WHERE w.`id`=i.`word` and i.`result_id`=r.`result_id` and (";
		
		//SELECT * FROM `tscloud-search_morph_indexing_word`w,`tscloud-search_morph_index`i,`tscloud-search_morph_results`r WHERE w.`word`='КЛИКНУТЬ' and w.`id`=i.`word` and i.`result_id`=r.`result_id`
		
		
		# Ищем по каждому слову результат
		foreach ($word_Bases as $word=>$wordarr){
			foreach($wordarr as $wordBase){
				//echo $word.$wordBase;
				$result_q_text.="w.`word`='$wordBase' or ";
			}
		}
		$result_q_text=substr($result_q_text,0,-4).") ORDER BY `weight` DESC;";
		//echo "<br>Запрос:".$result_q_text."<br><br>";
		$result_q=mysql_query($result_q_text);
				
		# Если результаты часто встречаются, складываем их веса
		while($result_q_arr=mysql_fetch_array($result_q)){
			$freq_arr[]=$result_q_arr['result_id'];
		}
		$freq_index=array_count_values ($freq_arr);
		//print_r($freq_index);
		arsort($freq_index); // Отсортировали по самым часто встречающимся
		
		//echo "Индексы увеличения веса ";print_r($freq_index);
		mysql_data_seek($result_q,0);
		
		/* Логика под вопросом. Здесь наибольший вес из повторяющихся результатов умножается на количетсво результатов
		Возможно, лучше будет сделать, чтобы вес каждого результата учитывался в поиске*/
		
		while($result_q_arr=mysql_fetch_array($result_q)){
			//echo "<br>Для ".$result_q_arr['result_id']." вес = ".$result_q_arr['weight']." умножаем на ".$freq_index[$result_q_arr['result_id']]."<br>";
			if(!$result_weight[$result_q_arr['result_id']]){
				$result_weight[$result_q_arr['result_id']]=$freq_index[$result_q_arr['result_id']]*$result_q_arr['weight'];
			} else{
				if($result_weight[$result_q_arr['result_id']]/$freq_index[$result_q_arr['result_id']]<$result_q_arr['weight']){// Вес предыдущего результата меньше текущего
					$result_weight[$result_q_arr['result_id']]=$freq_index[$result_q_arr['result_id']]*$result_q_arr['weight'];
				}
			}
			//echo " Получаем ".$result_weight[$result_q_arr['result_id']]."<br>";
			//Формируем выходной массив
			$search_result_arr[$result_q_arr['result_id']] = array('url'=>$result_q_arr['url'], 'title'=>$result_q_arr['title'], 'shorttext'=>$result_q_arr['shorttext']);
		}
		
		arsort($result_weight);
		//var_dump($result_weight);echo "<br><br>";var_export($search_result_arr);
		# Выводим
		if(file_exists($_SERVER["DOCUMENT_ROOT"]."/project/".$projectname. '/modules_data/'.$modulename.'.design_results.php')){
			
			include($_SERVER["DOCUMENT_ROOT"]."/project/".$projectname. '/modules_data/'.$modulename.'.design_results.php');
		
		} else {echo $sitemessage[$modulename]["no_result_design"]."<br> /project/" .$projectname. '/modules_data/'.$modulename.'.design_results.php';}
	}
}?>