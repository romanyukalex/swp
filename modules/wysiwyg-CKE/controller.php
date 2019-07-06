<?php
 /**************************************************************\
  * Modulename	: modulename				 					* 
  * Part		: controller									*
  * Scripted By	: RomanyukAlex		           					* 
  * Website		: http://popwebstudio.ru	   					* 
  * Email		: admin@popwebstudio.ru     					* 
  * License		: GPL (General Public License)					* 
  * Purpose		: control all operations						*
  * Access		: include									 	*
  * if its needed to return some data just add $return_data		*
  \*************************************************************/
$log->LogInfo('Got this file with params - '.implode(',',$param));
if($nitka=='1'){
	
	if($contact=='init_5'){# Добавляем скрипты от CKE5

		/* ПРИМЕРЫ
		
		<textarea  id="editor1">Тест</textarea>
		<? insert_module("wysiwyg-CKE","init_5","classic","#editor1"); //вместо classic бывает inline, balloon (всплывающий),  balloon-block, decoupled-document
		
		
		<!-- decoupled-document -->
		<div id="toolbar-container"></div>
		<div id="editor"><p>This is the initial editor content.</p></div>
		insert_module("wysiwyg-CKE","init_5","decoupled-document","#editor");
		
		<!-- С параметрами -->
		
		<textarea  id="editor">Тест</textarea>
		<? 
		$cke_params="toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ],
        heading: {
            options: [
                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' }
            ]
        }";
		insert_module("wysiwyg-CKE","init_5","classic","#editor","$cke_params");
		
		*/
		
		$selector=$param[3];
		$show_view='cke5';
		
	}
	elseif ($contact=='init_4'){# Добавляем скрипты от CKE4
		/* <textarea  id="editor1">Тест</textarea>
		<? insert_module("wysiwyg-CKE","init_4","full","editor1"); //вместо full бывает standard и basic
		insert_module("wysiwyg-CKE","init_4","short","editor1","height:400, width:200");*/
		
		$selector=$param[3];
		$show_view='cke4';
		
	}
}
?>