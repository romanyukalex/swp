<?php
 /****************************************************************
  * Snippet Name : clean_html_word_tags	           				 * 
  * Scripted By  : RomanyukAlex		           					 * 
  * Website      : http://popwebstudio.ru	   					 * 
  * Email        : admin@popwebstudio.ru     					 * 
  * License      : GPL (General Public License)					 * 
  * Purpose 	 : Очистка HTML от тегов WORD					 *
  * Access		 : clean_html_word_tags();				 		 *
  ***************************************************************/
$log->LogInfo('Got this file');

function clean_html_word_tags($html) {
$html = ereg_replace("<(/)?(font|span|del|ins)[^>]*>","",$html);

$html = ereg_replace("<([^>]*)(class|lang|style|size|face)=("[^"]*"|'[^']*'|[^>]+)([^>]*)>","<\1>",$html);

return $html;
}
?>