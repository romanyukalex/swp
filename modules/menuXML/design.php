<?php
 /***********************************************************************
  * Snippet Name : menu				           					 		* 
  * Scripted By  : RomanyukAlex		           					 		* 
  * Website      : http://popwebstudio.ru	   					 		* 
  * Email        : admin@popwebstudio.ru     					 		* 
  * License      : GPL (General Public License)							* 
  * Purpose 	 : menu													*
  * Access		 : $menu="topmenu";include("/modules/menu/design.php");	*
  ***********************************************************************/
 $log->LogInfo(basename (__FILE__)." | Got ".(__FILE__)); // крашит вэб
if ($nitka=="1"){
/*

$L1menuquery=mysql_query("SELECT * FROM `$tableprefix-menu` WHERE `menuname`='$menu' ORDER BY `orderinmenu` ASC");*/

/*(SELECT *,1 AS lev,pointid AS sor FROM  `swp-menu` WHERE parrentpointid='0')
UNION
(SELECT *,2 AS lev,parrentpointid AS sor FROM `swp-menu` WHERE parrentpointid!='0' order by `parrentpointid` asc,`orderinmenu` asc)
ORDER BY sor,pointid
*/
?><ul><?
//if (file_exists($fullpath.'/module/menu/menu.xml')) {
		$xml = simplexml_load_file($_SERVER["DOCUMENT_ROOT"].'/modules/menu/menu.xml');
		foreach ($xml->item as $item)
		{?><li<? if($item->addclasstoli){echo" class='".$item->addclasstoli."'";}?>>
		<a href="<?=$item->link?>"<? if($item->addclasstoa){echo" class='".$item->addclasstoa."'";} if($page==$item->page){?> class="selected"<? }?> id="link_for_page_<?=$item->page?>" onClick="changerazdel('<?=$item->page?>');return false;"><?=$item->title?></a>
		<? if ($item->submenues){// Меню второго уровня
			?>
            <ul><? foreach ($item->submenues->item as $item2)
				{?><li<? if($item2->addclasstoli){echo" class='".$item2->addclasstoli."'";}?>><a href="<?=($item2->link)?>"<? if($item2->addclasstoa){echo" class='".$item2->addclasstoa."'";}?> onClick="changerazdel('<?=$item2->page?>');return false;"><?=$item2->title?></a></li>
			<? if($page==$item2->page){?><script>$(document).ready(function(){$("#link_for_page_<?=$item->page?>").addClass("selected")});</script><? }
			}?>
            </ul>
			<?
			}?>
        
        </li><?
		}
	//if($page=="news"){echo ' modselected';} 
//	}
/*else{?><li>Меню не найдено</li><? } */?>
</ul>
<? } ?>