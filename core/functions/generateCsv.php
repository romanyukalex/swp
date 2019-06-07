<? #  функция для генерации CSV-файла из массива PHP. Функция принимает 3 параметра: данные, разделители полей CSV (по умолчанию это запятая) и ограничители полей CSV (по умолчанию - двойные кавычки)

function generateCsv($data, $delimiter = ',', $enclosure = '"',$file) {
	//global $log;
   $handle = fopen($file, 'r+');
   foreach ($data as $line) {
		   fputcsv($handle, $line, $delimiter, $enclosure);
   }
   rewind($handle);
   while (!feof($handle)) {
		   $contents .= fread($handle, 8192);
   }
   fclose($handle);
   return $contents;
}