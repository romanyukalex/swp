<?php
 /****************************************************************
  * Snippet Name : newsblock		          					 * 
  * Scripted By  : RomanyukAlex		           					 * 
  * Website      : http://popwebstudio.ru	   					 * 
  * Email        : admin@popwebstudio.ru     					 * 
  * License      : GPL (General Public License)					 * 
  * Purpose 	 : show news									 *
  * Access		 : insert_module								 *
  ***************************************************************/
$log->LogInfo(basename (__FILE__)." | Got ".(__FILE__));
if ($nitka=="1"){

global $tableprefix, $newsonmain, $newsonpage, $newonpageorder, $newonmainorder,$rss_picture;

if($param[1]=="newsonmain" or $param[1]=="newspage"){
	if ($param[1]=="newsonmain") {$newsnumberlimit="LIMIT 0,$newsonmain";
		if($newonmainorder=="По убыванию"){$newsascdesc="DESC";} else {$newsascdesc="ASC";}
	}
	elseif($param[1]=="newspage") {
		$newsnumberlimit1=$newsonpage*($param[2]-1);
		$newsnumberlimit="LIMIT $newsnumberlimit1,$newsonpage";
		if($newonpageorder=="По убыванию даты"){$newsascdesc="DESC";} else {$newsascdesc="ASC";}
	}
	$newsquery=mysql_query("SELECT * FROM `$moduletableprefix-news` WHERE `status`='active' ORDER BY `newsdate` $newsascdesc $newsnumberlimit");?>
	<div style="position:absolute; right:20px;top:187px"><a href="/modules/rss/"><img src="<?=$rss_picture?>" width="30px"></a></div>
	<div class="b-page b-text">
	<div class="js-tabs js-vtabs">
	<div class="tab-content tab-content_active">

	<div class="vtab-content vtab-content_active">                                  
		<div class="b-text_2col b-news-list b-text">
			<div class="col_left" style="width:100%">                      
			<? while($newsdata=mysql_fetch_array($newsquery)){?>                        
									
		<div id="bx_1914200112_5736" class="b-news-item">
			
						 <div class="date"><?=$newsdata['newsdate']?></div>
			<?//=$newonpageorder?>
							<h3><a href="/?page=news&newsaction=show_news_text&news_id=<?=$newsdata[newsid]?>&menu=mainmenu" class="news-detail-link"><?=$newsdata['newstitle_'.$language]?></a></h3>
			
						<p><?=substr(strip_tags ($newsdata['fulltext_'.$language]),0,(160-strlen($newsdata['newstitle_'.$language])),'utf-8')."..."?><a href="/?page=news&newsaction=show_news_text&news_id=<?=$newsdata[newsid]?>&menu=mainmenu" onClick="shownews('<?=$newsdata[newsid]?>');linkcolor('news');return false;">Читать ›</a>
	</p>						
		   
			
		</div>

	<? }?>
	</div></div></div></div></div></div>
<?}
elseif($param[1]=="show_news_text"){
	$newsquery=mysql_fetch_array(mysql_query("SELECT * FROM `$moduletableprefix-news` WHERE `newsid`='$param[2]'"));?>
	<div class="b-page b-text">
	<div class="js-tabs js-vtabs">
	<div class="tab-content tab-content_active">
	<h2 title="Опубликовал <?=$newsquery['autor_id']?>">[<?=$newsquery['newsdate']."] ".$newsquery['newstitle_'.$language]?></h2>
	<? 
	if($newsquery['news_photo_id']){
		$photoinfo=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-photos` WHERE `photo_id`='$newsquery[news_photo_id]'"));
		# Размер картинки
		list($width, $height, $type, $attr)= getimagesize ($_SERVER["DOCUMENT_ROOT"].$photoinfo['photo_path']);
		?><img src="<?=$photoinfo['photo_path']?>" <? if($width>$height and $width>270){?>width="270px"<?}
		elseif($width<$height and $height>270){ ?>height="270px"<? }?> 
		style="float: left;margin-right: 8px;<? if(iconv_strlen($newsquery['fulltext_'.$language],'UTF-8')<200){?>vertical-align:middle;<?}?>"/><?
	}?>
	<?=$newsquery['fulltext_'.$language]?>
	</div></div></div>
	<?/*
	# Удалить новость
	if($userrole=="admin" or $userrole=="administrator" or $newsdata['nickname']==$nickname)
			{// Показываем ajax скрипт для удаления новости?>
			<li style="background:none; border:none">
            <a href="/" onClick="deletevchnews('<?=$vchid?>','<?=$newsdata['newsid']?>');return false;">Удалить <b>›</b></a>
			<script>function deletevchnews(vchid,someid){
			$("#content1").load('/ajax/',{id:someid,action:"deletevchnews",page:"divisions"},function(){showvchnews(vchid);});
			return false;}</script></li>
		<?	}
		
		
		# Краткий текст новости:		
		$fulltextall=explode("<br>",$newsdata['fulltext']);$fulltext=$fulltextall[0];// Берем все до перевода каретки и выыводим первые N символов
		echo substr($fulltext,0,118)."...";
		
		# Добавление новости
		<li class="gb"><span title="Добавить новость">Добавить новость</span>
		<textarea id="newvchnews" rows="3" cols="80" style="vertical-align:middle"></textarea>
		<a href="/" onClick="postvchnews('<?=$vchid?>');return false;">Добавить <b>›</b></a></li>
		<script>
		function postvchnews(vchid){
		var newsdata = document.getElementById('newvchnews');
		$('#content1').load('/ajax/', {action:"newvchnews",newvchnews:newsdata.value,vch:vchid},function(){showvchnews(vchid);});
		}
		</script>
		*/?>
	
<?}
}
?>