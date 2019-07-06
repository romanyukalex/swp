<?php

class CnUserController
{
    public function actionAuthorize()
    {
        CnSession::start();
        $userInfo = null;
        $result = false;

        if (isset($_GET['code']) && isset($_GET['provider']) || (isset($_GET['oauth_token']) && isset($_GET['oauth_verifier']))) {
            $provider = $_GET['provider'];
            $code = $_GET['code'];

            $provider_connect = new $provider();
            $userId = $provider_connect->setUserData($code);

            if ($userId !== false) {
                $userInfo = CnUser::getUserById($userId);
            }

            if ($userInfo !== null) {
                if ($userInfo[CN_T_BAN] === 0) {
                    if ($userInfo[CN_T_EMAIL] == '') {
                        $result = 'no_email';
                        $_SESSION['cn_userId_temp'] = $userInfo[CN_T_ID];
                        $_SESSION['cn_provider_temp'] = $_GET['provider'];
                    } else {
                        $result = CnUser::userLogin($userInfo[CN_T_ID], $userInfo[CN_T_TOKEN]);
                    }
                }
            } else {
                $result = false;
            }
        } elseif (isset($_POST['email'])) {

            $userInfo = CnUser::getUserById($_SESSION['cn_userId_temp']);

            if ($_POST['email'] != '') {
                $emailValid = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

                if ($emailValid == true) {
                    $writeEmail = CnUser::writeEmail($userInfo[CN_T_ID], $_POST['email']);
                    if ($writeEmail == true) {
                        $result = CnUser::userLogin($userInfo[CN_T_ID], $userInfo[CN_T_TOKEN]);
                    } else $result = false;
                } else {
                    $result = 'email-incorrect';
                }
            } else $result = 'no_email';
        } elseif (isset($_POST['skip'])) {
            $userInfo = CnUser::getUserById($_SESSION['cn_userId_temp']);
            $result = CnUser::userLogin($userInfo[CN_T_ID], $userInfo[CN_T_TOKEN]);
        }

        include_once $_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/views/social.php';

        unset($_SESSION['cn_userId_temp']);
        unset($_SESSION['cn_provider_temp']);


        echo '<script>
                  setTimeout(function () {
                      window.opener.document.location.reload();
                      window.close()
                  }, 1000);
              </script>';
    }
}