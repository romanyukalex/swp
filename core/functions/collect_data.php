<?php


function collect_data2($secure_mode,$http_mode,$balancerip,$balancerport,$basicauthuser,$basicauthpwd,$add_http_header=false,$req_path="/",$accept_types=FALSE,$content_body = FALSE,$hooked_file= FALSE,$user_agent=FALSE,$proxy=FALSE,$timeout=60){
	global $mode,$log;
	$log->LogDebug("Called ".(__FUNCTION__)." function with params: ".implode(',',func_get_args()));

	if($basicauthuser and $basicauthpwd) $http_header .="Authorization: Basic ".base64_encode($basicauthuser.':'.$basicauthpwd)."\r\n";
	$http_header .= "Host: $balancerip";
	if($balancerport!=="80" and $balancerport!==80) $http_header .= ":$balancerport";
	if(substr($req_path,0,1)!=="/") $http_header .='/'.$req_path;
	else $http_header .=$req_path;
	$http_header .= "\r\nConnection: Close\r\n";

	if($accept_types) $http_header .= "Accept: $accept_types\r\n";
	if($add_http_header) $http_header .=$add_http_header."\r\n";
	if($content_body){
		if(isJSON($content_body)){#json
			$http_header .="Content-Type: application/json\r\n";
		}
		elseif(isValidXml($content_body)){#xml
			$http_header .= "Content-Type: text/xml\r\n";
		}
		$http_header .="Content-Length: " . strlen($content_body) . "\r\n\r\n". $content_body."\r\n\r\n";
	}
	
	# �������� ������
	$opts = array('http' =>
		array(
			'method'  => $http_mode,
			'header'  => $http_header
		)
	);
	# ������������� ����
	if($hooked_file){
		$fileHandle = fopen($hooked_file, "rb");
		$fileContents = stream_get_contents($fileHandle);
		$opts['http']['content']=$fileContents;
		
	}
	# user_agent
	if($user_agent){
		$opts['http']['user_agent']=$user_agent;
	}
	if($proxy){
		$opts['http']['proxy']=$proxy;
	}
	$opts['http']['timeout']=$timeout;
	# ���������� ������
	$context  = stream_context_create($opts);
	$url = $secure_mode.'://'.$balancerip;
	if($balancerport!=="80" and $balancerport!==80) $url .= ":".$balancerport;
	if(substr($req_path,0,1)!=="/") $url .= "/".$req_path;
	else $url .= $req_path;
	//echo "<textarea cols='85' rows='10'>".$http_header	."</textarea>";
	var_dump($opts);
	echo $url;
	//var_dump($context);
	$result = file_get_contents($url, false, $context, -1, 200000);
	//if()){
		return $result;
	//} else return FALSE;


}

insert_function("isJSON");
insert_function("isValidXml");


function collect_data($method,$cmd,$postdata=NULL){ // ������ �������������
global $balancerip, $balancerport, $basicauthuser, $basicauthpwd, $mode;
global $log;
$log->LogDebug("Called ".(__FUNCTION__)." function with params: ".implode(',',func_get_args()));



$fp = fsockopen($balancerip, $balancerport, $errno, $errstr, 30);
if($fp) 
	{# ��������� ������ � �������� �����
	if($postdata){$request="POST";}
	else{$request="GET";}
	$request .= " /$method/$cmd HTTP/1.1\r\n";
	$request .= "Host: $balancerip\r\n";
	if($postdata){
	
	$request .="Accept: application/json\r\n"
		."Content-Type: application/json\r\n"
		. "Content-Length: " . strlen($postdata) . "\r\n";
	}
	$request .= "Connection: Close\r\n";
	$request .= 'Authorization: Basic '.base64_encode($basicauthuser.':'.$basicauthpwd)."\r\n";
	$request .= "\r\n";
	if($postdata) $request .= $postdata;

	if ($mode=="debug") echo "������:".$request."<br>";
	# ���������� request � �����
	fwrite($fp, $request);
	#������� 7 ����� ��������� http ������ (200 ��)
	fgets($fp, 1024);fgets($fp, 1024);fgets($fp, 1024);fgets($fp, 1024);fgets($fp, 1024);fgets($fp, 1024);fgets($fp, 1024);
	# ������ ���� �����
	while(!feof($fp)) 
		{
		$json .=fgets($fp); 
		//$json .=fread($fp,1024000000000);
		}
	# ��������� ��
	fclose($fp);	
	//echo $json;
	return $json;
	}
}?>