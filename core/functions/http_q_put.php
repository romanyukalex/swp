<? # Функция делает PUT реквест. DELETE тоже также делается
/*
Вызывается:
if(doPut('http://example.com/api/a/b/c', array('foo' => 'bar')) == 200) 
   // do something 
else 
   // do something else. 
?> 

You can grab the request data on the other side with: 

<?php 
if($_SERVER['REQUEST_METHOD'] == 'PUT') 
{ 
   parse_str(file_get_contents('php://input'), $requestData); 

   // Array ( [foo] => bar ) 
   print_r($requestData); 

   // Do something with data... 
} 
?> 
*/

function http_q_put($url, $fields) 
{ 
   $fields = (is_array($fields)) ? http_build_query($fields) : $fields; 

   if($ch = curl_init($url)) 
   { 
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT'); 
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Length: ' . strlen($fields))); 
      curl_setopt($ch, CURLOPT_POSTFIELDS, $fields); 
      curl_exec($ch); 

      $status = curl_getinfo($ch, CURLINFO_HTTP_CODE); 

      curl_close($ch); 

      return (int) $status; 
   } 
   else 
   { 
      return false; 
   } 
} 