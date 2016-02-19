<?php

class DriverLitresHtmlParser
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
        $authorizeUrl = ['/user/api/litresSession'];

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
     * @return boolean|array
     */
    public function get($startDate = null, $endDate = null)
    {
        $ret = false;

        if (!empty($this->login)) {
            $this->dateFormatTo = 'Y-m-d';
            $this->formatDate($startDate, $endDate);

            $params = [
                'from' => $startDate,
                'to' => $endDate
            ];
            
            $parseUrl = 'http://www.litres.ru/pages/show_reader_partner_stats/?' . http_build_query($params);
            
            $result = $this->query($parseUrl, [], [
                CURLOPT_POST => false,
                CURLOPT_COOKIE => implode(' ', [
                    'SID=' . $this->login . ';'
                ])
            ], false);
            
            if ($result) {
                $simpleHTML = new SimpleHTMLDOM();
                $html = $simpleHTML->str_get_html($result);
                
                $login = $html->find('form#frm_login', 0);

                if (isset($login->action)) {
                    $this->log(['error' => 'litres.ru session has been expired']);
                } else {
                    $ret = [];
                    $rows = $html->find('#master_page_div table.bordered tr');

                    foreach ($rows as $row) {
                        if($row->find('th', 5) && $row->find('th', 0)->class !== 'cell_on_gray'){
                            $ret = [
                                'clicks' => $this->clearNumber($row->find('th', 1)->plaintext),
                                'users' => $this->clearNumber($row->find('th', 5)->plaintext),
                                'actions' => $this->clearNumber($row->find('th', 4)->plaintext),
                                'money' => str_replace(',', '.', $row->find('th', 3)->plaintext),
                            ];

                            $ret['money'] = Currency::model()->convertEarning($ret['money'], Currency::RUB);

                            break;
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
                'clicks' => empty($data['clicks']) ? null : $data['clicks'],
                'users' => empty($data['users']) ? null : $data['users'],
                'actions' => empty($data['actions']) ? null : $data['actions'],
                'earnings' => empty($data['money']) ? null : $data['money']
            ]);
            
            $this->saveStatisticData($siteId, $instrumentId, $set);
        }
    }
}
