<? # В РТК это 

if($_REQUEST['ms']){$_SESSION['next_page']=$_REQUEST['ms'];}
if($_SESSION['wifi_logged_in']){?>
<div class="units-box-row units-box-row_botborder-gray">
     <article class="unit-content-1">
     <img alt="" src="/project/wifi/templates/rtkwifi/files/lko_1000.jpg" class="content-img-1">
     
	<div class="content-block-2">
		<h1 class="content-head-30">Личный кабинет</h1>

		<p class="content-p-0 content-txt-14">
		<div id="wifi_cp_ap"></div>
		<form id="wifi_cp_form">
			Сменить тариф:
			<select name="sp">
			<? $sp_list=mysql_query("SELECT * FROM `$tableprefix-wifi-tariffs` WHERE 1;");
			# Тариф пользователя
			$cust_tariff_code=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-wifi-user_tariff` WHERE `userid`='".$_SESSION['wifi_logged_in']."' LIMIT 0,1;"));
			
			while($sp_list_data=mysql_fetch_array($sp_list)){
				?><option value="<?=$sp_list_data['tariff_code']?>" <?
				if($cust_tariff_code['tariff_code']==$sp_list_data['tariff_code']){?>selected<?}
				/*elseif(!$cust_tariff_code['tariff_code'] and $sp_list_data['tariff_code']==$rad_def_sp){?>selected<?}*/
				
				?>><?=$sp_list_data['tariff_name']?></option><?
			}
			?>
			</select><br><br>
			<a onClick="
			saveform3('','wifi_cp_form','wifi_cp_ap','wifi_cp_ap','project_script','change_tariff','','');return false;">
				<div class="modal-form__row modal-form__row_stand-last">
					<div class="modal-form__block modal-form__block_pos-l">
						<button id="logout_button" class="button-3 modal-form__btn modal-form__btn_width-full">
							<div class="spinner-circle-blue"></div>
							Сменить тариф
						</button>
					</div>
				</div>
			</a>
		</form>

		<br><br><br><br>
		
		<div id="wifi_cp_ok_ap"></div>
		
		<a onClick="ajax_rq ('project_script','Access_stop','wifi_cp_ok_ap','wifi_cp_ok_ap'); return false;">
			<div class="modal-form__row modal-form__row_stand-last">
				<div class="modal-form__block modal-form__block_pos-l">
					<button id="logout_button" class="button-3 modal-form__btn modal-form__btn_width-full">
						<div class="spinner-circle-blue"></div>
						Закончить сессию
					</button>
				</div>
			</div>
		</a>
   </div>
</article>
</div>
<? } else {
?>
<script>
$(document).ready(function(){
	changerazdel('rtk_wifi_sc');});
		//changerazdel('wifi_sc_main');
</script>

<?
}