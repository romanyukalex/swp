<?php
$log->LogInfo('Got this file');
/**
* According to ICQ website, we can have this kind of picture: 
* "http://status.icq.com/online.gif?icq=<account>&img=26"
* As they seems to be some nasty boys and have closed normal approche,
* We have to use sockets (and as it's a bit cold in here, it's
* better with sockets.. well.. ok)
* So, requiered :
* 1- Sockets support for your PHP.
* 2- hmm... that's all :]
*
* @author C. Jeanneret <cjeanneret@internux.ch>

Copyright (C) 2007 Jeanneret Internux

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
*/

class checkICQ {
 /* Account we want to check.
  * @var int  */
 var $account;
 /* Server URL. Should be private.
  * @var string */
 var $url;
 /* Server Port. Should be private.
  * @var int */
 var $port;
 /* User status. Should be private.
  * @var bool  */
 var $status;
 /* Time limit for socket connection. Should be private.
  * @var int  */
 var $timelimit;

 /**
  * Constructor.
  *
  * @param int $account
  * @return checkICQ
  */
 function checkICQ($account) {
  $this->account = $account;
  $this->url = '205.188.253.25';
  $this->port = '80';
  $this->timelimit = '5';
 }

 /* Grab status throug sockets.
  * @return bool false if there's an error.  */
 function setStatus() {
    $sock=@fsockopen($this->url, $this->port, $errno, $errstr, $this->timelimit);
    if(!$sock) {
       echo '<p>Fatal error ! '.$this->url.' returns ('.$errno.') '.$errstr.'</p>';
       return false;
      }
    // our socket is opened, we're warm for the next step!
    $request =  'HEAD /online.gif?icq='.$this->account.'&img=5 HTTP/1.0'."\r\n".
        'Host: '.$this->url."\r\n".'User-Agent: PHP/ICQ_Status1.5'."\r\nConnection: close\r\n\r\n";
    @fputs($sock,$request);
  do  {
    $response = fgets($sock,1024);
      } while (!feof($sock) && !stristr($response,"Location"));
  $this->status = preg_match("/online1/",$response);
 }

 /* Return user status
  * @return bool true if online  */
 function isOnline() {
    $this->setStatus();
    return $this->status;
 }
}
// Использовать
//$icq = new checkICQ('123456789');
// print($icq->isOnline());

?>