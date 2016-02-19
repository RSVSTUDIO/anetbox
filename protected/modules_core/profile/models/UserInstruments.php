<?php

/**
 * This is the model class for table "user_instruments".
 *
 * The followings are the available columns in table 'user_instruments':
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $url
 * @property integer $cpa
 * @property integer $cpc
 * @property integer $cpv
 * @property string $driver
 * @property string $signature
 * @property string $referral
 *
 */
class UserInstruments extends HActiveRecord
{

    const AnetBoxId = 1;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return UserInstruments the static model class
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
        return 'user_instruments';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title, url', 'required'),
            array('cpa, cpc, cpv', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 100),
            array('description, url', 'length', 'max' => 250),
            array('driver', 'length', 'max' => 50),
            array('signature', 'length', 'max' => 60),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'url' => 'URL',
        );
    }

    /**
     * Get instruments
     * @param string|array $columns
     * @param array $unsetIdis
     * @param array $setIdis
     * @return array
     */
    public function getInstruments($columns = '*', $unsetIdis = [], $setIdis = [])
    {
        $ret = [];

        $query = Yii::app()->db->createCommand()
            ->select($columns)
            ->from($this->tableName())
            ->order('title asc');

        if (count($unsetIdis) > 0) {
            $query->andWhere(['not in', 'id', $unsetIdis]);
        }

        if (count($setIdis) > 0) {
            $query->andWhere(['in', 'id', array_diff($setIdis, $unsetIdis)]);
        }

        $result = $query->queryAll();

        if ($result) {
            $ret = $result;
        }

        return $ret;
    }

    /**
     * Create Type for instruments array
     * @param array $inst
     * @return array
     */
    public function createType($inst)
    {
        if (is_array($inst)) {
            foreach ($inst as &$item) {
                $item['type'] = $this->generateType($item);
            }
        }

        return $inst;
    }

    /**
     * Get Type for current instrument
     * @return array
     */
    public function getType()
    {
        return $this->generateType($this);
    }

    /**
     * @param array|object $item
     * @return string
     */
    private function generateType($item)
    {
        if (!is_object($item)) {
            $item = (object) $item;
        }

        $type = [];

        if (isset($item->cpa) && $item->cpa == 1) {
            $type[] = 'CPA';
        }
        if (isset($item->cpc) && $item->cpc == 1) {
            $type[] = 'CPC';
        }
        if (isset($item->cpv) && $item->cpv == 1) {
            $type[] = 'CPV';
        }

        return implode(', ', $type);
    }

}
