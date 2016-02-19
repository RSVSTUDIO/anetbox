<?php

trait TraitDriverHelper
{

    /**
     * Show CException
     * @var boolean 
     */
    private $displayError = false;

    /**
     * ID связи сайта с инструментом
     * @var integer 
     */
    public $usi_id = null;

    /**
     * set data format from
     * @var string 
     */
    public $dateFormatFrom = 'd.m.Y';

    /**
     * set data format to
     * @var string 
     */
    public $dateFormatTo = 'Y-m-d';
    
    /**
     * Curl
     * @var Curl
     */
    protected $curlOptions = array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => false,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_AUTOREFERER => true,
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:5.0) Gecko/20110619 Firefox/5.0',
        CURLOPT_TIMEOUT => 0,
        CURLOPT_POST => true,
    );
    
    /**
     * URL подключение к API.
     * @var string
     */
    protected $apiUrl;

    /**
     * format date to API standart or create date
     * @param string $startDate
     * @param string $endDate
     */
    protected function formatDate(&$startDate, &$endDate)
    {
        if ($startDate === null) {
            $startDate = (new DateTime('NOW'))->modify('-1 day')->format($this->dateFormatTo);
        } else {
            $startDate = DateTime::createFromFormat($this->dateFormatFrom, $startDate)->format($this->dateFormatTo);
        }
        if ($endDate === null) {
            $endDate = (new DateTime('NOW'))->modify('-1 day')->format($this->dateFormatTo);
        } else {
            $endDate = DateTime::createFromFormat($this->dateFormatFrom, $endDate)->format($this->dateFormatTo);
        }
    }

    /**
     * Return error exeption
     * @throws CException
     */
    protected function getErrors()
    {
        $errors = [
            'code' => $this->api()->getError(),
            'str' => $this->api()->getErrorStr()
        ];

        if ($this->api()->getErrorDetail()) {
            $errors['detail'] = $this->api()->getErrorDetail();
        }

        $this->log(['error' => $errors]);

        if ($this->displayError === true) {
            throw new CException(implode(PHP_EOL, $errors));
        }
    }

    /**
     * Set usi_id
     * @param string $usiId
     * @return $this
     */
    public function setUsiId($usiId)
    {
        $this->usi_id = $usiId;
        return $this;
    }

    /**
     * Log cron action
     * @param array $arr Comment array
     */
    protected function log($arr = [])
    {
        if ((int) $this->usi_id > 0 && count($arr) > 0) {
            $model = new UserInstrumentsLog();
            $model->setAttributes([
                'usi_id' => $this->usi_id,
                'comment' => json_encode($arr, JSON_UNESCAPED_UNICODE)
            ]);
            $model->save();
        }
    }

    /**
     * Save Api data
     * @param string $data
     */
    protected function saveApiData($data = null)
    {
        if ((int) $this->usi_id > 0) {
            $model = UserSiteInstruments::model()->findByPk($this->usi_id);
            if ($model) {
                $model->api_data = $data;
                $model->save();
            }
        }
    }

    /**
     * Logger Exception
     * @param Exception $ex
     */
    protected function logException(Exception $ex)
    {
        $this->log(['exception' => $ex->getMessage()]);
    }

    /**
     * Set row data
     * @param array $data
     * @return array
     */
    protected function setData($data)
    {
        $set = [
            'pages' => isset($data['pages']) ? $data['pages'] : null,
            'users' => isset($data['users']) ? $data['users'] : null,
            'views' => isset($data['views']) ? $data['views'] : null,
            'clicks' => isset($data['clicks']) ? $data['clicks'] : null,
            'actions' => isset($data['actions']) ? $data['actions'] : null,
            'earnings' => isset($data['earnings']) ? $data['earnings'] : null,
        ];

        return $set;
    }

    /**
     * Set referral row data
     * @param array $data
     * @return array
     */
    protected function setReferralData($data)
    {
        $set = [
            'referrals' => isset($data['referrals']) ? $data['referrals'] : null,
            'earnings' => isset($data['earnings']) ? $data['earnings'] : null,
        ];

        return $set;
    }

    /**
     * @param string $url
     * @param array $params
     * @param array $curlOptions
     * @param boolean $decode
     * @return mixed
     */
    public function query($url = null, $params = [], $curlOptions = [], $decode = true)
    {
        $result = false;
        
        if ($url) {
            $this->curlOptions = $curlOptions + $this->curlOptions;
            $this->apiUrl = $url;

            $result = $this->_execCurl($params);
            if($decode === true && $result){
                $result = CJSON::decode($result);
            }
        } else {
            $this->log(['error' => 'empty url']);
        }

        return $result;
    }

    /**
     * Выполняем запрос
     * @return array
     */
    protected function _execCurl($data = [])
    {
        $ch = curl_init();
        curl_setopt_array($ch, $this->curlOptions);
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl);

        if ($this->curlOptions[CURLOPT_POST] === true) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        $c = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch) || $httpCode !== 200) {

            $this->log([
                'error' => [
                    'code' => $httpCode,
                    'str' => (curl_errno($ch) ? 'curl error: ' . curl_error($ch) : 'curl http_code: ' . $httpCode)
                ]
            ]);

            $c = false;
        }

        curl_close($ch);

        return $c;
    }
    
    /**
     * @param string $str
     * @param array|string $mask
     * @return string
     */
    public function clearNumber($str, $mask = ['&nbsp;', ' '])
    {
        return str_replace($mask, '', $str);
    }

    /**
     * Save statistic data
     * @param integer $siteId
     * @param integer $instrumentId
     * @param array $data
     */
    protected function saveStatisticData($siteId = 0, $instrumentId = 0, $data = [])
    {
        if ((int) $siteId > 0 && (int) $instrumentId > 0 && array_sum($data) > 0) {
            $recdate = (new DateTime('NOW'))->modify('-1 day')->format('Y-m-d') . ' 00:00:00';

            $criteria = new CDbCriteria();
            $criteria->addColumnCondition([
                'site_id' => $siteId,
                'instrument_id' => $instrumentId,
                'recdate' => $recdate
            ]);

            $model = UserInstrumentsData::model()->find($criteria);

            if ($model) {
                $this->log(['status' => UserInstrumentsLog::StatusUpdate]);
            } else {
                $data['site_id'] = $siteId;
                $data['instrument_id'] = $instrumentId;

                $model = new UserInstrumentsData();

                $this->log(['status' => UserInstrumentsLog::StatusAdd]);
            }

            $model->setAttributes($data);
            $model->recdate = $recdate;
            $model->save();
        } else {
            $this->log(['status' => UserInstrumentsLog::StatusNoData]);
        }
    }

    /**
     * Save referral data
     * @param integer $siteId
     * @param integer $instrumentId
     * @param array $data
     */
    protected function saveReferralData($siteId = 0, $instrumentId = 0, $data = [])
    {
        if ((int) $siteId > 0 && (int) $instrumentId > 0 && array_sum($data) > 0) {
            $recdate = (new DateTime('NOW'))->modify('-1 day')->format('Y-m-d') . ' 00:00:00';

            $criteria = new CDbCriteria();
            $criteria->addColumnCondition([
                'site_id' => $siteId,
                'instrument_id' => $instrumentId,
                'recdate' => $recdate
            ]);

            $model = UserReferralData::model()->find($criteria);

            if ($model) {
                $this->log(['status' => UserInstrumentsLog::StatusUpdate, 'type' => 'referral']);
            } else {
                $data['site_id'] = $siteId;
                $data['instrument_id'] = $instrumentId;

                $model = new UserReferralData();

                $this->log(['status' => UserInstrumentsLog::StatusAdd, 'type' => 'referral']);
            }

            $model->setAttributes($data);
            $model->recdate = $recdate;
            $model->save();
        } else {
            $this->log(['status' => UserInstrumentsLog::StatusNoData, 'type' => 'referral']);
        }
    }

}
