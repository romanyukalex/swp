<?php
 /**************************************************************\
  * Modulename	: modulename				 					* 
  * Part		: controller									*
  * Scripted By	: RomanyukAlex		           					* 
  * Website		: http://popwebstudio.ru	   					* 
  * Email		: admin@popwebstudio.ru     					* 
  * License		: GPL (General Public License)					* 
  * Purpose		: control all operations						*
  * Access		:  insert_module("youtube-api",""); 	*
  \*************************************************************/
  
  /*
  #Как получить access_token
 
  */
$log->LogDebug('Got this file with params - '.implode(',',$param));
if($nitka=='1'){
	insert_function('process_user_data');
	// Перенести это в insert_module и ajaxapi
	if(isset($param[1])) $contact=$param[1]; // Вызвали как модуль
	elseif(isset($_REQUEST['action'])) $contact=process_data($_REQUEST['action'],30);
	
	if(!isset($contact)){$contact=$default_action;}
	$log->LogDebug('Action is '.$contact);
	
	global $yt_api_key;
	

	require_once 'Google/autoload.php';
	
	########################################
	## Сохранить видео в плейлист YouTube ##
	########################################
	
	if($contact=='save_video_to_playlist'){
	


	
	function playlistItemsInsert($service, $properties, $part, $params) {
    $params = array_filter($params);
    $propertyObject = createResource($properties); // See full sample for function
    $resource = new Google_Service_YouTube_PlaylistItem($propertyObject);
    $response = $service->playlistItems->insert($part, $resource, $params);
    print_r($response);
}

playlistItemsInsert($service,
    array('snippet.playlistId' => $param[2],
           'snippet.resourceId.kind' => 'youtube#video',
           'snippet.resourceId.videoId' => $param[3],
           'snippet.position' => ''),
    'snippet', 
    array('onBehalfOfContentOwner' => ''));
	
	
	
	
	
	
	
	//	$url = 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&key='.$yt_api_key;


//		. '&playlistId=' . $param[2]
//		. '&resourceId='.$param[3]
		
		
		$buf = file_get_contents($url);

		
		
		/*
		{
"snippet":
{
"playlistId":"
PLbtvafp98VwAZAoAUdkS1fjHz3jeqdBGh
"
"resourceId":
{
"kind":"
youtube#video
"
"videoId":"
a-k8_ntb-E0
"

}

}

}
		*/
		
		
		
		
	} else {
		
		/*
		function YoutubeData($action,$some_id,$yt_api_key,$maxResults="15") {
	if($action=="get_videos_by_chid"){
	
		// выдача фида канала
		$url = 'https://www.googleapis.com/youtube/v3/search?part=snippet'
			. '&channelId=' . $some_id
			. '&order=date' // упорядочивать по дате добавления
			. '&maxResults='.$maxResults // за раз получать не более 5 результатов
			 //. '&fields=items/id/videoId'  // нам нужны только идентификаторы видео
			. '&key=' . $yt_api_key;
			//Пример: https://www.googleapis.com/youtube/v3/search?part=snippet&channelId=UCO6cpWSqqW9MKNCBtZFPJ0A&key=AIzaSyAWbODxz_E-CFPgbsa9zgpNzIwYTkBBUEI
	} elseif($action=="get_videos_by_plid"){
		$url = 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet'
			. '&playlistId=' . $some_id
			. '&order=date' // упорядочивать по дате добавления
			. '&maxResults='.$maxResults // за раз получать не более 5 результатов
			 //. '&fields=items/id/videoId'  // нам нужны только идентификаторы видео
			. '&key=' . $yt_api_key;
			//Пример:https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=50&playlistId=PLqSTFWHJscVfDacNWshZkU0KfVDbq0LdH&key=AIzaSyAWbODxz_E-CFPgbsa9zgpNzIwYTkBBUEI
	
	} elseif($action=="get_videos_by_words"){
	
		//$words=explode(';',$some_id);
		
		$url = 'https://www.googleapis.com/youtube/v3/search?part=snippet&q='.
		str_replace(' ','%20', $some_id)
		.'&order=date&type=video&maxResults='.$maxResults.'&key='. $yt_api_key;
		//Пример:    https://www.googleapis.com/youtube/v3/search?part=snippet&q=%D0%B1%D0%B8%D0%B7%D0%BD%D0%B5%D1%81%20%D0%BF%D0%BE%20%D0%B6%D0%B5%D0%BD%D1%81%D0%BA%D0%B8&order=date&type=video&maxResults=50&key=AIzaSyAWbODxz_E-CFPgbsa9zgpNzIwYTkBBUEI
		
	}
	$buf = file_get_contents($url);
	// декодируем JSON данные
	$json = json_decode($buf, 1);
	//echo 'ДО!! Первое видео в tarr '. $json ['items']['id']['videoId'];
	//print_r($json);
	return $json;
}
		*/
		
	}
}
?>