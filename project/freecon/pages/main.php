<? insert_function("StringPlural");?>
<style>
.text_color{color:#555b5e}

</style>

<div class="row flex-items-md-center">

<div class="col-md-12">
Здравствуй, добрый Путник!
<br><br> Позволь проводить тебя на этом отрезке твоего Пути<br>
<br>
1. <a href="/?page=CTATbu&search_string=счастье" class="text_color" style="text-decoration:underline;">Счастлив</a> ты, Путник, если <a class="text_color" href="/?page=CTATbu&search_string=осознание">осознаешь</a>, что Путь открывает тебе глаза, на то, к чему ранее был слеп.<br><br>

2. Счастлив ты, Путник, если в дороге твой рюкзак освобождается от <a class="text_color"style="text-decoration:underline;" href="/?page=CTATbu&search_string=вещи">вещей</a>, а твое сердце наполняется <a class="text_color"style="text-decoration:underline;" href="/?page=CTATbu&search_string=чувства">чувствами</a>.<br><br>

3. Счастлив ты, Путник, если в Пути тебя начинает больше волновать не <a class="text_color"style="text-decoration:underline;" href="/?page=CTATbu&search_string=эго">собственное существование</a>, а пребывание в мире <a class="text_color"style="text-decoration:underline;" href="/?page=CTATbu&search_string=окружен">с другими людьми</a>.<br><br>

4. Счастлив ты, Путник, если ты открываешь, что шаг назад для <a class="text_color"style="text-decoration:underline;" href="/?page=CTATbu&search_string=альтруи">помощи другому человеку</a> стоит больше, чем <a class="text_color"style="text-decoration:underline;" href="/?page=CTATbu&search_string=тайм+менеджмент">сто вперед</a> без внимания к окружающим тебя людям.<br><br>

5. Счастлив ты, Путник, если тебе <a class="text_color"style="text-decoration:underline;" href="/?page=videos&search_string=ораторское">не хватает слов</a>, чтобы выразить <a class="text_color"style="text-decoration:underline;" href="/?page=CTATbu&search_string=благодар">благодарность</a> за все то, что приносит тебе Путь в каждом своем изгибе.<br><br>

6. Счастлив ты, Путник, если <a class="text_color"style="text-decoration:underline;" href="/?page=CTATbu&search_string=цель+жизн">созерцание Пути</a> ведет тебя к сути вещей и к рассвету.<br><br>

7. Счастлив ты, Путник, если ты ищешь правду и превращаешь свой Путь в жизнь, а жизнь — в <a class="text_color"style="text-decoration:underline;" href="/?page=CTATbu&search_string=предназначение">поиск Пути, Правды и Жизни</a>.<br><br>

8. Счастлив ты, Путник, если на Пути ты <a class="text_color"style="text-decoration:underline;" href="/?page=CTATbu&search_string=самопозн">встречаешься сам с собой</a> и даришь себе время для общения со своим сердцем.<br><br>

9. Счастлив ты, Путник, если ты открываешь, что Путь полнится <a class="text_color"style="text-decoration:underline;" href="/?page=CTATbu&search_string=медитац">тишиной, медитацией</a> и встречей с чудесами, которые всё время происходят, если ты их замечаешь.<br><br>

10. Счастлив ты, Путник, если, <a class="text_color"style="text-decoration:underline;" href="/?page=CTATbu&search_string=смерт">завершая Путь</a>, ты открываешь, что подлинный Путь только начинается.<br><br>
			
</div>			
<script src="//cdn.wordart.com/wordart.min.js" async defer></script>
<div style="width:100%" data-wordart-src="//wordart.com/cdn/json/ck1b0yoz7rs6"  data-wordart-show-attribution></div><br>
			<a class="button bcgr_red" href="/?page=club_concept_n_rules">Концепция и правила Клуба</a><br><br>
</div>

<div class="row">
	<div class="col-md-12">
	<? $stat_q=mysql_query("SELECT * FROM `freecon-stat-results` WHERE `ts` > '2018-08-13 23:55:00'");
			
			while($stat=mysql_fetch_assoc($stat_q)){
			
				if($stat['paramName']=="vid_needModerate"){
					$v_need_mod_stat=substr($stat['result'],0,-3);
				}
				elseif($stat['paramName']=="vid_active"){
					$video_count=substr($stat['result'],0,-3);
				}
				elseif($stat['paramName']=="pages_artcls_db"){
					$artcls_count=substr($stat['result'],0,-3);
				}
				elseif($stat['paramName']=="pages_aprovedToday"){
					$pages_today_activ=substr($stat['result'],0,-3);
				}
				elseif($stat['paramName']=="book_countAll"){
					$books_count=substr($stat['result'],0,-3);
				} elseif($stat['paramName']=="abook_countAll"){
					$abooks_count=substr($stat['result'],0,-3);
				}
				elseif($stat['paramName']=="book_countAddedToday"){
					$books_countAddedToday=substr($stat['result'],0,-3);
				}
				elseif($stat['paramName']=="jokes_countAll"){
					$jokes_count=substr($stat['result'],0,-3);
				}
			}?>
			 <a href='/?page=videos' class="justlink">Много видео о психологии</a> (<? 
			
			echo $video_count.' '.StringPlural::Plural($video_count, array('ролик', 'ролика', 'роликов'));
			?>, на модерации <?
			
			echo $v_need_mod_stat.' '.StringPlural::Plural($v_need_mod_stat, array('ролик', 'ролика', 'роликов'));
			?>)<br>
			<a href='/?page=CTATbu' class="justlink">Статьи по психологии</a>(<?
			#Всего статей
			
			echo $artcls_count.' '.StringPlural::Plural($artcls_count, array('статья', 'статьи', 'статей'));

			#Одобрены сегодня
			
			if($pages_today_active>0){
			echo ', опубликовано сегодня '.$pages_today_active.' '.StringPlural::Plural($pages_today_active, array('статья', 'статьи', 'статей'));
			}
			?>)<br>
			<a href='/?page=swpshop' class="justlink">
			Отобранные качественные записи с тренингов и инфопродукты (&#8381;)</a>(
			<?
			
			$trngs_count=mysql_fetch_array(mysql_query("SELECT COUNT(*) as COUNT FROM `$tableprefix-product` WHERE `status`='active';"));
			echo $trngs_count['COUNT'].' '.StringPlural::Plural($trngs_count['BOOKCOUNT'], array('запись', 'записи', 'записей'));
			?>
			)
			<br>
			
			<a href='/?page=psybooks' class="justlink">Коллекция книг по психологии и прикладной эзотерике</a>(<?
			
			echo $books_count.' '.StringPlural::Plural($books_count, array('книга', 'книги', 'книг'));
			
			#Одобрены сегодня
			if($books_count>0){
				echo ', добавлено сегодня '.$books_countAddedToday.' '.StringPlural::Plural($books_countAddedToday, array('книга', 'книги', 'книг'));
			}
			?>)<br>
			
			<a href='/?page=audios' class="justlink">Коллекция аудиокниг по психологии</a>(<?
			
			echo $abooks_count.' '.StringPlural::Plural($abooks_count, array('книга', 'книги', 'книг'));
			?>)<br>
			
			<a href='/?page=who_is_who&search_cat=trainers'class="justlink">База тренеров и психологов, практикующих в России</a>(<?
			$trnr_count=mysql_fetch_array(mysql_query("SELECT COUNT(*) as COUNT FROM `$tableprefix-contactlist` WHERE `position`='Тренер';"));
			echo  $trnr_count['COUNT'].' '.StringPlural::Plural( $trnr_count['COUNT'], array('специалист', 'специалиста', 'специалистов'));
			?>)
			<br>
			<a href='/?page=psy_jokes' class="justlink">Шутки юмора о психологах и около</a> (<?
			
			echo  $jokes_count.' '.StringPlural::Plural( $jokes_count, array('анекдот', 'анекдота', 'анекдотов'));?>)
			
			<br><br>
	</div>
</div>	