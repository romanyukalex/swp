<?php
 /**************************************************************************\
  * Snippet Name : robokassa		           					 			*
  * Part		 : button (view)											*
  * Scripted By  : RomanyukAlex		           					 			*
  * Website      : http://popwebstudio.ru	   					 			*
  * Email        : admin@popwebstudio.ru     					 			*
  * License      : GPL (General Public License)					 			*
  * Purpose 	 : pay something								 			*
  * Access		 : 
  *																			*
  * insert_module('robokassa','get_pay_button',$pay_detail_arr)				*
  \*************************************************************************/
$log->LogDebug('Got this file');
if ($nitka=='1'){?>
	Уважаемый <?=$login?><br><br>
	<?if($_REQUEST['result']=='success'){
		echo sitemessage("$modulename",'payment_success');
	}else{
		echo sitemessage("$modulename",'payment_fail');
	}
}?>