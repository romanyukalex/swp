<?php
 /*******************************************************************
  * Snippet Name : ping           								 	*
  * Scripted By  : RomanyukAlex		           					 	*
  * Website      : http://popwebstudio.ru	   					 	*
  * Email        : admin@popwebstudio.ru     					 	*
  * License      : GPL (General Public License)					 	*
  * Purpose 	 : some functions								 	*
  * Access		 : include this script, insert_module("modulename")	*
  ******************************************************************/

  /*## Usage

This is a very simple class. Just create an instance, and run `ping()`.

```php
$host = 'www.example.com';
$ping = new Ping($host);
$latency = $ping->ping();
if ($latency !== false) {
  print 'Latency is ' . $latency . ' ms';
}
else {
  print 'Host could not be reached.';
}
```

You can also specify the ttl (maximum hops) when creating the instance:

```php
$ttl = 128;
$ping = new Ping($host, $ttl);
```

...or using the `setTtl()` method:

```php
$ping = new Ping($host);
$ping->setTtl(128);
```

You can change the host using the `setHost()` method:

```php
$ping = new Ping($host);
...
$ping->setHost('www.anotherexample.com');
```*/
  
  
  
$log->LogInfo(basename (__FILE__)." | Got ".(__FILE__));
if ($nitka=="1"){
	//if(file_exists($_SERVER["DOCUMENT_ROOT"]."/modules/".$modulename."/Ping.php")) {echo "1" ;}
	//include($_SERVER["DOCUMENT_ROOT"]."/modules/".$modulename."/Ping.php");
	$monmethod=$param[1];
	$host = $param[2];
	$monport=$param[3];
	
	?><span id="ap_for_<?=str_replace(".", "", $host);?>">загрузка</span>
	<script>
	function pingthis(pinghost,mon_method,mon_port,pinghost_ap){
			ajaxreq(pinghost,mon_port,mon_method,pinghost_ap,"<?=$modulename?>");
			//ajaxreq(some_id1,some_id2,someaction,answerplace,module)
			//alert("h");
			//$("#"+pinghost_ap).load('/core/ajaxapi.php',{mod:"<?=$modulename?>",someid1:pinghost,action:"ping",rand:Math.random()},function(){ })
			//alert(pinghost_ap);
		}
	$(document).ready(function(){
		pingthis("<?=$host;?>","<?=$monmethod?>","<?=$monport?>","ap_for_<?=str_replace(".", "", $host);?>");
	});
	//pingthis("<?=$host;?>","ap_for_<?=str_replace(".", "", $host)?>");
		
	</script>
	
	
	<?
	
	/*
	
	$ping = new Ping($host);
	$latency = $ping->ping("fsockopen");
	
	if ($latency !== false) {
	  print 'Latency is ' . $latency . ' ms';

	  return $latency;
	}
	else {
	  print 'Host could not be reached.';
	  return false;
	}
	*/
 }?>