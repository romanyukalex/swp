<? # ����� �� �������� ��������
if($_REQUEST['mode']=="debug"){
	@include($_SERVER["DOCUMENT_ROOT"]."/core/db/dbconn-read.php");
	@include($_SERVER["DOCUMENT_ROOT"]."/serverid.php");
	}
else{
	@include("/home/teligent/public_html/core/db/dbconn-read.php");
	@include("/home/teligent/public_html/serverid.php");
	$_SERVER["DOCUMENT_ROOT"]="/home/teligent/public_html";
	date_default_timezone_set('UTC');
	}
# �������� ���������
$paramdatas=mysql_query("SELECT `value`,`systemparamname` FROM `ms-siteconfig` WHERE 1;");
while($paramdata=mysql_fetch_array($paramdatas)){$$paramdata['systemparamname'] = $paramdata['value'];}

# �������� ������
if($chronoreportorder=="�� �������"){$orderby="order by `id` asc";}
elseif($chronoreportorder=="� �������� �������"){$orderby="order by `id` desc";}
else{$orderby="";}
$salt=rand(10,10000);
$query1=mysql_query("SELECT *,'$salt' as `1` FROM `chronopays` WHERE (`status`='2' or  `status`='3' or `status`='4' or `status`='5' or `status`='6' or `status`='7') 
and (unix_timestamp(now()) - unix_timestamp(`lastupdate`))<$chronoreportperiod $orderby;");
# ��������� ���������� �����
$reportarray="���� �������".$chronoseparator."����� �������(ORDER_ID)".$chronoseparator."MSISDN".$chronoseparator."�������� ������".$chronoseparator."����� ������, ���".$chronoseparator."������ �������� �����,%".$chronoseparator."����� �������� �����, ���."."
";
while($chrreport=mysql_fetch_array($query1)){
	$reportarray.=$chrreport['lastupdate'].$chronoseparator.$chrreport['id'].$chronoseparator.$chrreport['phone'].$chronoseparator.iconv("utf-8", "windows-1251",$chrreport['tariffname']).$chronoseparator.$chrreport['total'].$chronoseparator."1,85".$chronoseparator.($chrreport['total']*1.85/100)."
";
}
if($_REQUEST['mode']=="debug"){echo $reportarray;}
# �������� �����
$reportdate=date("y", time())."-".date("m", time())."-".date("d", time());//YYYY-MM-DD
if($_REQUEST['mode']=="debug"){
	$fp = fopen("/chronopaysreport/".$chronoreportfile.$reportdate.'.'.$chronoreportext, 'w');
	fwrite($fp,$reportarray);
	fclose($fp);
}
else{
	# ��������� ���� �� ���� .moved
	if (!file_exists($chronoreportfolder.$chronoreportfile."_".$serverid."_".$reportdate.'.'.$chronoreportext.".moved")){#����� ���, ������� � ���������� �����
		$fp = fopen($chronoreportfolder.$chronoreportfile."_".$serverid."_".$reportdate.'.'.$chronoreportext, 'w');
		fwrite($fp,$reportarray);
		fclose($fp);
		//@$sendemail = system('/home/teligent/send_email.pl', $retval);
		
		
		$un = strtoupper(uniqid(time())); 
		$domain="adminpanel.wifi.mts.ru";
		$from="[WiFi] Core Cronopay' report module";
		$header= "MIME-Version: 1.0\r\n";
		$header.="From: ".$from." <WiFi-Core@mts.ru>\r\n";
		$header.='Reply-To: aromanyuk@technoserv.com'."\r\n";
		$header.="Content-Type:multipart/mixed;";
		$header.="boundary=\"----------".$un."\"\n\n";
		$subject="[WiFi Core] ���������� �� �������� �������� �� ".$chronoreportperiod." ".$reportdate;
		$message="<html><body>
		������������<br><br> �� ���������� ������ (".$chronoreportperiod." ������) ���� ������������ ���������� ��������� WiFi Core<br><br><br>� ���������, ����� ������� VAS<br>����������� ���������� �������<br>��������� ��</body></html>";
		$zag= "------------".$un."\nContent-type: text/html;  charset=\"UTF-8\"\r\n";
		$zag.= "Content-Transfer-Encoding: 8bit\n\n$message\n\n";
		$zag.= "------------".$un."\n";
		# ������������� �����
		$filename=$chronoreportfolder.$chronoreportfile."_".$serverid."_".$reportdate.'.'.$chronoreportext;
		$f = fopen($filename,"rb");
		$zag.= "Content-Type: application/octet-stream;";
		$zag.= "name=\"".basename($filename)."\"\n";
		$zag.= "Content-Transfer-Encoding:base64\n";
		$zag.= "Content-Disposition:attachment;";
		$zag.= "filename=\"".basename($filename)."\"\n\n";
		$zag.= chunk_split(base64_encode(fread($f,filesize($filename))))."\n";
		$zag.= "------------".$un."\n";	
		# ����� � ��������
		include_once($_SERVER["DOCUMENT_ROOT"]."/KLogger.php");
		if (@mail($statemailaddrses, '=?UTF-8?B?'.base64_encode($subject).'?=', $zag, $header))
			{$log->LogInfo("127.0.0.1|| Mail with Chronopay-report was sent to ".$statemailaddrses." sucessfully");}
		else{$log->LogError("127.0.0.1|| Mail with Chronopay-report was not sent");}		
		
		//sleep(10);
		exec("/bin/mv ".$chronoreportfolder.$chronoreportfile."_".$serverid."_".$reportdate.'.'.$chronoreportext." ".$chronoreportfolder.$chronoreportfile."_".$serverid."_".$reportdate.'.'.$chronoreportext.".moved",$output);
	}
}

?>