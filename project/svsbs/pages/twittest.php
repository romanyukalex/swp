<?
# Подключение возможности твитнуть
require_once $_SERVER["DOCUMENT_ROOT"]."/included_classes/TwitterOAuth.php";
if ($twitterconsumerkey and $twitterconsumersecret and $twitteroauthtoken and $twitteroauthsecret){
define("CONSUMER_KEY", "DGup3X6fLFDB7a3WoQOEA");
define("CONSUMER_SECRET", "RKyE2pSi2qsNMNiOFQlKeTZZkIFyANku3CG7lwEjg");
define("OAUTH_TOKEN", "314150987-pkFTYydIffE9ITKHNz3NOluh2GtxmUsIrof5lyXu");
define("OAUTH_SECRET", "425QNLhdY2DeseBs8cwItemtiYxd9AiGNmOuDVmn0A");
//$tweet = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_TOKEN, OAUTH_SECRET);
//$tweet = new TwitterOAuth($twitterconsumerkey, $twitterconsumersecret, $twitteroauthtoken, $twitteroauthsecret);
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_TOKEN, OAUTH_SECRET);
$content = $connection->get('account/verify_credentials');
$connection->post('statuses/update', array('status' => "$messsdsadadas"));

}
?>