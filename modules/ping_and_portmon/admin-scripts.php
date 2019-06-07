<?php
 /****************************************************************
  * Snippet Name : admin scripts     					 		 * 
  * Scripted By  : RomanyukAlex		           					 * 
  * Website      : http://popwebstudio.ru	   					 * 
  * Email        : admin@popwebstudio.ru     					 * 
  * License      : GPL (General Public License)					 * 
  * Purpose 	 : admin purposes								 *
  * Access		 : include									 	 *
  ***************************************************************/

  if($block!==1 and $adminpanel==1){
	include_once($_SERVER["DOCUMENT_ROOT"]."/modules/".$modulename."/config.php");
	if($_REQUEST[action]=="show_module_data"){
		?>
		<div id="<?=$modulename?>_messageplace"></div>
		<table class="zebra ap_table">


		
		<thead><tr>
		<th width="3%">ID</th>
		<th width="25%">Hostname (Ru|En)</th>
		<th width="35%">Мониторинг</th>
		<th width="12%">Статус</th>
		<th width="25%">Действия</th></tr>
		</thead>
<tfoot>
    <tr>
        <td>&nbsp;</td>        
        <td></td>
        <td></td>
		<td></td>		<td></td>
		
    </tr>
    </tfoot>
	<?
	$mon_hosts_q=mysql_query("SELECT * FROM `$tableprefix-monitor-nodes` WHERE 1;");
		while($mon_hosts=mysql_fetch_array($mon_hosts_q)){?>
			<tr id="moduletr2" class="moduletr"><td class="heavy-rounded">
			<span class="hid">nodetr<?=$mon_hosts['node_id']?>_</span><?=$mon_hosts['node_id']?></td>
			<td class="heavy-rounded"><div id="fieldmessage_<?=$mon_hosts['node_id']?>"></div><?=$mon_hosts['hostname_ru']."<br>".$mon_hosts['hostname_en']?></td>
			<td class="heavy-rounded">
				<select>
				<? insert_function("enum_select");
				$fbos=enum_select("$tableprefix-monitor-nodes","mon_type");
				foreach($fbos as $fboskey=>$fbosvalue){
					?><option value="<?=$fbosvalue?>" <?if($fbosvalue==$mon_hosts['mon_type']){?>selected<?}?>><?=$fbosvalue?></option><?
				}?>
				</select><br>
				<div style="width: 100%;"><div style="display: inline-block; "><input title="Адрес"value="<?=$mon_hosts['ipaddr']?>" id="ipaddr_for_node_<?=$mon_hosts['node_id']?>"></div><div style="display: inline-block;">:</div><div style="display: inline-block; width: 20px;"><input title="Порт"value="<?=$mon_hosts['port']?>" id="port_for_node_<?=$mon_hosts['node_id']?>"></div></div><br>
				каждые <input value="<?=$mon_hosts['mon_period']?>" id="mon_period_for_node_<?=$mon_hosts['node_id']?>">микросекунд
			</td>
			<td><img width="20px" src="/files/simplicio/
			<?if($mon_hosts['cur_status']=="alive"){?>ok<?}
			elseif($mon_hosts['cur_status']=="dead"){ ?>notification_error<?}?>
			.png" title="Текущий: <?=$mon_hosts['cur_status']?>">
			<? 
			$pid_file=$_SERVER["DOCUMENT_ROOT"]."/modules/".$modulename."/".$mon_host_info['mon_type']. str_replace ('.' , '' ,$mon_host_info['ipaddr']) . $mon_host_info['port']. "every". $mon_host_info['mon_period']. '.pid';


			if (is_readable($pid_file)) { #Файл найден
				$pid = (int)file_get_contents($pid_file);

				if ($pid > 0 && posix_kill($pid, 0)) {# Такой демон найден и запущен
					?><img src="/files/simplicio/direction_up.png" title="Демон запущен"><?
				}

				if (!unlink(PIDFILE_NAME)) {# Файл найден, но демон не найден. Стираем файл с PID
					?><img src="/files/simplicio/direction_down.png" title="Демон не запущен"><?
				}
			}
			?>
			</td>
			<td class="barrel-rounded actiontd"><div id="changt_module_button_2"><a onclick="ajaxreq('<?=$mon_hosts['node_id']?>','','start_daemon','<?=$modulename?>_messageplace','<?=$modulename?>');" class="small button orange light-rounded">Запустить демона</a></div>
			
			<div id="accessbutton_2"><a onclick="ajaxreq('2','disable_module','change_param','fieldmessage_'+paramid,'adminpanel');save_param('')" class="small button red light-rounded">Отключить мониторинг</a></div>			</td>
			</tr>
	<?	}?>
			
	</tbody></table>
	<a><img src="/adminpanel/pics/custom-reports256.png" height="64px"class="imgmiddle">Отчет по событиям</a><?
	}
}
