<? # Проверка строки, JSON ли
	
function isJSON($string) {
    return ((is_string($string) && (is_object(json_decode($string)) || is_array(json_decode($string))))) ? true : false;	
}

// Дописать логирование
/*
$str = '{
   "firstName": "Sergey",
   "lastName": "Sauron918",
   "address": {
       "streetAddress": "Киевская 1",
       "city": "Киев",
       "postalCode": 10001
   },
   "phoneNumbers": [
       "097 111-1234",
       "067 123-7654"
   ]
}';

if(isJSON($str)) echo "Valid!";
*/
?>
