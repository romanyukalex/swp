<?php 
 /*********************************************** 
  * Snippet Name : censorMsg                    * 
  * Scripted By  : Hermawan Haryanto            * 
  * Website      : http://hermawan.dmonster.com * 
  * Email        : hermawan@dmonster.com        * 
  * License      : GPL (General Public License) * 
  * Access		 : $msg = censor($msg,"*");	*
  ***********************************************/
$log->LogInfo('Got this file');

function str_repeats($input, $mult) { 
	$ret = ""; 
	while($mult>0) {
		$ret .= $input; 
		$mult --; 
	} 
	return $ret; 
} 
function censor($msg, $replacement="*"){ 
	global $log;
    $log->LogDebug("Called '".(__FUNCTION__)."' function with params: ".implode(',',func_get_args()));
    global $badwordslist; 
    $badwords = explode("|", $bw); 
    $eachword = explode(" ", $msg); 
    for($j=0;$j<count($badwords);$j++){ 
		for($i=0;$i<count($eachword);$i++){
			if(is_int(strpos(strtr($eachword[$i], "АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯ", "абвгдеёжзийклмнопрстуфхцчшщъыьэюя"), $badwords[$j]))){ 
				$msg = eregi_replace($eachword[$i],str_repeats($replacement,strlen($eachword[$i])),stripslashes($msg)); 
        	} 
     	} 
    } 
    return $msg; 
}
?>