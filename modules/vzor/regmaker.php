<? require($_SERVER["DOCUMENT_ROOT"]."/core/db/dbconn-read.php");
require($_SERVER["DOCUMENT_ROOT"]."/vzor/siteconfig.php");
require($_SERVER["DOCUMENT_ROOT"]."/vzor/system-param.php");
require($_SERVER["DOCUMENT_ROOT"]."/vzor/send_letter.php");
require($_SERVER["DOCUMENT_ROOT"]."/vzor/process_user_data.php");
//bezopasnost' ot poddelki peremennikh
$prov=1;$KolAct=0;$errfield="";$nr=0;
//���������� ��� �������
$url = $_SERVER['REQUEST_URI']; 
$Link =explode("=", $url);

if ($Link[1]=="activate")
	{//aktivacia iz pisma
	$ActDeact=mysql_query("SELECT userrole,fullname FROM `ovzor-users` where `ActivationLink` ='$Link[2]'");
	$KolAct = mysql_num_rows($ActDeact);
	if ($KolAct==1)
		{//link est v base
		$data1=mysql_fetch_array($ActDeact);
		$subject="����� ������������ �� ����� www.ovzor.ru";
		$messagetoadmin="��������������� ". strtolower($data1[userrole]).": ".$data1[fullname]."<br>����������� �����: ".$EMAIL."<br>";
		sendletter($officialemail,$subject,$messagetoadmin);
		sendletter_to_admin($subject,$messagetoadmin);

		require($_SERVER["DOCUMENT_ROOT"]."/core/db/dbconn.php"); 
		// ������� ��� ���� � ������ �����-������� �� ����
		$query16 = mysql_query("select `userid` from `ovzor-users` where `ActivationLink` ='$Link[2]' LIMIT 1");
		$userid=mysql_fetch_array($query16);
		mysql_query("INSERT INTO `ovzor-account` (`userid`, `means`, `tariffid`) VALUES ('$userid[userid]', '$gift', '$starttariff');");
		
		//ispravlaem zapis o usere na ACTIVE
		mysql_query("UPDATE `ovzor-users` SET  `status`='active',`ActivationLink`='',`DeactivationLink`='' WHERE `ActivationLink` ='$Link[2]' LIMIT 1");
		
		//otpravlaem dorogogo klienta na register.php s kodom - registracia proidena, mogete polzovatsa loginom i parolem
		$p=6;$pass=0;$err=0;
		}
	else{//linka net v baze	//otpravit na order s kodom "Ssilka neaktivna naverno istek srok aktivacii" 
		$p=7;$pass=0;$messagetoadmin=0;$err=0;
		};
	}
