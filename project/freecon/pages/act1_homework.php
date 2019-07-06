<? if ($userrole=="user"){?>
<div class="div08">
	<div class="container">
		<div class="text 2row_color_block">
			Домашнее задание <br>Занятие 1
		</div>
	</div>
</div>        <div class="div11">
	<div class="container">
		
		<div class="maintitle" style=" font-size: 26px;">			
			Темы занятия - Калибровка и Ведение
		</div><br>
		<div class="justtext">
		

		</div>
		<br>
		
		<div class="list">
			<div class="item">
				<div class="title">
					<div class="num">0</div> Ознакомьтесь с правилами Клуба
				</div>
				<div class="text">
					Пожалуйста, прочтите <a href="/?page=club_concept_n_rules&previous_page=<?=$page?>" class="justlink">правила клуба</a>
				</div>
			</div><br>
			<div class="item">
				<div class="title">
					<div class="num">1</div> Прочитайте (или послушайте) теорию Калибровки
				</div>
				<div class="text">
					Пожалуйста, вспомните теорию о <a href="/?page=calibration&previous_page=<?=$page?>" class="justlink">Калибровке</a>
				</div>
			</div><br>
			<div class="item">
				<div class="title">
					<div class="num">2</div> Прочитайте тексты упражнений "Угадай, что мне хочется купить" и "Четыре близких человека" (Калибровка)
				</div>
				<div class="text">
					Пожалуйста, ознакомьтесь с текстами <a href="/?page=calibration_practice&previous_page=<?=$page?>" class="justlink">упражнений на Калибровку</a>
				</div>
			</div><br>
			<div class="item">
				<div class="title">
					<div class="num">3</div> Прочитайте теорию Шаблона псевдологики
				</div>
				<div class="text">
					Пожалуйста, вспомните теорию о <a href="/?page=LEADING_pseudologic&previous_page=<?=$page?>" class="justlink">Шаблоне псевдологики</a>
				</div>
			</div><br>
			<div class="item">
				<div class="title">
					<div class="num">4</div> Прочитайте текст упражнения "Хорошо - это плохо" (Шаблон псевдологики, Ведение)
				</div>
				<div class="text">
					Пожалуйста, ознакомьтесь с текстом <a href="/?page=LEADING_plogic_pract&previous_page=<?=$page?>" class="justlink">упражнения "Хорошо - это плохо"</a>
				</div>
			</div><br>
			<div class="item">
				<div class="title">
					<div class="num">5</div> Прочитайте текст упражнения "Афоризм" (Ассоциативное мышление, Ведение)
				</div>
				<div class="text">
					Пожалуйста, ознакомьтесь с текстом <a href="/?page=LEADING_assoc_pract&previous_page=<?=$page?>" class="justlink">упражнения "Афоризм"</a>
				</div>
			</div>
		</div>
			
			<br><br>
		<div class="ta_c">
			<a class="button" href="/?page=act2_homework" id="start_edu_link">Продолжить обучение</a><br><br><br>
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