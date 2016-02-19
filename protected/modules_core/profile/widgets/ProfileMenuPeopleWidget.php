<?php

/**
 * ProfileMenuNetworksWidget shows the (usually left) navigation on user profiles.
 */
class ProfileMenuPeopleWidget extends MenuWidget
{

    public $template = "application.modules_core.profile.widgets.views.leftNavigationPeople";
    public $filterId = 0;

    public function init()
    {
        $assetPrefix = Yii::app()->assetManager->publish(dirname(__FILE__) . '/js', true, 0, defined('YII_DEBUG'));
        Yii::app()->clientScript->registerScriptFile($assetPrefix . '/menuPeopleWidget.js', CClientScript::POS_END);

        $this->filterId = (int) Yii::app()->request->getQuery('filter');

        $filterArray = [
            [
                'id' => 0,
                'label' => 'all participants'
            ],
            [
                'id' => 1,
                'label' => 'my contacts'
            ],
            [
                'id' => 3,
                'label' => 'buyer',
                'class' => 'disable-element'
            ],
            [
                'id' => 4,
                'label' => 'seller',
                'class' => 'disable-element'
            ],
            [
                'id' => 2,
                'label' => 'blocked'
            ],
        ];

        foreach ($filterArray as $key => $item) {
            $this->addItem(array(
                'label' => Yii::t('ProfileModule.people', $item['label'], (isset($item['label_array']) ? $item['label_array'] : [])),
                'group' => 'peoples',
                'url' => Yii::app()->createUrl('//profile/people', ($item['id'] > 0 ? ['filter' => $item['id']] : [])),
                'sortOrder' => (100 + $key),
                'isActive' => (
                isset(Yii::app()->controller->id) &&
                Yii::app()->controller->id == 'people' &&
                isset(Yii::app()->controller->action->id) &&
                Yii::app()->controller->action->id == 'index' &&
                $item['id'] == $this->filterId
                ),
                'class' => (isset($item['class']) ? $item['class'] : '')
            ));
        }

        parent::init();
    }

}

?>
