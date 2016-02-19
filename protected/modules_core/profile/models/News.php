<?php

/**
 * This is the model class for table "news".
 *
 * The followings are the available columns in table 'news':
 * @property integer $id
 * @property integer $instrument_id
 * @property string $title
 * @property string $short_text
 * @property string $full_text
 * @property string $url
 *
 */
class News extends HActiveRecord
{

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return News the static model class
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
        return 'news';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('instrument_id, title, short_text', 'required'),
            array('instrument_id', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 100),
            array('short_text', 'length', 'max' => 1000),
            array('full_text', 'length', 'max' => 20000),
            array('url', 'length', 'max' => 90),
            array('title, short_text, full_text, url', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
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
            'uinstrument' => array(self::BELONGS_TO, 'UserInstruments', 'instrument_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'instrument_id' => Yii::t('ProfileModule.base', 'Network'),
            'title' => Yii::t('ProfileModule.base', 'Title'),
            'short_text' => Yii::t('ProfileModule.base', 'Short text'),
            'full_text' => Yii::t('ProfileModule.base', 'Full text'),
            'url' => Yii::t('ProfileModule.base', 'URL'),
        );
    } 
    
    public function defaultScope()
    {
        return [
            'order' => 'created_at DESC'
        ];
    }

}
