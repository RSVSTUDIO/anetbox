<?php

/**
 * ProfileMenuNetworksWidget shows the (usually left) navigation on user profiles.
 */
class ProfileMenuNetworksWidget extends MenuWidget
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
            'label' => Yii::t('ProfileModule.base', 'All networks'),
            'sortOrder' => 100,
        ));
        
        $this->addItemGroup(array(
            'id' => 'my_networks',
            'label' => Yii::t('ProfileModule.base', 'My networks'),
            'sortOrder' => 200,
        ));

        if (!empty($instruments)) {
            foreach ($instruments as $key => $inst) {
                $this->addItem(array(
                    'label' => $inst['title'],
                    'group' => 'all_networks',
                    'url' => Yii::app()->createUrl('//profile/networks/show', ['id' => $inst['id']]),
                    'sortOrder' => (110 + $key),
                    'isActive' => (isset(Yii::app()->controller->id) && Yii::app()->controller->id == 'networks' && isset(Yii::app()->controller->action->id) && Yii::app()->controller->action->id == 'show' && $inst['id'] == $instId),
                    'status' => (in_array($inst['id'], $myInstruments) ? '<i class="fa fa-check pull-right text-success"></i>' : '')
                ));
                
                if (in_array($inst['id'], $myInstruments)) {
                    $this->addItem(array(
                        'label' => $inst['title'],
                        'group' => 'my_networks',
                        'url' => Yii::app()->createUrl('//profile/networks/show', ['id' => $inst['id']]),
                        'sortOrder' => (210 + $key),
                        'isActive' => (isset(Yii::app()->controller->id) && Yii::app()->controller->id == 'networks' && isset(Yii::app()->controller->action->id) && Yii::app()->controller->action->id == 'show' && $inst['id'] == $instId),
                        'status' => ''
                    ));
                }
            }
        }

        parent::init();
    }

}

?>
