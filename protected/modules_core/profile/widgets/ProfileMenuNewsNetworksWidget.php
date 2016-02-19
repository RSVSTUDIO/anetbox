<?php

/**
 * ProfileMenuNewsNetworksWidget shows the (usually left) navigation on user profiles.
 */
class ProfileMenuNewsNetworksWidget extends MenuWidget
{

    public $template = "application.modules_core.profile.widgets.views.leftNavigation";

    public function init()
    {
        $assetPrefix = Yii::app()->assetManager->publish(dirname(__FILE__) . '/css', true, 0, defined('YII_DEBUG'));
        Yii::app()->clientScript->registerCssFile($assetPrefix . '/menuNetworksWidget.css');

        $assetPrefix = Yii::app()->assetManager->publish(dirname(__FILE__) . '/js', true, 0, defined('YII_DEBUG'));
        Yii::app()->clientScript->registerScriptFile($assetPrefix . '/menuNetworksWidget.js', CClientScript::POS_END);
        
        $instId = Yii::app()->request->getQuery('id');
        $userGuid = Yii::app()->user->guid;
        $myInstruments = UserSiteInstruments::model()->getIdsByUserGuid($userGuid);
        $instruments = UserInstruments::model()->getInstruments();

        $this->addItemGroup(array(
            'id' => 'all_networks',
            'label' => Yii::t('ProfileModule.base', 'Networks'),
            'sortOrder' => 100,
        ));
        
        if (Yii::app()->user->isNewsAdmin()) {            
            $this->addItem(array(
                'label' => Yii::t('ProfileModule.base', 'Add news'),
                'group' => 'all_networks',
                'type' => 'button',
                'icon' => '<i class="fa fa-plus"></i>',
                'options' => 'data-toggle="modal" data-target="#addNewsModal" data-text-label="' . Yii::t('ProfileModule.base', 'New news') . '" data-text-btn="' . Yii::t('ProfileModule.base', 'Add news') . '"',
                'sortOrder' => 108
            ));
        }

        
        $this->addItem(array(
            'label' => Yii::t('ProfileModule.base', 'All networks'),
            'group' => 'all_networks',
            'url' => Yii::app()->createUrl('//profile/news'),
            'sortOrder' => 109,
            'isActive' => (isset(Yii::app()->controller->id) && Yii::app()->controller->id == 'news' && isset(Yii::app()->controller->action->id) && Yii::app()->controller->action->id == 'index'),
            'status' => ''
        ));
        
        if (!empty($instruments)) {
            foreach ($instruments as $key => $inst) {
                $this->addItem(array(
                    'label' => $inst['title'],
                    'group' => 'all_networks',
                    'url' => Yii::app()->createUrl('//profile/news/network', ['id' => $inst['id']]),
                    'sortOrder' => (110 + $key),
                    'isActive' => (isset(Yii::app()->controller->id) && Yii::app()->controller->id == 'news' && isset(Yii::app()->controller->action->id) && Yii::app()->controller->action->id == 'network' && $inst['id'] == $instId),
                    'status' => (in_array($inst['id'], $myInstruments) ? '<i class="fa fa-check pull-right text-success"></i>' : '')
                ));
            }
        }

        parent::init();
    }

}

?>
