<?php
 /***********************************************************************************
  * Snippet Name : module template           					 					*
  * Scripted By  : RomanyukAlex		           					 					*
  * Website      : http://popwebstudio.ru	   					 					*
  * Email        : admin@popwebstudio.ru     					 					*
  * License      : GPL (General Public License)					 					*
  * Purpose 	 : some functions								 					*
  * Access		 : insert_module("sms_smscru","FROM","TO_MOBILE","MESSAGE","TIME")	*
  *			Param FROM will be eq SMSC.RU in basic version.It is not free service	*
  **********************************************************************************/
$log->LogInfo(basename (__FILE__)." | Got ".(__FILE__));
if ($nitka=="1"){
global $smscru_ad;
$smscru_ad_arr=explode("/",$smscru_ad);
$smsclient = new SoapClient('https://smsc.ru/sys/soap.php?wsdl', array("trace" => 1, "exception" => 0));
$smsclient->send_sms(array('login'=>$smscru_ad_arr[0], 'psw'=>$smscru_ad_arr[1], 'phones'=>"$param[2]", 'mes'=>"$param[3]", 'id'=>'', 'sender'=>'$param[1]', 'time'=>$param[4]));	

}?>