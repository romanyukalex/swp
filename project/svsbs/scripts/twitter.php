<?php
# �������� ����� TwitterOAuth, ��������� ������� ������ $messagetotwitter � �������
$tweet = new TwitterOAuth($twitterconsumerkey, $twitterconsumersecret, $twitteroauthtoken, $twitteroauthsecret);
$content = $tweet->get('account/verify_credentials');
// �������� ��� $tweet->post('statuses/update', array('status' => "$messagetotwitter"));
?>