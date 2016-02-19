<?php

class DriverYandexMetrika
{

    use TraitDriverHelper;

    const apiID = DriverConfig::yandexApiID;
    const apiPasswd = DriverConfig::yandexApiPasswd;

    private $api = null;
    private $login = null;
    private $token = null;

    public function labelNetworkPassword()
    {
        return Yii::t('ProfileModule.base', 'Token');
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
     * Set api token
     * @param string $token
     * @return $this
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    private function api()
    {
        if ($this->api === null) {
            $this->api = new \Yandex\MetrikaApi();
            $this->api->setID(self::apiID)
                ->setPassword(self::apiPasswd)
                ->init();
        }

        return $this->api;
    }
     
    /**
     * Destroy connection
     */
    private function destroy()
    {
        $this->api = null;
    }

    /**
     * Get authorize URL
     * @return string
     */
    public function authorizeUrl()
    {
        $authorizeUrl = $this->api()->getAuthorizeUrl();

        return Yii::t('ProfileModule.base', 'For the token, follow this {link}', [
                '{link}' => CHtml::link(Yii::t('ProfileModule.base', 'link', 1.5), $authorizeUrl, ['target' => '_blank'])
        ]);
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

        if (!empty($this->login) && !empty($this->token)) {
            try {
                $id = $this->getCounterID($this->login, $this->token, $url);

                if ((int) $id > 0) {
                    $this->dateFormatTo = 'Ymd';
                    $this->formatDate($startDate, $endDate);

                    $result = $this->api()
                        ->setToken($this->token)
                        ->apiQuery('stat/traffic/summary', [
                        'id' => $id,
                        'date1' => $startDate,
                        'date2' => $endDate,
                        'group' => 'day'
                    ]);

// TODO: должно отдавать статистику директа                    
//                    $result = $this->api()
//                        ->setToken($this->token)
//                        ->apiQuery('stat/sources/direct/summary', [
//                        'id' => $id,
//                        'date1' => $startDate,
//                        'date2' => $endDate
//                    ]);

                    if ($result === false) {
                        $this->getErrors();
                    } else {
                        if (isset($result['data']) && count($result['data']) === 0) {
                            $this->log(['status' => UserInstrumentsLog::StatusNoData]);
                        } else {
                            $ret = $result;
                        }
                    }
                } else {
                    $this->log(['status' => UserInstrumentsLog::StatusEmptyId]);
                }
            } catch (Exception $ex) {
                $this->logException($ex);
            }
        }
        
        $this->destroy();

        return $ret;
    }

    /**
     * Get counter id
     * @param string $login
     * @param string $token
     * @param string $url
     * @return integer
     */
    private function getCounterID($login, $token, $url)
    {
        $result = $this->api()
            ->setToken($token)
            ->apiQuery('counters', [
            'ulogin' => $login,
            'type' => 'partner'
        ]);
        
        if ($result === false) {
            $this->getErrors();
        }

        $id = 0;
        if (isset($result['counters'])) {
            foreach ($result['counters'] as $item) {
                if ($url === $item['site'] && $login === $item['owner_login']) {
                    $id = $item['id'];
                    break;
                }
            }
        }

        return $id;
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
                'pages' => isset($data['page_views']) ? $data['page_views'] : null,
                'users' => isset($data['visitors']) ? $data['visitors'] : null,
                'views' => isset($data['visits']) ? $data['visits'] : null,
            ]);
            
            $this->saveStatisticData($siteId, $instrumentId, $set);
        }
    }

}
