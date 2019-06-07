<? 
$log->LogInfo('Got this file');
# Определяем $menureq из GET
if($_REQUEST['menu']){$menureq=process_data($_REQUEST['menu'],20);}
elseif($pageshtrihquery['page_menu']){$menureq=$pageshtrihquery['page_menu'];}
else $menureq=NULL;?>