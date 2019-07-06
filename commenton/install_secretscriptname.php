<?php
if (empty($_SERVER['QUERY_STRING'])) {
    header('Location: ' . urldecode($_SERVER['REQUEST_URI']) . '?u=db');
}

ini_set('display_errors', 'Off');

include 'headset.php';

$error = null;
if (isset($_POST['action'])) {
    if ($_POST['action'] == 'db_setting') {

        if (trim($_POST['cn_host']) === '') {
            $error = 'Укажите Сервер БД';
        } elseif (trim($_POST['cn_user']) === '') {
            $error = 'Укажите Пользователя БД';
        } else if (trim($_POST['cn_password']) === '') {
            $error = 'Укажите Пароль БД';
        } else if (trim($_POST['cn_base_name']) === '') {
            $error = 'Укажите Имя БД';
        }

        if ($error == null) {
            $mysqli = new mysqli($_POST['cn_host'], $_POST['cn_user'], $_POST['cn_password'], $_POST['cn_base_name']);
            $mysqli->set_charset('utf8mb4');

            if ($mysqli->connect_errno != 0) {
                $notice = null;
                switch ($mysqli->connect_errno) {
                    case 1045:
                        $notice = 'Не верное имя пользователя или пароль';
                        break;
                    case 1046:
                        $notice = 'Не выбрана БД';
                        break;
                    case 1049:
                        $notice = 'База <b>' . $_POST['cn_base_name'] . '</b> не найдена. Создайте базу и повторите попытку.';
                        break;
                    case 2002:
                        $notice = 'Ошибка сервера БД';
                        break;
                    default:
                        $notice = 'ERROR: ' . $mysqli->connect_error;
                }
                $error = $notice;
            }
        }

        if ($error == null) {
            $sql = $mysqli->query("
                    CREATE TABLE IF NOT EXISTS `commenton_comments` (
                      `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
                      `uid` int(11) NOT NULL,
                      `pid` text NOT NULL,
                      `page_title` text NOT NULL,
                      `text` text NOT NULL,
                      `attach` text,
                      `new` int(1) NOT NULL DEFAULT '1',
                      `posted` int(1) NOT NULL DEFAULT '1',
                      `moderation` int(1) NOT NULL DEFAULT '0',
                      `hype` int(11) NOT NULL DEFAULT '0',
                      `complain` longtext,
                      `date_published` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
                    ");
            if ($mysqli->errno != 0) $error = 'ERROR CREATE TABLE <b>"commenton_comments"</b>: ' . $mysqli->error;
        }

        if ($error == null) {
            $mysqli->query("
                    CREATE TABLE IF NOT EXISTS `commenton_comments_answer` (
                      `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
                      `parent_id` int(11) NOT NULL,
                      `mcid` int(11) NOT NULL,
                      `pid` text NOT NULL,
                      `page_title` text NOT NULL,
                      `uid` int(11) NOT NULL,
                      `puid` int(11) NOT NULL,
                      `text` text NOT NULL,
                      `attach` text,
                      `quote` text NOT NULL,
                      `new` int(1) NOT NULL DEFAULT '1',
                      `posted` int(1) NOT NULL DEFAULT '1',
                      `moderation` int(1) NOT NULL DEFAULT '0',
                      `hype` int(11) NOT NULL DEFAULT '0',
                      `complain` longtext,
                      `date_published` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
                    ");
            if ($mysqli->errno != 0) $error = 'ERROR CREATE TABLE <b>"commenton_comments_answer"</b>: ' . $mysqli->error;
        }

        if ($error == null) {
            $mysqli->query("
                    CREATE TABLE IF NOT EXISTS `commenton_rating` (
                      `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
                      `cid` varchar(20) NOT NULL,
                      `uid` int(11) NOT NULL,
                      `score` int(11) NOT NULL
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
                    ");
            if ($mysqli->errno != 0) $error = 'ERROR CREATE TABLE <b>"commenton_rating"</b>: ' . $mysqli->error;
        }

        if ($error == null) {
            $mysqli->query("
                    CREATE TABLE IF NOT EXISTS `commenton_user` (
                      `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
                      `name` varchar(50) NOT NULL,
                      `email` varchar(255) DEFAULT NULL,
                      `auth_via` varchar(25) NOT NULL,
                      `sid` varchar(255) DEFAULT NULL,
                      `avatar` varchar(255) NOT NULL DEFAULT '/img/avatar.jpg',
                      `link` varchar(255) DEFAULT NULL,
                      `uip` varchar(20) NOT NULL,
                      `status` varchar(100) NOT NULL DEFAULT '-',
                      `ban` int(1) NOT NULL DEFAULT '0',
                      `token` varchar(32) NOT NULL,
                      `date_reg` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
                    ");
            if ($mysqli->errno != 0) $error = 'ERROR CREATE TABLE <b>"commenton_user"</b>: ' . $mysqli->error;
        }

        if ($error == null) {
            $mysqli->query("
                    CREATE TABLE IF NOT EXISTS `commenton_comments_united` (
                      `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
                      `type` varchar(6) NOT NULL,
                      `cid` int(11) NOT NULL,
                      `mcid` int(11),
                      `date_published` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
                    ");
            if ($mysqli->errno != 0) $error = 'ERROR CREATE TABLE <b>"commenton_comments_united"</b>: ' . $mysqli->error;
        }

        if ($error == null) {
            $filePath = $_SERVER['DOCUMENT_ROOT'] . '/commenton/config/db_config.php';

            if (is_writable($filePath)) {
                $fileData = <<<HEREDOC
<?php

return array(
    "host" => "${_POST['cn_host']}",
    "user" => "${_POST['cn_user']}",
    "password" => "${_POST['cn_password']}",
    "base_name" => "${_POST['cn_base_name']}",
    "charset" => "utf8mb4"
);
HEREDOC;
                file_put_contents($filePath, $fileData);
            } else {
                $errorCode = 1;
                $error = 'Невозможно сохранить настройки, введите их вручную в файле ' . $filePath;
            }
        }

        if ($error == null) {
            header('Location: ' . $_SERVER['SCRIPT_NAME'] . '?u=set');
        }
    }


    if ($_POST['action'] == 'set_common') {

        if (trim($_POST['cn_admin_login']) === '') {
            $error = 'Укажите Логин администратора';
        } else if (trim($_POST['cn_admin_password']) === '') {
            $error = 'Укажите Пароль администратора';
        } else if (trim($_POST['cn_admin_password_repeat']) === '') {
            $error = 'Повторите Пароль администратора';
        }

        if ($error == null) {
            if ($_POST['cn_admin_password'] != $_POST['cn_admin_password_repeat']) {
                $error = 'Пароли не совпадают';
            }
        }

        if ($error == null) {
            $filePath = $_SERVER['DOCUMENT_ROOT'] . '/commenton/config/config.php';
            $folderConst = (defined('CN_PANEL_SCRIPT') && CN_PANEL_SCRIPT !== '') ? CN_PANEL_SCRIPT : 'panel';
            if (is_writable($filePath)) {
                $fileData = <<<HEREDOC
<?php

define('CN_TIME_ZONE', ''); //Список временных зон на http://php.net/manual/ru/timezones.php
define('CN_PROTOCOL', '${_POST['cn_protocol']}://');
define('CN_PANEL_SCRIPT', '${folderConst}');
define('CN_ADMIN_LOGIN', '${_POST['cn_admin_login']}');
define('CN_ADMIN_PASSWORD', '${_POST['cn_admin_password']}');
define('CN_COOKIE_TIME', '30');
define('CN_COOKIE_DOMAIN', '${_SERVER['HTTP_HOST']}');
HEREDOC;
                file_put_contents($filePath, $fileData);
            } else {
                $errorCode = 1;
                $error = 'Невозможно сохранить настройки, введите их вручную в файле ' . $filePath;
            }
        }

        if ($error == null) {
            header('Location: ' . $_SERVER['SCRIPT_NAME'] . '?u=end');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            color: #464646;
            margin: 0;
            padding: 0;
        }

        .cn_header {
            font-size: 20px;
            padding: 60px;
            margin: 20px;
            background: url("img/main_color.png") center / contain no-repeat;
            color: #000;
        }

        .block_form_db_setting, .block_form_setting_common {
            text-align: center;
            font-size: 20px;
        }

        .header_title {
            font-size: 30px;
            padding: 0 0 30px;
        }

        form {
            display: inline-block;
            text-align: left;
        }

        input, select {
            padding: 10px;
            font-size: 20px;
            margin-bottom: 10px;
            border: #c7c7c7 solid 1px;
        }

        input[type="submit"], input[type="button"] {
            cursor: pointer;
            border: none;
            color: #FFF;
            background: #25acd8;
        }

        .cn_install_completed {
            text-align: center;
        }

        .cn_install_completed pre {
            display: inline-block;
            background: #e0e0e0;
            padding: 2px 8px;
            border-radius: 2px;
        }

        .cn_error_notice {
            text-align: center;
            margin: 60px 0 20px;
        }

        .cn_error_notice span {
            display: inline-block;
        }

        .cn_error_notice span span {
            padding: 5px;
            margin-bottom: 15px;
            border-bottom: #b5b5b5 solid 1px;
        }

        .cn_error_notice a {
            float: right;
            text-decoration: none;
        }
    </style>
    <title>Установка/настройка скрипта</title>
</head>
<body>

<div class="cn_header"></div>

<?php if (isset($_GET['u']) && $_GET['u'] == 'db'): ?>
    <div class="block_form_db_setting">
        <div class="header_title">Настройка БД</div>
        <form name="form_db_setting" method="post">
            <label for="cn_host">Сервер БД</label>
            <br>
            <input id="cn_host" name="cn_host" type="text" required autocomplete="off"
                   value="<? echo isset($_POST['cn_host']) ? $_POST['cn_host'] : 'localhost' ?>">
            <br>
            <label for="cn_user">Пользователь БД</label>
            <br>
            <input id="cn_user" name="cn_user" type="text" required autocomplete="off"
                   value="<? echo isset($_POST['cn_user']) ? $_POST['cn_user'] : '' ?>">
            <br>
            <label for="cn_password">Пароль БД</label>
            <br>
            <input id="cn_password" name="cn_password" type="password" required autocomplete="off"
                   value="<? echo isset($_POST['cn_password']) ? $_POST['cn_password'] : '' ?>">
            <br>
            <label for="cn_base_name">Имя БД</label>
            <br>
            <input id="cn_base_name" name="cn_base_name" type="text" required
                   value="<? echo isset($_POST['cn_base_name']) ? $_POST['cn_base_name'] : '' ?>">
            <br><br>
            <input type="hidden" name="action" value="db_setting">
            <input type="submit" value="Сохранить">
        </form>
    </div>

    <div class="cn_error_notice">
        <span>
            <span><?php echo $error; ?></span>
            <br>
            <?php if (isset($errorCode) && $errorCode === 1): ?>
                <a href="<? echo $_SERVER['SCRIPT_NAME']; ?>?u=end"><input type="button" value="Продолжить"></a>
            <? endif; ?>
        </span>
    </div>

<? endif; ?>



<?php if (isset($_GET['u']) && $_GET['u'] == 'set'): ?>
    <div class="block_form_setting_common">
        <div class="header_title">Общие настройки</div>
        <form name="form_setting_common" method="post">
            <label for="cn_protocol">Протокол</label>
            <br>
            <select id="cn_protocol" name="cn_protocol">
                <option <?php echo ($_POST['cn_protocol'] == 'http') ? 'selected' : ''; ?> value="http">http</option>
                <option <?php echo ($_POST['cn_protocol'] == 'https') ? 'selected' : ''; ?> value="https">https</option>
            </select>
            <br>
            <label for="cn_admin_login">Логин администратора</label>
            <br>
            <input id="cn_admin_login" name="cn_admin_login" type="text" required autocomplete="off"
                   value="<?php echo isset($_POST['cn_admin_login']) ? $_POST['cn_admin_login'] : ''; ?>">
            <br>
            <label for="cn_admin_password">Пароль администратора</label>
            <br>
            <input id="cn_admin_password" name="cn_admin_password" type="password" required autocomplete="off"
                   value="<?php echo isset($_POST['cn_admin_login']) ? $_POST['cn_admin_password'] : ''; ?>">
            <br>
            <label for="cn_admin_password_repeat">Повторите пароль</label>
            <br>
            <input id="cn_admin_password_repeat" name="cn_admin_password_repeat" type="password" required autocomplete="off"
                   value="<?php echo isset($_POST['cn_admin_login']) ? $_POST['cn_admin_password_repeat'] : ''; ?>">
            <br><br>
            <input type="hidden" name="action" value="set_common">
            <input type="submit" value="Сохранить">
        </form>
    </div>

    <div class="cn_error_notice">
        <span>
            <span><?php echo $error; ?></span>
            <br>
            <?php if (isset($errorCode) && $errorCode === 1): ?>
                <a href="<? echo $_SERVER['SCRIPT_NAME']; ?>?u=end"><input type="button" value="Продолжить"></a>
            <? endif; ?>
        </span>
    </div>

<? endif; ?>

<?php if (isset($_GET['u']) && $_GET['u'] == 'end'): ?>
    <div class="cn_install_completed">
        <div class="header_title">Установка завершена!</div>
        <div style="margin-bottom: 30px">Удалите файл
            <pre>install.php</pre>
        </div>
        <div>
            <a href="/commenton/<?= CN_PANEL_SCRIPT ?>.php"><input type="button" value="В админку"></a>
        </div>
    </div>
<? endif; ?>

</body>
</html>