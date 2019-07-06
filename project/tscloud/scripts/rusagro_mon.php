<?
$log->LogInfo(basename (__FILE__)." | ".(__LINE__)." | Got ".(__FILE__)); 
if ($nitka=="1"){

	?><tr><td>Статус инстанса</td><td><b>:</b></td>
		<td>
		База данных (из ServiceNOW):<span id="sn_db_check_ap">Загрузка</span><br>
		<? 
		//Production
		?>Пинг сервера приложений:<? insert_module("ping_and_portmon","ping","172.31.254.36");
		?><br>Пинг базы данных:<?
		insert_module("ping_and_portmon","ping","172.31.254.37");
		?><br>Почтовый сервер (port 25):<?
		insert_module("ping_and_portmon","fsockopen","mail.ts-cloud.ru","25");
		?>
		<br>
		</td>
	</tr>
	<tr>
		<td>
	История доступности<br>
		</td>
		<td><b>:</b></td>
		<td>
		<form>
			<select name="mon_hist_month" id="mon_hist_month" onChange="get_monitor_history('2,7,8,9,10,11,12,13,14,15,16,17');">
				<option value="2015-10">Октябрь 2015</option>
				<option value="2015-09">Сентябрь 2015</option>
				<option value="2015-08">Август 2015</option>
				<option value="2015-07">Июль 2015</option>
				<option value="2015-06">Июнь 2015</option>
				<option value="2015-05">Май 2015</option>
			</select>
		</form>
		<div id="hist_table"></div>
		<script>
		function get_monitor_history(nodes){
			var mon_month = document.getElementById('mon_hist_month').value;
			ajaxreq(nodes,mon_month,'get_mon_history','hist_table','ping_and_portmon','downtime_SN.php');
		}

		get_monitor_history('2,7,8,9,10,11,12,13,14,15,16,17');
		ajaxreq('https://rusagro.ts-cloud.ru/stats.do','',"check_SN_DB","sn_db_check_ap","project_script");
		</script>
		<br>
		</td>
	</tr>
	<tr>
		<td>
	Нормативная информация<br>
		</td>
		<td><b>:</b></td>
		<td>
			<a target="_blank" href="/project/tscloud/files/rusagro_contract.pdf"><img style="padding-right:8px" class="imgmiddle" src="/project/tscloud/files/pdf_hover.png">Текст договора</a>
		</td>
	</tr>
	<?
	}?>