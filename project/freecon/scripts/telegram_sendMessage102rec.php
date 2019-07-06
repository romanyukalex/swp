<? 
echo "Post To TG";


include($_SERVER['DOCUMENT_ROOT'].'/modules/telegram_api/vendor/autoload.php'); //Подключаем библиотеку

use Telegram\Bot\Api;

$telegram = new Api('316600410:AAGOtL1I7QcMA5jKU1kZH_iZWCHHXfnBrm4',true); //Устанавливаем токен, полученный у BotFather (102bot)

$chat_id="@podcasts102";


foreach($tg_post as $key=>$tg_post_arr){
	$log->LogInfo('102 rec. Post to telega. VK message id is '.$key);
	echo "<br>POST ID".$key;
	print_r($tg_post_arr);

	if($tg_post_arr['image']) $telegram->sendPhoto([ 'chat_id' => $chat_id, 'photo' => $tg_post_arr['image']]);

//	https://api.telegram.org/bot316600410:AAGOtL1I7QcMA5jKU1kZH_iZWCHHXfnBrm4/sendMessage?chat_id=@podcasts102&text="hellow!"
	$mes=$telegram->sendMessage([ 'chat_id' => $chat_id, 'disable_web_page_preview'=>true,'text' => $tg_post_arr['text']]);
	
}
?>