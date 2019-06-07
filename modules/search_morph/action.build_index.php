<? # 
if ($nitka=="1"){

	if($param[2]=="from_categories"){#Строим индекс по категориям поиска
		
		mysql_query("DELETE FROM `$moduletableprefix-search_morph_results` WHERE 1;");
		mysql_query("DELETE FROM `$moduletableprefix-search_morph_index` WHERE 1;");
		
		# Лезем за "местами" в places
		$index_settings_q=mysql_query("select * from `$moduletableprefix-search_morph-places` WHERE 1;");
		
		while($index_settings=mysql_fetch_array($index_settings_q)){
			echo "<hr><hr><h2><b>".$index_settings['field']." в ".$index_settings['table']."</b></h2><hr><hr>";
			
			# Проверяем, есть ли поле index_this в этой табличке, если есть, то ставим его в текст запроса
			$fieldexist_q=mysql_num_rows(mysql_query("show columns FROM `".$index_settings['table']."` where `Field` = 'index_this'")); 
			echo "Поле index_this ";
			if ($fieldexist_q==1){echo "есть в этой табличке<br>";}else{echo "не найдено<br>";}
			# Получаем все тексты из БД из указанных мест
			$index_data_q_text="select `".$index_settings['field']."`,`".$index_settings['result_id_field']."`,`".$index_settings['title_field']."` from `".$index_settings['table']."` WHERE ";
			if($fieldexist_q==1) $index_data_q_text.="`index_this`=TRUE;";
			else $index_data_q_text.="1;";
			$index_data_q=mysql_query($index_data_q_text);
			
			echo "Выбираем запросом:<br>".$index_data_q_text."<br>";
			echo "Число результатов из таблички ".$index_settings['table']." по данному месту (".$index_settings['field']."):". mysql_num_rows($index_data_q)."<br>";
			while($index_data=mysql_fetch_array($index_data_q)){
				if($index_data[$index_settings['field']]) { #Есть содержание в искомом поле
				echo "<br><hr><br>Будет индексировано поле ".$index_settings['field']." в табличке ".$index_settings['table']." : ".$index_data[$index_settings['result_id_field']]."<br>";
				# Убираем теги из текста
				$index_data[$index_settings['field']] = preg_replace('@<script[^>]*?>.*?</script>@si',' ',$index_data[$index_settings['field']]);
				$index_data[$index_settings['field']] = preg_replace('@<style[^>]*?>.*?</style>@si',' ',$index_data[$index_settings['field']]);
				$index_data[$index_settings['field']] = preg_replace('@<[/!]*?[^<>]*?>@si',' ',$index_data[$index_settings['field']]);
				$index_data[$index_settings['field']] = preg_replace('/[^a-zа-яё -]+/iu', '',$index_data[$index_settings['field']]);
				$index_data[$index_settings['field']] =  preg_replace('/ {2,}/',' ',$index_data[$index_settings['field']]); //Двойные пробелы
				
				echo "300 символов текста после обаботки:<br>".mb_substr($index_data[$index_settings['field']],0,300)."...<br><br>";
				
				
				# Пишем в таблицу результатов ссылку на результат, чтобы был result_id
				$result_url=str_replace("{RESULT_ID_FIELD}",$index_data[$index_settings['result_id_field']],$index_settings['result_link']);
				$result_title=$index_data[$index_settings['title_field']];
				$result_shorttext=substr($index_data[$index_settings['field']],0,300);
				$put_result_q=mysql_query("INSERT INTO `$moduletableprefix-search_morph_results` (`result_id` ,`url` ,`title` ,`shorttext` )VALUES (NULL , '$result_url', '$result_title', '$result_shorttext');");
				$result_id=mysql_insert_id();
				# Формируем массив слов, деля по пробелу
				$text_words=explode(" ",mb_strtolower($index_data[$index_settings['field']]));
				echo "Количество слов в тексте:".count($text_words)."<br>";
				foreach($text_words as $key => $val){#Удаляем пустые элементы
					//echo "Смотрим ".$val."<br>";
					if (empty($val) or $val=='
' or $val=='

'or $val=='
	'){
						 unset($text_words[$key]);
					}
					
					if (mb_strlen($val)<3){
						echo "Уничтожаем слово ".$val."<br>";
						unset($text_words[$key]);}
				}
				//var_export($text_words);
				
				echo "Количество слов для обработки:".count($text_words)."<br>";
				if(count($text_words)>1){$allwords=implode ( "@" , $text_words);}
				else $allwords=$text_words[0];
				# Определеяем язык этого конкретного текста (не надо, есть в get_Base)
				//$lang[$index_data[$index_settings['result_id_field']]]=insert_module("Language_Auto_Detect",$allwords);
				//if($lang[$index_data[$index_settings['result_id_field']]]=="ua"){$lang[$index_data[$index_settings['result_id_field']]]="ru";}
				//unset($allwords);
				
				# Получаем массив со словами в исходной форме
				$word_Bases=insert_module("search_morph","get_Base",$allwords);	
				//var_dump($word_Bases);
				//echo "<br><br><br>";
				
				
				foreach($word_Bases as $wordintext=>$word_base_form){
					foreach($word_base_form as $word_base_form_key=>$word_base_form_value){
						#Формируем плоский массив для подсчета частоты появления слов
						$words_bases_arr[]=$word_base_form_value;
						#Получаем ID слов в словаре indexing_word
						$words_id_arr_q=mysql_query("SELECT `id` FROM `$moduletableprefix-search_morph_indexing_word` WHERE `word`='$word_base_form_value'");
						if(mysql_num_rows($words_id_arr_q)>0){# Слово найдено в словаре indexing_word
							$words_id_arr_data=mysql_fetch_array($words_id_arr_q);
							$words_id_arr[$word_base_form_value]=$words_id_arr_data['id'];
						} else {# Слово не найдено в словаре indexing_word
							# Добавляем слово в indexing_word, получаем ID
							mysql_query("INSERT INTO `$moduletableprefix-search_morph_indexing_word` (`id`, `word`, `sound`) VALUES (NULL, '$word_base_form_value', '$word_base_form_value');");
							$words_id_arr[$word_base_form_value]=mysql_insert_id();
						}
					}
				}
				
				
				# Считаем частоту появления начальной формы слова
				$word_Bases_count_arr=array_count_values($words_bases_arr);
				
				# Пишем в базу morph_index: ID слова,  ID результата, вес = количество раз*номинальный_вес страницы
				$index_q_text="INSERT INTO `$moduletableprefix-search_morph_index` (`index_id`, `result_id`, `word`, `weight`) VALUES";
				foreach($word_Bases_count_arr as $word_Base=>$wordcount){
					$index_q_text.="(NULL, '".$result_id."', '".$words_id_arr[$word_Base]."', '".($wordcount*$index_settings['multiplier'])."'),";
				}
				$index_q_text=substr($index_q_text,0,-1).";";//Отрезали лишнюю запятую
				mysql_query($index_q_text);
				
				
				//echo $index_q_text;
				echo "Частота вхождений:<br>";
				var_export($word_Bases_count_arr);
				echo "<br><br>";
				//var_export($words_id_arr);
				
				
				
				unset($allwords,$text_words,$word_Bases,$words_bases_arr);
				
				}
			}
		}
	
	}

/*

	$index_data_q=mysql_query("select * from `$moduletableprefix-search_morph_results` WHERE 1;");
	//insert_function("postdata");
	while($index_data=mysql_fetch_array($index_data_q)){
		
		$uri=$index_data["uri"];
		
		$content = file ($uri);
		foreach($content as $line) echo $line;
		
		//echo htmlspecialchars($code);
	}*/
}