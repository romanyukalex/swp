<?
 /*******************************************************
  * Snippet Name : base_domain_from_url            	    *
  * Scripted By  : php.net                              *
  * Email        : aromanuk@mail.ru             	    *
  * License      : GPL (General Public License) 	    *
  * Access		 : // RETURNS "BIT.COM"                 *
  * base_domain_from_url('http://www.ff.bit.com/?ce=ho);*
  ******************************************************/
  $log->LogInfo('Got this file');

/*
$fullstring = 'this is my [tag]dog[/tag]';
$parsed = string_getStrBetween($fullstring, '[tag]', '[/tag]');

echo $parsed; // (result = dog)  
  
*/

function string_getStrBetween($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}
  
  
  
// substr_getbykeys() - Returns everything in a source string that exists between the first occurance of each of the two key substrings
//          - only returns first match, and can be used in loops to iterate through large datasets
//          - arg 1 is the first substring to look for
//          - arg 2 is the second substring to look for
//          - arg 3 is the source string the search is performed on.
//          - arg 4 is boolean and allows you to determine if returned result should include the search keys.
//          - arg 5 is boolean and can be used to determine whether search should be case-sensative or not. (!!!!!)
//

function substr_getbykeys($key1, $key2, $source, $returnkeys, $casematters) {
    if ($casematters === true) {
        $start = strpos($source, $key1);
        $end = strpos($source, $key2);
    } else {
        $start = stripos($source, $key1);
        $end = stripos($source, $key2);
    }
    if ($start === false || $end === false) { return false; }
    if ($start > $end) {
        $temp = $start;
        $start = $end;
        $end = $temp;
    }
    if ( $returnkeys === true) {
        $length = ($end + strlen($key2)) - $start;
    } else {
        $start = $start + strlen($key1);
        $length = $end - $start;
    }
    return substr($source, $start, $length);
}

// substr_delbykeys() - Returns a copy of source string with everything between the first occurance of both key substrings removed
//          - only returns first match, and can be used in loops to iterate through large datasets
//          - arg 1 is the first key substring to look for
//          - arg 2 is the second key substring to look for
//          - arg 3 is the source string the search is performed on.
//          - arg 4 is boolean and allows you to determine if returned result should include the search keys.
//          - arg 5 is boolean and can be used to determine whether search should be case-sensative or not.
//

function substr_delbykeys($key1, $key2, $source, $returnkeys, $casematters) {
    if ($casematters === true) {
        $start = strpos($source, $key1);
        $end = strpos($source, $key2);
    } else {
        $start = stripos($source, $key1);
        $end = stripos($source, $key2);
    }
    if ($start === false || $end === false) { return false; }
    if ($start > $end) {
        $temp = $start; 
        $start = $end;
        $end = $temp;
    }
    if ( $returnkeys === true) {
        $start = $start + strlen($key1);
        $length = $end - $start;
    } else {
        $length = ($end + strlen($key2)) - $start;  
    }
    return substr_replace($source, '', $start, $length);
}
  
/* Example
$text='Поступила заработная плата 20000 USD';
$str1='Поступила заработная плата ';
$str2=' USD';

$strbtw= string_betw2str($text, $str1, $str2);
// выведет "20000"
*/
  
  
 function string_betw2str($text, $str1, $str2, $match_num=1) { //$text - ищем в тексте;$str1 и $str2 - 1 и 2 слово, между которыми ищем; $match_num - номер вхождения
  if(preg_match("/".$str1."([^".$str2."]*)/",$text,$matches)) return $matches[$match_num];
}


/*
cho GetBetween("a","c","abc"); // returns: b
echo GetBetween("h","o","hello"); // returns: ell
*/
function GetBetween($var1="",$var2="",$pool){
    $temp1 = strpos($pool,$var1)+strlen($var1);
    $result = substr($pool,$temp1,strlen($pool));
    $dd=strpos($result,$var2);
    if($dd == 0){
        $dd = strlen($result);
    }

    return substr($result,0,$dd);
}

/*
 $content = "Try to find the guy in the middle with this function!";
  $start = "Try to find ";
  $end = " with this function!";
  $output = getBetween2($content,$start,$end);
  echo $output;
*/
 function getBetween2($content,$start,$end){
    $r = explode($start, $content);
    if (isset($r[1])){
        $r = explode($end, $r[1]);
        return $r[0];
    }
    return '';
  }
  
function get_string_between($string, $start, $end){
    $split_string       = explode($end,$string);
    foreach($split_string as $data) {
         $str_pos       = strpos($data,$start);
         $last_pos      = strlen($data);
         $capture_len   = $last_pos - $str_pos;
         $return[]      = substr($data,$str_pos+1,$capture_len);
    }
    return $return;
}

/*
$string = "foo I wanna a cake foo";
$substring = getInnerSubstring($string, "foo");

echo $substring;

OR

$substring = getInnerSubstring($string, "foo", true); //Если вы хотите обрезать функцию использования результата
*/

function getInnerSubstring($string, $boundstring, $trimit=false) {
    $res = false;
    $bstart = strpos($string, $boundstring);
    if ($bstart >= 0) {
        $bend = strrpos($string, $boundstring);
        if ($bend >= 0 && $bend > $bstart)
            $res = substr($string, $bstart+strlen($boundstring), $bend-$bstart-strlen($boundstring));
    }
    return $trimit ? trim($res) : $res;
}
  
//http://qaru.site/questions/68240/how-to-get-a-substring-between-two-strings-in-php - вот здесь еще функции
?>