<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="/<?php echo CN_FOLDER_SCRIPT; ?>/style/login.css" type="text/css" rel="stylesheet">
    <script src="/<?php echo CN_FOLDER_SCRIPT; ?>/js/jquery-3.2.1.min.js"></script>
    <script src="/<?php echo CN_FOLDER_SCRIPT; ?>/js/ajax.js"></script>
    <title><?php echo CN_ENTER_PANEL; ?></title>
</head>
<body>

<div class="cn_login_body">
    <div class="cn_login_block">
        <div class="cn_login_title"><?php echo CN_ENTER_PANEL; ?></div>
        <div class="cn_login_form">
            <label for="cn_login">
                <input id="cn_login" name="cn_login" type="text" placeholder="<?php echo CN_USERNAME; ?>">
            </label>
            <label for="cn_password">
                <input id="cn_password" name="cn_password" type="password" placeholder="<?php echo CN_PASSWORD; ?>">
            </label>
            <input class="cn_login_submit" name="cn_login_submit" type="submit" value="<?php echo CN_LOGIN; ?>">
        </div>
    </div>
</div>

</body>
</html>