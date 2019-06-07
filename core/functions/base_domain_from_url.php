<?
 /*******************************************************
  * Snippet Name : base_domain_from_url            	    *
  * Scripted By  : php.net                              *
  * Email        : aromanuk@mail.ru             	    *
  * License      : GPL (General Public License) 	    *
  * Access		 : // RETURNS "BIT.COM"                 *
  * base_domain_from_url('http://www.ff.bit.com/?ce=ho);*
  ******************************************************/
  $log->LogInfo('Got this file');

 function base_domain_from_url($url) {
  $tld = parse_url($url,PHP_URL_HOST);
  $tldArray = explode(".",$tld);
  
  // COUNTS THE POSITION IN THE ARRAY TO IDENTIFY THE TOP LEVEL DOMAIN (TLD)
  $l1 = '0';
  
  foreach($tldArray as $s) {
    // CHECKS THE POSITION IN THE ARRAY TO SEE IF IT MATCHES ANY OF THE KNOWN TOP LEVEL DOMAINS (YOU CAN ADD TO THIS LIST)
    if($s == 'com' || $s == 'net' || $s == 'info' || $s == 'biz' || $s == 'us' || $s == 'co' || $s == 'org' || $s == 'me'|| $s == 'ru') {
      
      // CALCULATES THE SECOND LEVEL DOMAIN POSITION IN THE ARRAY ONCE THE POSITION OF THE TOP LEVEL DOMAIN IS IDENTIFIED
      $l2 = $l1 - 1;    
    }
    else {
      // INCREMENTS THE COUNTER FOR THE TOP LEVEL DOMAIN POSITION IF NO MATCH IS FOUND
      $l1++;
    }
  }
  
  // RETURN THE SECOND LEVEL DOMAIN AND THE TOP LEVEL DOMAIN IN THE FORMAT LIKE "SOMEDOMAIN.COM"
  return $tldArray[$l2] . '.' . $tldArray[$l1];
}



?>