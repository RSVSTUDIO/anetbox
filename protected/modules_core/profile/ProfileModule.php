<?php

/**
 * Profile Base Module
 */
class ProfileModule extends HWebModule
{

    public $isCoreModule = true;

    /**
     * Inits the Module
     */
    public function init()
    {
        $this->setImport(array(
            //'profile.models.*', //imported in /protected/config/_defaults.php
            'mail.models.*',
        ));
    }

    /**
     * On build of the TopMenu, check if module is enabled
     * When enabled add a menu item
     *
     * @param type $event
     */
    public static function onTopMenuInit($event)
    {
        $menu = [
            [
                'label' => 'Profile',
                'id' => 'profile',
                'icon' => 'fa fa-user',
                'isEmpty' => false,
            ],
            [
                'label' => 'Cabinet',
                'id' => 'cabinet',
                'icon' => 'fa fa-tachometer',
                'isEmpty' => false,
            ],
            [
                'label' => 'Areas',
                'id' => 'areas',
                'icon' => 'fa fa-database',
                'isEmpty' => false,
            ],
            [
                'label' => 'Networks',
                'id' => 'networks',
                'icon' => 'fa fa-cloud',
                'isEmpty' => false,
            ],
            [
                'label' => 'People',
                'id' => 'people',
                'icon' => 'fa fa-users',
                'isEmpty' => false,
            ],
//            [
//                'label' => 'Advert',
//                'id' => 'advert',
//                'icon' => 'fa fa-bullhorn',
//                'isEmpty' => true,
//            ],
//            [
//                'label' => 'Events',
//                'id' => 'events',
//                'icon' => 'fa fa-glass',
//                'isEmpty' => true,
//            ],
            [
                'label' => 'News',
                'id' => 'news',
                'icon' => 'fa fa-newspaper-o',
                'isEmpty' => false,
            ],
        ];

        foreach ($menu as $key => $item) {
            $event->sender->addItem(array(
                'label' => Yii::t('ProfileModule.base', $item['label']),
                'id' => $item['id'],
                'icon' => '<i class="' . $item['icon'] . '"></i>',
                'url' => Yii::app()->createUrl('//profile/' . $item['id']),
                'sortOrder' => ($key + 1),
                'isActive' => (isset(Yii::app()->controller->module) && Yii::app()->controller->module->id == 'profile' && Yii::app()->controller->id == $item['id']),
                'isEmpty' => $item['isEmpty'],
            ));
        }
    }

}