elseif ($Link[1]=="newcand")
	{// ����� �������������� ������:
	$SN=process_data($_POST['SN'],20);
	$FN=process_data($_POST['FN'],20);
	$USERRROLE=process_data($_POST['USERROLE'],1);
	$CITY=process_data($_POST['CITY'],25);
	$ROBOTTRAP=process_data($_POST['ROBOTTRAP'],1);
	$DOUTYPE=process_data($_POST['DOUTYPE'],1);
	$REALNUMBER=process_data($_POST['REALNUMBER'],6);
	$CLASSTITLE=process_data($_POST['CLASSTITLE'],12);
	$NICKNAME=process_data($_POST['NICKNAME'],40);
	$EMAIL=process_data($_POST['EMAIL'],30);
	$COMMENT=process_data($_POST['COMMENT'],600);
	$SCHOOLKEY=htmlspecialchars(trim($SCHOOLKEY), ENT_QUOTES);
	$LOGIN=htmlspecialchars(trim($LOGIN), ENT_QUOTES);
	$PASSWORD=htmlspecialchars(trim($PASSWORD), ENT_QUOTES);
	$QUESTION=htmlspecialchars(trim($QUESTION), ENT_QUOTES);
	$SECRETANSWER=htmlspecialchars(trim($SECRETANSWER), ENT_QUOTES);

	//proverka poluchennogo:
	// ��� �� ������ ����������/��������?
	if (empty($SN) or 
		empty($FN) or 
		empty($CITY) or 
		empty($DOUTYPE) or
		empty($REALNUMBER) or
		empty($USERRROLE) or
		empty($CLASSTITLE) or
		empty($EMAIL) or 
		empty($COMMENT)) 
		{/*���� ����� �� ��� ������ - ��� �� ��� ���� �������� ���� ��� ������ �� ���� ��� �����. */
	 	$errfield.="�� ��� ���� ���������<br>";
		};
		
	if (!preg_match('/^([A-Za-z�-��-�])+$/',$SN))	
		{
		$errfield.="�������<br>";//���� � ������� ������
		};
	if (!preg_match('/^([A-Za-z�-��-�])+$/',$FN))	
		{
		$errfield.="���<br>";
		};
	if (!preg_match('/^([A-Za-z�-��-� ])+$/',$NICKNAME))	
		{
		$errfield.="��������� � ���<br>";
		};
	if (!preg_match('/^([1-3])+$/',$USERROLE))	
		{
		$errfield.="��� ������������<br>";
		};
	if (!preg_match('/^([A-Za-z�-��-�])+$/',$CITY))	
		{
		$errfield.="�����<br>";
		};
	if (!preg_match('/^([0-9])+$/',$DOUTYPE))	
		{
		$errfield.="��� ����������<br>";
		};
	if (!preg_match('/^([0-9])+$/',$REALNUMBER))	
		{
		$errfield.="����� ���<br>";
		};	
	if (!preg_match('/^([0-9�-��-� ])+$/',$CLASSTITLE))	
		{
		$errfield.="�����/������<br>";
		};
	if (!preg_match('/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-])+(\.([A-Za-z0-9])+)+$/',$EMAIL))
		{
		$errfield.="����� ���������� �����<br>";
		};
	if(!$ROBOTTRAP=="") 
		{//��� ������� ��� �������.����� �� ��������
		$errfield.="�� - �����<br>";
		};

	if ($errfield)
			{// �������� �������� ���������
				$p=8;$messagetoadmin=0;
				$err="���� ��������� �������:".$errfield;
				
			}
	else {// �������� �������� �������
		//������� ������� � ����� ������ � �������, ���� ����� ��������, ��� ������
		
		$SCHOOLANDCLASS="";
			if ($DOUTYPE==1)
				{$SCHOOLANDCLASS.="�����";
			}
			elseif($DOUTYPE==2)
				{$SCHOOLANDCLASS.="������� ���";
				};
		$SCHOOLANDCLASS.=" ����� ".$REALNUMBER.", ����� ".$CLASSTITLE;
		if ($COMMENT=="��� ������ ��������"){$COMMENT="";// ����� ��� ��������� ���� ������}
		if ($USERROLE==1){$USERROLE="��������";} elseif($USERROLE==2){$USERROLE="�������� ���";}
		
		require($_SERVER["DOCUMENT_ROOT"]."/core/db/dbconn.php"); 
		
		$query="INSERT INTO `ovzor-candidates` (`SN` ,`FN` ,`NICKNAME`,`CITY` ,`SCHOOLandCLASS` ,`EMAIL` ,`COMMENT` ,`USERROLE`)
		VALUES ('$SN', '$FN','$NICKNAME', '$CITY', '$SCHOOLANDCLASS', '$EMAIL', '$COMMENT', '$USERROLE');  ";		
		if ($pp=mysql_query($query))
			{
			if ($COMMENT!==""){$COMMENT="����������� ������������: ".$COMMENT;};
			$subject="����� ������ �� �����������";
			$messagetoadmin="<br>�������: ".$SN."<bR>���: ".$FN."<br>������ ����������: ".$NICKNAME."<br>����:".$USERROLE.
			"<br>����������� �����: ".$EMAIL."<br>� ";
			if ($DOUTYPE==1)
				{$messagetoadmin.="�����";
				}
			elseif($DOUTYPE==2)
				{$messagetoadmin.="������� ����";
				};
			$messagetoadmin.=" ����� ".$REALNUMBER."������ ".$CITY."<br>".$COMMENT;
			sendletter($officialemail,$subject,$messagetoadmin);
			sendletter_to_admin($subject,$messagetoadmin);

			$subjection="�������������� ������ � �����";
			$messagetouser="<center><a href='http://www.ovzor.ru'><img src='http://www.ovzor.ru/i/vzorlogo.gif'></a><br>������������, ".
			$NICKNAME.".</center><br>".$messagetocandidate."<br><br><center>C ���������<br>������������� �������� �����л<br>www.".$sitedomainname."</center>";
			sendletter($EMAIL,$subjection,$messagetouser);
			$p=1;
			}
		}}
}
elseif ($Link[1]=="newuser")
	{//eto noviy zakaz:
	$SN=process_data($_POST['SN'],20);
	$FN=process_data($_POST['FN'],20);
	$CITY=process_data($_POST['CITY'],25);
	$ROBOTTRAP=process_data($_POST['ROBOTTRAP'],1);
	$DOUTYPE=process_data($_POST['DOUTYPE'],1);
	$REALNUMBER=process_data($_POST['REALNUMBER'],6);
	$CLASSTITLE=process_data($_POST['CLASSTITLE'],6);
	$SCHOOLKEY=process_data($_POST['schoolkey'],10);
	$LOGIN=process_data($_POST['LOGIN'],20);
	$PASSWORD=process_data($_POST['PASSWORD'],20);
	$NICKNAME=process_data($_POST['NICKNAME'],40);
	$EMAIL=process_data($_POST['EMAIL'],30);
	$QUESTION=process_data($_POST['QUESTION'],40);
	$SECRETANSWER=process_data($_POST['SECRETANSWER'],30);
	$COMMENT=process_data($_POST['COMMENT'],600);
	
	//proverka poluchennogo:
	// ��� �� ������ ����������/��������?
	if (empty($SN) or 
		empty($FN) or 
		empty($CITY) or 
		empty($DOUTYPE) or
		empty($REALNUMBER) or
		empty($CLASSTITLE) or
		empty($SCHOOLKEY) or 
		empty($LOGIN) or 
		empty($PASSWORD) or 
		empty($NICKNAME) or 
		empty($EMAIL) or 
		empty($QUESTION) or 
		empty($SECRETANSWER) or 
		empty($COMMENT)) 
		{/*���� ����� �� ��� ������ - ��� �� ��� ���� �������� ���� ��� ������ �� ���� ��� �����. */
	 	$errfield.="�� ��� ���� ���������<br>";
		};
		
	if (!preg_match('/^([A-Za-z�-��-�])+$/',$SN))	
		{
		$errfield.="�������<br>";//���� � ������� ������
		};
	if (!preg_match('/^([A-Za-z�-��-�])+$/',$FN))	
		{
		$errfield.="���<br>";
		};
	if (!preg_match('/^([A-Za-z�-��-�])+$/',$CITY))	
		{
		$errfield.="�����<br>";
		};
	if (!preg_match('/^([0-9])+$/',$DOUTYPE))	
		{
		$errfield.="��� ����������<br>";
		};
	if (!preg_match('/^([0-9�-��-�])+$/',$REALNUMBER))	
		{
		$errfield.="����� ���<br>";
		};	
	if (!preg_match('/^([0-9�-��-�])+$/',$CLASSTITLE))	
		{
		$errfield.="�����/������<br>";
		};
	if (!preg_match('/^([0-9�-��-�A-Za-z ])+$/',$SCHOOLKEY))	
		{
		$errfield.="��������� �����<br>";
		};
	if (!preg_match('/^([0-9�-��-�A-Za-z])+$/',$LOGIN))	
		{
		$errfield.="�����<br>";
		};
	if (!preg_match('/^([0-9�-��-�A-Za-z])+$/',$PASSWORD))	
		{
		$errfield.="��������<br>";
		};
		if (!preg_match('/^([�-��-�A-Za-z ])+$/',$NICKNAME))	
		{
		$errfield.="���� ���������<br>";
		};
	if (!preg_match('/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-])+(\.([A-Za-z0-9])+)+$/',$EMAIL))
		{
		$errfield.="����� ���������� �����<br>";
		};
		if (!preg_match('/^([0-9�-��-�A-Za-z ])+$/',$QUESTION))	
		{
		$errfield.="��� ��������� ������<br>";
		};
	if (!preg_match('/^([0-9�-��-�A-Za-z ])+$/',$SECRETANSWER))	
		{
		$errfield.="����� �� ��������� ������<br>";
		};
	if (strlen($PASSWORD)<9)
		{
		$errfield.="�������� ������ ���� ����� 8 ��������<br>";
		};
	if(!$ROBOTTRAP=="") 
		{//��� ������� ��� �������.����� �� ��������
		$errfield.="�� - �����<br>";
		};

	if ($COMMENT=="��� ������ ��������")
		{$COMMENT="";// ����� ��� ��������� ���� ������
		}else{$COMMENT="����������� ������������: ".$COMMENT;
		};

	$fullname1=$SN." ".$FN;	$fullname2=$FN." ".$SN;
	// ���� ����� � ����
	$select="select count(*) from 	`ovzor-classroom`,`ovzor-class`,`ovzor-users`,`ovzor-school`
	where (`fullname`='$fullname1' or `fullname`='$fullname2') and `ovzor-users`.`classid`=`ovzor-class`.`classid` and `ovzor-class`.`classtitle`='$CLASSTITLE' and    `ovzor-classroom`.`classroomid`=`ovzor-class`.`classroomid` and `ovzor-classroom`.`schoolid`=`ovzor-school`.`schoolid` and `ovzor-school`.`realnumber`='$REALNUMBER' and `ovzor-school`.`doutype`='$DOUTYPE' and `ovzor-school`.`city`='$CITY' and `ovzor-users`.`schoolkey`='$SCHOOLKEY'"; //echo $select."<br>";
	$query = mysql_query($select);
	if(@mysql_result($query,0)!=="1")
		{$errfield.="������ ������� ��� � ����<br>"; //echo $errfield;
		}
	else{
		require($_SERVER["DOCUMENT_ROOT"]."/core/db/dbconn.php"); 
		$query = mysql_query("select `userid` from `ovzor-classroom`,`ovzor-class`,`ovzor-users` ,`ovzor-school`
		where (`fullname`='$fullname1' or `fullname`='$fullname2') and `ovzor-users`.`classid`=`ovzor-class`.`classid` and 	
		`ovzor-class`.`classtitle`='$CLASSTITLE' and    `ovzor-classroom`.`classroomid`=`ovzor-class`.`classroomid` and 
		`ovzor-classroom`.`schoolid`=`ovzor-school`.`schoolid` and `ovzor-school`.`realnumber`='$REALNUMBER' and 
		`ovzor-school`.`doutype`='$DOUTYPE' and `ovzor-school`.`city`='$CITY' and `ovzor-users`.`schoolkey`='$SCHOOLKEY'");
		};
	
	if ($errfield)
			{//�������� �������� ���������
				$p=9;$messagetoadmin=0;
				$err="���� ��������� �������:".$errfield;
				
			}	
	else{// ������ ������ � ���������� �������
		$subject="������������� ����������� �� ����� www.ovzor.ru";
		$arr1=array('1','2','3','4','5','6','7','8','9','0');
		for($ii = 0; $ii < 6; $ii++)
			{$index1 = rand(0, count($arr1) - 1);	$OrderID .= $arr1[$index1];	
			};
		$arr = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','r','s','t','u','v',
		'x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','R','S','T','U','V',
		'X','Y','Z','1','2','3','4','5','6','7','8','9','0');

		//generim silki aktivacii
		$ActivationLink=""; $DeactivationLink="";
		for($i = 0; $i < 15; $i++)
			{$index2 = rand(0, count($arr1) - 1);$ActivationLink .= $arr[$index2];
			};
		for($i = 0; $i < 15; $i++)
			{$index3 = rand(0, count($arr1) - 1);$DeactivationLink .= $arr[$index3];
			};
		//������ � ����� ������ � ����� �� �����:
		$res=mysql_fetch_array($query);
		$select="UPDATE `ovzor-users` SET `login` = '$LOGIN',`password`='$PASSWORD',`nickname`='$NICKNAME',`contactmail`='$EMAIL', `status`='between',`ActivationLink`='$ActivationLink',`DeactivationLink`='$DeactivationLink' WHERE `ovzor-users`.`userid`='$res[userid]' LIMIT 1";echo $select;
		$res=mysql_query($select); 
		//otpravlaem pismo dla confirma
		$messagetouser = "<body><b>������������.</b><br>���-��, �������� ��, �������� ����� ����������� �� ����� <a href='".$sitedomainname."'>www.".$sitedomainname."</a>. ���� ��� ������������� ������� ��, ����������, ����������� ���, ����� �� ������ (��������� 3 ���):<br>
<a href='http://".$sitedomainname."/vzor/regmaker.php?=activate=".$ActivationLink."'>��������� ������� ��������</a><br><li>���� �� �� �� ������ ��������� � ���������� ����� �� <a href='".$sitedomainname."'>www.".$sitedomainname."</a>, �� ������ ������ ��������������� ��� ������.<bR><br>� ���������� �����������.<br><b>������������� �������� \"���� - ����� ������ � ������\"</b></body>";
		sendletter($EMAIL,$subject,$messagetouser);
		if ($COMMENT)
			{// ������������ ���-�� ���� � �����������, ����� ���� ��� ����� ������ 
			$messagetoadmin="� ������� ��������������� ������������: ".$fullname1."<br>�������: ".$SN."<bR>���: ".$FN."<br>����������� �����: ".$EMAIL."<br>� ";
			if ($DOUTYPE==1)
				{$messagetoadmin.="�����";
			}
			elseif($DOUTYPE==2)
				{$messagetoadmin.="������� ����";
				};
			$messagetoadmin.=" ����� ".$REALNUMBER."������ ".$CITY."<br><br>������ ���� ������� �� ������������ ���� �����������:<br>".$COMMENT;
			sendletter($officialemail,$subject,$messagetoadmin);
			};
		$p=2;//dannie vvedeni pravilno
		//konec novoy registracii
		}
	}	
else 
	{//a vot eto NEPRAVILNAYA STROKA ADRESA
	header("Location: http://www.liveinternet.ru/users/56193/post116318212/");//otpravlaem tuda, otkuda priwel
	exit; 
	};

require($_SERVER["DOCUMENT_ROOT"]."/vzor/register.php");
?>