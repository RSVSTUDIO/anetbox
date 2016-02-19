<?php

class DriverActionTeaserHtmlParser
{
    use TraitDriverHelper;
    
    private $login = null;
    
    public function labelNetworkLogin()
    {
        return Yii::t('ProfileModule.base', 'Session Key');
    }
    
    public function labelNetworkPassword()
    {
        return false;
    }
    
    /**
     * Get authorize URL
     * @return string
     */
    public function authorizeUrl()
    {
        $authorizeUrl = ['/user/api/actionTeaserSession'];

        return Yii::t('ProfileModule.base', 'For the session key, follow this {link}', [
                '{link}' => CHtml::link(Yii::t('ProfileModule.base', 'link', 1.5), $authorizeUrl, ['target' => '_blank'])
        ]);
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
     * Get stat data
     * @param string $startDate DD.MM.YYYY
     * @param string $endDate DD.MM.YYYY
     * @param string $url
     * @return boolean|array
     */
    public function get($startDate = null, $endDate = null, $url = null)
    {
        $ret = false;

        if (!empty($this->login)) {
            $this->dateFormatTo = 'Y-m-d';
            $this->formatDate($startDate, $endDate);

            $params = [
                'stat/bysites',
                'startDate/' . $startDate,
                'endDate/' . $endDate
            ];
            
            $parseUrl = 'http://actionteaser.ru/webmaster/' . implode('/', $params);
            
            $result = $this->query($parseUrl, [], [
                CURLOPT_POST => false,
                CURLOPT_COOKIE => implode(' ', [
                    'PHPSESSID=' . $this->login . ';'
                ])
            ], false);
            
            if ($result) {
                $simpleHTML = new SimpleHTMLDOM();
                $html = $simpleHTML->str_get_html($result);
                
                $login = $html->find('.login-page form#login-form', 0);

                if (isset($login->action)) {
                    $this->log(['error' => 'actionteaser session has been expired']);
                } else {
                    $ret = [];
                    $rows = $html->find('#bySites table.table_stat tr');

                    foreach ($rows as $row) {
                        if($row->find('td', 7)){                            
                            $site = @$row->find('td', 0)->plaintext;

                            if (strpos($site, $url) !== false) {
                                $ret = [
                                    'views' => $this->clearNumber($row->find('td', 2)->plaintext, ['&nbsp;', ' ', '-']),
                                    'clicks' => $this->clearNumber($row->find('td', 3)->plaintext, ['&nbsp;', ' ', '-']),
                                    'money' => str_replace(',', '.', $row->find('td', 7)->plaintext),
                                ];

                                $ret['money'] = Currency::model()->convertEarning($ret['money'], Currency::RUB);

                                break;
                            }
                        }
                    }
                }
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
                'views' => empty($data['views']) ? null : $data['views'],
                'clicks' => empty($data['clicks']) ? null : $data['clicks'],
                'earnings' => empty($data['money']) ? null : $data['money']
            ]);
            
            $this->saveStatisticData($siteId, $instrumentId, $set);
        }
    }

    /**
     * Get referral data
     * @return boolean|array
     */
    public function getReferral()
    {
        $ret = false;

        if (!empty($this->login)) {
            $parseUrl = 'http://actionteaser.ru/webmaster/referral';
            
            $result = $this->query($parseUrl, [], [
                CURLOPT_POST => false,
                CURLOPT_COOKIE => implode(' ', [
                    'PHPSESSID=' . $this->login . ';'
                ])
            ], false);

            if ($result) {
                $simpleHTML = new SimpleHTMLDOM();
                $html = $simpleHTML->str_get_html($result);
                
                $login = $html->find('.login-page form#login-form', 0);

                if (isset($login->action)) {
                    $this->log(['error' => 'actionteaser session has been expired']);
                } else {
                    $ret = [];
                    $content = $html->find('#referalsConent', 0);
                    
                    $referrals = $content->find('.earningsReferals', 0);
                    $earnings = $content->find('.earningsReferals', 1);
                    
                    $ret = [
                        'referrals' => $this->clearNumber(@$referrals->plaintext),
                        'earnings' => $this->clearNumber(@$earnings->plaintext, [' ', 'р'])
                    ];
                }
            }
        }

        return $ret;
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
            $res = UserReferralData::model()->getReferralsBySite($siteId, $instrumentId);
            
            if (!empty($res)) {
                // calculate one day
                if (isset($data['referrals']) && isset($res['referrals'])) {
                    $data['referrals'] -= $res['referrals'];

                    if ($data['referrals'] <= 0) {
                        $data['referrals'] = null;
                    }
                }
                if (isset($data['earnings']) && isset($res['earnings'])) {
                    $data['earnings'] -= $res['earnings'];

                    if ($data['earnings'] <= 0) {
                        $data['earnings'] = null;
                    }
                }
            }
            
            $set = $this->setReferralData([
                'referrals' => empty($data['referrals']) ? null : $data['referrals'],
                'earnings' => empty($data['earnings']) ? null : $data['earnings']
            ]);
            
            $this->saveReferralData($siteId, $instrumentId, $set);
        }
    }
}
