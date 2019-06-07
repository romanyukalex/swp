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
<form action='https://merchant.roboxchange.com/Index.aspx' method='<?=$param[2]['method']?>'>
<input type=hidden name=MrchLogin value='<?=$rk_shop_id;//$rk_login?>'>
<input type=hidden name=OutSum value=<?=$param[2]['summ']?>>

<input type=hidden name=Desc value='<?=$param[2]['order_desc']?>'>

<input type=hidden name=InvId value=<?=$param[2]['order_id']?>>
<input type=hidden name=SignatureValue value=<?=$crc?>>


<input type=hidden name=Culture value=<?=$language?>>
<input type=hidden name=Encoding value="utf-8">
<input type=hidden name=IsTest value='<?=$param[2]['IsTest']?>'>
<input type=submit value='<?=$param[2]['button_text']?>' class='<?=$param[2]['button_class']?>'>
</form>
<? }?>