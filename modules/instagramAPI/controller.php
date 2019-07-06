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
  
  //https://github.com/mgp25/Instagram-API
  
$log->LogInfo('Got this file with params - '.implode(',',$param));
if($nitka=='1'){

	$post_params=$param[2]; //Это параметры запроса
	
	
	require 'vendor/autoload.php';
	/////// CONFIG ///////
	$username = $post_params['username'];
	$password = $post_params['password'];
	$debug = true; // ДЕБАГ мод
	$truncatedDebug = false;
	if($post_params['proxy']) $proxy=$post_params['proxy'];
	//////////////////////
	
	\InstagramAPI\Instagram::$allowDangerousWebUsageAtMyOwnRisk = true;

	$ig = new \InstagramAPI\Instagram($debug, $truncatedDebug);
	
	if($proxy) $ig->setProxy("$proxy"); //Если есть прокси, то открываем его

	try { // Нужно вызывать этот метод и без постинга раз в 30мин - 6 часов, как настоящий юзер
		$ig->login($username, $password);
	} catch (\Exception $e) {
		echo 'Something went wrong: '.$e->getMessage()."\n";
		exit(0);
	}
	
	if ($contact=='make_post'){ #Запостить фото в Instagram
		
		/* #Пример постинга фото с подписью
		
		$photoFilename = $_SERVER['DOCUMENT_ROOT'].'/project/freecon/files/lietomeposter.jpg';
		$caption_Text="Насмешки, юмор, шутки, подколы…";
		$post_params=array(
			"username"=>"your_username",
			"password"=>"your_pasword",
			"photo"=>$photoFilename,
			"text"=>$caption_Text,
			"location":"location (not_required)"
			"proxy": 'http://user:pass@iporhost:port' // или 'http://iporhost:port','https://user:pass@iporhost:port','https://iporhost:port','socks5://user:pass@iporhost:port'  и тп
		);
		$mediaId=insert_module("instagramAPI","make_post",$post_params);
		if($mediaId) echo "success. MediaId - ".$mediaId;
		else echo "no success"
		*/
		

		/////// MEDIA ////////
		$photoFilename = $post_params['photo'];
		$captionText = $post_params['text'];
		//////////////////////


		try {
			// The most basic upload command, if you're sure that your photo file is
			// valid on Instagram (that it fits all requirements), is the following:
			// $ig->timeline->uploadPhoto($photoFilename, ['caption' => $captionText]);

			// However, if you want to guarantee that the file is valid (correct format,
			// width, height and aspect ratio), then you can run it through our
			// automatic photo processing class. It is pretty fast, and only does any
			// work when the input file is invalid, so you may want to always use it.
			// You have nothing to worry about, since the class uses temporary files if
			// the input needs processing, and it never overwrites your original file.
			//
			// Also note that it has lots of options, so read its class documentation!
			$photo = new \InstagramAPI\Media\Photo\InstagramPhoto($photoFilename);
			$json_answer=$ig->timeline->uploadPhoto($photo->getFile(), ['caption' => $captionText]);
			//$return_data= true;
			$answ_arr=json_decode($json_answer, TRUE);
			$return_data=$answ_arr['media']['id'];
		} catch (\Exception $e) {
			echo 'Something went wrong: '.$e->getMessage()."\n";
			$return_data= false;
		}
			
	} elseif($contact=='get_userId_byUserName'){ #Узнать ID пользователя по никнейму
		
		/*
		$post_params=array(
			"username":"your_username",
			"password":"your_pasword",
			"targ_username":"someUserName"
		);
		insert_module("instagramAPI","get_userId_byUserName",$post_params);
		*/
				
		
		
	
		try {
			$return_data = $ig->people->getUserIdForName($post_params['targ_username']); //Узнать ID
		} catch (\Exception $e) {
			echo 'Something went wrong: '.$e->getMessage()."\n";
			$return_data= false;
		}
	
	
	} elseif($contact=='put_commentToPost'){ #Оставить комментарий к посту
	
		/*
		
		$mediaId="1921862734895817284_8774153562";

		$text="#хештеги";

		$post_params=array(
			"username"=>"your_username",
			"password"=>"your_pasword",
			"mediaId"=>$mediaId,
			"text"=>$text
		);
		insert_module("instagramAPI","put_commentToPost",$post_params);
		
		*/
	
	
		/////// MEDIA ////////
		$mediaId = $post_params['mediaId'];
		$commenttext = $post_params['text'];
		//////////////////////
	
		try {
				$ig->media->comment($mediaId, $commenttext);
				$return_data= true;
		} catch (\Exception $e) {
				echo 'Something went wrong: '.$e->getMessage()."\n";
				$return_data= false;
		}
	
	
	
	}  elseif($contact=='sendMessage'){ #Послать сообщение пользователю
		
		/*
		
		#Узнаём userId юзера
		$post_params=array(
			"username"=>"your_username",
			"password"=>"your_pasword",
			"targ_username"=>"romanyukalexey"
		);
		$userId=insert_module("instagramAPI","get_userId_byUserName",$post_params);

		$text="Насмешки, юмор, шутки, подколы…";
		// или $text="https://www.instagram.com/p/BqrZEKYhaRi/";
		$post_params=array(
			"username"=>"your_username",
			"password"=>"your_pasword",
			"recipients"=>[
						'users' => ["$userId"] // must be an [array] of valid UserPK IDs
					],
			"text"=>$text
		);
		insert_module("instagramAPI","sendMessage",$post_params);

		*/
		/////// MEDIA ////////
		$recipients = $post_params['recipients'];
		$text = $post_params['text'];
		//////////////////////

		\InstagramAPI\Instagram::$allowDangerousWebUsageAtMyOwnRisk = true;

		$ig = new \InstagramAPI\Instagram($debug, $truncatedDebug);


		try { // Нужно вызывать этот метод и без постинга раз в 30мин - 6 часов, как настоящий юзер
			$ig->login($username, $password);
		} catch (\Exception $e) {
			echo 'Something went wrong1: '.$e->getMessage()."\n";
			exit(0);
		}

		try {
			
			$ig->direct->sendText($recipients, $text);
		
			$return_data= true;
		} catch (\Exception $e) {
			echo 'Something went wrong2: '.$e->getMessage()."\n";
			$return_data= false;
		}
		
		
		
		
	}
}
?>