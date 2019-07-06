<?php

class fbAuth
{
    public $client_id;
    public $client_secret;
    public $redirect_uri;
    public $scope = 'email';
    public $urlAuth = 'https://www.facebook.com/dialog/oauth';
    public $urlAuthToken = 'https://graph.facebook.com/oauth/access_token';
    public $urlGetUser = 'https://graph.facebook.com/me';
    public $provider = 'fbAuth';

    public function __construct()
    {
        $this->client_id = CN_SET_FB_CLIENT_ID;
        $this->client_secret = CN_SET_FB_CLIENT_SECRET;
        $this->redirect_uri = CN_PROTOCOL . $_SERVER['HTTP_HOST'] . '/' . CN_FOLDER_SCRIPT . '/authResult.php?provider=' . $this->provider;
    }

    public function getUri()
    {
        $param['client_id'] = $this->client_id;
        $param['redirect_uri'] = $this->redirect_uri;
        $param['scope'] = $this->scope;

        return $this->urlAuth . '?' . urldecode(http_build_query($param));
    }

    public function setUserData($code)
    {
        $param['client_id'] = $this->client_id;
        $param['client_secret'] = $this->client_secret;
        $param['redirect_uri'] = $this->redirect_uri;
        $param['code'] = $code;

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
            $params['fields'] = 'id,email,name,birthday,gender,first_name,last_name';

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $this->urlGetUser);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, urldecode(http_build_query($params)));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            $userResult = curl_exec($curl);
            curl_close($curl);

            $userData = json_decode($userResult, TRUE);

            $userDataArr[CN_T_SID] = $userData['id'];
            $userDataArr[CN_T_NAME] = $userData['name'];
            $userDataArr[CN_T_EMAIL] = $userData['email'];
            $userDataArr[CN_T_AVATAR] = 'https://graph.facebook.com/' . $userData['id'] . '/picture?type=large';
            $userDataArr[CN_T_LINK] = '';
            $userDataArr[CN_T_TOKEN] = md5(md5(microtime()) . $userDataArr[CN_T_NAME] . rand(0, 999999));

            if (isset($userDataArr[CN_T_SID]) && !empty($userDataArr[CN_T_SID])) {

                $result = CnUser::writeAuth($userDataArr, $this->provider);
            }
        }

        return $result;
    }
}