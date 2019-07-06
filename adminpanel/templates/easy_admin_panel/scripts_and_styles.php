<? 
  /***************************************************************************************************************************
  * Snippet Name : Scripts and styles																						 * 
  * Scripted By  : RomanyukAlex		           																				 * 
  * Website      : http://popwebstudio.ru	   																				 * 
  * Email        : admin@popwebstudio.ru    					 														     * 
  * License      : License on popwebstudio.ru from autor		 															 *
  * Purpose 	 : Вставляется в <head></head>, содержит стили и javascripts шаблона										 *
  * Insert		 : include_once('/templates/$currenttemplate/scripts_and_styles.php');										 *
  ***************************************************************************************************************************/ 

 ?>

<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
 <!-- Bootstrap Core CSS -->
<? /*if($userrole!=='guest' ){?>
<link href="/adminpanel/templates/<?=$adminsitetemplate?>/css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<? } else {*/?>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap-flex.min.css" rel="stylesheet">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>


<?// }?>


<!-- Custom CSS -->
<link href="/adminpanel/templates/<?=$adminsitetemplate?>/css/style.css" rel='stylesheet' type='text/css' />
<!-- Graph CSS -->
<link href="/adminpanel/templates/<?=$adminsitetemplate?>/css/font-awesome.css" rel="stylesheet"> 
<!-- jQuery -->
<!-- lined-icons -->
<link rel="stylesheet" href="/adminpanel/templates/<?=$adminsitetemplate?>/css/icon-font.min.css" type='text/css' />
<!-- //lined-icons -->
<!-- chart -->
<script src="/adminpanel/templates/<?=$adminsitetemplate?>/js/Chart.js"></script>
<!-- //chart -->
<!--animate-->
<link href="/adminpanel/templates/<?=$adminsitetemplate?>/css/animate.css" rel="stylesheet" type="text/css" media="all">
<script src="/adminpanel/templates/<?=$adminsitetemplate?>/js/wow.min.js"></script>
	<script>
		 new WOW().init();
	</script>
<!--//end-animate-->
<!----webfonts--->
<link href='//fonts.googleapis.com/css?family=Cabin:400,400italic,500,500italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<!---//webfonts---> 
 <!-- Meters graphs -->
<script src="/adminpanel/templates/<?=$adminsitetemplate?>/js/jquery-1.10.2.min.js"></script>
<!-- Placed js at the end of the document so the pages load faster -->

