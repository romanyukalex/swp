<? /* Скрипт, дающий экспортировать код и БД системы
Запускаешь генерацию
http://tscloud.popwebstudio.ru/?action=export_code
Ждешь 20 секунд
Скачиваешь файл
http://tscloud.popwebstudio.ru/project/tscloud/export/tscloud.swp.tar.gz
Затем удаляешь код
http://tscloud.popwebstudio.ru/?action=delete_exported_code

БД
Сливаешь БД в файл
http://tscloud.popwebstudio.ru/?action=export_db
Скачиваешь файл
http://tscloud.popwebstudio.ru/project/tscloud/export/tscloud.db.sql
Затем удаляешь дамп
http://tscloud.popwebstudio.ru/?action=delete_exported_dump
*/
$log->LogInfo('The new export request - '.$_REQUEST['action']);

if($_REQUEST['action']=='export_code'){
	$file=$fullpath.'project/'.$projectname.'/export/'.$projectname.'.swp.tar.gz';
	if(@system('tar cvzf '.$file.' adminpanel/ core/ files/ js/ logout/ modules/ pages/ style/ project/'.$projectname.'/files/ project/'.$projectname.'/modules_data/ project/'.$projectname.'/pages/ project/'.$projectname.'/scripts/ project/'.$projectname.'/templates/ project/projectdb.csv index.php 404.php')) {
		?>Code exported to file<?
	}
}
elseif($_REQUEST['action']=='export_db'){
	$file='project/'.$projectname.'/export/'.$projectname.'.db.sql';
	insert_function('Mysqldump');
	$dumpSettings = array(
    'compress' => Mysqldump::NONE,
    'no-data' => false,
    'add-drop-table' => true,
    'single-transaction' => true,
    'lock-tables' => true,
    'add-locks' => true,
    'extended-insert' => false,
    'disable-keys' => true,
    'skip-triggers' => false,
    'add-drop-trigger' => true,
    'databases' => false,
    'add-drop-database' => false,
    'hex-blob' => true,
    'no-create-info' => false,
    'where' => ''
    );
	$dump = new Mysqldump($databasename,$dbadmin_login,$dbadmin_pass,'localhost','mysql',$dumpSettings);
	$dump->start($file);	
	?>DB dumped to file<?
}
elseif($_REQUEST['action']=='delete_exported_code'){
	$file=$fullpath.'project/'.$projectname.'/export/'.$projectname.'.swp.tar.gz';
	unlink ($file);
	?>Platform code archive deleted from folder<?
}
elseif($_REQUEST['action']=='delete_exported_dump'){
	$file=$fullpath.'project/'.$projectname.'/export/'.$projectname.'.db.sql';
	unlink ($file);
	?>DB dump deleted from folder<?
}

