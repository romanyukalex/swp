<div class="content-center">
<?	if ($userrole=="admin" or $userrole=="�������� �����" or $userrole=="������������ ������� ����"){// ��������� 
	if ($blockcabinet=="��������� ���� � �������"){
	$userid=$user[userid];
	//if ($userrole=="������������ ������� ����")
	//��������  ������ � ����� ������������ � ������ ��� ��������������� �� ��������
	$prov=mysql_query("SELECT `action`,`date` FROM `ovzor-log` WHERE `userid`='$userid' and `ip`='$userip' ORDER BY `date` DESC LIMIT 0,1");
	$lastaction=mysql_fetch_array($prov);
	if ($lastaction[action]=="startshowcam" or $lastaction[action]=="startshow" or $lastaction[action]=="inprogress")
		{// ��� �������� ������ ������ ��� - ���� ���������. ��� ������ �� ������ �� �������� �� ���������� ������
		$query[1]="BbIXOD";
		}
	@require($_SERVER["DOCUMENT_ROOT"]."/core/db/dbconn.php");
	if ($query[1]=="BxoD")
		{ // ����� � �������
		//echo $lastaction[action].$userip;
		if ($lastaction[action]!=="enter" or !$lastaction[action])
			{// ������ �� �������
			$lastenter=$lastaction[date];
			mysql_query("INSERT INTO `ovzor-log` (`ip`,`userid`, `classroomid`,`camera`, `date`, `action`)
			VALUES ('$userip', '$userid', NULL ,NULL, CURRENT_TIMESTAMP, 'enter');"); // �������� ����
			//echo "�������� ����� � ��";
			}
		//else echo "������ ����� $lastaction[action] $lastaction[date] ��� IP=$userip      $ip";
		}
	if ($query[1]=="ADMuHuCTP")
		{
		if (!strstr($lastaction[action],"messagesent"))
			{// ������ �� �������
			$messagetoadmin=substr(trim($_POST['messagetoadmin']),0,500);
			$messagetoadmin=htmlspecialchars($messagetoadmin, ENT_QUOTES);
			$userdata1=mysql_query("select `contactmail` from `ovzor-users` where `login`='$login' and `password`='$password'");
			$user1=mysql_fetch_array($userdata1);
			$usermail=$user1[contactmail];
			// ���������� ���������
			$subject="��������� ������������ �� ������� �������� www.ovzor.ru";
			$from="������������� �����";
			$header="Content-type: text/html;  charset=utf-8\n";
			$header.="From: ".$nickname." <".$usermail.">\n";
			$header.="Subject: ".$subject."\n";
			$header.="Content-type: text/html; charset=cp1251";
			@ mail($var[3], $subject, $messagetoadmin, $header);
			$messagetouser="������������,".$nickname."<br>�� ������ ������� �������� � ������� ���� (����� ������ � �������) ���� ���������� ��������� 
			������������� ����� ���������� ����������<br>".$messagetoadmin."<br>��� ������ ����� �������������� �������� � ���������� � ����� ����������� 
			�������������� ������������ ������� ����. ���� ��� ��������� ���������� �� ����, ������ ��� �������� ���. ������� �� ���������.<br>
			������������� ������� ���� (����� ������ � �������)";
			$header1="Content-type: text/html;  charset=utf-8\n";
			$header1.="From: ".$from." OVZOR.RU<".$var[3].">\n";
			$header1.="Subject: ".$subject."\n";
			$header1.="Content-type: text/html; charset=cp1251";
			@ mail($usermail, $subject, $messagetouser, $header1);
			mysql_query("INSERT INTO `ovzor-log` (`ip`,`userid`, `classroomid`, `date`, `action`) 
			VALUES ('$userip', '$userid', NULL , CURRENT_TIMESTAMP, 'messagesent');"); // �������� �������� ���������
			$errormessage="���� ��������� ���������� ������������� ������� ����<br>�� ��� �������� ����� ���������� ����������� �� ���� �������";
			}
		}
	if ($query[1]=="IIapoJlb")
		{
		if ($lastaction[action]!=="Password_changed")
			{// ������ �� �������
			$oldpassword=substr(trim($_POST['oldpassword']),0,20);
			$oldpassword=htmlspecialchars($oldpassword, ENT_QUOTES);
			if ($oldpassword==$password)
				{// ������ ���� ������ ���������
				$newpassword1=substr(trim($_POST['newpassword1']),0,20);
				$newpassword1=htmlspecialchars($newpassword1, ENT_QUOTES);
				$newpassword2=substr(trim($_POST['newpassword2']),0,20);
				$newpassword2=htmlspecialchars($newpassword2, ENT_QUOTES);
				if ($newpassword1==$newpassword2)
					{
					if (strlen($newpassword1)<9){$errormessage="������ ������ ���� ����� 8 ��������";}
					else{// ������ �� ��������� ������ ��������
						mysql_query("UPDATE `ovzor-users` SET `password` = '$newpassword1' WHERE `ovzor-users`.`userid` ='$userid' LIMIT 1 ");
						mysql_query("INSERT INTO `ovzor-log` (`ip`,`userid`, `classroomid`,`camera`, `date`, `action`) 
						VALUES ('$userip', '$userid', NULL ,NULL , CURRENT_TIMESTAMP, 'Password_changed');"); // �������� ����� ������
						$errormessage="��� ������ ������� �������";
						};
					}
				else{$errormessage="��� ����� ������ ������ �����������, ���������� ��� ���";}
				}
			else{$errormessage="��� ������� ������ ������ �������";}	
			}
		}
	if ($query[1]=="Tapuqp" and $userrole=="������������ ������� ����")
		{ // ������ �����
		$tariffname=substr(trim($_POST['tariff']),0,20);
		$tariffname=htmlspecialchars($tariffname, ENT_QUOTES);
		if ($tariffname){
		$prov=mysql_query("SELECT `minsummforchangeto`,`tariffid` FROM `ovzor-tariff` 
		WHERE `tariffname`='$tariffname' and `status`='active' and `tarifftype`='online';");
		$tariffchange=mysql_fetch_array($prov);
		if ($tariffchange[minsummforchangeto])
			{// ����� ������
			// ��������� ��� ��� �� ����� � ��������� �� ������� (������� �� ��� �� �����)
			$query1=mysql_query("select `means`, t.`tariffid`  from `ovzor-tariff` t, `ovzor-account` 
			where `ovzor-account`.`userid`='$userid' and `ovzor-account`.`tariffid`=t.`tariffid`");

			$maininfo=mysql_fetch_array($query1);
			if ($maininfo[tariffid]==$tariffchange[tariffid])
				{// ��������� ��� �� ����� ��� � ���
				$errormessage="����� ������ ������ ���������: ������������� �������� ���� ��� ������������ ����.";
				}
			else {// ��������� �������� ����, �� ������ ��������
				if ($maininfo[means]>=$tariffchange[minsummforchangeto])
					{// ����� �� ����� ���������� ����� �������� ����
					mysql_query("UPDATE `ovzor-account` SET `tariffid` = '$tariffchange[tariffid]' WHERE `ovzor-account`.`userid` ='$userid' 
					AND `ovzor-account`.`tariffid` ='$maininfo[tariffid]' LIMIT 1 ;"); // �������� �����
					mysql_query("INSERT INTO `ovzor-log` (`ip`,`userid`, `classroomid`,`camera`, `date`, `action`) 
					VALUES ('$userip', '$userid', NULL ,NULL , CURRENT_TIMESTAMP, '�� �������� �������� ���� �� $tariffname');"); // �������� ����� ������
					$errormessage="�������� ���� ������� �� $tariffname";
					}
				else{// ����� �� ����� �� ���������� ����� �������� ����
					$errormessage="����� �� ����� ����� �� ���������� ��� �������� �� �������� ���� $tariffname";
					}
				}		
			}
		else{// ����� �� ������ - �������� ������� - ����� ��� ������ �������
			$errormessage="������������� ����� �� ������� ��������";
			}
		}
		else {// ������ ��� POST - ������
			$errormessage="�� ����� ������ ��� �������";
			}
		}
	if ($query[1]=="BbIXOD")
		{// ����� �� ������ ���������
		if ($lastaction[action]=="startshowcam" or $lastaction[action]=="startshow" or $lastaction[action]=="inprogress")
			{// ������ �� ������ �������� �������� ���������, � ������������� ����� �� ���������	
		
			// �������� �������� "����� �� ���������" � ���
			mysql_query("INSERT INTO `ovzor-log` (`ip`, `userid`, `classroomid`,`camera`, `date`, `action`) 
			VALUES ('$userip', '$userid', NULL ,NULL , CURRENT_TIMESTAMP- INTERVAL 1 second, 'stopshow');");

			if ($userrole=="������������ ������� ����"){ // �������� �����
				// ��������� �� ������� �� ���������
				@require($_SERVER["DOCUMENT_ROOT"]."/vzor/payit.php");
				} // �������� �����
				// ��������� ������� � ��������� ���
				$starttime[date]=date('h:i:s A', $starttime[date]);
				$stoptime[date]=date('h:i:s A', $stoptime[date]);
				//$sessiontime=date('i:s', $sessiontime);
			}
		}
	if ($userrole=="������������ ������� ����")
		{
		$query=mysql_query("
		select `classtitle`,`ovzor-classroom`.`classroomid`,`cameraname`,`means`,`tariffname`,`tarifftype`, `tariffprice`,`ovzor-users`.`userid`, `doutype` , `realnumber`
		from `ovzor-classroom`,`ovzor-class`,`ovzor-users`,`ovzor-tariff`, `ovzor-account`, `ovzor-school`
		where 
			`ovzor-users`.`userid`='$userid' and 
			`ovzor-users`.`classid`=`ovzor-class`.`classid` and 
			`ovzor-classroom`.`classroomid`=`ovzor-class`.`classroomid` and
			`ovzor-account`.`userid`=`ovzor-users`.`userid` and
			`ovzor-account`.`tariffid`=`ovzor-tariff`.`tariffid` and 
			`ovzor-classroom`.`schoolid` = `ovzor-school`.`schoolid`
		LIMIT 1	");

		$maininfo=mysql_fetch_array($query);
		$userid=$maininfo[userid];
		$mainclasstitle=$maininfo[classtitle];
		$maintariffprice=$maininfo[tariffprice];
		$mainmeans=$maininfo[means];			
		$minute= floor($mainmeans/$maintariffprice);
		$maintariffname=$maininfo[tariffname];
		$maintarifftype=$maininfo[tarifftype];
		$doutype=$maininfo[doutype];
		$realnumber=$maininfo[realnumber];
		}
	elseif ($userrole=="�������� �����")
		{
		// ������ �� ����� ��� ����:
		$query=mysql_query("
		SELECT `ovzor-classroom`.`classroomid` ,`cameraname`, `ovzor-classroom`.`describe` , `forepostip` , `forepostport` , `tariffname` 
		FROM `ovzor-school` , `ovzor-classroom` , `ovzor-account` , `ovzor-tariff` 
		WHERE `directorid` ='$userid'
		AND `ovzor-school`.`schoolid` = `ovzor-classroom`.`schoolid` 
		AND `access` = 'forall'
		AND `ovzor-account`.`userid` = `directorid` 
		AND `ovzor-account`.`tariffid` = `ovzor-tariff`.`tariffid` 
		LIMIT 1");
		$maininfo=mysql_fetch_array($query);
		// ���� ����� ������ �� ����� � ������ ��������, �� ���� ���������� ������ ������ � �����
		$mainclasstitle=$maininfo[describe];
		$minute=2;
		// ����� (���������� ������� ������ ��� ���� ������ �����������, ����� ���� ����� � �����, � ����� ��� �������
		$query5=mysql_query("SELECT `tariffname` FROM  `ovzor-account` , `ovzor-tariff` 
		WHERE `ovzor-account`.`userid` = '$userid' AND `ovzor-account`.`tariffid` = `ovzor-tariff`.`tariffid` LIMIT 1");
		$tariffinfo=mysql_fetch_array($query5);
		$maintariffname=$tariffinfo[tariffname];
		}
	$mainclassroomid=$maininfo[classroomid];
	$mainclassroomcameraname=$maininfo[cameraname];
	
	###################
	# ������ ��������:
	###################
	?><center>������������, <?=$nickname?><br><br><br><div class='ramka'><?	
	if ($lastenter){ echo "�� ���� ����� ������ ���. �� �� �������� � ".$lastenter; }
	elseif ($starttime[date] and $stoptime[date])
		{date_default_timezone_set("Etc/GMT0"); // ����� �� ������ �� ��������� ��� ������� (��� sessiontime)
		echo "���� ������ ��������� �������� ".$starttime[date]." � ����������� � ".$stoptime[date].".<br>����� ��������� - ".date("H:i:s", $sessiontime);
		if ($maintarifftype=="time"){echo "<br>������� �� ����� - ".$paid." �����(-��)";}
		} 
	elseif($errormessage){echo $errormessage;}
	else {echo "������ ������� � ������� ����";}
	?></div></center><br>
	<table>
		<tr><td><img src='i/tribal-magic.ru.people.png'></td><td><span style='font:12;'>���� ���� �� �����: &laquo;<?=$userrole?>&raquo;</span><br></td></tr>
		<tr><td><img src='i/tribal-magic.ru.money.png'></td><td>��� �������� ����  &laquo;<?=$maintariffname?>&raquo;<?
	if ($userrole=="������������ ������� ����")
		{echo "(".$maintariffprice;
		if ($maintarifftype=="time"){echo " ������ �� ������ ���������).";}
		elseif($maintarifftype=="unlim"){echo " ������ � ���� ��� ����������� �� ������� ���������).";}
		echo "<br>������ �� ����� ".$mainmeans." ������";
		if ($maintarifftype=="time"){echo ", ������� ������ ��� �� ".$minute." ����� ���������";}
		echo "<br>����� ����� (��� �������� � �������� ����������):"; 
		if (strlen($userid) < $var[4])
			{ for ($i=strlen($userid);$i<($var[4]);$i++)
				{ echo "0";};
			}
		echo $userid;
		}
			?></td>
		</tr>
	</table><?
	if ($userip=="87.118.81.21"){ ?>
		<div class="ramka">
		<table>
		<tr><td><img src='i/tribal-magic.ru.alert.png'></td><td>������ 313 [ IP ����� ������������ ��������� ������� ]<br>
		� ������������ ���������� ����������� �� ������
		</td></tr>
		</table>
		</div>
	<?	include_once($_SERVER["DOCUMENT_ROOT"]."/vzor/send_letter.php");
		sendletter_to_admin("�������� � ������������ IP ������ �� �����","�������� � ������������ IP ������ �� �����<br>������������ $userid ��������� � IP= $userip . ������ ��� �� ���������������");
		}
	elseif ($minute>1 and (($browser=='ie' and $browserversion>=8) or $browser=='firefox' or $browser=='chrome' or $browser=='opera' ))
		{
		?>
		<div class="ramka">
			<div style="LEFT:400px; POSITION: absolute; TOP: -120px; z-index:0; visibility:hidden">
 			<img src="i/tribal-magic.ru.play-onmouseover.png" />
			</div>
		<table><tr><td><a href="/vzor/?camera=<?=$mainclassroomcameraname;?>" onMouseOver="document.playcamera.src='i/tribal-magic.ru.play-onmouseover.png'" 
		onMouseOut="document.playcamera.src='i/tribal-magic.ru.play.png'"><img src='i/tribal-magic.ru.play.png' name="playcamera"></a></td>
		<td><center><a href="/vzor/?camera=<?=$mainclassroomcameraname;?>" onMouseOver="document.playcamera.src='i/tribal-magic.ru.play-onmouseover.png'" 
		onMouseOut="document.playcamera.src='i/tribal-magic.ru.play.png'" class='tribal-magic-Scrollover' type='scrollover'>
		������ ��������� (<?
		if ($userrole=="������������ ������� ����")
			{if ($doutype==1){echo "����� ����� ";}
			elseif($doutype==2){echo "������� ��� ";}
			echo $realnumber.", ";	
			if ($doutype==1){echo "����� ";}
			elseif($doutype==2){echo "������ ";}
			echo $mainclasstitle;?>)</a></center></td></tr>
		<? if ($maintarifftype=="time")
				{?><tr><td><br><img src='i/tribal-magic.ru.alert.png'></td><td><?=$var[1];// ��������� ��� ������� ���� ?></td></tr>
			<?	}
			}
		elseif ($userrole=="�������� �����")
			{
			echo $mainclasstitle; ?>)</a></center></td></tr>
<?			}	?>
		</table>
		</div>
		<?
		} 
	elseif (($browser!=='ie' and $browser!=='firefox' and $browser!=='chrome' and $browser!=='opera' and $browser!=='safari' and $minute>1) or ($browser=='ie' and ($browserversion=="5" or $browserversion=="6" or $browserversion=="7")))
		{ ?>
		<div class="ramka">
		<table>
		<tr><td><img src='i/tribal-magic.ru.alert.png'></td><td>��� ������� �� ������������ ����������� �������<br>
		<? if ($browser=="ie"){echo "�������� ������ Internet Explorer �� 8 ��� ����";}else{echo "����������� ����� �� �������������� ���������: Internet Explorer, Firefox, Google Chrome, Opera";}?>
		</td></tr>
		</table>
		</div>
	<?	}?>
		<table><tr><td>
		<br><img src='i/tribal-magic.ru.sessionsinfo.png'></td><td style="text-align:left;">
		<a onclick="downloadstats();showHideSelection(this,'statistics')" ><?=$var[2];// ��������� ���������� ?></a></td></tr></table>
		<script type="text/javascript">
		function downloadstats(){
		$("#statistics").load('get_stat.php',{user:"<?=$userid;?>"});
		}
		</script>
				<div style="display: none;" id='statistics'>
				</div>
		<table><tr><td><br><img src='i/tribal-magic.ru.settings.png'><a onclick="showHideSelection(this,'settings')" >��������� ������</a>
				<div style="display: none;" id='settings'>
				<table><tr><td  width="128px"> </td><td>
					<div id="example-links">
<?					if ($userrole=="������������ ������� ����")
						{ ?>
						<a href="#">�������� ����</a>
<?						} ?>
					<a href="#">��������� ������</a>
					<a href="#">�������� ����</a>
					<!--<a href="#">��� �� ���</a>
					<a href="#">��� �� ���</a> -->
					</div>
				</td><td>
					<div id="example-content-container">
						<div id="example-content">
<?						if ($userrole=="������������ ������� ����")
							{ // ��������� ������ ?>
							<div><img src='i/tribal-magic.ru.changetariff.png' style="float:left;"><b>��������� ��������� �����</b>
							<br />�� ������ �������� �������� ���� �� ����� ����������. ������������ �������� �������� �������� ������� 
							&laquo;������������ �����&raquo; �� �����<br>
							<FORM ACTION="/?%C4ET=Tapuqp" METHOD="POST">
							<? $tariffquery=mysql_query("SELECT `tariffname`,`minsummforchangeto` FROM `ovzor-tariff` 
							WHERE `tarifftype` = 'online' AND `status`='active' AND `minsummforchangeto`;");
							while ($tariffname=mysql_fetch_array($tariffquery))
								{ ?>
								<INPUT TYPE="radio" NAME="tariff"  SIZE="21" MAXLENGTH="20" <? if ($maintariffname==$tariffname[tariffname]){echo " checked ";}
								echo "value='".$tariffname[tariffname]."'>".$tariffname[tariffname]." (".$tariffname[minsummforchangeto]." �.)<br>";
								}	?>		
							<INPUT type="text" SIZE="1" MAXLENGTH="1" name="Family" class="hid" style="visibility:hidden;">
							<INPUT type="submit" value="��������" class="enter-input">
							</FORM>
							</div>
<?							} ?>
							<div>
							<img src='i/tribal-magic.ru.password.png' style="float:left;"><b>�������� ������</b><br />�������� ������ ����� ������. 
							������� ������ ������ � �����, �������� ������<br>
							<FORM ACTION="http://tribal-magic.ru/vzor/?%C4ET=IIapoJlb" METHOD="POST">
							
							<table><tr><td>������</td><td><INPUT TYPE="password" NAME="oldpassword"  SIZE="20" MAXLENGTH="20" 
							class="idle" onblur="this.className='idle'" onfocus="this.className='activeField'"></td></tr>
							<tr><td>�����</td><td><INPUT TYPE="password" NAME="newpassword1"  SIZE="20" MAXLENGTH="20"
							class="idle" onblur="this.className='idle'" onfocus="this.className='activeField'"></td></tr>
							<tr><td>�����</td><td><INPUT TYPE="password" NAME="newpassword2"  SIZE="20" MAXLENGTH="20" 
							class="idle" onblur="this.className='idle'" onfocus="this.className='activeField'">(��� ���)</td></tr>
							<INPUT type="text" SIZE="1" MAXLENGTH="1" name="Family" class="hid" style="visibility:hidden;">
							<tr><td colspan="2"><center><INPUT type="submit" value="���������" class="enter-input"></center></td></tr></table>
							
							</FORM>
							</div>
							<div><img src='i/tribal-magic.ru.message.png' style="float:left;"><b>��������� �������������</b><br />
							<FORM ACTION="http://tribal-magic.ru/vzor/?%C4ET=ADMuHuCTP" METHOD="POST">
							<INPUT TYPE="text" NAME="messagetoadmin"  SIZE="30" MAXLENGTH="500"
							class="idle" onblur="this.className='idle'" onfocus="this.className='activeField'"><br>
							<INPUT type="text" SIZE="1" MAXLENGTH="1" name="Family" class="hid" style="visibility:hidden;">
							<INPUT type="submit" value="���������" class="enter-input">
							</FORM></div>

						</div>
					</div>
					<div style="clear:both"></div>
					<script language="javascript">
					$('#example-links a').click(function(){
					var index = $("#example-links a").index(this);
					$('#example-content').animate({"marginTop" : -index*220 + "px"}); 
					return false;
					});
						
					</script>
				</td></tr></table>
				</div>
		</td></tr></table>
		<script language="javascript" type="text/javascript">
function showHideSelection(ths,str){
var obj=document.getElementById(str);
    if(obj.style.display=='inline'){
        obj.style.display='none';
    }else{
        obj.style.display='inline';   
    }
}
</script>
<? }
	else{echo $blockcabinetmessage;} // ����-��������
}; ?>

</DIV>