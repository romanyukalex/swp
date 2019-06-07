<?php
 /***************************************************************************
  * Snippet Name : date_compareDatetime	           			 				* 
  * Scripted By  : RomanyukAlex		           					 			* 
  * Website      : http://popwebstudio.ru	   					 			* 
  * Email        : admin@popwebstudio.ru     					 			* 
  * License      : GPL (General Public License)					 			* 
  * Purpose 	 : Сравнить 2 даты  типа: "Y-m-d H:i"			 			*
  * Access		 : 		*
  **************************************************************************/
function date_compareDatetime($date1, $date2){
	//$date1 = "2013-02-21 12:59";
    //$date2 = "2013-02-21 16:59";
    $arr1 = explode(" ", $date1);
    $arr2 = explode(" ", $date2);  
    $arrdate1 = explode("-", $arr1[0]);
    $arrdate2 = explode("-", $arr2[0]);
    $arrtime1 = explode(":", $arr1[1]);
    $arrtime2 = explode(":", $arr2[1]);
    $timestamp2 = (mktime($arrtime2[0], $arrtime2[1], 0, $arrdate2[1],  $arrdate2[2],  $arrdate2[0]));
    $timestamp1 = (mktime($arrtime1[0], $arrtime1[1], 0, $arrdate1[1],  $arrdate1[2],  $arrdate1[0]));
    if($timestamp1>$timestamp2){
        return 1;
    }else{
        return 2;
    }
}
?>