<?php

class DriverYandexHtmlParser
{

    use TraitDriverHelper;

    const apiID = DriverConfig::yandexApiID;
    const apiPasswd = DriverConfig::yandexApiPasswd;

    private $api = null;
    private $login = null;
    private $token = null;

    public function labelNetworkLogin()
    {
        return Yii::t('ProfileModule.base', 'Session Key {id}', ['{id}' => 1]);
    }

    public function labelNetworkPassword()
    {
        return Yii::t('ProfileModule.base', 'Session Key {id}', ['{id}' => 2]);
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
        $authorizeUrl = ['/user/api/yandexSession'];

        return Yii::t('ProfileModule.base', 'For the session keys, follow this {link}', [
                '{link}' => CHtml::link(Yii::t('ProfileModule.base', 'link', 1.5), $authorizeUrl, ['target' => '_blank'])
        ]);
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

        if (!empty($this->login) && !empty($this->token)) {
            $this->dateFormatTo = 'Y-m-d';
            $this->formatDate($startDate, $endDate);

            $params = [
                'cmd' => 'campaign_list',
                'ID' => '',
                'viewoptionsstr' => implode('|', [
                    'stattime_',
                    'pcosttype_dirpartnerwithoutnds',
                    'stattype_yesterday',
                    'status_work',
                    'fd2_' . $endDate,
                    'type_',
                    'curpage_1',
                    'fd_' . $startDate,
                    'pageels_10',
                    'compareRangeFrom_',
                    'compareRangeTo_',
                    'comparestattype_',
                ])
            ];

            $parseUrl = 'https://partner.yandex.ru/registered' . '?' . http_build_query($params);

            $result = $this->query($parseUrl, [], [
                CURLOPT_POST => false,
                CURLOPT_COOKIE => implode(' ', [
                    'Session_id=' . $this->login . ';',
                    'sessionid2=' . $this->token . ';',
                ])
            ], false);
            
            
            if ($result) {                
                $simpleHTML = new SimpleHTMLDOM();
                $html = $simpleHTML->str_get_html($result);
                
                $login = $html->find('form[data-form-name="auth"] input#login', 0);

                if (isset($login->name)) {
                    $this->log(['error' => 'yandex session has been expired']);
                } else {
                    $ret = [];
                    $rows = $html->find('tbody.b-data-table-body tr.first-row');

                    foreach ($rows as $row) {
                        $site = $row->find('td.sites a.b-url', 0);

                        if (isset($site->href) && strpos($site->href, 'url=' . $url) !== false) {
                            $ret = [
                                'show' => $this->clearNumber($row->find('td.show', 0)->plaintext),
                                'clicks' => $row->find('td.clicks', 0)->plaintext,
                                'income' => str_replace(',', '.', $row->find('td.income .with_nds', 0)->plaintext),
                            ];

                            $ret['income'] = Currency::model()->convertEarning($ret['income'], Currency::RUB);

                            break;
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
                'views' => isset($data['show']) ? $data['show'] : null,
                'clicks' => isset($data['clicks']) ? $data['clicks'] : null,
                'earnings' => isset($data['income']) ? $data['income'] : null
            ]);
            
            $this->saveStatisticData($siteId, $instrumentId, $set);
        }
    }

}
