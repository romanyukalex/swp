<?php
 /***************************************************************************************************
  * Snippet Name : menu				           					 									* 
  * Scripted By  : RomanyukAlex		           					 									* 
  * Website      : http://popwebstudio.ru	   					 									* 
  * Email        : admin@popwebstudio.ru     					 									* 
  * License      : GPL (General Public License)														* 
  * Purpose 	 : menu																				*
  * Access		 : $menu="menutitle";$menu_with_UL="no";$menu_with_LI="yes";					    *				   		 
  *				   include($_SERVER["DOCUMENT_ROOT"]."/modules/menu/design.php");					*
  **************************************************************************************************/
//$log->LogInfo(basename (__FILE__)." | Got ".(__FILE__)); // крашит вэб
if ($nitka=="1"){
/*

/*(SELECT *,1 AS lev,pointid AS sor FROM  `swp-menu` WHERE parrentpointid='0')
UNION
(SELECT *,2 AS lev,parrentpointid AS sor FROM `swp-menu` WHERE parrentpointid!='0' order by `parrentpointid` asc,`orderinmenu` asc)
ORDER BY sor,pointid
*/
@include_once($_SERVER["DOCUMENT_ROOT"]."/core/db/dbconn.php");
if($param[0]){# Вызов через insert_module("menu",$menureq,"no","yes");
	$menu=$param[1];
	$menu_with_UL=$param[2];
	$menu_with_LI=$param[3];
	global $tableprefix, $page, $defaultmenu;
}

if($page and $menu==NULL){# Берем menu из page, если она там определена, и если не запрашивали через GET другую
		$pagesettings=mysql_fetch_array(mysql_query("SELECT `page_menu` FROM `$tableprefix-pages` WHERE `page`='$page' Limit 0,1;"));
		if($pagesettings['page_menu']){$menu=$pagesettings['page_menu'];} else {$menu=$defaultmenu;}
	}
if ($menu) {$dontshowmenu=2;



/*	if($page){
		$menusettingsreq=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-menus-settings` WHERE `menuname`='$menu' Limit 0,1;"));
		$notshopages=explode(";",$menusettingsreq[notshowpages]);
		foreach($notshopages as $notshopage){if($notshopage==$page){$dontshowmenu=1;}}
		
	}*/
	if($dontshowmenu==2){
		$menuquery=mysql_query("SELECT * FROM `$tableprefix-menus` WHERE `menuname`='$menu' and `status`='enabled' order by `menuposition` ASC;");?>
	<?	if ($menu_with_UL=="yes"){echo "<ul>";}// ul
		while ($submenu=mysql_fetch_array($menuquery))
			{
			if ($menu_with_LI=="yes"){?><li<? if($submenu['addclasstoli']){echo" class='".$submenu['addclasstoli']."'";}?>><? }// li?>
			<a href="<?=$submenu['link']?>"<? if($submenu['addclasstoa']){echo" class='".$submenu['addclasstoa']."'";} if($page==$submenu['page']){?> class="<?=$liactiveclass?>"<? }?> id="link_for_page_<?=$submenu['page']?>" <? if($submenu['jsonclick']){?>onClick="<?=$submenu['jsonclick']?>"<?}//onClick="changerazdel('<?=$submenu['page']? >');return false;"?>><?=$submenu['title_'.$language]?></a>
			<? /*if ($submenu['submenues']){// Меню второго уровня
				?>
				<ul><? foreach ($submenu['submenues']->item as $item2)
					{?><li<? if($submenu['addclasstoli']){echo" class='".$submenu['addclasstoli']."'";}?>><a href="<?=($submenu['link'])?>"
					<? if($submenu['addclasstoa']){echo" class='".$submenu['addclasstoa']."'";}?> onClick="changerazdel('<?=$submenu['page']?>');
						return false;"><?=$submenu['title']?></a></li>
				<? if($page==$submenu['page']){?><script>$(document).ready(function(){$("#link_for_page_<?=$submenu['page']?>").addClass("selected")});</script><? }
				}?>
				</ul>
				<?
				}*/
			
			if ($menu_with_LI=="yes"){?></li><? } // /li
			}
		if ($menu_with_UL=="yes"){echo "</ul>";} // /ul
	}
}
else {echo "Укажите пункт меню $ menu";}?>
<? } ?>