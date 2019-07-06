<?php
 /**************************************************************************\
  * Snippet Name : modulename		           					 			*
  * Part		 : view (view)												*
  * Scripted By  : RomanyukAlex		           					 			*
  * Website      : http://popwebstudio.ru	   					 			*
  * Email        : admin@popwebstudio.ru     					 			*
  * License      : GPL (General Public License)					 			*
  * Purpose 	 : do something								 				*
  * Access		 : 															*
  * insert_module('modulename','get_some',$get_detail_arr)					*
  \*************************************************************************/
$log->LogDebug('Got this file');
if ($nitka=='1'){?>
<script src="https://cdn.ckeditor.com/ckeditor5/12.0.0/<?=$param[2]?>/ckeditor.js"></script>

<script>
<? if($param[2]=="classic" or $param[2]=="inline" or  $param[2]=="balloon" or $param[2]=="balloon-block"){
 
 if($param[2]=="balloon-block") $param[2]="balloon"; //Ну такое вот исключение у производителя, что метод не называется balloon-block, а просто baloon
 
 echo ucfirst ($param[2])?>Editor
	.create( document.querySelector( '<?=$selector?>' )<? if($param[4]){echo ", {".$param[4]."}";}?> )
	.catch( error => {
		console.error( error );
	} );
<? } elseif($param[2]=="decoupled-document"){
	?>
	DecoupledEditor
            .create( document.querySelector( '<?=$selector?>'<? if($param[4]){echo ", {".$param[4]."}";}?>  ) )
            .then( editor => {
                const toolbarContainer = document.querySelector( '#toolbar-container' );

                toolbarContainer.appendChild( editor.ui.view.toolbar.element );
            } )
            .catch( error => {
                console.error( error );
            } );<?
	
}

?>
</script>
	
	
<? }?>