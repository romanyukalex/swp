<? if ($userrole=="user"){?>
<div class="div08">
	<div class="container">
		<div class="text 2row_color_block">
			Домашнее задание <br>Занятие 2
		</div>
	</div>
</div>        <div class="div11">
	<div class="container">
		
		<div class="maintitle" style=" font-size: 26px;">			
			Темы занятия - Калибровка
		</div><br>
		<div class="justtext">
		

		</div>
		<br>
		<div class="justtext">
		Итак, на первом занятим мы тренировали основы Калибровки и навыков ассоциативного мышления, так необходимого при ведении человека.<br><br>
		
		
		Тема занятия на редкость чёткая - Калибровка. 
		Занятие не смешанное, все упражнения на занятии 2 будут на калибровку, но при этом не все они будут скучными и нужными. Мы, как всегда, постараемся раскрасить обучение в яркие эмоциональные краски.
		<br><br>Домашнее задание маленькое, тк до занятия осталось всего 2 дня.
		<br>Задание делится на 2 направления:
		<ul><li> задание для тех, кто новичок в калибровке (*),</li><li> и задание для тех, у кого уже кое что получается(**).</li></ul>
		<br>Если Вы не сделали по какой то причине ДЗ для первого занятия, то мы даём важные моменты и в этот раз.<br><br>
		</div>
		<div class="list">
			<div class="item">
				<div class="title">
					<div class="num">1</div> Прочитайте (или послушайте) теорию Калибровки (*)
				</div>
				<div class="text">
					Пожалуйста, вспомните теорию о <a href="/?page=calibration&previous_page=<?=$page?>" class="justlink">Калибровке</a>
				</div>
			</div><br>
			<div class="item">
				<div class="title">
					<div class="num">2</div> Посмотрите Lie to me (*)
				</div>
				<div class="text">
					Пожалуйста, если Вы не смотрели этот славный сериал, то обязательно ознакомьтесь с первым сезоном (самый наглядный - первый сезон). А если уже смотрели, то взгляните на него с другой, калибровочной точки зрения. "Обмани меня" - отличный журнал иллюстраций человеческих эмоций. <a href="//lostfilmonline.ru/load/obmani_menja/obmani_menja_1_j_sezon/obmani_menja_1_sezon_onlajn_hd_720p/174-1-0-48" class="justlink" target="_blank">Смотреть сейчас</a>
				</div>
			</div><br>
			<div class="item">
				<div class="title">
					<div class="num">3</div> Смотреть телевизор, программы новостей без звука (*)
				</div>
				<div class="text">
					Пожалуйста, найдите в доме телевизор и посмотрите его БЕЗ ЗВУКА. Обращайте внимание на мимику людей в кино, токшоу. Понятно, какие эмоции они транслируют? Это очень полезное и веселое упражнение
					</div>
			</div><br>
			<div class="item">
				<div class="title">
					<div class="num">4</div> Смотреть хорошее, качественное кино с хорошими актерами (*)
				</div>
				<div class="text">
					Пожалуйста, найдите на вечер фильм с хорошими актерами. Можно советсткий, можно голивудскую классику. Главное, чтобы актеры были харизматичными. Смотрите фильм и обращайте внимание на мимику актёров.
					</div>
			</div><br>
			<div class="item">
				<div class="title">
					<div class="num">5</div> Перед зеркалом изображаете эмоцию (**)
				</div>
				<div class="text">
					Мы часто управляем своей мимикой другими людьми, даже не замечая этого. Другие люди бессознательно считывают Ваши телесные и мимические (не путать с мимимическими) сигналы. Ведь наша мимика - это 70 процентов информации для собеседников.<br>
					Стоя перед зеркалом, изобразите (для начала) самые востребованные (для управления другими людьми) мимические реакции:
					<br>Одобрение, неодобрение, симпатия, благодарность<br>
					Задача изобразить и понять, насколько мою мимику могут считывать другие люди. Управляя своей мимикой в подстройке, Вы увидите, что люди начинают подстраиваться под Вас.
				</div>
			</div><br>
			<? if ($gender=="male"){?>
			<div class="item">
				<div class="title">
					<div class="num">6</div> Литературный оргазм (**)
				</div>
				<div class="text">
					Задание для мужчин (женщины это задание не видят). Откалибруйте на лицах 7 женщин половое возбуждение и, что характерно, оргазм.<br>
					<a href="//www.youtube.com/watch?v=BNhfwpnEjGg&list=PLuyVx7q_VVcC3vMp7JeTg-8mImv_77L05" class="justlink" target="_blank">Смотреть сейчас</a>
				</div>
			</div><br>
			<? }?>
		</div>
			
			<br><br>
		<div class="ta_c">
			<a class="button" href="/?page=act3_homework" id="start_edu_link">Продолжить обучение</a><br><br><br>
		</div>
	</div>
</div>               
</div>
<? } else{?>
<div class="div11">
	<div class="container">
		
		<div class="maintitle" style=" font-size: 26px;">			
			Пожалуйста, войдите
		</div><br><?
	insert_module("loginform_simple");?>
	</div>
<?}?>