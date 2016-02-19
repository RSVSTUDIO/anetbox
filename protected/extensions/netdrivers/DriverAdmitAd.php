<?php

class DriverAdmitAd
{

    use TraitDriverHelper;

    private $apiID = null;
    private $apiKEY = null;

    public function __construct()
    {
        $this->dateFormatTo = 'd.m.Y';
    }

    public function labelNetworkLogin()
    {
        return Yii::t('ProfileModule.base', 'Identifier');
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
        $authorizeUrl = 'https://developers.admitad.com/ru/apps/';

        return Yii::t('ProfileModule.base', 'For the API keys, follow this {link}', [
                '{link}' => CHtml::link(Yii::t('ProfileModule.base', 'link', 1.5), $authorizeUrl, ['target' => '_blank'])
        ]);
    }

    /**
     * Set api ID
     * @param string $id
     * @return $this
     */
    public function setApiID($id)
    {
        $this->apiID = $id;
        return $this;
    }

    /**
     * Set api KEY
     * @param string $key
     * @return $this
     */
    public function setApiKEY($key)
    {
        $this->apiKEY = $key;
        return $this;
    }

    private function api()
    {
        $api = new Admitad\Api\Api();
        return $api->selfAuthorize($this->apiID, $this->apiKEY, 'statistics');
    }

    /**
     * Get statistic, doc: 
     * {@link https://developers.admitad.com/doc/api/methods/statistics/statistics-websites/#id2}
     * @param array $params array()
     *   <pre>
     *       offset => (integer)
     *       limit => (integer)
     *       date_start => (%d.%m.%Y)
     *       date_end => (%d.%m.%Y)
     *       website => (integer)
     *       campaign => (integer)
     *       subid => (integer)
     *       total => (1 or 0) Default: 0
     *       order_by => (string)
     *   </pre>
     * @param null|string $field value: null or 'results' or '_meta'
     * @return array
     */
    public function getStatSites($params = [], $field = null)
    {
        return $this->api()
                ->get('/statistics/websites/', $params)
                ->getArrayResult($field);
    }

    public function getStatDates($params = [], $field = null)
    {
        return $this->api()
                ->get('/statistics/dates/', $params)
                ->getArrayResult($field);
    }

    /**
     * Get referrals, doc: 
     * {@link https://developers.admitad.com/ru/doc/api/methods/referrals/referrals/}
     * @param array $params array()
     *   <pre>
     *       offset => (integer)
     *       limit => (integer)
     *       date_start => (%d.%m.%Y)
     *       date_end => (%d.%m.%Y)
     *   </pre>
     * @param null|string $field value: null or 'results' or '_meta'
     * @return array
     */
    public function getStatReferrals($params = [], $field = null)
    {
        return $this->api()
                ->get('/referrals/', $params)
                ->getArrayResult($field);
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
        $result = [];
        $this->formatDate($startDate, $endDate);

        $params = [
            'limit' => 1000,
            'date_start' => $startDate,
            'date_end' => $endDate
        ];

        try {
            //Get all sites
            $result = $this->getStatSites($params, 'results');
            if (!empty($url)) {
                foreach ($result as $sites) {
                    if ($sites['website_name'] == $url) {
                        $params['website'] = $sites['website_id'];
                    }
                }
            } else {
                $result = reset($result);
                $params['website'] = $result['website_id'];
            }

            $result = $this->getStatDates($params, 'results');
        } catch (Exception $ex) {
            $this->logException($ex);
        }

        return reset($result);
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
            ]);
            
            $this->saveStatisticData($siteId, $instrumentId, $set);
        }
    }

    /**
     * Get referral data
     * @param string $startDate DD.MM.YYYY
     * @param string $endDate DD.MM.YYYY
     * @return array
     */
    public function getReferral($startDate = null, $endDate = null)
    {
        $result = [];
        $this->formatDate($startDate, $endDate);

        $params = [
            'limit' => 1000,
            'date_start' => $startDate,
            'date_end' => $endDate
        ];

        try {
            $res = $this->getStatReferrals($params);
            if (is_array($res)) {
                $result = [
                    'referrals' => 0,
                    'earnings' => 0
                ];
                
                foreach ($res as $item) {
                    if (isset($item['payment'])) {
                        $result['referrals'] ++;

                        if ((float) $item['payment'] > 0) {
                            $result['earnings'] += (float) $item['payment'];
                        }
                    }
                }
            }
        } catch (Exception $ex) {
            $this->logException($ex);
        }

        return $result;
    }
    
    /**
     * Save referral data
     * @param integer $siteId
     * @param integer $instrumentId
     * @param array $data
     */
    public function saveReferral($siteId = 0, $instrumentId = 0, $data = [])
    {
        if (count($data) > 0) {
            $set = $this->setData([
                'referrals' => isset($data['referrals']) ? $data['referrals'] : null,
                'earnings' => isset($data['earnings']) ? $data['earnings'] : null
            ]);
            
            $this->saveReferralData($siteId, $instrumentId, $set);
        }
    }
}
