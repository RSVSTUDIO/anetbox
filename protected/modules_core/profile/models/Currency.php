<?php

/**
 * This is the model class for table "currency".
 *
 * The followings are the available columns in table 'currency':
 * @property integer $id
 * @property string $code
 * @property float $value
 *
 */
class Currency extends HActiveRecord
{

    const USD = 'usd';
    const EUR = 'eur';
    const RUB = 'rub';

    public static $valueEUR = null;
    public static $valueRUB = null;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Currency the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'currency';
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'code' => 'Code',
            'value' => 'Value',
        );
    }

    /**
     * Get currency from cbr.ru
     * @param string $currency
     * @return float
     */
    public function get($currency = self::USD)
    {
        $url = 'http://www.cbr.ru/scripts/XML_daily.asp';
        $res = $this->_execCurl($url);
        $ret = self::model()->findByAttributes(['code' => self::USD])->value;

        if ($currency === self::RUB) {
            $ret = $this->_calcRUB($res);
        }

        if ($currency === self::EUR) {
            $ret = $this->_calcEUR($res);
        }

        return $ret;
    }

    private function _calcRUB($res)
    {
        $model = self::model()->findByAttributes(['code' => self::RUB]);
        $ret = $model->value;

        if ($res) {
            $xml = simplexml_load_string($res);
            if (isset($xml->Valute)) {
                foreach ($xml->Valute as $item) {
                    $code = (string) $item->CharCode;

                    if ($code === 'USD') {
                        $ret = (str_replace(',', '.', $item->Value) / $item->Nominal);
                        $ret = number_format($ret, 4);

                        if ($model->value != $ret) {
                            $model->value = $ret;
                            $model->save();
                        }
                        break;
                    }
                }
            }
        }

        return $ret;
    }

    private function _calcEUR($res)
    {
        $model = self::model()->findByAttributes(['code' => self::EUR]);
        $ret = $model->value;

        if ($res) {
            $xml = simplexml_load_string($res);
            if (isset($xml->Valute)) {
                $usd = null;
                $eur = null;

                foreach ($xml->Valute as $item) {
                    $code = (string) $item->CharCode;

                    if ($code === 'USD') {
                        $usd = (str_replace(',', '.', $item->Value) / $item->Nominal);
                    }
                    if ($code === 'EUR') {
                        $eur = (str_replace(',', '.', $item->Value) / $item->Nominal);
                    }

                    if ($usd !== null && $eur !== null) {
                        $ret = ($eur / $usd);
                        $ret = number_format($ret, 4);

                        if ($model->value != $ret) {
                            $model->value = $ret;
                            $model->save();
                        }
                        break;
                    }
                }
            }
        }

        return $ret;
    }

    /**
     * Exec curl
     * @param string $url
     * @param array $data
     * @param array $options
     * @return mixed
     */
    private function _execCurl($url = null, $data = [], $options = [])
    {
        $res = false;

        if (!empty($url)) {
            $curlOptions = array(
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER => false,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_AUTOREFERER => true,
                CURLOPT_CONNECTTIMEOUT => 10,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:5.0) Gecko/20110619 Firefox/5.0',
                CURLOPT_TIMEOUT => 0,
                CURLOPT_POST => false,
            );

            $curlOptions = $options + $curlOptions;

            $ch = curl_init();
            curl_setopt_array($ch, $curlOptions);
            curl_setopt($ch, CURLOPT_URL, $url);

            if ($curlOptions[CURLOPT_POST] === true) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            }

            $res = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            if (curl_errno($ch) || $httpCode !== 200) {
                $res = false;
            }

            curl_close($ch);
        }

        return $res;
    }

    /**
     * Set currency string
     * @param string $value
     * @return string
     */
    public function setString($value)
    {
        switch (Yii::app()->user->getModel()->getCurrency()) {
            case self::RUB:
                $value = $value . ' <i class="fa fa-rub"></i>';
                break;
            case self::EUR:
                $value = $value . ' <i class="fa fa-eur"></i>';
                break;
            default:
                $value = '<i class="fa fa-usd"></i> ' . $value;
        }

        return $value;
    }
    
    /**
     * Convert to/from USD
     * @param float $earning
     * @param string $currency
     * @param boolean $toDollar
     * @return float
     */
    public function convertEarning($earning = 0, $currency = self::USD, $toDollar = true)
    {
        if ((float) $earning > 0) {
            if ($currency === self::RUB) {
                if (self::$valueRUB === null) {
                    self::$valueRUB = self::model()->get(self::RUB);
                }
                $earning = ($toDollar === true) ? ($earning / self::$valueRUB) : ($earning * self::$valueRUB);
            }
            if ($currency === self::EUR) {
                if (self::$valueEUR === null) {
                    self::$valueEUR = self::model()->get(self::EUR);
                }
                $earning = ($toDollar === true) ? ($earning / self::$valueEUR) : ($earning * self::$valueEUR);
            }
        }

        return number_format($earning, 2, '.', '');
    }

}
