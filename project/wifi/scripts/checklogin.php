<?php
 /***********************************************************************
  * Snippet Name : Project ajax scripts		 					 		*
  * Scripted By  : RomanyukAlex		           					 		*
  * Website      : http://popwebstudio.ru	   					 		*
  * Email        : admin@popwebstudio.ru     					 		*
  * License      : GPL (General Public License)					 		*
  * Purpose 	 : some ajax functions							 		*
  * Access		 : 														*
  *  ajaxreq(some_id1,some_id2,action,answer_place,"project_script");	*
  **********************************************************************/
 $log->LogInfo(basename (__FILE__)." | ".(__LINE__)." | Got ".(__FILE__));
if ($nitka=="1"){
	
	global $rad_db_ad,$rad_pass_mode,$rad_pass_len,$rad_bras_ad,$wifi_access_mode,$wifi_access_vendor,$allot_wsdl_path,$rad_def_sp;		
	# Проверяем АД
	$customer_login=process_data($_REQUEST['username'],25);
	$customer_pass=process_data($_REQUEST['password'],($rad_pass_len+25));
	# Параметры для подключения к БД freeradius
	$rad_db_ad_data=explode("/",$rad_db_ad);			
	
	$dbconnconnect1=mysql_connect($rad_db_ad_data[0],$rad_db_ad_data[1],$rad_db_ad_data[2]);
	if($dbconnconnect1){#Подключение есть
		$log->LogDebug(basename (__FILE__)." | ".(__LINE__)." | Got radius DB connect");
		$dbsel=mysql_select_db($rad_db_ad_data[3],$dbconnconnect1);
	
		//$user_del_req = mysql_query("DELETE FROM radcheck WHERE `username` = '79036766552'",$dbconnconnect1);

		$userreq=mysql_fetch_array(mysql_query("SELECT * FROM radcheck WHERE `username` = '$customer_login' and `attribute`='Password' and `op`='==' and `value`='$customer_pass'",$dbconnconnect1));

		if(!$userreq['username']){ # Пользователь не найден в БД freeradius
			$log->LogDebug(basename (__FILE__)." | ".(__LINE__)." | User with login $customer_login was not found in freeradius DB");
			$loginresult=2;
		} else {# Пользователь с указанным телефоном найден в БД freeradius
			$log->LogDebug(basename (__FILE__)." | ".(__LINE__)." | User with login $customer_login was found in freeradius DB");
			$loginresult=1;
		}
	}
} ?>