<?php

class DriverActionTeaser
{
    use TraitDriverHelper;
    
    private $apiKey = null;
    private $siteId = null;
    
    public function labelNetworkLogin()
    {
        return Yii::t('ProfileModule.base', 'Site ID');
    }
    
    public function labelNetworkPassword()
    {
        return Yii::t('ProfileModule.base', 'Secret key');
    }
    
    /**
     * Get authorize URL
     * @return string
     */
    public function authorizeUrl()
    {
        $authorizeUrl = 'http://actionteaser.ru/login';

        return Yii::t('ProfileModule.base', 'For the API key, follow this {link}', [
                '{link}' => CHtml::link(Yii::t('ProfileModule.base', 'link', 1.5), $authorizeUrl, ['target' => '_blank'])
        ]);
    }
    
    /**
     * Set Site ID
     * @param string $siteId
     * @return $this
     */
    public function setSiteId($siteId)
    {
        $this->siteId = $siteId;
        return $this;
    }
    
    /**
     * Set API key
     * @param string $apiKey
     * @return $this
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
        return $this;
    }

    /**
     * Get stat data
     * @param string $startDate DD.MM.YYYY
     * @param string $endDate DD.MM.YYYY
     * @return boolean|array
     */
    public function get($startDate = null, $endDate = null)
    {
        $ret = false;

        if (!empty($this->siteId) && !empty($this->apiKey)) {
            $this->dateFormatTo = 'Y-m-d';
            $this->formatDate($startDate, $endDate);

            $params = [
                'key/' . $this->apiKey,
                'startDate/' . $startDate,
                'endDate/' . $endDate,
                'siteId/' . $this->siteId,
                'result/json',
            ];
            
            $parseUrl = 'http://actionteaser.ru/api/webstat/' . implode('/', $params);

            $result = $this->query($parseUrl, [], [CURLOPT_POST => false]);
            
            if (is_array($result) && count($result) > 0) {
                $result = reset($result);

                $ret = [
                    'views' => isset($result['viewsblock']) ? $result['viewsblock'] : null,
                    'clicks' => isset($result['clicks']) ? $result['clicks'] : null,
                    'money' => isset($result['money']) ? $result['money'] : null,
                ];
                
                $ret['money'] = Currency::model()->convertEarning($ret['money'], Currency::RUB);
            }
        }

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
                'views' => isset($data['views']) ? $data['views'] : null,
                'clicks' => isset($data['clicks']) ? $data['clicks'] : null,
                'earnings' => isset($data['money']) ? $data['money'] : null
            ]);
            
            $this->saveStatisticData($siteId, $instrumentId, $set);
        }
    }

    /**
     * Get referral data
     * @param string $startDate DD.MM.YYYY
     * @param string $endDate DD.MM.YYYY
     * @return boolean|array
     */
    public function getReferral($startDate = null, $endDate = null)
    {
        $ret = false;

        if (!empty($this->siteId) && !empty($this->apiKey)) {
            $this->dateFormatTo = 'Y-m-d';
            $this->formatDate($startDate, $endDate);

            $params = [
                'key/' . $this->apiKey,
                'startDate/' . $startDate,
                'endDate/' . $endDate,
                'siteId/' . $this->siteId,
                'result/json',
            ];
            
            $parseUrl = 'http://actionteaser.ru/api/webstat/' . implode('/', $params);

            $result = $this->query($parseUrl, [], [CURLOPT_POST => false]);
            
            if (is_array($result) && count($result) > 0) {
                $result = reset($result);
                
                if(isset($result['fromref'])){              
// TODO: fromref всегда NULL, поэтому не реализовано
//                      
//                    $ret = [
//                        'referrals' => 0,
//                        'earnings' => 0
//                    ];
                }
            }
        }

        return $ret;
    }


    /**
     * Save referral datar
     * @param integer $siteId
     * @param integer $instrumentId
     * @param array $data
     */
    public function saveReferral($siteId = 0, $instrumentId = 0, $data = [])
    {
        if (count($data) > 0) {
            $set = $this->setReferralData([
                'referrals' => isset($data['referrals']) ? $data['referrals'] : null,
                'earnings' => isset($data['earnings']) ? $data['earnings'] : null
            ]);
            
            $this->saveReferralData($siteId, $instrumentId, $set);
        }
    }
}
