<?php

/**
 * Компонент для работы с API Yandex.Direct
 *
 * @method archiveCampaign($param = array())
 * @method createOrUpdateCampaign($param = array())
 * @method deleteCampaign($param = array())
 * @method getCampaignParams($param = array())
 * @method getCampaignsList($param = array())
 * @method getCampaignsListFilter($param = array())
 * @method getCampaignsParams($param = array())
 * @method resumeCampaign($param = array())
 * @method stopCampaign($param = array())
 * @method unArchiveCampaign($param = array())
 *
 * @method archiveBanners($param = array())
 * @method createOrUpdateBanners($param = array())
 * @method deleteBanners($param = array())
 * @method getBanners($param = array())
 * @method getBannerPhrases($param = array())
 * @method getBannerPhrasesFilter($param = array())
 * @method moderateBanners($param = array())
 * @method resumeBanners($param = array())
 * @method stopBanners($param = array())
 * @method unArchiveBanners($param = array())
 *
 * @method setAutoPrice($param = array())
 * @method updatePrices($param = array())
 *
 * @method getBalance($param = array())
 * @method getSummaryStat($param = array())
 * @method createNewReport($param = array())
 * @method deleteReport($param = array())
 * @method getReportList()
 * @method createNewWordstatReport($param = array())
 * @method deleteWordstatReport($param = array())
 * @method getWordstatReport($param = array())
 * @method getWordstatReportList()
 * @method createNewForecast($param = array())
 * @method deleteForecastReport($param = array())
 * @method getForecast($param = array())
 * @method getForecastList()
 *
 * @method createNewSubclient($params = array())
 * @method getClientInfo($param = array())
 * @method getClientsList($param = array())
 * @method getClientsUnits($param = array())
 * @method getSubClients($param = array())
 * @method updateClientInfo($param = array())
 *
 * @method getAvailableVersions()
 * @method getChanges($param = array())
 * @method getRegions()
 * @method getRubrics()
 * @method getStatGoals($param = array())
 * @method getTimeZones()
 * @method getVersion()
 * @method pingAPI()
 * 
 * @tutorial https://tech.yandex.ru/direct/doc/dg-v4/reference/_AllMethods-docpage/
 */

namespace Yandex;

class DirectApi extends Api
{

    /**
     * На каком языке получать ответы из яндекса
     * @var string
     */
    protected $locale = 'ru';

    /**
     * URL
     */
    protected $jsonApiUrl = 'https://api.direct.yandex.ru/v4/json/';
    protected $sandboxJsonApiUrl = 'https://api-sandbox.direct.yandex.ru/v4/json/';

    /**
     * Установка языка ответов из яндекса
     * @param $locale по умолчанию 'ru'
     * @return self
     */
    public function setLocale($locale = 'ru')
    {
        $this->locale = $locale;
        return $this;
    }

    /**
     * Запрос к API
     * @param string $method
     * @param array $params
     * @return bool|array
     */
    public function apiQuery($method, $params = array())
    {
        $this->clearErrors();
        $params = array(
            'method' => $method,
            'param' => $params,
            'locale' => $this->locale,
            'login' => $this->login,
            'application_id' => $this->id,
            'token' => $this->token
        );

        $params = $this->utf8($params);
        $params = \CJSON::encode($params);
        $result = $this->_execCurl($params);
        $result = \CJSON::decode($result);

        # Если все прошло без ошибок
        if (!empty($result)) {
            if (isset($result['error_code']) && isset($result['error_str'])) {
                $this->setError($result['error_code'])->setErrorStr($result['error_str']);
                if (!empty($result['error_detail'])) {
                    $this->setErrorDetail($result['error_detail']);
                }
                $result = false;
            }
        } else {
            $result = false;
        }

        return $result;
    }

    /**
     * Вызов методов
     * @param string $method
     * @param array $args
     * @return mixed|void
     */
    public function __call($method, $args)
    {
        $params = empty($args) ? array() : $args[0];
        return $this->apiQuery(ucfirst($method), $params);
    }

}
