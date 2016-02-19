<?php

Yii::app()->moduleManager->register(array(
    'id' => 'cron',
    'class' => 'application.modules_core.cron.CronModule',
    'isCoreModule' => true,
    'import' => array(
        //'application.modules_core.cron.*',
    ),
    // Events to Catch 
    'events' => array(),
));
?>