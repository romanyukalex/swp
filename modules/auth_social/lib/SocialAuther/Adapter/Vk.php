<?php

namespace SocialAuther\Adapter;

class Vk extends AbstractAdapter
{
    public function __construct($config)
    {
		
        parent::__construct($config);

        $this->socialFieldsMap = array(
            'socialId'   => 'uid',
            'email'      => 'email',
            'avatar'     => 'photo_big',
            'birthday'   => 'bdate',
			'country'	=> 'country'
        );

        $this->provider = 'vk';
    }

    /**
     * Get user name or null if it is not set
     *
     * @return string|null
     */
    public function getName()
    {
        $result = null;

        if (isset($this->userInfo['first_name']) && isset($this->userInfo['last_name'])) {
            $result = $this->userInfo['first_name'] . ' ' . $this->userInfo['last_name'];
        } elseif (isset($this->userInfo['first_name']) && !isset($this->userInfo['last_name'])) {
            $result = $this->userInfo['first_name'];
        } elseif (!isset($this->userInfo['first_name']) && isset($this->userInfo['last_name'])) {
            $result = $this->userInfo['last_name'];
        }

        return $result;
    }
	public function getFirstName()
    {
        $result = null;

        if (isset($this->userInfo['first_name'])) {
            $result = $this->userInfo['first_name'];
        }
        return $result;
    }
	public function getSecondName()
    {
        $result = null;

        if (isset($this->userInfo['last_name'])) {
            $result = $this->userInfo['last_name'];
        }
        return $result;
    }
	public function getUserCountry()
    {
        $result = null;

        if (isset($this->userInfo['country'])) {
            $result = $this->userInfo['country'];
        }
        return $result;
    }
	public function getUserCity()
    {
        $result = null;

        if (isset($this->userInfo['city'])) {
            $result = $this->userInfo['city'];
        }
        return $result;
    }
	public function getHomePhone()
    {
        $result = null;

        if (isset($this->userInfo['home_phone'])) {
            $result = $this->userInfo['home_phone'];
        }
        return $result;
    }
    /**
     * Get user social id or null if it is not set
     *
     * @return string|null
     */
    public function getSocialPage()
    {
        $result = null;

        if (isset($this->userInfo['screen_name'])) {
            $result = 'http://vk.com/' . $this->userInfo['screen_name'];
        }

        return $result;
    }

    /**
     * Get user sex or null if it is not set
     *
     * @return string|null
     */
    public function getSex()
    {
        $result = null;
        if (isset($this->userInfo['sex'])) {
            $result = $this->userInfo['sex'] == 1 ? 'female' : 'male';
        }

        return $result;
    }

    /**
     * Authenticate and return bool result of authentication
     *
     * @return bool
     */
    public function authenticate()
    {	
        $result = false;

        if (isset($_GET['code'])) {

            $params = array(
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'code' => $_GET['code'],
                'redirect_uri' => $this->redirectUri,
				'v'=>'5.73'
            );
			
            $tokenInfo = $this->get('https://oauth.vk.com/access_token', $params);
			
            if (isset($tokenInfo['access_token'])) {
                $params = array(
                    'uids'         => $tokenInfo['user_id'],
                    'fields'       => 'uid,first_name,last_name,screen_name,sex,bdate,photo_big,country,city,contacts',
                    'access_token' => $tokenInfo['access_token'],
					'v'=>'5.73'
                );

                $userInfo = $this->get('https://api.vk.com/method/users.get', $params);
				//$_SESSION['test2']=json_encode($userInfo);
                if (isset($userInfo['response'][0]['first_name'])) {
                    $this->userInfo = $userInfo['response'][0];
                    $result = true;
                }
            }
		} 
		//else $log->LogError('Code is not available for this user');

        return $result;
    }

    /**
     * Prepare params for authentication url
     *
     * @return array
     */
    public function prepareAuthParams()
    {
        return array(
            'auth_url'    => 'http://oauth.vk.com/authorize',
            'auth_params' => array(
                'client_id'     => $this->clientId,
                'scope'         => 'notify',
                'redirect_uri'  => $this->redirectUri,
                'response_type' => 'code',
				'v'=>'5.72'
            )
        );
    }
}