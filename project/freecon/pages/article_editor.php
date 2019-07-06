<? 
if ($userrole=="user"){
	
	
	if($_REQUEST['artID']){
		
	}?>

	<script>
	function post_article(){
		
		var page_html=$('#editor').html();
		var pageTitleRU_src=$('input[name=article_titleRU]').val();
		ajax_rq ('project_script','save_article','save_ap','save_ap',page_html, pageTitleRU_src);
	}
	</script>
   
	
	<form>
	
	<ul>
	<li>
		<div class="field_name">Название статьи</div>
		<div class="field_option">
			<input type="text" placeholder="Психология как философия или наоборот" name="article_titleRU" maxlength="200" required>
		</div>
	</li>

	
   <!-- This container will become the editable. -->
    <div id="editor">
		<h2>Подзаголовок</h2>
        <p>Текст статьи</p>
    </div>
	</form>
	<? $cke_params="
		
		toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ],
        heading: {
            options: [
                { model: 'paragraph', title: 'Текст в параграфе', class: 'ck-heading_paragraph' },
                { model: 'heading1', view: 'h2', title: 'Заголовок ур.2', class: 'ck-heading_heading1' },
				{ model: 'heading2', view: 'h3', title: 'Заголовок ур.3', class: 'ck-heading_heading2' }
            ]
        }";
		insert_module("wysiwyg-CKE","init_5","classic","#editor","$cke_params");?>
		<div id="save_ap"></div>
		<a class="large swp_button yellow" id="submit_a" style="color:white" onclick="post_article();return false;">Сохранить</a>




<? } else{?>
<div class="row">
	<div class="">
		
		<div class="maintitle" style=" font-size: 26px;">			
			Пожалуйста, войдите
		</div><br><?
	insert_module("loginform_simple");?>
	</div>
<?}?>