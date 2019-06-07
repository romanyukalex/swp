<?php
/************************************************************************************
 * Snippet Name : module start script        					 					* 
 * Scripted By  : RomanyukAlex		           					 					* 
 * Website      : http://popwebstudio.ru	   					 					* 
 * Email        : admin@popwebstudio.ru     					 					* 
 * License      : GPL (General Public License)					 					* 
 * Purpose 		: page for start this module					 					*
 * Access		: create page with pagepath=/modules/modulename/startscript.php 	*
 ***********************************************************************************/
//if($_REQUEST['filename']=="yes"){$nitka=1;@include_once($_SERVER["DOCUMENT_ROOT"]."/modules/docmailgenerator/download_link.php");}
if(substr_count($_REQUEST['filename'], '.docx')==0) $filename=$_REQUEST['filename'].".docx";
else $filename=$_REQUEST['filename'];
$file = '1.docx';
$path = $_SERVER["DOCUMENT_ROOT"].'/modules/word_doc_generate/';
header ('Content-Type: application/vnd.ms-word'); 
header ('Content-Disposition: attachment; filename=' . $filename); 
header ('Content-Transfer-Encoding: binary'); 
header ('Content-Length: ' . filesize ($path . $file));

$fp = fopen ($path . $file, 'rb');
fpassthru ($fp);
fclose ($fp); 
?>