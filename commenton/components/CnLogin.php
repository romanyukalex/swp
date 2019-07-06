<?php

class CnLogin
{
    public static function login($uid, $utc)
    {
        CnSession::start();

        unset($_SESSION[CN_S_LOGGED_ADMIN]);

        $_SESSION[CN_S_USER_ID] = $uid;
        $_SESSION[CN_S_TOKEN] = $utc;

        setcookie(CN_S_USER_ID, $uid, time() + 60 * 60 * 24 * (int)CN_COOKIE_TIME, '/', CN_COOKIE_DOMAIN);
        setcookie(CN_S_TOKEN, $utc, time() + 60 * 60 * 24 * (int)CN_COOKIE_TIME, '/', CN_COOKIE_DOMAIN);

        return true;
    }

    public static function logout()
    {
        CnSession::start();

        unset($_SESSION[CN_S_USER_ID]);
        unset($_SESSION[CN_S_TOKEN]);
        unset($_SESSION[CN_S_LOGGED_ADMIN]);

        setcookie(CN_S_USER_ID, '', time() - 3600, '/', CN_COOKIE_DOMAIN);
        setcookie(CN_S_TOKEN, '', time() - 3600, '/', CN_COOKIE_DOMAIN);

        return true;
    }
}