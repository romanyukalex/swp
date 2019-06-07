<? # Функция обрабатывает $various по стандартным правилам безопасности
$log->LogInfo('Got this file');
function process_data($various,$maxletter){ 
$returnvar=htmlspecialchars(substr(trim($various),0,$maxletter), ENT_QUOTES);
return $returnvar;
}

function process_user_data($various,$maxletter){ 
$returnvar=htmlspecialchars(substr(trim($various),0,$maxletter), ENT_QUOTES);
return $returnvar;
}