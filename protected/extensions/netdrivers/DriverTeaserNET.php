<?php

class DriverTeaserNET
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
        $authorizeUrl = ['/user/api/teaserNetSession'];

        return Yii::t('ProfileModule.base', 'For the session key, follow this {link}', [
                '{link}' => CHtml::link(Yii::t('ProfileModule.base', 'link', 1.5), $authorizeUrl, ['target' => '_blank'])
        ]);
    }
    
//    /**
//     * Render upload form
//     * @param Controller $controller
//     * @param array $urlArray
//     * @return string
//     */
//    public function fileUploadForm(Controller $controller, $urlArray)
//    {
//        return $controller->renderPartial(
//                    'ext.netdrivers.views.form-file-upload', 
//                    [
//                        'title' => Yii::t('ProfileModule.base', 'Upload file for network {network}', [
//                            '{network}' => 'TeaserNET'
//                        ]),
//                        'urlArray' => $urlArray
//                    ], 
//                    true
//                );
//    }
//
//    /**
//     * Parse file
//     * @param integer $networkId
//     * @param mixed $file
//     */
//    public function fileParser($networkId, $file)
//    {
//      
//        //TODO: example, put your code here
//        return print_r($file, true);
//        
//    }
    
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
     * Get stat data from html page
     * @param string $startDate DD.MM.YYYY
     * @param string $endDate DD.MM.YYYY
     * @param string $url
     * @return boolean|array
     */
    public function get($startDate = null, $endDate = null, $url = null)
    {
        $ret = false;

        if (!empty($this->login)) {
            $this->dateFormatTo = 'd.m.Y';
            $this->formatDate($startDate, $endDate);

            $params = [
                'by' => 'site',
                'from' => $startDate,
                'till' => $endDate,
            ];

            $parseUrl = 'http://teasernet.com/webmaster/stats/' . http_build_query($params);

            $result = $this->query($parseUrl, [], [
                CURLOPT_POST => false,
                CURLOPT_COOKIE => implode(' ', [
                    'PHPSESSID=' . $this->login . ';',
                ])
            ], false);

            
            if ($result) {
                $simpleHTML = new SimpleHTMLDOM();
                $html = $simpleHTML->str_get_html($result);
                
                $login = $html->find('form.login_form', 0);

                if (isset($login->action)) {
                    $this->log(['error' => 'teasernet session has been expired']);
                } else {
                    $ret = [];
                    $rows = $html->find('table#statTableSites > tbody > tr');

                    if ($rows) {
                        foreach ($rows as $row) {
                            if ($row->find('td._name', 0)) {
                                $site = $row->find('td._name', 0)->find('span', 0)->plaintext;

                                if (strpos($site, $url) !== false) {
                                    $ret = [
                                        'bhits' => $this->clearNumber($row->find('td._bhits', 0)->find('span', 0)->plaintext),
                                        'clicks' => $this->clearNumber($row->find('td._clicks', 0)->find('span', 0)->plaintext),
                                        'money' => $this->clearNumber($row->find('td._money', 0)->find('span', 0)->plaintext),
                                    ];

                                    $ret['money'] = Currency::model()->convertEarning($ret['money'], Currency::RUB);

                                    break;
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
     * Save data from html parser
     * @param integer $siteId
     * @param integer $instrumentId
     * @param array $data
     */
    public function save($siteId = 0, $instrumentId = 0, $data = [])
    {
        if (count($data) > 0) {
            $set = $this->setData([
                'views' => isset($data['bhits']) ? $data['bhits'] : null,
                'clicks' => isset($data['clicks']) ? $data['clicks'] : null,
                'earnings' => isset($data['money']) ? $data['money'] : null
            ]);
            
            $this->saveStatisticData($siteId, $instrumentId, $set);
        }
    }

    /**
     * Get referral data from html page
     * @param string $startDate DD.MM.YYYY
     * @param string $endDate DD.MM.YYYY
     * @return boolean|array
     */
    public function getReferral($startDate = null, $endDate = null)
    {
        $ret = false;

        if (!empty($this->login)) {
            $this->dateFormatTo = 'd.m.Y';
            $this->formatDate($startDate, $endDate);

            $params = [
                'from' => $startDate,
                'till' => $endDate,
            ];

            $parseUrl = 'http://teasernet.com/webmaster/stats/referals/' . http_build_query($params);

            $result = $this->query($parseUrl, [], [
                CURLOPT_POST => false,
                CURLOPT_COOKIE => implode(' ', [
                    'PHPSESSID=' . $this->login . ';',
                ])
            ], false);

            
            if ($result) {
                $simpleHTML = new SimpleHTMLDOM();
                $html = $simpleHTML->str_get_html($result);
                
                $login = $html->find('form.login_form', 0);

                if (isset($login->action)) {
                    $this->log(['error' => 'teasernet session has been expired', 'type' => 'referral']);
                } else {
                    $ret = [];
                    $rows = $html->find('table#statTableGeneral > tbody > tr');

                    if ($rows) {
                        $ret = [
                            'referrals' => 0,
                            'earnings' => 0,
                        ];
                        foreach ($rows as $row) {
                            if ($row->find('td', 2)) {
                                $ret['referrals'] += $this->clearNumber($row->find('td', 1)->find('span', 0)->plaintext);
                                $earnings = $this->clearNumber($row->find('td', 2)->find('span', 0)->plaintext);

                                $ret['earnings'] += Currency::model()->convertEarning($earnings, Currency::RUB);
                            }
                        }
                    }
                }
            }
        }

        return $ret;
    }

    /**
     * Save referral data from html parser
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
