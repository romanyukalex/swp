<?php
$log->LogInfo('Got this file');
/**
* According to Skype documentation ( https://developer.skype.com/Docs/Web?action=AttachFile&do=get&target=2006-06-06skypewebdevnotes.pdf ),
* we can check skype status through http://mystatus.skype.com/<username>.<ext>
* Available <ext> are :
* .xml (returns complete xml with status in 12 languages and number)
* .txt (returns a string (warning : language depends on client configuration!) )
* .num (return only status number [1 = offline, 2 = online, 0 = account doesn't exist]
* <non> (return basic image)
*
* This class takes only .num, as it's very easy to use it. It checks only if it doesn't match "1". others are considered as online.
* If status == 0, account doesn't exist, so we return false.
* It can give other status as simple numbers if you wish (there's a function for this inside the class).
*
* Requiered :
* 1- fopen for external files support
* 2- well, nothing else I guess ;)
* @author C. Jeanneret <cjeanneret@internux.ch>
*/

/*
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

class checkSkype {
 /* Should be private : skype status server URL
  * @var string  */
 var $url;
 /* Account we want to check
  * @var string  */
 var $account;
 /* Status. Should also be private
  * @var bool  */
 var $status;

 /* Constructor
  * @param string $account
  * @return checkSkype  */
 function checkSkype($account) {
  $this->account = $account;
//  $this->url = '194.165.188.90/'.$this->account.'.num';
  $this->url = 'http://195.46.253.233/'.$this->account.'.num';
 }

 /* Just grab status */
 function getStatus() {
  $num = file($this->url);
  $this->status = $num[0];
 }

 /* Check if status == 2
  * @return bool true if so */
 function isOnline() {
  $this->getStatus();
  return ($this->status != 1 && $this->status != 0);
 }

}
// ёзать так 
//$skype = new checkMSN('kdg_22');
// print($skype->isOnline());
?>