<? # ������� ������, ��������� ������������� �� ��������
session_start();
@require($_SERVER["DOCUMENT_ROOT"]."/userlogin6.php");
if ($userrole!=="guest")
	{
	@include($_SERVER["DOCUMENT_ROOT"]."/process_user_data.php");
	$order_id=process_data($_REQUEST['id'],10);
	if (preg_match('/^([0-9])+$/',$order_id))
		{// ��, ������� �������� ������ �����
		//@include_once($_SERVER["DOCUMENT_ROOT"]."/siteconfig.php");
		@include_once($_SERVER["DOCUMENT_ROOT"]."/system-param.php");
		@include_once($_SERVER["DOCUMENT_ROOT"]."/core/db/dbconn-read.php");
		$query34=mysql_query("SELECT `tariffid`,`tariffname`,`total`,`lastupdate`,`status` FROM `chronopays` WHERE `id`='$order_id' LIMIT 0,1;");
		$waittariffs=mysql_fetch_array($query34);
			if ($waittariffs[status]=="1")
				{$picsrc="wait.gif";// ���� ��������, ������ ������� ��������� ������
				$title="��������� ������������� ����������� �������";
				$usermessage=$waitmessage;
				$usermessagecolor="grey";
				}
			elseif($waittariffs[status]=="2")
				{$picsrc="ok.png";// ������ �� ��������, ������ ������� ������ ��
				}
			elseif($waittariffs[status]=="8" or $waittariffs[status]=="9")
				{// �� ������ �� ��������, ������ �� ������� ������
				}
			else{$picsrc="unknownstatus.png";
				$title="�� ��������� ������ ������(".$waittariffs[status].")";
				$usermessage=$errortariffmessage;
				$usermessagecolor="red";
				}
			
		}
	else{$picsrc="unknownstatus.png";
		$title="�� ��������� ����� ������";
		$usermessage=$errortariffmessage;
		$usermessagecolor="red";
		}
	if ($picsrc)
		{$tariffname=iconv("utf-8", "windows-1251",$waittariffs[tariffname]);?>
		<td><?=$tariffname?></td><td><?=$waittariffs[lastupdate]?></td><td><?=$tariffname?></td>
		<td><img src="/mtsstyles/i/magicsolutions/<?=$picsrc?>"<? if ($title){?> title="<?=$title?>"<? }?> class="statuspic">
<?		if($usermessage){?><span style='color:<?=$usermessagecolor?>'><?=$usermessage?></span><? }
		if($picsrc=="ok.png"){?><script>$(document).ready(function() {$("#refererform").animate({opacity: "show"},1000);});</script><? }?>
		</td>
<?		}	
	} ?>