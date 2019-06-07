<?
if ($nitka=="1"){

$lang = 'ru_RU';

try {
    $morphy = new phpMorphy($dir, $lang, $opts);// Create phpMorphy instance
} catch(phpMorphy_Exception $e) {
    die('Error occured while creating phpMorphy instance: ' . PHP_EOL . $e);
}



	$words = array('КРАКОЗЯБЛИКИ', 'СТАЛИ', 'ВИНА', 'И', 'ДУХИ', 'abc');
	/*
	if(function_exists('iconv')) {
		foreach($words as &$word) {
		   // $word = iconv('windows-1251', $morphy->getEncoding(), $word);
		}
		unset($word);
	}*/

	try {
		foreach($words as $word) {
			// by default, phpMorphy finds $word in dictionary and when nothig found, try to predict them
			// you can change this behaviour, via second argument to getXXX or findWord methods
			$base = $morphy->getBaseForm($word);
			$all = $morphy->getAllForms($word);
			$part_of_speech = $morphy->getPartOfSpeech($word);      

			// $base = $morphy->getBaseForm($word, phpMorphy::NORMAL); // normal behaviour
			// $base = $morphy->getBaseForm($word, phpMorphy::IGNORE_PREDICT); // don`t use prediction
			// $base = $morphy->getBaseForm($word, phpMorphy::ONLY_PREDICT); // always predict word

			$is_predicted = $morphy->isLastPredicted(); // or $morphy->getLastPredictionType() == phpMorphy::PREDICT_BY_NONE
			$is_predicted_by_db = $morphy->getLastPredictionType() == phpMorphy::PREDICT_BY_DB;
			$is_predicted_by_suffix = $morphy->getLastPredictionType() == phpMorphy::PREDICT_BY_SUFFIX;

			// this used for deep analysis
			$collection = $morphy->findWord($word);
			//var_dump($morphy->getAllFormsWithGramInfo($word)); //for debug

			if(false === $collection) { 
				echo $word, " NOT FOUND<br>";
				continue;
			} else {
			}

			echo $is_predicted ? '-' : '+', "Рассматриваемое слово - ".$word, "<br>";
			echo 'Варианты: ', implode(', ', $base), "<br>";
			echo 'Всё: ', implode(', ', $all), "<br>";
			echo 'Часть речи: ', implode(', ', $part_of_speech), "<br>";
			
			echo "<br>";
			// $collection collection of paradigm for given word

			// TODO: $collection->getByPartOfSpeech(...);
			foreach($collection as $paradigm) {
				// TODO: $paradigm->getBaseForm();
				// TODO: $paradigm->getAllForms();
				// TODO: $paradigm->hasGrammems(array('', ''));
				// TODO: $paradigm->getWordFormsByGrammems(array('', ''));
				// TODO: $paradigm->hasPartOfSpeech('');
				// TODO: $paradigm->getWordFormsByPartOfSpeech('');

				
				echo "Вариант: ", $paradigm[0]->getWord(), "<br>";
				foreach($paradigm->getFoundWordForm() as $found_word_form) {
					echo
						$found_word_form->getWord(), ' ',
						//$found_word_form->getFormNo(),' ',
						$found_word_form->getPartOfSpeech(), ' ',
						'(', implode(', ', $found_word_form->getGrammems()), ')',
						"<br>";
				}
				echo "<br>";
				/*
				foreach($paradigm as $word_form) {
					 TODO: $word_form->getWord();
					 TODO: $word_form->getFormNo();
					 TODO: $word_form->getGrammems();
					 TODO: $word_form->getPartOfSpeech();
					 TODO: $word_form->hasGrammems(array('', ''));
				}*/
			}

			//echo "Конец обработки слова ".$word."<br><br><hr><br>";
			$log->LogInfo(basename (__FILE__)." | End of word processing (".$word.")");
		}
	} catch(phpMorphy_Exception $e) {
		die('Error occured while text processing: ' . $e->getMessage());
	}
}