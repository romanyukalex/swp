<?php

class vkAuth
{
    public $client_id;
    public $client_secret;
    public $scope = 'email';
    public $redirect_uri;
    public $urlAuth = 'http://oauth.vk.com/authorize';
    public $urlAuthToken = 'https://oauth.vk.com/access_token';
    public $urlGetUser = 'https://api.vk.com/method/users.get';
    public $provider = 'vkAuth';

    public function __construct()
    {
        $this->client_id = CN_SET_VK_CLIENT_ID;
        $this->client_secret = CN_SET_VK_CLIENT_SECRET;
        $this->redirect_uri = CN_PROTOCOL . $_SERVER['HTTP_HOST'] . '/' . CN_FOLDER_SCRIPT . '/authResult.php?provider=' . $this->provider;
    }

    public function getUri()
    {
        $param['client_id'] = $this->client_id;
        $param['scope'] = $this->scope;
        $param['redirect_uri'] = $this->redirect_uri;

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
            $params['uids'] = $token['user_id'];
            $params['access_token'] = $token['access_token'];
            $params['fields'] = 'uid,first_name,last_name,screen_name,sex,bdate,photo_50';
            $params['v'] = '5.73';

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $this->urlGetUser);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, urldecode(http_build_query($params)));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            $userResult = curl_exec($curl);
            curl_close($curl);

            $userData = json_decode($userResult, TRUE);

            $userDataArr[CN_T_SID] = $userData['response'][0]['id'];
            $userDataArr[CN_T_NAME] = $userData['response'][0]['first_name'] . ' ' . $userData['response'][0]['last_name'];
            $userDataArr[CN_T_EMAIL] = $token['email'];
            $userDataArr[CN_T_AVATAR] = $userData['response'][0]['photo_50'];
            $userDataArr[CN_T_LINK] = 'https://vk.com/'.$userData['response'][0]['screen_name'];
            $userDataArr[CN_T_TOKEN] = md5(md5(microtime()) . $userDataArr[CN_T_NAME] . rand(0, 999999));

            if (isset($userDataArr[CN_T_SID]) && !empty($userDataArr[CN_T_SID])) {

                $result = CnUser::writeAuth($userDataArr, $this->provider);
            }
        }

        return $result;
    }
}