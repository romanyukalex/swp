<?php
 /****************************************************************
  * Snippet Name : newsblock admin scripts				 		 * 
  * Scripted By  : RomanyukAlex		           					 * 
  * Website      : http://popwebstudio.ru	   					 * 
  * Email        : admin@popwebstudio.ru     					 * 
  * License      : GPL (General Public License)					 * 
  * Purpose 	 : admin purposes								 *
  * Access		 : include									 	 *
  ***************************************************************/
$log->LogInfo(basename (__FILE__)." | Got ".(__FILE__));

 if($block!==1 and $adminpanel==1 and $nitka=="1"){
	include_once($_SERVER["DOCUMENT_ROOT"]."/modules/".$modulename."/config.php");
	if($_REQUEST[action]=="show_module_data"){
		if($newonpageorder=="По убыванию"){$newsascdesc="DESC";} else {$newsascdesc="ASC";}
		$newsreq=mysql_query("SELECT * FROM `$moduletableprefix-news` WHERE 1 ORDER BY `newsdate` $newsascdesc");
		?>
		<h3>Все новости</h3>
		<table class="settings_table" id="news_table">
		<tr class="gradient_to_top_green"><th>ID</th><th>Дата создания</th><th>Дата новости</th><th>Заголовок</th><!--th>Раздел</th--><th>Автор</th><th>Действия</th></tr>
		<? while($news=mysql_fetch_array($newsreq)){?>
		<tr>
			<td class="heavy-rounded"><?=$news['newsid']?></td>
			<td class="heavy-rounded"><?=$news['date']?></td>
			<td class="heavy-rounded"><?=$news['newsdate']?></td>
			<td class="heavy-rounded"><? 
				if($news['newstitle_ru']) echo $news['newstitle_ru']; 
				elseif($news['newstitle_en'])echo $news['newstitle_en'];
				else echo "НЕТ ТЕКСТА";?></td>
			<!--td class="heavy-rounded"><? if($news['section']){echo $news['section'];} else echo "&nbsp;";?></td-->
			<td class="heavy-rounded">
				<?	if($news['autor_id']){$userdata=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-users-admin` WHERE `userid`='$news[autor_id]' LIMIT 0,1"));
						echo $userdata[fullname];}
					else echo "&nbsp;";?></td>
			<td class="barrel-rounded"><? if($userrole=="root" or $news[autor]==$userid){?><a id="<?=$news[newsid]?>" class="admindeletelink" title="Удалить новость '<?=$news[newstitle]?>'"><img src="/adminpanel/pics/red-cross.png" height="28px"></a><? }?><a onClick="editnews('<?=$news[newsid]?>');return false;" title="Правка новости '<?=$news['newstitle']?>'"><img src="/adminpanel/pics/Highlightmarker-orange256withoutLine.png" height="32px"></a></td>
		</tr>
		<? $nextid=$news['newsid'];
		}
		$nextid++;
		?>
		<tr id="newpageform" style="display:none;">
			<td class="heavy-rounded"><span class="hid">'newpageform'</span><?=$nextid?></td>
			<td class="heavy-rounded"><?=date ("Y-m-d H-i")?></td>
			<td class="heavy-rounded"><input name="newsdate" value="<?=date ("Y-m-d")?>" id="newsdate"></td>
            <td class="heavy-rounded"><input name="newnewstitle" value="" id="newnewstitle" size="60"></td>
			<!--td class="heavy-rounded"> </td-->
			<td class="heavy-rounded">
				<? if($userrole=="root"){?>
					<select name="news_autor"><?
					$alladminreq=mysql_query("SELECT `userid`,`fullname` FROM `$tableprefix-users-admin` WHERE 1;");
					while($alladmin=mysql_fetch_array($alladminreq)){
						?><option value="<?=$alladmin['userid']?>"><?=$alladmin['fullname']?></option><?
					}?>
					</select><?
				} else {echo $fullname;}
			?></td>
			<td class="barrel-rounded"><a onclick="openfullcreationform();return false;" title="Продолжить оформление новости"><img src="/adminpanel/pics/green-add-circle.png" class="smallimg"></a></td>
		</tr>
		<tr><td colspan="6" style="border:0">
		<a class="menulink" id="add_news_link" style="margin-left:18;" onClick="showtr('news_table','newpageform',1000);closeblock('add_news_link');return false;"><img src="/adminpanel/pics/green-add-circle.png" class="smallimg">Добавить новость</a><br><br><br>
		</td></tr>
		</table>
		<div id="news_editor" class="hid">
			<h3><img src="/adminpanel/pics/rename256.png" class="imgmiddle smallimg">Добавить новость</h3>
			<form id="add_news_form">
			<table>
			<tr><td>ID</td><td>:</td><td><?=$nextid?></td></tr>
			<tr><td>Дата новости</td><td>:</td><td><input name="newsdate" value="<?=date ("Y-m-d")?>" id="newsdate1"></td></tr>
			<tr><td>Заголовок</td><td>:</td><td><input name="newnewstitle" value="" id="newnewstitle1" size="140"></td></tr>
			
			<tr><td>Полный текст новости</td><td>:</td>
			<td><? require($_SERVER["DOCUMENT_ROOT"]."/modules/wysiwyg-tinyMCE/design.php");// insert_module("wysiwyg-tinyMCE");?>
			</td></tr>
			<tr><td>Автор</td><td>:</td><td>
					<? if($userrole=="root"){?>
					<select name="news_autor"><?
					 mysql_data_seek($alladminreq,0);
					while($alladmin=mysql_fetch_array($alladminreq)){
						?><option value="<?=$alladmin['userid']?>"><?=$alladmin['fullname']?></option><?
					}?>
					</select><?
				} else {echo $fullname;}?>
			</td></tr>
			<tr><td>Отправить</td><td>:</td><td><img src="/adminpanel/pics/upload1256.png" height="30px"class="imgmiddle"><a class="small button green light-rounded">Отправить</a>
			</td></tr>
			</table>
			</form>
		</div>
		<script>
		function openfullcreationform(){
			var newsdate=$("#newsdate").val();$("#newsdate1").val(newsdate);
			var newstitle=$("#newnewstitle").val();$("#newnewstitle1").val(newstitle);
			var news_autor=$("#news_autor").val();$("#news_autor").val(news_autor);
			showblock('news_editor');
			hidetr('news_table','newpageform',1000);
		}
		</script>
		<?
	}
}
