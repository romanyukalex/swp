<? 

$log->LogInfo('Post to telega. Message is '.$tg_mes);
include($_SERVER['DOCUMENT_ROOT'].'/modules/telegram_api/vendor/autoload.php'); //Подключаем библиотеку

use Telegram\Bot\Api;

$telegram = new Api('468386961:AAG6Ih5bIT6iCP4oT6lu5MJJpX-SwI1iXaw',true); //Устанавливаем токен, полученный у BotFather (PsyspaceBot)

$chat_id="@soznanie_club";

if($tg_img) $telegram->sendPhoto([ 'chat_id' => $chat_id, 'photo' => $tg_img]);
sleep (1);
$telegram->sendMessage([ 'chat_id' => $chat_id, 'text' =>$tg_mes]);
?>