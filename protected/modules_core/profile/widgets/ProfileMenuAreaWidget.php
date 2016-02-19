<?php

/**
 * ProfileMenuAreaWidget shows the (usually left) navigation on user profiles.
 */
class ProfileMenuAreaWidget extends MenuWidget
{

    public $template = "application.widgets.views.leftNavigation";

    public function init()
    {
        $assetPrefix = Yii::app()->assetManager->publish(dirname(__FILE__) . '/css', true, 0, defined('YII_DEBUG'));
        Yii::app()->clientScript->registerCssFile($assetPrefix . '/menuAreaWidget.css');
        
        $siteId = Yii::app()->request->getQuery('id');
        $userGuid = Yii::app()->user->guid;
        $sites = UserSite::model()->findAll('user_id=:user_id', array(':user_id' => $userGuid));

        $this->addItemGroup(array(
            'id' => 'areas',
            'label' => Yii::t('ProfileModule.base', 'My areas'),
            'sortOrder' => 100,
        ));


        $this->addItem(array(
            'id' => 'add-site',
            'type' => 'button',
            'label' => Yii::t('ProfileModule.base', 'Add site'),
            'group' => 'areas',
            'sortOrder' => 110,
            'icon' => '<i class="fa fa-plus"></i>',
            'options' => 'data-toggle="modal" data-target="#addSiteModal"',
            //'url' => Yii::app()->createUrl('//profile/areas/add', []),
            //'isActive' => (isset(Yii::app()->controller->id) && Yii::app()->controller->id == 'areas' && isset(Yii::app()->controller->action->id) && Yii::app()->controller->action->id == 'add'),
        ));


        if (!empty($sites)) {
            foreach ($sites as $key => $site) {
                $this->addItem(array(
                    'label' => Yii::t('UserModule.widgets_ProfileMenuWidget', $site->title),
                    'group' => 'areas',
                    'url' => Yii::app()->createUrl('//profile/areas/show', ['id' => $site->id]),
                    'sortOrder' => (120 + $key),
                    'isActive' => (isset(Yii::app()->controller->id) && Yii::app()->controller->id == 'areas' && isset(Yii::app()->controller->action->id) && Yii::app()->controller->action->id == 'show' && $site->id == $siteId),
                ));
            }
        }

        parent::init();
    }

}

?>
