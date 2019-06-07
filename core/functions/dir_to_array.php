<? # Функция получает массив из всех файлов в папке с подкаталогами
/*
Вызывается:
dir_to_array($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname);
*/
//$log->LogInfo('Got this file');

function dir_to_array($dir) { 
	
   //global $log;
	//$log->LogDebug('Called '.(__FUNCTION__).' function with params: '.implode(',',func_get_args()));
   $result = array(); 
   $cdir = scandir($dir); 
   foreach ($cdir as $key => $value) 
   { 
		if (!in_array($value,array(".",".."))) { 
			if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) 
			{ 
				$result[$value] = dir_to_array($dir . DIRECTORY_SEPARATOR . $value); 
			} 
			else 
				{ 
					$result[] = $value; 
				} 
		 
      } 
   } 
   
   return $result; 
} ?>