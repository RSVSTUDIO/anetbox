<?php

class DriverGoogleAdSense
{

    use TraitDriverHelper;

    const clientID = DriverConfig::googleClientID;
    const clientSecret = DriverConfig::googleClientSecret;

    /**
     * Determines where the response is sent. 
     * The value of this parameter must exactly match one of the values that appear 
     * in the Credentials page in the Google Developers Console
     * https://console.developers.google.com/
     */
    const redirectUri = 'http://anetbox.com/index.php?r=user/api/adsense';

    private $client = null;
    private $api = null;
    private $login = null;
    private $code = null;
    private $token = null;

    public function labelNetworkLogin()
    {
        return Yii::t('ProfileModule.base', 'Publisher ID');
    }

    public function labelNetworkPassword()
    {
        return Yii::t('ProfileModule.base', 'Access code');
    }

    /**
     * Get authorize URL
     * @return string
     */
    public function authorizeUrl()
    {
        $authorizeUrl = $this->client()->createAuthUrl();

        $link = 'https://www.google.com/adsense/app?#main/accountInformation';
        $html = Yii::t('ProfileModule.base', 'For the publisher ID, watch in {your_account}', [
                '{your_account}' => CHtml::link(Yii::t('ProfileModule.base', 'your account', 1.5), $link, ['target' => '_blank'])
        ]);
        $html .= '<br>';
        $html .= Yii::t('ProfileModule.base', 'For the access code, follow this {link}', [
                '{link}' => CHtml::link(Yii::t('ProfileModule.base', 'link', 1.5), $authorizeUrl, ['target' => '_blank'])
        ]);
        $html .= '<br>';
        $html .= Yii::t('ProfileModule.base', '<strong>Caution:</strong> the access code is a one-time and it is necessary to create each time before adding the network.');

        return $html;
    }

    private function client()
    {
        if ($this->client === null) {
            $this->client = new Google_Client();
            $this->client->addScope(Google_Service_AdSense::ADSENSE_READONLY);
            $this->client->setClientId(self::clientID);
            $this->client->setClientSecret(self::clientSecret);
            $this->client->setRedirectUri(self::redirectUri);
            $this->client->setAccessType('offline');
            $this->client->setApprovalPrompt('force');
        }

        return $this->client;
    }

    /**
     * Create API service
     * @return Google_Service
     */
    private function api()
    {
        if ($this->api === null) {
            if (empty($this->token)) {
                $this->client()->authenticate($this->code);
                $this->token = $this->client()->getAccessToken();
                $this->saveApiData($this->token);
            }

            $this->client()->setAccessToken($this->token);

            if ($this->client()->isAccessTokenExpired()) {
                $newToken = json_decode($this->token);
                if (isset($newToken->refresh_token)) {
                    $this->client()->refreshToken($newToken->refresh_token);
                    $this->token = $this->client()->getAccessToken();
                    $this->saveApiData($this->token);
                }
            }

            $this->api = new Google_Service_AdSense($this->client());
        }

        return $this->api;
    }
    
    /**
     * Destroy connection
     */
    private function destroy()
    {
        $this->api = null;
        $this->token = null;
    }

    /**
     * Set api login
     * @param string $login
     * @return $this
     */
    public function setLogin($login)
    {
        $this->login = $login;
        return $this;
    }

    /**
     * Set api access code
     * @param string $code
     * @return $this
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * Set api token
     * @param string $token
     * @return $this
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    /**
     * Generate and save token
     * @param string $code
     * @return boolean
     */
    public function geterateToken($code)
    {
        $ret = true;
        $this->code = $code;

        try {
            //Create API service and save token
            $this->api();
        } catch (Exception $ex) {
            $this->logException($ex);
            $ret = false;
        }

        return $ret;
    }

    /**
     * Get stat data
     * @param string $startDate DD.MM.YYYY
     * @param string $endDate DD.MM.YYYY
     * @param string $url
     * @return array
     */
    public function get($startDate = null, $endDate = null, $url = null)
    {
        $ret = [];

        if (!empty($this->login)) {
            $this->formatDate($startDate, $endDate);

            $params = [
                'dimension' => 'DOMAIN_NAME',
                'metric' => [
                    'CLICKS',
                    'MATCHED_AD_REQUESTS',
                    'EARNINGS',
                ]
            ];

            if (!empty($url)) {
                $params['filter'] = 'DOMAIN_NAME==' . $url;
            }

            try {
                $result = $this->api()->accounts_reports->generate($this->login, $startDate, $endDate, $params);
                
                if (isset($result->rows)) {
                    if (count($result->rows) > 0) {
                        $ret = $result->rows;
                    } else {
                        $this->log(['status' => UserInstrumentsLog::StatusNoData]);
                    }
                } else {
                    $this->log(['status' => UserInstrumentsLog::StatusNoData]);
                }
            } catch (Exception $ex) {
                $this->logException($ex);
            }
        } else {
            $this->log(['status' => UserInstrumentsLog::StatusEmptyId]);
        }
        
        $this->destroy();
        
        return $ret;
    }

    /**
     * Save data
     * @param integer $siteId
     * @param integer $instrumentId
     * @param array $data
     */
    public function save($siteId = 0, $instrumentId = 0, $data = [])
    {
        if (count($data) > 0) {
            $set = $this->setData([
                'views' => isset($data[2]) ? $data[2] : null,
                'clicks' => isset($data[1]) ? $data[1] : null,
                'earnings' => isset($data[3]) ? $data[3] : null,
            ]);
            
            $this->saveStatisticData($siteId, $instrumentId, $set);
        }
    }

}
