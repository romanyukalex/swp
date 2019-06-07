<? # Функция генерации случайных последовательностей
/*
Вызывается:
abracadabra(10,'human_readable');
abracadabra(8,'digits'); // Только цифры
abracadabra(5,'characters'); // Только буквы
abracadabra(7,'mix'); // Смесь букв и цифр
*/
$log->LogInfo('Got this file');
function abracadabra($strlen,$symbol_mode){ 
	global $log;
	$log->LogDebug('Called '.(__FUNCTION__).' function with params: '.implode(',',func_get_args()));
	
	if($symbol_mode!=='human_readable'){
		if($symbol_mode=='digits'){$arr = array('1','2','3','4','5','6','7','8','9','0');}
		elseif($symbol_mode=='characters'){$arr = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','r','s','t','u','v',
	'x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','R','S','T','U','V',
	'X','Y','Z');
		}
		elseif($symbol_mode=='mix'){$arr = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','r','s','t','u','v',
	'x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','R','S','T','U','V',
	'X','Y','Z','1','2','3','4','5','6','7','8','9','0');
		}
		$abracadabra='';
		if(substr(phpversion(),0,1)==5) for($i = 0; $i < $strlen; $i++){$index2 = rand(0, count($arr) - 1);$abracadabra .= $arr[$index2];}
		elseif(substr(phpversion(),0,1)==7) for($i = 0; $i < $strlen; $i++){$index2 = random_int(0, count($arr) - 1);$abracadabra .= $arr[$index2];}
	} else{
		$conso=array('b','c','d','f','g','h','j','k','l','m','n','p','r','s','t','v','w','x','y','z');
		$vocal=array('a','e','i','o','u');
		$abracadabra='';
		if(substr(phpversion(),0,1)==5) {
			for($i=1; $i<= $strlen/2; $i++){
				$abracadabra.=$conso[rand(0,19)];
				$abracadabra.=$vocal[rand(0,4)];
			}
		} elseif(substr(phpversion(),0,1)==7){
			for($i=1; $i<= $strlen/2; $i++){
				$abracadabra.=$conso[random_int(0,19)];
				$abracadabra.=$vocal[random_int(0,4)];
			}
		}
	}
	return $abracadabra;
}