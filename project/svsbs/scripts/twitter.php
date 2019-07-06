<?php
# Вызывает класс TwitterOAuth, позволяет постить статус $messagetotwitter в твиттер
$tweet = new TwitterOAuth($twitterconsumerkey, $twitterconsumersecret, $twitteroauthtoken, $twitteroauthsecret);
$content = $tweet->get('account/verify_credentials');
// вызывать так $tweet->post('statuses/update', array('status' => "$messagetotwitter"));
?>