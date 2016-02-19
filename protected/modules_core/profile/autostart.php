<?php

Yii::app()->moduleManager->register(array(
    'id' => 'profile',
    'class' => 'application.modules_core.profile.ProfileModule',
    'isCoreModule' => true,
    'import' => array(
        'application.modules_core.profile.*',
    ),
    // Events to Catch 
    'events' => array(
        array('class' => 'TopMenuWidget', 'event' => 'onInit', 'callback' => array('ProfileModule', 'onTopMenuInit')),
    ),
));
?>