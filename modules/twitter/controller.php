<?php
 /**************************************************************************************\
  * Modulename	: tweeter				 											* 
  * Part		: controller															*
  * Scripted By	: RomanyukAlex		           											* 
  * Website		: http://popwebstudio.ru	   											* 
  * Email		: admin@popwebstudio.ru     											* 
  * License		: GPL (General Public License)											* 
  * Purpose		: control all operations												*
  * Access		: $tweet_text="test".rand(1,1000);										*
  * $tweet_img_src=$_SERVER['DOCUMENT_ROOT']."/project/freecon/files/B17_logo.jpg";		*
  * $post_tweet=insert_module("twitter","post_tweet","$tweet_text");					*
  * $post_tweet=insert_module("twitter","post_tweet","$tweet_text",$tweet_img_src);		*
  * 							*
  \*************************************************************************************/
  
  /*
  //https://github.com/jublonet/codebird-php
  //http://www.pontikis.net/blog/auto_post_on_twitter_with_php
  
$params = [
  'status' => 'I love London',
  'lat'    => 51.5033,
  'long'   => 0.1197
];
$reply = $cb->statuses_update($params);
$params = [
  'screen_name' => 'jublonet'
];
$reply = $cb->users_show($params);

$reply = $cb->search_tweets('q=Twitter', true);

  */
  
$log->LogInfo('Got this file with params - '.implode(',',$param));
if($nitka=='1'){
	insert_function('process_user_data');
	// Перенести это в insert_module и ajaxapi
	if(isset($param[1])) $contact=$param[1]; // Вызвали как модуль
	elseif(isset($_REQUEST['action'])) $contact=process_data($_REQUEST['action'],30);
	
	if(!isset($contact)){$contact=$default_action;}
	$log->LogDebug('Action is '.$contact);
	global $twitterconsumerkey,$twitterconsumersecret, $twitteroauthtoken, $twitteroauthsecret;
	//echo $twitterconsumerkey."<br>".$twitterconsumersecret."<br>". $twitteroauthtoken."<br>". $twitteroauthsecret;
	if ($contact=='post_tweet'){# Страничка с продуктом
		$tweet_text=$param[2];
		$media=$param[3];
		// require codebird
		require_once($_SERVER["DOCUMENT_ROOT"].'/modules/twitter/codebird.php');
		 
		\Codebird\Codebird::setConsumerKey("$twitterconsumerkey", "$twitterconsumersecret");
		$cb = \Codebird\Codebird::getInstance();
		$cb->setToken("$twitteroauthtoken", "$twitteroauthsecret");
		
		if(!$media){
			$params = array('status' => "$tweet_text");
			$reply = $cb->statuses_update($params);
		}
		else {#Пост с картинкой
			echo $media;
			$params = array(
				'status' => "$tweet_text",
				'media[]' => "$media"
			);
			$reply = $cb->statuses_updateWithMedia($params);
		}
	}
}
?>