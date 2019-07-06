<?php

class okAuth
{
    public $client_id;
    public $public_key;
    public $client_secret;
    public $redirect_uri;
    public $urlAuth = 'http://www.odnoklassniki.ru/oauth/authorize';
    public $urlAuthToken = 'http://api.odnoklassniki.ru/oauth/token.do';
    public $urlGetUser = 'http://api.odnoklassniki.ru/fb.do';
    public $provider = 'okAuth';

    public function __construct()
    {
        $this->client_id = CN_SET_OK_CLIENT_ID;
        $this->public_key = CN_SET_OK_PUBLIC_KEY;
        $this->client_secret = CN_SET_OK_CLIENT_SECRET;
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
            $params['application_key'] = $this->public_key;
            $params['format'] = 'json';
            $params['method'] = 'users.getCurrentUser';
            $params['access_token'] = $token['access_token'];
            $params['sig'] = md5('application_key=' . $this->public_key . 'format=jsonmethod=users.getCurrentUser' . md5($token['access_token'] . $this->client_secret));

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $this->urlGetUser);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, urldecode(http_build_query($params)));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            $userResult = curl_exec($curl);
            curl_close($curl);

            $userData = json_decode($userResult, TRUE);

            $userDataArr[CN_T_SID] = $userData['uid'];
            $userDataArr[CN_T_NAME] = $userData['name'];
            $userDataArr[CN_T_EMAIL] = '';
            $userDataArr[CN_T_AVATAR] = $userData['pic_1'];
            $userDataArr[CN_T_LINK] = 'https://ok.ru/profile/'.$userData['uid'];
            $userDataArr[CN_T_TOKEN] = md5(md5(microtime()) . $userDataArr[CN_T_NAME] . rand(0, 999999));

            if (isset($userDataArr[CN_T_SID]) && !empty($userDataArr[CN_T_SID])) {

                $result = CnUser::writeAuth($userDataArr, $this->provider);
            }
        }

        return $result;
    }
}