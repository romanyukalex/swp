<? 
//echo $pagequery[autor];
$article_user_data=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-users` u,`$tableprefix-contactlist` cl WHERE u.`userid`='$pagequery[autor]' and cl.`user_data`=u.`userid`;"));
?>
<!-- Автор -->
<div class="row  flex-items-md-center commentaries">

	<div id="comments" class="commentaries col-md-6 ">
		<div class="container">
			<!--div class="col-md-6 "-->
				<h4>Статья подготовлена</h4>
				<div class="commentaries_wrap">
					<div class="commentaries__counter-clear"></div>
					<div class="comment-container-js">
						<div class="comment-list-js">
							<div class="commentaries_item level1 comment-js">
								<div class="commentaries_pic">
									<? //Ссылка
									if(!empty($article_user_data['contactmail'])){$author_link='mailto:'.$article_user_data['contactmail'];}
									elseif($article_user_data['website']){
										if(!mb_strstr($article_user_data['website'],"http")) $author_link='http://';
										$author_link.=$article_user_data['website'];
									}?>
									
									
									<a href="<?//=$author_link?>#" style="color: #36cdb6;">
										<img class="img" src="<?=$article_user_data['user_photo']?>" alt="<?=$article_user_data['second_name']." ".$article_user_data['first_name']?>"
										onclick="$('#author_detail_modal').modal('show');return false;"
										>
									</a>
								</div>
								<div class="commentaries_detals">
									<span class="name">
										<a target="_blank" href="<?//=$author_link?>#" onclick="$('#author_detail_modal').modal('show');return false;"><?=$article_user_data['second_name']." ".$article_user_data['first_name']?></a>
									</span>
									<!--span class="date"><?=substr($pagequery['creation_date'],0,10)?></span-->
									<div class="text">
										<?=$article_user_data['position']?><br>
										
										<a class="fancybox-popup_login highslide" href="#" 
										<? /*onclick="return hs.htmlExpand(this, { contentId: 'autor_info_<?=$article_user_data['contact_id'];?>' } )"*/?>
										onclick="$('#author_detail_modal').modal('show');return false;"
										style="color: #36cdb6;">Подробнее об источнике</a>
						
										<? ?>
										<br><a href="<?=$pagequery['orig_link'];
										if (mb_strstr($pagequery['orig_link'],'b17.ru')){
										?>?prt=psyspace<? }?>" target="_blank" style="color: #36cdb6;">Оригинал статьи</a>
										
									</div>
								</div>
			
								<div class="clear"></div>
							</div>
						</div>
					</div>
				</div>
			<!--/div-->
		</div>
	</div>
	<div class="col-md-5"style="display: table;">
		<div style="display: table-cell; vertical-align: middle;"><span class="date" ><?=substr($pagequery['creation_date'],0,10)?></span></div>
	</div>
	<div class="col-md-12"style="display: table;">
		<div style="display: table-cell; vertical-align: middle;"><i style='font-size:9px; text-align:  center;'>Статья выложена в ознакомительных целях. Все права на текст принадлежат ресурсу и/или автору (<?=$article_user_data['second_name']." ".$article_user_data['first_name']?>)</i></div>
	</div>
</div>




<div class="modal fade" id="author_detail_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel"><?=$article_user_data['first_name']." ".$article_user_data['patronymic_name']." ".$article_user_data['second_name']?></h4></span>
      </div>
      <div class="modal-body">
		<img src="<?=$article_user_data['user_photo']?>" width="153px"style="float:left; margin-right:10px">
		<?=$article_user_data['comment']?>
      </div>
    </div>
  </div>
</div>
<!-- // Автор -->