<?php

/**
 * This is the model class for table "user_site_instrument".
 *
 * The followings are the available columns in table 'user_site_instrument':
 * @property integer $id
 * @property integer $site_id
 * @property integer $instrument_id
 * @property string $cron
 * @property string $login
 * @property string $password
 * @property string $api_data
 *
 */
class UserSiteInstruments extends HActiveRecord
{
    
    const cronActionYes = 'y';
    const cronActionNo = 'n';

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return UserSiteInstruments the static model class
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
        return 'user_site_instrument';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('site_id, instrument_id', 'required'),
            array('site_id, instrument_id', 'numerical', 'integerOnly' => true),
            array('site_id', 'exist', 'attributeName' => 'id', 'className' => 'UserSite'),
            array('instrument_id', 'exist', 'attributeName' => 'id', 'className' => 'UserInstruments'),
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
            'usite' => array(self::BELONGS_TO, 'UserSite', 'site_id'),
            'uinstrument' => array(self::BELONGS_TO, 'UserInstruments', 'instrument_id'),
        );
    }
    
    /**
     * Before saving this record.
     *
     * @return attribute model
     */
    protected function beforeSave()
    {
        if (empty($this->cron)) {
            $this->cron = self::cronActionYes; //default value
        }

        return parent::beforeSave();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'site_id' => 'Site',
            'instrument_id' => 'Instrument',
        );
    }

    /**
     * 
     * @param integer $id
     * @return array
     */
    public function getIdisBySiteId($id = 0)
    {
        $ret = [];

        if ((int)$id > 0) {
            $query = Yii::app()->db->createCommand()
                ->select('instrument_id')
                ->from($this->tableName())
                ->where('site_id = :site_id', [':site_id' => $id])
                ->order('instrument_id asc');
            
            
            $result = $query->queryColumn();

            if ($result) {
                $ret = $result;
            }
        }

        return $ret;
    }

    /**
     * Get one row
     * @param array $params
     * @return array
     */
    public function getRows($params = [])
    {
        $ret = [];

        if (count($params) > 0) {
            $select = [
                'usi.id as usi_id',
                'usi.site_id',
                'usi.instrument_id',
                'us.url as site_url',
                'us.user_id',
                'usi.login',
                'usi.password',
                'usi.api_data',
            ];
            $query = Yii::app()->db->createCommand()
                ->from($this->tableName() . ' as usi')
                ->join(UserSite::model()->tableName() . ' as us', 'usi.site_id = us.id');

            if (!empty($params['site_id'])) {
                $query->andWhere('usi.site_id = :site_id', [':site_id' => $params['site_id']]);
            }
            if (!empty($params['instrument_id'])) {
                $query->andWhere('usi.instrument_id = :instrument_id', [':instrument_id' => $params['instrument_id']]);
            }
            if (!empty($params['cron'])) {
                $query->andWhere('usi.cron = :cron', [':cron' => $params['cron']]);
            }
            if (!empty($params['user_id'])) {
                $query->andWhere('us.user_id = :user_id', [':user_id' => $params['user_id']]);
            }
            
            $query->select($select);

            $result = $query->queryAll();

            if ($result) {
                $ret = $result;
            }
        }

        return $ret;
    }

    /**
     * Get ids array
     * @param string $guid
     * @return array
     */
    public function getIdsByUserGuid($guid = null)
    {
        $ret = [];

        if (!empty($guid)) {
            $query = Yii::app()->db->createCommand()
                ->selectDistinct('usi.instrument_id')
                ->from($this->tableName() . ' as usi')
                ->join(UserSite::model()->tableName() . ' as us', 'usi.site_id = us.id')
                ->where('us.user_id = :user_id', [':user_id' => $guid]);

            $result = $query->queryColumn();

            if ($result) {
                $ret = $result;
            }
        }

        return $ret;
    }

}
