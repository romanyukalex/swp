<?php
 /**************************************************************************************\
  * Snippet Name : получить ассоциации к словам					 						*
  * Part		 : button (view)														*
  * Scripted By  : RomanyukAlex		           					 						*
  * Website      : http://popwebstudio.ru	   					 						*
  * Email        : admin@popwebstudio.ru     					 						*
  * License      : GPL (General Public License)					 						*
  * Purpose 	 : pay something								 						*
  * Access		 : 																		*
  *																						*
  * на входе $phrase, на выходе	$fin_assoc_arr											*
  * include($_SERVER['DOCUMENT_ROOT'].'/project/freecon/scripts/get_associative.php');  *
  \*************************************************************************************/
$log->LogDebug('Got this file');
if ($nitka=='1'){

#СТОП СЛОВА, которых не должно быть в результатах (ни о чём)
$assoc_stop_words=array('человек',
'меня', 'мне', 'меня', 'мной','тебя', 'тебе', 'тобой','его', 'ему', 'его', 'им','её', 'ей', 'нём'
);
#Предлоги, местоимения и знаки препинания(для удаления из поиска)
$prepositions=array('в','без','с','на','под','по','в','через','после','о','для','и','за','из','к',
'если','как','кто', 'что','почему','какой','каков','чей','который','сколько','такое','эти','те','такие','таковы','сии','любой','каждый','другой','другие'
);
$punctuation=array('?','!',',','.','-','"',"'",'!!!','?!',';',':');

unset($fin_assoc_arr,$assoc_array_o,$ph_words_formtd,$base_word_array,$pwr_assoc_arr);

$ph_words=explode(" ",$phrase); #Разбиваем фразу на слова

//echo $phrase;
//Удаляем точки, тире
foreach($ph_words as $word){
	//if($word!=="?" and $word!=="!" and $word!=="," and $word!=="." and $word!=="-" and $word!=="\"" and $word!=="'" and $word!=="без" and $word!=="с" and $word!=="на" and $word!=="по" and $word!=="в" and $word!=="под" and $word!=="через" and $word!=="если" and $word!=="как" and $word!=="после" and $word!=="о" and $word!=="для"and $word!=="и"){//Кандидат на оставление в списке поиска ассоциаций
	//if(!in_array($word,$prepositions) and !in_array($word,$punctuation)){
		#Форматируем
		$fsymb=mb_substr($word,0,1);
		if(in_array($fsymb,$punctuation)) { //Отрезаем первый символ
			$word=mb_substr($word,1);
		}
		$lsymb=mb_substr($word,-1);
		if(in_array($lsymb,$punctuation)) { //Отрезаем последний символ
			$word=mb_substr($word,0,-1);
		}
		#Отрезаем все, что в списке стоп слов
		if(!in_array($word,$prepositions) and !in_array($word,$punctuation)){
			$ph_words_formtd[]=$word;
		}
	//}
}

#Удалим предлоги (дописать)
//$word_partOfSpeech=insert_module("search_morph","get_partOfSpeech",$ph_words_formtd);


$word_Bases=insert_module("search_morph","get_Base",$ph_words_formtd);

var_dump($word_Bases);

foreach($word_Bases as $word=>$base_word_arr){
	
	foreach($base_word_arr as $key=>$base_word){
		$assoc_arr=insert_module("search_associative","get_assoc",$base_word,array('isSafe'=>0,'gender'=>'no','weight_limit'=>'0.4'));
		//общий массив слов
		$assoc_array_o[]=$base_word;
		if($assoc_arr) $assoc_array_o=array_merge($assoc_array_o,$assoc_arr);
		//массив оригиналов
		$base_word_array[]=mb_strtolower($base_word);
	}

}
echo "Base word array -";print_r($base_word_array);echo "<hr>";

echo "Assoc array -";print_r($assoc_array_o);echo "<hr>";

#Находим повторные слова - самые сильные ассоциации
$arr_word_cnt= array_count_values($assoc_array_o);
//print_r($arr_word_cnt);
foreach($arr_word_cnt as $word=>$wrd_count){
	if($wrd_count>1){ //пишем это слово в финальный шорт-лист ассоциаций
		$pwr_assoc_arr[]=$word;
	}
}

//Сливаем массив сильных ассоциаций с оригинальными словами
$pwr_assoc_arr=array_merge($pwr_assoc_arr,$base_word_array);
echo "POWER до фильтра -";print_r($pwr_assoc_arr);echo "<hr>";
$pwr_assoc_arr = array_diff($pwr_assoc_arr,$assoc_stop_words);
echo "POWER-";print_r($pwr_assoc_arr);echo "<hr>";
#Если мало сильных ассоциаций, то добавляем в шорт лист слов из простых ассоциаций с наибольшим ассоциативным весом
if(count($pwr_assoc_arr)<10){
	//echo "НАДО ЕЩЕ слов";
	foreach($word_Bases as $word=>$base_word_arr){	
		foreach($base_word_arr as $key=>$base_word){
		
			$assoc_arr=insert_module("search_associative","get_assoc",$base_word,array('isSafe'=>0,'gender'=>'no','weight_limit'=>'0.8'));
			//echo "АССОЦ >0.8 на ".$base_word;print_r ($assoc_arr);echo "<br>при этом общий ассоц08 - ";print_r($smpl_assoc_arr);
			
			if($assoc_arr and $smpl_assoc_arr) $smpl_assoc_arr=array_merge($smpl_assoc_arr,$assoc_arr);
			elseif($assoc_arr)$smpl_assoc_arr=$assoc_arr;
			//echo "<br>после слияния этих двух - ";print_r($smpl_assoc_arr);echo "<hr>";
		}
	}
}

#Слияние всех найденных ключевиков
if($smpl_assoc_arr) $fin_assoc_arr=array_merge($pwr_assoc_arr,$smpl_assoc_arr);
else $fin_assoc_arr=$pwr_assoc_arr;

#Удаляем повторные элементы, если затесались

$fin_assoc_arr=array_unique($fin_assoc_arr);

#Удаляем слова из стоп-листа
$fin_assoc_arr = array_diff($fin_assoc_arr,$assoc_stop_words);
}?>