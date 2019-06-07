<? # Return array with Base of words 
if ($nitka=="1"){
	
	
	if(strstr($param[2],"@")){$words=explode("@", $param[2]);}
	elseif(is_array($param[2])){$words = $param[2];
	//echo "!!";
	//var_dump($param[2]);
	}
	else {$words = array($param[2],$param[3],$param[4],$param[5],$param[6],$param[7],$param[8],$param[9],$param[10],$param[11]);}
	
	
	
	foreach($words as $wordnum=>$word){ // Убиваем пустые элементы
		if(empty($word)){unset($words[$wordnum]);}
		else{# В большие буквы (надо для phpmorphy)
			$words[$wordnum]=mb_strtoupper($word,'UTF-8');
		}
	}

	# Массив с языком слов. Выясняем, чтобы выбрать словарь(и) для запуска

	if(count($words)>1){$allwords=implode ( "@" , $words);}
	else $allwords=$words[0];
	$langs=insert_module("Language_Auto_Detect",$allwords);
	
	foreach($langs as $word=>$lang){
		if($lang=="en"){$lang_iso="en_EN";} elseif($lang=="ru"){$lang_iso = 'ru_RU';} else $lang_iso = 'ru_RU';
		if(!$lad_lang_obj[$lang]){//Запускаем объект для этого языка
			try {$morphy[$lang] = new phpMorphy($dir, $lang_iso, $opts);// Create phpMorphy instance
			} catch(phpMorphy_Exception $e) {echo $e;}
			$lad_lang_obj[$lang]=1;
		}
	}

//	var_dump($words);
//	var_dump($langs);
	try {
		foreach($words as $word) {
			$log->LogDebug("Start of word processing (".$word.")");
			$gg=0;
			// by default, phpMorphy finds $word in dictionary and when nothig found, try to predict them
			// you can change this behaviour, via second argument to getXXX or findWord methods
			if($word=="@") continue;
			$base = $morphy[$langs[$word]]->getBaseForm($word);
			$is_predicted = $morphy[$langs[$word]]->isLastPredicted(); // or $morphy->getLastPredictionType() == phpMorphy::PREDICT_BY_NONE
			$is_predicted_by_db = $morphy[$langs[$word]]->getLastPredictionType() == phpMorphy::PREDICT_BY_DB;
			$is_predicted_by_suffix = $morphy[$langs[$word]]->getLastPredictionType() == phpMorphy::PREDICT_BY_SUFFIX;
			//$all = $morphy->getAllForms($word);
			$part_of_speech = $morphy[$langs[$word]]->getPartOfSpeech($word);
			
			//$log->LogDebug("place1");
			
			// this used for deep analysis
			$collection = $morphy[$langs[$word]]->findWord($word);
			//var_dump($morphy[$langs[$word]]->getAllFormsWithGramInfo($word)); //for debug

			//$log->LogDebug("place2");
			
			if(false === $collection) { //echo $word, " NOT FOUND<br>";
				$return_data[$word][$gg]=$word;
				continue;
			} 
			//$log->LogDebug("place3");
			foreach($collection as $paradigm) {
				$return_data[$word][$gg]=$paradigm[0]->getWord();
				$gg++;
			}
			//$log->LogDebug("place4");
			
			$return_data[$word] = array_unique($return_data[$word]);
			$log->LogDebug("End of word processing (".$word.")");
		}
		
	} catch(phpMorphy_Exception $e) {
		//die('Error occured while text processing: ' . $e->getMessage());
		$log->LogError('Error occured while text processing: ' . $e->getMessage());
	}
	$log->LogDebug("End of words processing");
}