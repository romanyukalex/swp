<? $log->LogInfo('Got this file');?>
<!-- standart project scripts and styles (platform_jscss) -->
<? 
# Если вставляем bootstrap в конце сайта

if($takebootstrap_where=='В конце страницы') {
	# Bootstrap
	if($takebootstrap=='Ссылка на портал bootstrapcdn.com'){?>
		<!-- Bootstrap. Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

		<!-- Bootstrap. Latest compiled and minified JavaScript -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

<? 	} elseif($takebootstrap=='Локальные файлы из /js/lib/bootstrap/'){?>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="/js/lib/bootstrap/css/bootstrap.min.css" type="text/css">
		<!-- Latest compiled and minified JavaScript -->
		<script src="/js/lib/bootstrap/js/bootstrap.min.js"></script>
<?	}
}?>