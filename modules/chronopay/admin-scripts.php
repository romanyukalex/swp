<? # ���������� ������ � �������� Chronopay
//session_start();
//@require($_SERVER["DOCUMENT_ROOT"]."/userlogin4.php");
if ($userrole=="admin" or $userrole=="administrator")
	{@include_once($_SERVER["DOCUMENT_ROOT"]."/core/db/dbconn-read.php");
	if (!$subquery){$subquery=substr($_REQUEST['subquery'],0,20);}
	if($subquery=="bad")
		{#�������� ������� � ������ ��������
		$where="`status`!='2' and `status`!='8' and `status`!='9'";
		$pagehead="��������� ����������� �������";
		}
	elseif($subquery=="good")
		{#�������� ������� � ������� ��������
		$where="`status`='2'";
		$pagehead="������� ����������� �������";
		}
	elseif($subquery=="ugly")
		{#�������� ������� �� �������� �� ��������� �������������
		$where="`status`='8'";
		$pagehead="�������, �� ����������� �������������";
		}
	else{$where="1";}
	?><h3><a onClick="gettariffs('<?=$subquery?>');return false;" style="cursor:pointer" title="������ ��� ���������� �������">
	<img src="/mtsstyles/i/magicsolutions/red-<?=$subquery?>.png" border="0" style='vertical-align:middle'><?=$pagehead?></a></h3>
	<table class="chronotable">
		<tr class="border">
		<th>������</th>
		<th>����� ������</th>
		<th>MSISDN</th>
		<th>�����</th>
		<th>�����</th>
<?	if($subquery!=="ugly")
		{?>
		<th>transaction_type</th>
		<th>customer_id</th>
		<th>transaction_id</th>
		<th>�������� �����</th>
		<th>�����</th>
		<th>payment_type</th>
		<th>auth_code</th>
<?		}?>
		<th>������ ��������</th>
<?	if($subquery!=="good")
		{?>	
		<th>��������</th>
<?		}?>
		</tr>
<?	$query1=mysql_query("SELECT * FROM `chronopays` WHERE $where order by `id` desc;");
	$n=0;
	while($pays=mysql_fetch_array($query1))
		{if ($pays[status]=="1")
			{$picsrc="wait.gif";// ���� ��������, ������ ������� ��������� ������
			$title="��������� ������������� ����������� �������";
			}
		elseif($pays[status]=="2")
			{$picsrc="ok.png";// ������ �� ��������, ������ ������� ������ ��
			}
		elseif($pays[status]=="8")
			{$picsrc="exclamation.png";// �� ������ �� ��������
			}
		else{$picsrc="unknownstatus.png";
			if ($pays[status]=="3"){$title="������ ����������� Chronopay, �� ���������� ����� �� ����������";}
			if ($pays[status]=="4"){$title="������ ����������� Chronopay, �� ���������� �������� ���� ����� ��� ������� ������������";}
			if ($pays[status]=="5"){$title="������ ����������� Chronopay, �� ������������ �������";}
			if ($pays[status]=="6"){$title="����������� �������";}
			if ($pays[status]=="7"){$title="������ ����������� Chronopay, �� ����� ������ �� ���� � ��";}
			}
		$n++;
	?>	<tr>
			<td><img src="/mtsstyles/i/magicsolutions/<?=$picsrc?>" border="0"<? if ($title){?> title="<?=$title?>"<? }?>></td>
			<td><?=$pays[id]?></td>
			<td><?=$pays[phone]?></td>
			<td><?=$pays[tariffid]?></td>
			<td><?=$pays[total]?></td>
	<?	if($subquery!=="ugly")
			{?>
			<td><?=$pays[transaction_type]?></td>
			<td><?=$pays[customer_id]?></td>
			<td><?=$pays[transaction_id]?></td>
			<td><?=$pays[name]?></td>
			<td><?=$pays[city]." ".$pays[street]?></td>
			<td><?=$pays[payment_type]?></td>
			<td><?=$pays[auth_code]?></td>
	<?		}?>
			<td><?=$pays[lastupdate]?></td>
	<?	if($subquery!=="good")
			{?>	
			<td><a href="/" title="������� ������" onClick="deletetariff('<?=$pays[id]?>','<?=$subquery?>');return false;">
			<img src="/mtsstyles/i/magicsolutions/red-delete.png" border="0" width="24"></a>
		<?	if($subquery=="bad")
				{?>	
			<a href="/" title="������� ������" onClick="buytariff('<?=$pays[id]?>');return false;"><img src="/mtsstyles/i/magicsolutions/ok.png" border="0"></a></td>
	<?			}
			}?>
		</tr>
		</tr>
	<?	}
	if($n==0){?><tr><td colspan="<? if($subquery=="ugly"){echo "7";}else{echo"13";}?>"><span style="color:green">��� ����� ��� �����������</span></td></tr><? }
?>	</table>
<? }?>