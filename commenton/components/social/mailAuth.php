<?php

class mailAuth
{
    public $client_id;
    public $client_secret;
    public $redirect_uri;
    public $urlAuth = 'https://connect.mail.ru/oauth/authorize';
    public $urlAuthToken = 'https://connect.mail.ru/oauth/token';
    public $urlGetUser = 'http://www.appsmail.ru/platform/api';
    public $provider = 'mailAuth';

    public function __construct()
    {
        $this->client_id = CN_SET_MM_CLIENT_ID;
        $this->client_secret = CN_SET_MM_CLIENT_SECRET;
        $this->redirect_uri = CN_PROTOCOL . $_SERVER['HTTP_HOST'] . '/' . CN_FOLDER_SCRIPT . '/authResult.php?provider=' . $this->provider;
    }

    public function getUri()
    {
        $param['client_id'] = $this->client_id;
        $param['response_type'] = 'code';
        $param['redirect_uri'] = $this->redirect_uri;

        return $this->urlAuth . '?' . urldecode(http_build_query($param));
    }

    public function setUserData($code)
    {
        $param['client_id'] = $this->client_id;
        $param['client_secret'] = $this->client_secret;
        $param['redirect_uri'] = $this->redirect_uri;
        $param['code'] = $code;
        $param['grant_type'] = 'authorization_code';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->urlAuthToken);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, urldecode(http_build_query($param)));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        $result = curl_exec($curl);
        curl_close($curl);

        $token = json_decode($result, TRUE);

        $userDataArr = null;

        if (isset($token['access_token'])) {
            $params['method'] = 'users.getInfo';
            $params['app_id'] = $this->client_id;
            $params['session_key'] = $token['access_token'];
            $params['secure'] = '1';
            $params['uids'] = $token['x_mailru_vid'];
            $params['sig'] = md5("app_id=" . $this->client_id . "method=users.getInfosecure=1session_key=" . $token['access_token'] . "uids=" . $token['x_mailru_vid'] . $this->client_secret);

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $this->urlGetUser);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, urldecode(http_build_query($params)));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            $userResult = curl_exec($curl);
            curl_close($curl);

            $userData = json_decode($userResult, TRUE);

            $userDataArr[CN_T_SID] = $userData[0]['uid'];
            $userDataArr[CN_T_NAME] = $userData[0]['nick'];
            $userDataArr[CN_T_EMAIL] = $userData[0]['email'];
            $userDataArr[CN_T_AVATAR] = str_replace('http://', 'https://', $userData[0]['pic_small']);
            $userDataArr[CN_T_LINK] = $userData[0]['link'];
            $userDataArr[CN_T_TOKEN] = md5(md5(microtime()) . $userDataArr[CN_T_NAME] . rand(0, 999999));

            if (isset($userDataArr[CN_T_SID]) && !empty($userDataArr[CN_T_SID])) {

                $result = CnUser::writeAuth($userDataArr, $this->provider);
            }
        }

        return $result;
    }
}