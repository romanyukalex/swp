<?php
 /*******************************************************************
  * Snippet Name : module template           					 	*
  * Scripted By  : RomanyukAlex		           					 	*
  * Website      : http://popwebstudio.ru	   					 	*
  * Email        : admin@popwebstudio.ru     					 	*
  * License      : GPL (General Public License)					 	*
  * Purpose 	 : some functions								 	*
  * Access		 : insert_module("vk-api","api_id","secret_key");?>	*
  * insert_module("vk-api","4977152","mo8Ru7fGxBriLR93uEOh");		*
  ******************************************************************/
$log->LogInfo("Got ".(__FILE__));
if ($nitka=="1"){

/*
require 'vk-orig/vkapi.class.php';

$api_id = $param[1]; // Insert here id of your application
$secret_key = $param[2]; // Insert here secret key of your application

$VK = new vkapi($api_id, $secret_key);

$resp = $VK->api('getProfiles', array('uids'=>'10153418','fields'=>'uid, first_name, last_name, nickname, screen_name, sex, bdate (birthdate), city, country, timezone, photo, photo_medium, photo_big, has_mobile, rate, contacts, education, online, counters')); // можно через "," несколько юзеров

$resp3 = $VK->api('users.get',array('user_ids'=>'aoromanyuk'));
print_r($resp3);
echo "<br><br>";
$resp1 = $VK->api('groups.getMembers',array('group_id'=>'76078089'));
//print_r($resp);
//$resp4 =$VK->api('getAppPermissions',array('user_id'=>'10153418'));
echo "<br><Br><br>";
//print_r($resp4);
echo "<br><br>";
echo "Список пользователей:";
//$resp2 = $VK->api('friends.add',array('uids'=>'310358508'));
//print_r($resp2);
echo "<br><br>";

foreach ($resp1['response']['users'] as $dd){
	echo $dd."<br>";

}
//echo $resp1['response']['users'][0];
*/
?>

	<div style="">
<form id="vkapiform">
<table class="zebra">
<tr>
	<td>API ID</td><td><input type="text" name='api_id' value="<?=$param[2]?>"></td>
</tr>
<tr>
	<td>secret_key</td><td><input type="text" name='secret_key' value="<?=$param[3]?>"></td>
</tr>
<tr><td>Действие</td>
<td>
<select name="vk_action">
<option value="groups.getMembers">Получить список участников групп</option>
<option value="getProfiles">Получить инфо по профилю пользователей</option>
<option value="getUsers">Получить краткое инфо пользователей</option>
<option value="getUserFriends">Получить список друзей пользователя</option>
</select>
</td></tr>
<tr><td>Группы</td><td><!--input type="text" name='vk_gm_grids' value="nlpcourse"-->
<textarea name='vk_gm_grids'></textarea>
</td></tr>
<tr><td>Список полностью</td><td><input type="checkbox" name="vk_gm_all_list"></td></tr>
<tr><td>Вывести только Москву</td><td><input type="checkbox" name="vk_gm_only_moscow"></td></tr>
<tr><td>В файл</td><td><input type="checkbox" name="vk_gm_intofile" checked></td></tr>
<tr><td></td><td> </td></tr>
</table>

</form>
<a href="/" class="green medium button"onclick="saveform2('','vkapiform','vk_answer_place','<?=$modulename?>','get_api_data','no_resetform','no_hideform');return false;">Отправить запрос</a>

<br>
<div id="vk_answer_place"></div>


</div>


<?

 }?>