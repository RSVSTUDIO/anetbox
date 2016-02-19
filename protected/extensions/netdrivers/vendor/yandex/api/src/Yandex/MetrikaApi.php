<?php

/**
 * Компонент для работы с API Yandex.Metrika
 * 
 * @tutorial https://tech.yandex.ru/metrika/doc/ref/concepts/About-docpage/
 */

namespace Yandex;

class MetrikaApi extends Api
{

    /**
     * URL
     */
    protected $jsonApiUrl = 'https://api-metrika.yandex.ru/[API_METHOD].json';
    protected $sandboxJsonApiUrl = null;

    /**
     * Запрос к API
     * @param string $method
     * @param array $params
     * @return bool|array
     */
    public function apiQuery($method, $params = array())
    {
        $this->clearErrors();

        $params['oauth_token'] = $this->token;
        $params = $this->utf8($params);

        $url = str_replace('[API_METHOD]', $method, $this->jsonApiUrl) . '?' . http_build_query($params);
        
        $result = $this->query($url, [], [CURLOPT_POST => false]);

        # Если все прошло без ошибок
        if (!empty($result)) {
            if (isset($result['errors'])) {
                $errors = reset($result['errors']);

                if (!empty($errors['code'])) {
                    $this->setError($errors['code']);
                }
                if (!empty($errors['text'])) {
                    $this->setErrorStr($errors['text']);
                }

                if (!empty($errors['object_id']) || !empty($errors['id'])) {
                    $errorDetail = '';

                    if (!empty($errors['object_id'])) {
                        $errorDetail .= 'object_id: ' . $errors['object_id'];
                    }
                    if (!empty($errors['id'])) {
                        $errorDetail .= (!empty($errorDetail) ? ' ' : '') . 'id: ' . $errors['id'];
                    }

                    if (!empty($errorDetail)) {
                        $this->setErrorDetail($errorDetail);
                    }
                }
                $result = false;
            }
        } else {
            $result = false;
        }

        return $result;
    }
    
    /**
     * @param string $url
     * @param array $params
     * @param array $curlOptions
     * @param boolean $decode
     * @return mixed
     */
    public function query($url, $params = [], $curlOptions = [], $decode = true)
    {
        $result = false;
        
        if ($url) {
            $this->curlOptions = $curlOptions + $this->curlOptions;
            $this->apiUrl = $url;
            

            $result = $this->_execCurl($params);
            if($decode === true){
                $result = \CJSON::decode($result);
            }
        }

        return $result;
    }

}
