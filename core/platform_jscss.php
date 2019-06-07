<? $log->LogInfo('Got this file');?>
<!-- standart project scripts and styles -->

<?
# Если вставляем bootstrap в конце сайта
if($takebootstrap_where=='В конце страницы') {
# Bootstrap
if($takebootstrap=='Ссылка на портал bootstrapcdn.com'){?>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

<? }elseif($takebootstrap=='Локальные файлы из /js/lib/bootstrap/'){?>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="/js/lib/bootstrap/css/bootstrap.min.css" type="text/css">
<!-- Latest compiled and minified JavaScript -->
<script src="/js/lib/bootstrap/js/bootstrap.min.js"></script>
<? }
}

/*if(!isset($adminpanel)){?><script type="text/javascript" src="/js/platformscripts.php"></script><?}*/