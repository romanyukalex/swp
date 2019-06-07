<?php
/****************************************************************
 * Snippet Name : module template (ajax part) 					* 
 * Scripted By  : RomanyukAlex		           					* 
 * Website      : http://popwebstudio.ru	   					* 
 * Email        : admin@popwebstudio.ru     					* 
 * License      : GPL (General Public License)					* 
 * Purpose 	 : some ajax functions							 	*
 * Access		 : via /ajax/								 	*
 ***************************************************************/
if($nitka=="1"){
	if($_REQUEST['action']=="searchsome"){
		?><h3>Результаты поиска</h3><?
		$category=process_data($_REQUEST['srchcat'],2);
		$searchtext=process_data($_REQUEST['q'],80);
		if ($category=="0") {
			$categoriesqry=mysql_query("SELECT * FROM `$moduletableprefix-$modulename-categories` WHERE 1 order by `cat_pri` ASC;"); 
		} else{
			$categoriesqry=mysql_query("SELECT * FROM `$moduletableprefix-$modulename-categories` WHERE `cat_id`='$category';"); 
			$catqrytext="and cat.`cat_id`='$category'";
		}
		while ($categoriesinfo=mysql_fetch_array($categoriesqry)){
			echo "CAT=".$categoriesinfo['category_name_ru']."<br>";
			
			$placesqry=mysql_query("SELECT * FROM `$moduletableprefix-$modulename-places` pl
			WHERE `cat_id`='$categoriesinfo[cat_id]' order by `place_pri` ASC;");

			while ($placesinfo=mysql_fetch_array($placesqry)){
				echo "Будем искать в:".$placesinfo['table']." ".$placesinfo['field']." Результир ID=".$placesinfo['result_id_field']."<br>";
					$srch_result[$placesinfo['table']]=mysql_query("SELECT `".$placesinfo['field']."`,`".$placesinfo['result_id_field']."` FROM `".$placesinfo['table']."` WHERE `".$placesinfo['field']."` LIKE '%".$searchtext."%';");
					echo "Запрос:"."SELECT `".$placesinfo['field']."`,`".$placesinfo['result_id_field']."` FROM `".$placesinfo['table']."` WHERE `".$placesinfo['field']."` LIKE %".$searchtext."%;";
					echo "Результат поиска:";
					while($srch_result_data=mysql_fetch_array($srch_result[$placesinfo['table']])){
						//echo $srch_result_data[$placesinfo['result_id_field']];
						
					}
					echo "<br>";
			}

			
		echo "<br>";
		
		}
	}
	
}?>