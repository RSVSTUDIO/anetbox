<?php

/**
 * This is the model class for table "user_instruments_log".
 *
 * The followings are the available columns in table 'user_instruments_log':
 * @property integer $id
 * @property integer $usi_id
 * @property string $comment
 *
 */
class UserInstrumentsLog extends HActiveRecord
{

    const StatusUpdate = 'update';
    const StatusAdd = 'add';
    const StatusNoData = 'no data';
    const StatusEmptyId = 'not found id';

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return UserInstrumentsLog the static model class
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
        return 'user_instruments_log';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('usi_id, comment', 'required'),
            array('usi_id', 'numerical', 'integerOnly' => true),
            array('usi_id', 'exist', 'attributeName' => 'id', 'className' => 'UserSiteInstruments'),
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
            'userSiteInstrument' => array(self::BELONGS_TO, 'UserSiteInstruments', 'usi_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'usi_id' => 'Site Instruments primary key',
            'comment' => 'Log comment',
        );
    }

}
