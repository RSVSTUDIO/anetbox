<?php

/**
 * This is the model class for table "user_friend".
 *
 * The followings are the available columns in table 'user_friend':
 * @property integer $id
 * @property integer $user_id
 * @property integer $friend_id
 * @property string $accept Default 'n'
 * 
 * The followings are the available model relations:
 * @property User $user
 * @property User $friend
 */
class UserFriend extends HActiveRecord
{
    const statusAccepted = 'accepted';
    const statusSentRequest = 'sent';
    const statusReceivedRequest = 'received';
    
    const actionRemove = 'remove';
    const actionReject = 'reject';
    const actionConfirm = 'confirm';
    const actionRevoke = 'revoke';
    const actionSend = 'send';

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return UserFriend the static model class
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
        return 'user_friend';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, friend_id', 'numerical', 'integerOnly' => true),
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
            'friend' => array(self::BELONGS_TO, 'User', 'friend_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'user_id' => 'User ID',
            'friend_id' => 'Friend ID',
        );
    }

    /**
     * Return status
     * @return string
     */
    public function status()
    {
        if ($this->accept === 'y') {
            $status = self::statusAccepted;
        } else {
            $uid = Yii::app()->user->id;
            if ($this->user_id == $uid) {
                $status = self::statusSentRequest;
            } else {
                $status = self::statusReceivedRequest;
            }
        }

        return $status;
    }

    /**
     * Set user id
     * @param integer $uid
     * @param integer $fid
     * @return $this
     */
    public function setUser($uid = 0, $fid = 0)
    {
        if ($uid > 0) {
            $criteria = new CDbCriteria();

            $cond = [
                'u' => 'user_id = :uid',
                'f' => 'friend_id = :uid'
            ];
            $criteria->params = [':uid' => $uid];

            if ($fid > 0) {
                $cond['u'] = '(' . $cond['u'] . ' AND friend_id = :fid)';
                $cond['f'] = '(' . $cond['f'] . ' AND user_id = :fid)';
                $criteria->params[':fid'] = $fid;
            }

            foreach ($cond as $item) {
                $criteria->addCondition($item, 'OR');
            }

            $this->setDbCriteria($criteria);
        }

        return $this;
    }

    /**
     * Get includes user id without ban idis
     * @param integer $uid
     * @return arrai
     */
    public function getFriendIncludesWithoutBanIdis($uid = 0)
    {
        $includes = [];

        if ($uid > 0) {
            $friends = self::model()->setUser($uid)->findAllByAttributes(['accept' => 'y']);

            if (!empty($friends)) {
                $excludes = UserBan::model()->bannedIdisByUser($uid);
                $excludes[] = $uid;

                foreach ($friends as $friend) {
                    if (!in_array($friend->user_id, $excludes) && !in_array($friend->user_id, $includes)) {
                        $includes[] = $friend->user_id;
                    }
                    if (!in_array($friend->friend_id, $excludes) && !in_array($friend->friend_id, $includes)) {
                        $includes[] = $friend->friend_id;
                    }
                }
            }
        }

        return $includes;
    }

}
