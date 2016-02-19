<?php

/**
 * This is the model class for table "user_ban".
 *
 * The followings are the available columns in table 'user_ban':
 * @property integer $id
 * @property integer $user_id
 * @property integer $banned_id
 *
 */
class UserBan extends HActiveRecord
{

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return UserBan the static model class
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
        return 'user_ban';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, banned_id', 'numerical', 'integerOnly' => true),
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
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'banned' => array(self::BELONGS_TO, 'User', 'banned_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'user_id' => 'User ID',
            'banned_id' => 'Banned ID',
        );
    }

    /**
     * Get id array
     * @param integer $uid
     * @return array
     */
    public function bannedIdisByUser($uid = 0)
    {
        $idis = [];

        if ($uid > 0) {
            $banned = self::model()->findAllByAttributes(['user_id' => $uid]);
            if (!empty($banned)) {
                foreach ($banned as $ban) {
                    $idis[] = $ban->banned_id;
                }
            }
        }

        return $idis;
    }

}
