<? 
#Проверяет наличие страницы с таким page по входящему параметру $artcl['article_page']

$page_check=mysql_query("SELECT `page_id` FROM `$tableprefix-pages` WHERE `page`='".$artcl['article_page']."';");
if(mysql_num_rows($page_check)>0){//Страница с таким page уже есть
	$artcl['article_page']=$artcl['article_page'].'_'.time();
}
unset($page_check);