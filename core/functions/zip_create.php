<?php
 /****************************************************************
  * Snippet Name : isSiteAvailable		           				 * 
  * Scripted By  : RomanyukAlex		           					 * 
  * Website      : http://popwebstudio.ru	   					 * 
  * Email        : admin@popwebstudio.ru     					 * 
  * License      : GPL (General Public License)					 * 
  * Purpose 	 : Проверка работоспособности сайта на CURL		 *
  * Access		 : $response = isSiteAvailable($someUrl); 		 *
  ***************************************************************/
//$log->LogInfo('Got this file');
/* creates a compressed zip file */
function zip_create($files = array(),$destination = '',$overwrite = false) {
//	global $log;
//	$log->LogDebug("Called '".(__FUNCTION__)."' function with params: ".implode(',',func_get_args()));
//echo "Called '".(__FUNCTION__)."' function with params: ".implode(',',func_get_args());
	//if the zip file already exists and overwrite is false, return false
	if(file_exists($destination) && !$overwrite) { return false; }
	//vars
	$valid_files = array();
	//if files were passed in...
	if(is_array($files)) {
		//cycle through each file
		foreach($files as $file) {
			//make sure the file exists
			if(file_exists($file)) {
				$valid_files[] = $file;
			}
		}
	}
	//if we have good files...
	if(count($valid_files)) {
		//create the archive
		$zip = new ZipArchive();
		if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
			return false;
		}
		//add the files
		foreach($valid_files as $file) {
			$zip->addFile($file,$file);
		}
		//debug
		//echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;
		
		//close the zip -- done!
		$zip->close();
		
		//check to make sure the file exists
		return file_exists($destination);
	}
	else
	{
		return false;
	}
}
/***** Example Usage 
$files=array('file1.jpg', 'file2.jpg', 'file3.gif');
zip_create($files, 'myzipfile.zip', true); // По-моему с TRUE не работает***/
?>