<?php

/**
 * This is the model class for table "user_site".
 *
 * The followings are the available columns in table 'user_site':
 * @property integer $id
 * @property string $user_id
 * @property string $title
 * @property string $url
 * @property string $description
 * @property string $code
 * @property string $recdate
 * @property string $active
 *
 */
class UserSite extends HActiveRecord
{

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return UserSite the static model class
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
        return 'user_site';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title', 'required',
                'message' => Yii::t('ProfileModule.base', 'You must fill in the field «{field}»', [
                    '{field}' => Yii::t('ProfileModule.base', 'Title')
                ]), 'on' => 'add'
            ),
            array('url', 'required',
                'message' => Yii::t('ProfileModule.base', 'You must fill in the field «{field}»', [
                    '{field}' => 'URL'
                ])
            ),
            array('id', 'numerical', 'integerOnly' => true, 'on' => 'add'),
            array('user_id', 'length', 'max' => 45, 'on' => 'add'),
            array('user_id', 'exist', 'attributeName' => 'guid', 'className' => 'User'),
            array('title', 'length', 'max' => 100,
                'tooLong' => Yii::t('ProfileModule.base', '{field} is too long (maximum of {max} characters)', [
                    '{field}' => Yii::t('ProfileModule.base', 'Title'),
                    '{max}' => 100
                ]), 'on' => 'add'
            ),
            array('description', 'length', 'max' => 100,
                'tooLong' => Yii::t('ProfileModule.base', '{field} is too long (maximum of {max} characters)', [
                    '{field}' => Yii::t('ProfileModule.base', 'Description'),
                    '{max}' => 100
                ]), 'on' => 'add'
            ),
            array('url', 'length', 'max' => 250,
                'tooLong' => Yii::t('ProfileModule.base', '{field} is too long (maximum of {max} characters)', [
                    '{field}' => 'URL',
                    '{max}' => 250
                ])
            ),
            array('url', 'unique',
                'message' => Yii::t('ProfileModule.base', 'You have already added this URL'),
                'criteria' => [
                    'condition' => 'user_id = :user_id',
                    'params' => [':user_id' => Yii::app()->user->guid],
                ]
            ),
            array('url', 'url', 'pattern'=>'(([a-z0-9\-\.]+)?[a-z0-9\-]+(!?\.[a-z]{2,4}))',
                'message' => Yii::t('ProfileModule.base', 'URL is not correct')
            ),
            array('code', 'length', 'max' => 36, 'on' => 'add'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, user_id, title, url, description, code, recdate', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'ins' => array(self::HAS_MANY, 'UserInstrumentsData', 'site_id'),
            'user' => array(self::BELONGS_TO, 'User', ['guid' => 'user_id']),
        );
    }
    
    protected function beforeValidate()
    {
        $this->url = $this->fixURL($this->url);

        return parent::beforeValidate();
    }

    /**
     * Before saving this record.
     *
     * @return attribute model
     */
    protected function beforeSave()
    {
        $this->recdate = new CDbExpression('NOW()');
        if (!empty(Yii::app()->user->guid)) {
            $this->user_id = Yii::app()->user->guid;
        }
        $this->active = $this->statusActive('http://' . $this->url);

        
        return parent::beforeSave();
    }
    
    protected function afterSave()
    {
        // add site instruments
        $model = UserSiteInstruments::model()->findByAttributes([
            'site_id' => $this->id, 
            'instrument_id' => UserInstruments::AnetBoxId
        ]);
        
        if(!isset($model->id)){ 
            $model = new UserSiteInstruments();
            $model->site_id = $this->id;
            $model->instrument_id = UserInstruments::AnetBoxId;
            $model->save();
        }

        parent::afterSave();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'user_id' => 'User',
            'title' => 'Title',
            'url' => 'URL',
            'description' => 'Description',
            'code' => 'Code',
            'recdate' => 'Created At',
            'active' => 'Active',
        );
    }
    
    /**
     * @param string $url
     * @param boolean $sheme Default: false
     * @return string
     */
    public function fixURL($url, $sheme = false)
    {
        $tmp = parse_url($url);

        if (!isset($tmp['host'])) {
            $tmp = parse_url('http://' . $url);
        }

        if ($sheme === true) {
            $url = 'http://' . $tmp['host'];
        } else {
            $url = $tmp['host'];
        }

        return $url;
    }

    /**
     * @param string $url
     * @return string $active
     */
    public function statusActive($url)
    {
        $active = 'n';

        if (!empty($url)) {
            $user_agent = 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0)';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_VERBOSE, false);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSLVERSION, 3);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            $page = curl_exec($ch);

            $err = curl_error($ch);
            if (empty($err)) {
                $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                if (in_array($httpcode, [200, 301, 302])) {
                    $active = 'y';
                }
            }
            curl_close($ch);
        }

        return $active;
    }
    
    /**
     * Generate code
     * @param string $url
     * @return string
     */
    public function generateCode($url = null)
    {
        if (empty($url)) {
            $url = $this->url;
        }

        return 'ANB_' . md5($this->id . '_' . $url);
    }

    /**
     * @param string $url
     * @return string
     */
    public function getScript($url = null)
    {
        if (empty($url)) {
            $url = $this->url;
        }
        
        $script_text = "<script type='text/javascript'> //<![CDATA[ ANetBox counter for " . $url . PHP_EOL .
                            "var _anb = '" . $this->generateCode($url) . "';" . PHP_EOL .
                            " (function () {" . PHP_EOL .
                            "    var s_adb = document.createElement('script');" . PHP_EOL .
                            "    s_adb.type = 'text/javascript';" . PHP_EOL .
                            "    s_adb.async = true;" . PHP_EOL .
                            "    s_adb.src = 'http://counter.anetbox.com/anetbox.js';" . PHP_EOL .
                            "    var s_tag = document.getElementsByTagName('script')[0];" . PHP_EOL .
                            "    s_tag.parentNode.insertBefore(s_adb, s_tag);" . PHP_EOL .
                            " })(); " . PHP_EOL .
                       "//]]> </script>";

        return $script_text;
    }

    /**
     * @param string $url
     * @param array $idis
     * @return array $found_instruments
     */

    public function searchInstruments($url, $idis = [])
    {

        $found_instruments = array();
        $options = array(
            'http' => array('method' => "GET")
        );

        $context = stream_context_create($options);
        $analize_page = file_get_contents('http://' . $url, false, $context);

        if (count($idis) > 0) {
            $instruments = UserInstruments::model()->getInstruments('*', [], $idis);
        } else {
            $instruments = UserInstruments::model()->getInstruments();
        }


        foreach ($instruments as $instrument) {
            if (!empty($instrument['signature'])) {
                if (strpos($analize_page, $instrument['signature']) != false) {
                    $found_instruments[$instrument['id']] = $instrument['title'];
                }
            }
        }

        return $found_instruments;
    }

}
