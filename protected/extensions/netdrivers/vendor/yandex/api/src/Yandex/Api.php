<?php

namespace Yandex;

class Api
{

    /**
     * Id приложения
     * @var string $id
     */
    protected $id;

    /**
     * Пароль приложения
     * @var string
     */
    protected $password;

    /**
     * Песочница или боевое подключение
     * @var boolean
     */
    protected $useSandbox = false;

    /**
     * Ссылка для авторизации на директе
     * @var string
     */
    protected $authorizeLink;

    /**
     * Токен от директа
     * @var string
     */
    protected $token;

    /**
     * Здесь хранится код ошибки, если она произошла
     * @var string
     */
    protected $error;

    /**
     * Здесь строка ошибки при вызове методов API
     * @var string
     */
    protected $errorStr;

    /**
     * Здесь описание ошибки при вызове методов API
     * @var string
     */
    protected $errorDetail;

    /**
     * Логин пользователя, с данными которого мы работаем
     * @var string
     */
    protected $login;

    /**
     * Curl
     * @var Curl
     */
    protected $curlOptions = array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_AUTOREFERER => true,
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:5.0) Gecko/20110619 Firefox/5.0',
        CURLOPT_TIMEOUT => 0,
        CURLOPT_POST => true,
    );

    /**
     * URL подключение к API. Либо боевой, либо песочница
     * @var string
     */
    protected $apiUrl;

    const AUTHORIZE_URL = 'https://oauth.yandex.ru/authorize';
    const RESPONSE_TYPE = 'token';

    public function init()
    {
        $this->apiUrl = ($this->useSandbox === true && $this->sandboxJsonApiUrl !== null) ? $this->sandboxJsonApiUrl : $this->jsonApiUrl;

        # Установим строку для авторизации
        $this->authorizeLink = self::AUTHORIZE_URL . '?' . http_build_query(array(
                'response_type' => self::RESPONSE_TYPE,
                'client_id' => $this->id,
        ));

        return $this;
    }

    /**
     * Получение ссылки для авторизации
     * @param string $state - произвольный параметр состояния
     * @return string
     */
    public function getAuthorizeUrl($state = '')
    {
        return $state ? $this->authorizeLink . '&state=' . $state : $this->authorizeLink;
    }

    /**
     * Установка ID приложения, с которым будем работать
     * @param $id
     * @return self
     */
    public function setID($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Установка пароля приложения, с которым будем работать
     * @param $password
     * @return self
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * Установка токена
     * @param string $token
     * @return self
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    /**
     * Установка использование песочницы
     * @param $useSandbox false или true
     * @return self
     */
    public function setUseSandbox($useSandbox = false)
    {
        $this->useSandbox = $useSandbox;
        return $this;
    }

    /**
     * Получаем логин пользователя, с которым мы работаем
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Установка логина пользователя, с которым будем работать
     * @param $login
     * @return self
     */
    public function setLogin($login)
    {
        $this->login = $login;
        return $this;
    }

    /**
     * Получение ошибки
     * return null|string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Установка ошибки
     * @param $error
     * @return $this
     */
    public function setError($error)
    {
        $this->error = $error;
        return $this;
    }

    /**
     * Установка информации об ошибке
     * @param string $errorDetail
     * @return $this
     */
    public function setErrorDetail($errorDetail)
    {
        $this->errorDetail = $errorDetail;
        return $this;
    }

    /**
     * Получение информации об ошибке
     * @return string
     */
    public function getErrorDetail()
    {
        return $this->errorDetail;
    }

    /**
     * Установка заголовка ошибки
     * @param string $errorStr
     * @return $this
     */
    public function setErrorStr($errorStr)
    {
        $this->errorStr = $errorStr;
        return $this;
    }

    /**
     * Получение заголовка ошибки
     * @return string
     */
    public function getErrorStr()
    {
        return $this->errorStr;
    }

    /**
     * Очистка информации об ошибках
     * @return $this
     */
    public function clearErrors()
    {
        $this->error = null;
        $this->errorStr = null;
        $this->errorDetail = null;
        return $this;
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
            $this->setError($httpCode);

            if (curl_errno($ch)) {
                $this->setErrorStr('curl error: ' . curl_error($ch));
            } else {
                $this->setErrorStr('curl http_code: ' . $httpCode);
            }

            $c = false;
        }

        curl_close($ch);

        return $c;
    }

    /**
     * Перекодировка
     * @param $struct
     * @return mixed
     */
    public function utf8($struct)
    {
        foreach ($struct as $key => $value) {
            if (is_array($value)) {
                $struct[$key] = $this->utf8($value);
            } elseif (is_string($value)) {
                $struct[$key] = utf8_encode($value);
            }
        }
        return $struct;
    }

}
