<?php

/**
 * This is the model class for table "user_instruments".
 *
 * The followings are the available columns in table 'user_instruments':
 * @property integer $id
 * @property string $site_id
 * @property string $instrument_id
 * @property string $pages
 * @property string $users
 * @property string $views
 * @property string $clicks
 * @property string $actions
 * @property string $earnings
 * @property string $recdate
 *
 */
class UserInstrumentsData extends HActiveRecord
{

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return UserInstrumentsData the static model class
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
        return 'user_instruments_data';
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
            array('site_id, instrument_id, pages, users, views, clicks, actions', 'numerical', 'integerOnly' => true),
            array('earnings', 'numerical', 'integerOnly' => false),
            array('pages, users, views, clicks, actions, earnings', 'length', 'max' => 20),
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
            'pages' => 'Pages',
            'users' => 'Users',
            'views' => 'Views',
            'clicks' => 'Clicks',
            'actions' => 'Action',
            'earnings' => 'Earnings',
            'recdate' => 'Created At',
        );
    }

    /**
     * Get site counters
     * @param string $userId
     * @param integer $instrumentId
     * @param string $dateFrom
     * @param string $dateTo
     * @return array
     */
    public function getSiteCounters($userId = '', $instrumentId = 0, $dateFrom = '', $dateTo = '')
    {
        $result = [];

        if (!empty($userId)) {
            $query = Yii::app()->db->createCommand()
                ->select([
                    'us.url',
                    'sum(uid.pages) as pages',
                    'sum(uid.users) as users',
                    'sum(uid.views) as views',
                    'sum(uid.clicks) as clicks',
                    'sum(uid.actions) as actions',
                    'sum(uid.earnings) as earnings',
                ])
                ->from(UserSite::model()->tableName() . ' as us')
                ->leftJoin($this->tableName() . ' as uid', 'us.id = uid.site_id')
                ->where('us.user_id = :user_id', [':user_id' => $userId])
                ->group('us.id')
                ->order('us.id asc');

            if ($instrumentId > 0) {
                $query->andWhere('uid.instrument_id = :instrument_id', [':instrument_id' => $instrumentId]);
            }

            if (!empty($dateFrom)) {
                $query->andWhere('uid.recdate >= :dateFrom', [':dateFrom' => $dateFrom]);
            }

            if (!empty($dateTo)) {
                $query->andWhere('uid.recdate <= :dateTo', [':dateTo' => $dateTo]);
            }

            $result = $query->queryAll();

            if ($result) {
                foreach ($result as &$item) {
                    $item['total'] = $this->calcTotal($item);
                    if (!empty($item['earnings'])) {
                        $item['earnings'] = Currency::model()->convertEarning($item['earnings'], Yii::app()->user->getModel()->getCurrency(), false);
                    }
                }
            }
        }

        return $result;
    }

    /**
     * Get site counters by Ajax
     * @param string $userId
     * @param integer $instrumentId
     * @param string $dateFrom
     * @param string $dateTo
     * @return array
     */
    public function getSiteCountersByAjax($userId = '', $instrumentId = 0, $dateFrom = '', $dateTo = '')
    {
        $ret = $this->getSiteCounters($userId, $instrumentId, $dateFrom, $dateTo);

        foreach ($ret as &$item) {
            if (!empty($item['earnings'])) {
                $item['earnings'] = Currency::model()->convertEarning($item['earnings'], Yii::app()->user->getModel()->getCurrency(), false);
            }

            $item['pages'] = empty($item['pages']) ? '<small>N/A</small>' : '<strong>' . $item['pages'] . '</strong>';
            $item['users'] = empty($item['users']) ? '<small>N/A</small>' : '<strong>' . $item['users'] . '</strong>';
            $item['views'] = empty($item['views']) ? '<small>N/A</small>' : '<strong>' . $item['views'] . '</strong>';
            $item['clicks'] = empty($item['clicks']) ? '<small>N/A</small>' : '<strong>' . $item['clicks'] . '</strong>';
            $item['actions'] = empty($item['actions']) ? '<small>N/A</small>' : '<strong>' . $item['actions'] . '</strong>';
            $item['earnings'] = empty($item['earnings']) ? '<small>N/A</small>' : '<strong>' . Currency::model()->setString($item['earnings']) . '</strong>';
            $item['total'] = empty($item['total']) ? '<small>N/A</small>' : '<strong>' . $item['total'] . '</strong>';
        }

        return $ret;
    }

    /**
     * Calculate total for item
     * @param array $item
     * @return integer
     */
    private function calcTotal($item)
    {
        return array_sum([
            $item['pages'],
            $item['users'],
            $item['views'],
            $item['clicks'],
            $item['actions']
        ]);
    }

    /**
     * Get network CTR
     * @param integer $userId
     * @param integer $siteId
     * @param string $dateFrom
     * @param string $dateTo
     * @return array
     */
    public function getNetworkCTR($userId = 0, $siteId = 0, $dateFrom = '', $dateTo = '')
    {
        $result = [];

        if ($userId > 0 && $siteId > 0) {
            $query = Yii::app()->db->createCommand()
                ->select([
                    'ui.title',
                    'sum(uid.clicks) as clicks',
                    'sum(uid.views) as views',
                    'sum(uid.earnings) as earnings',
                ])
                ->from(UserInstruments::model()->tableName() . ' as ui')
                ->leftJoin($this->tableName() . ' as uid', 'ui.id = uid.instrument_id')
                ->rightJoin(UserSite::model()->tableName() . ' as us', 'uid.site_id = us.id')
                ->where('us.user_id = :user_id', [':user_id' => $userId])
                ->andWhere('us.id = :site_id', [':site_id' => $siteId])
                ->group('ui.id')
                ->order('ui.title asc');

            if (!empty($dateFrom)) {
                $query->andWhere('uid.recdate >= :dateFrom', [':dateFrom' => $dateFrom]);
            }

            if (!empty($dateTo)) {
                $query->andWhere('uid.recdate <= :dateTo', [':dateTo' => $dateTo]);
            }

            $result = $query->queryAll();

            if ($result) {
                foreach ($result as &$item) {
                    if ($item['views'] > 0) {
                        $item['ctr'] = (($item['clicks'] / $item['views']) * 100);
                    } else {
                        $item['ctr'] = 0;
                    }

                    $item['ctr'] = number_format($item['ctr'], 2, '.', '');
                    $item['earnings'] = Currency::model()->convertEarning($item['earnings'], Yii::app()->user->getModel()->getCurrency(), false);
                    $item['earnings'] = Currency::model()->setString($item['earnings']);
                }
            }
        }

        return $result;
    }
    
}
