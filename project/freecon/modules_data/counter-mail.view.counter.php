<?
 /**************************************************************************\
  * Snippet Name : Yandex counter		 	   								*
  * Scripted By  : RomanyukAlex		           								*
  * Website      : http://popwebstudio.ru	   								*
  * Email        : admin@popwebstudio.ru     								*
  * License      : GPL (General Public License)								*
  * Purpose 	 : counter user access data									*
  * Access		 : insert_module('counter-yandex','show_counter');			*
  \*************************************************************************/
$log->LogInfo('Got this file');
if ($nitka=="1"){
	if($_SERVER['HTTP_HOST']=="nlp-course.ru" or $_SERVER['HTTP_HOST']=="www.nlp-course.ru" or $_SERVER['HTTP_HOST']=="psy-space.ru" or $_SERVER['HTTP_HOST']=="www.psy-space.ru" ){
	?>
<!-- Rating@Mail.ru counter -->
<script type="text/javascript">
var _tmr = window._tmr || (window._tmr = []);
_tmr.push({id: "2904324", type: "pageView", start: (new Date()).getTime()});
(function (d, w, id) {
  if (d.getElementById(id)) return;
  var ts = d.createElement("script"); ts.type = "text/javascript"; ts.async = true; ts.id = id;
  ts.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//top-fwz1.mail.ru/js/code.js";
  var f = function () {var s = d.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ts, s);};
  if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); }
})(document, window, "topmailru-code");
</script><noscript><div>
<img src="//top-fwz1.mail.ru/counter?id=2904324;js=na" style="border:0;position:absolute;left:-9999px;" alt="" />
</div></noscript>
<!-- //Rating@Mail.ru counter -->
<? }
} ?>