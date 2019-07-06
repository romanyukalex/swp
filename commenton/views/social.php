<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="/<?php echo CN_FOLDER_SCRIPT; ?>/style/authorize.css" type="text/css" rel="stylesheet">
    <title><?php echo CN_AUTHORIZE; ?></title>
</head>
<body>

<?php if ($result === true): ?>
    <div class="cn_success_block">
        <div class="cn_success_notice"><?php echo CN_SUCCESS; ?>!</div>
    </div>
<?php endif; ?>

<?php if ($result === 'no_email'): ?>
    <div class="cn_email_block <?= strtolower($_SESSION['cn_provider_temp']); ?>_style">
        <div class="cn_title"><?php echo CN_MORE_INFO; ?></div>
        <p><?= CN_MORE_INFO_NOTE ?></p>

        <form action="/<?php echo CN_FOLDER_SCRIPT; ?>/authResult.php" name="submit" method="post">
            <label for="cn_email" class="cn_label_email"></label>
            <input id="cn_email" class="cn_email" name="email" type="email" placeholder="Email" value=""/>
            <input class="cn_auth_submit" type="submit" value="<?= CN_SAVE; ?>"/>
        </form>

        <div class="cn_form_skip">
            <form action="/<?php echo CN_FOLDER_SCRIPT; ?>/authResult.php" name="skip" method="post">
                <input name="skip" type="hidden" value="1">
                <input class="cn_auth_skip" type="submit" value="<?= CN_SKIP; ?>"/>
            </form>
        </div>

    </div>
    <?php exit(); ?>
<?php endif; ?>

<?php if ($result === false): ?>
    <div class="cn_error_block">
        <div class="cn_error_notice"><?php echo CN_ERROR; ?>!</div>
    </div>
<?php endif; ?>

<?php if ($result === 'email-incorrect'): ?>
    <div class="cn_error_block">
        <div class="cn_error_notice"><?php echo CN_EMAIL_INCORRECT; ?>!</div>
    </div>
<?php endif; ?>

</body>
</html>