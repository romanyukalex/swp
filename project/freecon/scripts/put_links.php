<? 
#Заменяет слова в тексте $textForLinks ссылками из словарей и выдаёт результат в виде переменной $textWithLinks



if($nitka=="1"){
	//$textForLinks=file_get_contents ($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/pages/html/lyubov-bolezn-mkb-10');
	//echo $textForLinks;
	#разбиваем текст на слова
	
	$text_arr=explode(" ",$textForLinks);
	
	
	#Открываем словари для замены слова в массив
	
	#Ценности человека
	if(!$repDict_arr) $repDict_arr=file($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/files/human_values.txt');
	
	foreach($repDict_arr as $key=>$value) {
		$value = str_replace(array("\r\n", "\n", "\r"), '', $value);
		$repDict_arr1[mb_strtolower($value)]=$key;
		
	}
	
//	echo "Razm - ".count($repDict_arr1);
	
	foreach($text_arr as $word_in_text){
		//Обрезаем слово
		$newstr = preg_replace('/[^\p{Cyrillic}\p{Latin}]/ui', '', $word_in_text);
		if($newstr){
			
			//echo "Check ".$newstr."<br>";
			if($repDict_arr1[mb_strtolower($newstr)] and !in_array(mb_strtolower($newstr),$putted_words_arr)){ //Слово есть в массиве ключевиков и еще не вставлялась ссылка
				$putted_words_arr[] = mb_strtolower($newstr); //Всовываем слово в массив уже добавленных слов-ссылок, чтобы не было повторов
				$word_in_text="<a class='link_search' rel='$newstr' href='/?page=search&search_string=".$newstr."'>".$word_in_text."</a>";
			}
		}
		$textWithLinks.= $word_in_text.' ';
		
	}
	
	#Определения
	if(!$pedia_artcl_q) $pedia_artcl_q=mysql_query("SELECT `code_ru` FROM `freecon-pedia-artcl` WHERE `code_ru` NOT LIKE '%[0123456789]%';"); //Не содержащие дат определения
	else mysql_data_seek($pedia_artcl_q,0); //Данные уже выгружали, надо просто перемотать значение
	
	insert_function("string_replace_nth");
	insert_function("string_ucfirst");
	
	while($pedia_artcl=mysql_fetch_assoc($pedia_artcl_q)){ //Перебираем термины
		
		$textWithLinks_prev=$textWithLinks;//Сохранили текущее состояние
		if(strlen($pedia_artcl['code_ru'])>6 and !in_array(mb_strtolower($pedia_artcl['code_ru']),$putted_words_arr)) {
			
			$putted_words_arr[] = mb_strtolower($pedia_artcl['code_ru']); //Всовываем слово в массив уже добавленных слов-ссылок, чтобы не было повторов
			
			$textWithLinks=string_replace_nth(" ".mb_strtolower($pedia_artcl['code_ru'])." ", " <a class='link_pedia' rel='".$pedia_artcl['code_ru']."' href='/?page=pedia&search_string=".mb_strtolower($pedia_artcl['code_ru'])."'>".mb_strtolower($pedia_artcl['code_ru'])."</a> ", $textWithLinks, 1);
			
			//Проверяем, заменили ли чего
			if($textWithLinks==$textWithLinks_prev){ //Ничего не поменялось, можно попробовать с большой буквой
				$textWithLinks=string_replace_nth(string_ucfirst(mb_strtolower($pedia_artcl['code_ru']))." ", "<a class='link_pedia' rel='".$pedia_artcl['code_ru']."' href='/?page=pedia&search_string=".mb_strtolower($pedia_artcl['code_ru'])."'>".string_ucfirst(mb_strtolower($pedia_artcl['code_ru']))."</a> ", $textWithLinks, 1);
			}

		}

	}
	
	
	#Список ключевиков, тегов и тп
	if (!$tagDict_arr) $tagDict_arr=file($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/files/tags.txt');
	
	foreach($tagDict_arr as $value) {
		$value = str_replace(array("\r\n", "\n", "\r"), '', $value);

		$textWithLinks_prev=$textWithLinks;//Сохранили текущее состояние
		if($value and !in_array(mb_strtolower($value),$putted_words_arr)) {
			
			$putted_words_arr[] = mb_strtolower($value); //Всовываем слово в массив уже добавленных слов-ссылок, чтобы не было повторов
			
			$textWithLinks=string_replace_nth(" ".mb_strtolower($value)." ", " <a class='link_search' rel='".mb_strtolower($value)."'  href='/?page=search&search_string=".mb_strtolower($value)."'>".mb_strtolower($value)."</a> ", $textWithLinks, 1);
			
			//Проверяем, заменили ли чего
			if($textWithLinks==$textWithLinks_prev){ //Ничего не поменялось, можно попробовать с большой буквой
				$textWithLinks=string_replace_nth(string_ucfirst(mb_strtolower($value))." ", "<a class='link_search' rel='".mb_strtolower($value)."' href='/?page=search&search_string=".mb_strtolower($value)."'>".string_ucfirst(mb_strtolower($value))."</a> ", $textWithLinks, 1);
			}

		}
		
	}
	
	unset($textForLinks);
}