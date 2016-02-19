<?php

class DriverYandexDirect
{

    use TraitDriverHelper;

    const apiID = DriverConfig::yandexApiID;
    const apiPasswd = DriverConfig::yandexApiPasswd;

    private $api = null;

    public function labelNetworkPassword()
    {
        return Yii::t('ProfileModule.base', 'Token');
    }

    private function api()
    {
        if ($this->api === null) {
            $this->api = new \Yandex\DirectApi();
            $this->api->setID(self::apiID)
                ->setPassword(self::apiPasswd)
                //->setUseSandbox(true)
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
                $ids = $this->getCampaignsIDS($this->login, $this->token, $url);

                if (count($ids) > 0) {
                    $this->formatDate($startDate, $endDate);

                    $result = $this->api()
                        ->setLogin($this->login)
                        ->setToken($this->token)
                        ->getSummaryStat([
                        'CampaignIDS' => $ids,
                        'StartDate' => $startDate,
                        'EndDate' => $endDate
                    ]);

                    if ($result === false) {
                        $this->getErrors();
                    } else {
                        $ret = $result;
                        if (isset($result['data']) && count($result['data']) === 0) {
                            $this->log(['status' => UserInstrumentsLog::StatusNoData]);
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
     * Get campaigns ids array
     * @param string $login
     * @param string $token
     * @param string $url
     * @return array
     */
    private function getCampaignsIDS($login, $token, $url)
    {
        $result = $this->api()
            ->setLogin($login)
            ->setToken($token)
            ->getCampaignsList([$login]);

        if ($result === false) {
            $this->getErrors();
        }

        $ids = [];
        if (isset($result['data'])) {
            foreach ($result['data'] as $item) {
                if ($item['Name'] === $url) {
                    $ids[] = $item['CampaignID'];
                }
            }
        }

        return $ids;
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
                'pages' => isset($data['pages']) ? $data['pages'] : null,
                'users' => isset($data['users']) ? $data['users'] : null,
                'views' => isset($data['views']) ? $data['views'] : null,
            ]);
            
            $this->saveStatisticData($siteId, $instrumentId, $set);
        }
    }

}
