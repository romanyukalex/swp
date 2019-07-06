<?php

class gAuth
{
    public $client_id;
    public $client_secret;
    public $redirect_uri;
    public $scope = 'https://www.googleapis.com/auth/userinfo.email%20https://www.googleapis.com/auth/userinfo.profile';
    public $urlAuth = 'https://accounts.google.com/o/oauth2/v2/auth';
    public $urlAuthToken = 'https://accounts.google.com/o/oauth2/token';
    public $urlGetUser = 'https://www.googleapis.com/oauth2/v1/userinfo';
    public $provider = 'gAuth';

    public function __construct()
    {
        $this->client_id = CN_SET_G_CLIENT_ID;
        $this->client_secret = CN_SET_G_CLIENT_SECRET;
        $this->redirect_uri = CN_PROTOCOL . $_SERVER['HTTP_HOST'] . '/' . CN_FOLDER_SCRIPT . '/authResult.php?provider=' . $this->provider;
    }

    public function getUri()
    {
        $param['client_id'] = $this->client_id;
        $param['redirect_uri'] = $this->redirect_uri;
        $param['scope'] = $this->scope;
        $param['response_type'] = 'code';

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
            $params['access_token'] = $token['access_token'];

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $this->urlGetUser . '?' . urldecode(http_build_query($params)));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            $userResult = curl_exec($curl);
            curl_close($curl);

            $userData = json_decode($userResult, TRUE);

            $userDataArr[CN_T_SID] = $userData['id'];
            $userDataArr[CN_T_NAME] = $userData['name'];
            $userDataArr[CN_T_EMAIL] = $userData['email'];
            $userDataArr[CN_T_AVATAR] = $userData['picture'];
            $userDataArr[CN_T_LINK] = $userData['link'];
            $userDataArr[CN_T_TOKEN] = md5(md5(microtime()) . $userDataArr[CN_T_NAME] . rand(0, 999999));

            if (isset($userDataArr[CN_T_SID]) && !empty($userDataArr[CN_T_SID])) {

                $result = CnUser::writeAuth($userDataArr, $this->provider);
            }
        }

        return $result;
    }
}