<?php

/**
 * This is the model class for table "user_referral_data".
 *
 * The followings are the available columns in table 'user_referral_data':
 * @property integer $id
 * @property string $site_id
 * @property string $instrument_id
 * @property string $referrals
 * @property string $earnings
 * @property string $recdate
 *
 */
class UserReferralData extends HActiveRecord
{

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return UserReferralData the static model class
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
        return 'user_referral_data';
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
            array('site_id, instrument_id, referrals', 'numerical', 'integerOnly' => true),
            array('earnings', 'numerical', 'integerOnly' => false),
            array('referrals, earnings', 'length', 'max' => 20),
            array('instrument_id', 'exist', 'attributeName' => 'id', 'className' => 'UserInstruments'),
            array('site_id', 'exist', 'attributeName' => 'id', 'className' => 'UserSite'),
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
            'usite' => array(self::BELONGS_TO, 'UserSite', 'site_id'),
        );
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
            'referrals' => 'Referrals',
            'earnings' => 'Earnings',
            'recdate' => 'Created At',
        );
    }

    /**
     * Get referrals by site
     * @param integer $siteId
     * @param integer $instrumentId
     * @param string $dateFrom
     * @param string $dateTo
     * @return array
     */
    public function getReferralsBySite($siteId = 0, $instrumentId = 0, $dateFrom = '', $dateTo = '')
    {
        $result = [];

        if ($siteId > 0) {
            $query = Yii::app()->db->createCommand()
                ->select([
                    'sum(urd.referrals) as referrals',
                    'sum(urd.earnings) as earnings'
                ])
                ->from($this->tableName() . ' as urd')
                ->where('urd.site_id = :site_id', [':site_id' => $siteId]);

            if ($instrumentId > 0) {
                $query->andWhere('urd.instrument_id = :instrument_id', [':instrument_id' => $instrumentId]);
            }

            if (!empty($dateFrom)) {
                $query->andWhere('urd.recdate >= :dateFrom', [':dateFrom' => $dateFrom]);
            }

            if (!empty($dateTo)) {
                $query->andWhere('urd.recdate <= :dateTo', [':dateTo' => $dateTo]);
            }

            $result = $query->queryRow();

            if ($result) {
                foreach ($result as &$item) {
                    if (!empty($item['earnings'])) {
                        $item['earnings'] = Currency::model()->convertEarning($item['earnings'], Yii::app()->user->getModel()->getCurrency(), false);
                    }
                }
            }
        }

        return $result;
    }

    /**
     * Get counters
     * @param string $userId
     * @param integer $instrumentId
     * @param string $dateFrom
     * @param string $dateTo
     * @return array
     */
    public function getReferralCounters($userId = '', $instrumentId = 0, $dateFrom = '', $dateTo = '')
    {
        $result = [];

        if (!empty($userId)) {
            $subDateFrom = (new DateTime('NOW'))->modify('-1 day')->format('Y-m-d') . ' 00:00:00';

            $subQuery = Yii::app()->db->createCommand()
                ->select('sum(sub_urd.referrals)')
                ->from($this->tableName() . ' as sub_urd')
                ->where('sub_urd.site_id = urd.site_id')
                ->andWhere('sub_urd.instrument_id = urd.instrument_id')
                ->andWhere('sub_urd.recdate >= "' . $subDateFrom . '"');
            
            $query = Yii::app()->db->createCommand()
                ->select([
                    'us.url',
                    'sum(urd.referrals) as referrals',
                    'sum(urd.earnings) as earnings',
                    '(' . $subQuery->getText() . ') as new_referrals',
                ])
                ->from(UserSite::model()->tableName() . ' as us')
                ->leftJoin($this->tableName() . ' as urd', 'us.id = urd.site_id')
                ->where('us.user_id = :user_id', [':user_id' => $userId])
                ->group('us.id')
                ->order('us.id asc');

            if ($instrumentId > 0) {
                $query->andWhere('urd.instrument_id = :instrument_id', [':instrument_id' => $instrumentId]);
            }

            if (!empty($dateFrom)) {
                $query->andWhere('urd.recdate >= :dateFrom', [':dateFrom' => $dateFrom]);
            }

            if (!empty($dateTo)) {
                $query->andWhere('urd.recdate <= :dateTo', [':dateTo' => $dateTo]);
            }

            $result = $query->queryAll();

            if ($result) {
                foreach ($result as &$item) {
                    if (!empty($item['earnings'])) {
                        $item['earnings'] = Currency::model()->convertEarning($item['earnings'], Yii::app()->user->getModel()->getCurrency(), false);
                    }
                    
                    $item['new_referrals'] = empty($item['new_referrals']) ? '' : ' <sup title="'.Yii::t('ProfileModule.base', 'New referrals').'">('.$item['new_referrals'].')</sup>';
                }
            }
        }

        return $result;
    }

    /**
     * Get counters by Ajax
     * @param string $userId
     * @param integer $instrumentId
     * @param string $dateFrom
     * @param string $dateTo
     * @return array
     */
    public function getReferralCountersByAjax($userId = '', $instrumentId = 0, $dateFrom = '', $dateTo = '')
    {
        $ret = $this->getReferralCounters($userId, $instrumentId, $dateFrom, $dateTo);

        foreach ($ret as &$item) {
            if (!empty($item['earnings'])) {
                $item['earnings'] = Currency::model()->convertEarning($item['earnings'], Yii::app()->user->getModel()->getCurrency(), false);
            }
            
            $item['referrals'] = empty($item['referrals']) ? '<small>N/A</small>' : '<strong>' . $item['referrals'] . $item['new_referrals'] . '</strong>';
            $item['earnings'] = empty($item['earnings']) ? '<small>N/A</small>' : '<strong>' . Currency::model()->setString($item['earnings']) . '</strong>';
            
            unset($item['new_referrals']);
        }

        return $ret;
    }
}
