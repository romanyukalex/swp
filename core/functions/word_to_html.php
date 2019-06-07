<?php 
 /*********************************************** 
  * Snippet Name : word_to_html                 * 
  * Scripted By  :         * 
  * Website      : * 
  * Email        :         * 
  * License      : GPL (General Public License) * 
  * Access		 :   	*
  ***********************************************/
$log->LogInfo('Got this file');

# ПРОВЕРИТЬ
function DoHTMLEntities ($string)    { 
  $trans_tbl = get_html_translation_table (HTML_ENTITIES); 

  // MS Word strangeness.. 
  // smart single/ double quotes: 
  $trans_tbl[chr(145)] = '\''; 
  $trans_tbl[chr(146)] = '\''; 
  $trans_tbl[chr(147)] = '&quot;'; 
  $trans_tbl[chr(148)] = '&quot;'; 

          // Acute 'e' 
  $trans_tbl[chr(142)] = '&eacute;'; 

  return strtr ($string, $trans_tbl); 
}
?>