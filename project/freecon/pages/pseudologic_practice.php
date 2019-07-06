<? if ($userrole=="user"){?>
<div class="div08">
	<div class="container">
		<div class="text 2row_color_block">
			Ведение<br>
			Позвольте с Вами повальсировать
		</div>
	</div>
</div>        <div class="div11">
	<div class="container">
		
		<!--div class="maintitle" style=" font-size: 26px;">			
			Хорошо это плохо
		</div--><br>
	<div class="list">
			<div class="item">
				<div class="title">
					<div class="num">1</div> Хорошо - это плохо
				</div>
				<div class="text">
				Первый говорит утверждение о мире со знаком +, после чего, добавляет «логичное» объяснение через связку «потому, что...». <br>
				Например: «Заниматься спортом - это хорошо, потому чувствуешь себя сильным».<br>
				Следующий в группе (по часовой стрелке) берёт вторую часть и меняет её знак на – :<br>
				«Чувствовать силу - это плохо, потому что избыток силы приносит излишнюю самоуверенность».<br>
				Следующий в группе (по часовой стрелке) берёт вторую часть и меняет её знак на + :<br>
				«Излишняя самоуверенность - это хорошо, потому что карьеру можно сделать быстрее».<br>
				«Делать карьеру быстро - это плохо, потому что некачественно управляешь людьми».<br>
				И так далее по кругу в группе.
				</div>
			</div>
			
	</div>
		
		<div class="ta_c">
			<a class="button" href="/?page=<?=$_REQUEST['previous_page']?>">Продолжить обучение</a>
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