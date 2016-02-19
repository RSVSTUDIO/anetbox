<?php

/**
 * This is the model class for table "user_instruments_users".
 *
 * The followings are the available columns in table 'user_instruments_users':
 * @property integer $id
 * @property integer $instrument_id
 * @property string $user_id
 * @property string $role
 * @property string $login
 * @property string $password
 *
 */
class UserInstrumentsUsers extends HActiveRecord
{
    
    const ROLE_OWNER = 'owner';

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return UserInstrumentsUsers the static model class
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
        return 'user_instruments_users';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, instrument_id, role, login, password', 'required'),
            array('instrument_id', 'numerical', 'integerOnly' => true),
            array('login', 'length', 'max' => 250),
            array('password', 'length', 'max' => 32),
            array('instrument_id', 'exist', 'attributeName' => 'id', 'className' => 'UserInstruments'),
            array('user_id', 'exist', 'attributeName' => 'guid', 'className' => 'User'),
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
            'uinstrument' => array(self::BELONGS_TO, 'UserInstruments', 'instrument_id'),
            'user' => array(self::BELONGS_TO, 'User', ['guid' => 'user_id']),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'user_id' => 'User ID',
            'instrument_id' => 'Instrument',
            'role' => 'Role',
            'login' => 'Login',
            'password' => 'Password',
        );
    }

    /**
     * Get instruments id array
     * @param string $guid
     * @return array
     */
    public function getIdisByUserId($guid = '')
    {
        $ret = [];

        if (!empty($guid)) {
            $query = Yii::app()->db->createCommand()
                ->select('instrument_id')
                ->from($this->tableName())
                ->where('user_id = :user_id', [':user_id' => $guid])
                ->order('instrument_id asc');
            
            $result = $query->queryColumn();

            if ($result) {
                $ret = $result;
            }
        }

        return $ret;
    }
}
