<?php

class CnSendMail
{
    public static function noticeAnswer($pid, $idAnswer, $userName, $textAnswer, $email)
    {
        $site = $_SERVER['HTTP_HOST'];
        $link = CN_PROTOCOL . $site . $pid . '#' . $idAnswer;
        $to = $email;
        $subject = CN_EMAIL_TITLE_ANSWER;
        $message = '
		<html>
		<head>
		<title>' . $subject . '</title>
		<style>
		body {
			font-family: Arial, sans-serif;
		}
		</style>
		</head>
		<body>
		<div style="font-size:18px;">' . $subject . '</div>
		<div style="padding:20px;">
			<div style="font-size:14px;color:#0b9df4;"><span dir="ltr">' . $userName . '</span> - <b style="color:#949ea7;font-size:12px;font-weight:normal;">' . date("d.m.Y H:i", time()) . '</b></div>
			<div>' . $textAnswer . '</div>
			<br/>
			<a href="' . $link . '">' . CN_LOOK_ON_SITE . '</a>
		</div>
		<br/><br/>
		' . CN_EMAIL_SIGN . $site . '!
		</body>
		</html>
	';
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=' . CN_SET_ENCODING . "\r\n";
        $headers .= 'From: ' . $site . ' <robot@' . $site . '>' . "\r\n";
        mail($to, $subject, $message, $headers);
    }

    public static function noticeForAdmin($pid, $id, $userName, $text)
    {
        $site = $_SERVER['HTTP_HOST'];
        $linkSite = CN_PROTOCOL . $site . $pid . '#' . $id;
        $linkPanel = CN_PROTOCOL . $site . '/' . CN_FOLDER_SCRIPT . '/' . CN_PANEL_SCRIPT . '.php' . '#' . $id;
        $to = CN_SET_ADMIN_MAIL;
        $subject = CN_EMAIL_TITLE_ADMIN;
        $message = '
		<html>
		<head>
		<title>' . $subject . '</title>
		<style>
		body {
			font-family: Arial, sans-serif;
		}
		</style>
		</head>
		<body>
		<div style="font-size:18px;">' . $subject . '</div>
		<div style="padding:20px;">
			<div style="font-size:14px;color:#0b9df4;"><span dir="ltr">' . $userName . '</span> - <b style="color:#949ea7;font-size:12px;font-weight:normal;">' . date("d.m.Y H:i", time()) . '</b></div>
			<div>' . $text . '</div>
			' . ((CN_SET_MODERATION === 'off') ? '<br/><a href="' . $linkSite . '">' . CN_LOOK_ON_SITE . '</a>' : '') . '
			<br/>
			<a href="' . $linkPanel . '">' . CN_LOOK_IN_PANEL . '</a>
		</div>
		<br/><br/>
		' . $site . '!
		</body>
		</html>
	';
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=' . CN_SET_ENCODING . "\r\n";
        $headers .= 'From: ' . $site . ' <robot@' . $site . '>' . "\r\n";
        mail($to, $subject, $message, $headers);
    }
}