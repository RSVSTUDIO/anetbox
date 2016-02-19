<?php

class DriverDirectAdvert
{
    use TraitDriverHelper;
    
    private $login = null;
    private $password = null;
    private $url = 'https://api.directadvert.ru/';
    private $token = null;
    
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
     * Set api password
     * @param string $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;
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
    
    private function auth()
    {
        $ret = false;

        $params = [
            'name' => $this->login,
            'password' => $this->password,
        ];

        $parseUrl = $this->url . 'auth.json?' . http_build_query($params);

        $result = $this->query($parseUrl, [], [CURLOPT_POST => false]);

        if (isset($result['success']) && $result['success'] && isset($result['token'])) {
            $this->setToken($result['token']);
            $ret = true;
        } else {
            if (isset($result['error_message'])) {
                $this->log(['error' => $result['error_message']]);
            }
        }

        return $ret;
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

        if (!empty($this->login) && !empty($this->password)) {
            if ($this->auth()) {
                $this->dateFormatTo = 'Y-m-d';
                $this->formatDate($startDate, $endDate);

                $params = [
                    'token' => $this->token,
                    'date' => $startDate,
                    'date_end' => $endDate,
                ];

                $parseUrl = $this->url . 'get_sites_info.json?' . http_build_query($params);

                $result = $this->query($parseUrl, [], [CURLOPT_POST => false]);
                
                
                if (isset($result['success']) && $result['success'] && isset($result['site_data'])) {
                    foreach ($result['site_data'] as $site) {
                        if (
                            isset($site['status']) &&
                            $site['status'] === 'active' &&
                            isset($site['title']) &&
                            strpos($site['title'], $url) !== false
                        ) {
                            if(isset($site['statistics']['current'])){
                                $stat = $site['statistics']['current'];
                                
                                $ret = [
                                    'shows' => $this->clearNumber($stat['shows']),
                                    'clicks' => $this->clearNumber($stat['clicks']),
                                    'profit' => $this->clearNumber($stat['profit'])
                                ];
                                
                                $ret['profit'] = Currency::model()->convertEarning($ret['profit'], Currency::RUB);
                            }
                            
                            break;
                        }
                    }
                }
            }
            
        }

        return $ret;
    }


    /**
     * Save stat data
     * @param string $userId
     * @param integer $siteId
     * @param integer $instrumentId
     * @param array $data
     */
    public function save($userId = '', $siteId = 0, $instrumentId = 0, $data = [])
    {
        if (count($data) > 0) {
            $res = UserInstrumentsData::model()->getSiteCounters($userId, $instrumentId);
            
            if (!empty($res)) {
                $res = reset($res);
                
                // calculate one day
                if (isset($data['shows']) && isset($res['views'])) {
                    $data['shows'] -= $res['views'];

                    if ($data['shows'] <= 0) {
                        $data['shows'] = null;
                    }
                }
                if (isset($data['clicks']) && isset($res['clicks'])) {
                    $data['clicks'] -= $res['clicks'];

                    if ($data['clicks'] <= 0) {
                        $data['clicks'] = null;
                    }
                }
                if (isset($data['profit']) && isset($res['earnings'])) {
                    $data['profit'] -= $res['earnings'];

                    if ($data['profit'] <= 0) {
                        $data['profit'] = null;
                    }
                }
            }

            $set = $this->setData([
                'views' => isset($data['shows']) ? $data['shows'] : null,
                'clicks' => isset($data['clicks']) ? $data['clicks'] : null,
                'earnings' => isset($data['profit']) ? $data['profit'] : null
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

        if (!empty($this->login) && !empty($this->password)) {
            if ($this->auth()) {
                $this->dateFormatTo = 'Y-m-d';
                $this->formatDate($startDate, $endDate);

                $params = [
                    'token' => $this->token,
                    'date' => $startDate,
                    'date_end' => $endDate,
                ];

                $parseUrl = $this->url . 'get_sites_info.json?' . http_build_query($params);

                $result = $this->query($parseUrl, [], [CURLOPT_POST => false]);
                
                
                if (isset($result['success']) && $result['success'] && isset($result['referral_site_data'])) {
                    if (is_array($result['referral_site_data']) && count($result['referral_site_data']) > 0) {                        
                        $ret = [
                            'referrals' => 0,
                            'earnings' => 0
                        ];

                        foreach ($result['referral_site_data'] as $referral) {
                            if (isset($referral['title']) && isset($referral['statistics'])) {
                                $ret['referrals']++;
                                if(isset($referral['statistics']['today'])){
                                    $earnings = $this->clearNumber($referral['statistics']['today']);
                                    $ret['earnings'] += Currency::model()->convertEarning($earnings, Currency::RUB);
                                }
                            }
                        }
                    }
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
                'referrals' => isset($data['referrals']) ? $data['referrals'] : null,
                'earnings' => isset($data['earnings']) ? $data['earnings'] : null
            ]);
            
            $this->saveReferralData($siteId, $instrumentId, $set);
        }
    }
}
