<?php 
// load js for datetimepicker component
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/moment-with-locales.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap-datetimepicker.js', CClientScript::POS_END);
// load css for datetimepicker component
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/bootstrap-datetimepicker.css');

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/profile/period-date.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/profile/period-date.js', CClientScript::POS_END); 
?>
<div class="form-inline">
    <?php echo CHtml::beginForm($urlArray, 'post', ['class' => 'form-set-period-date']); ?>
        <div class="form-group period-datetime-title"><?php echo(Yii::t('ProfileModule.base', 'Period')); ?></div>
        <div class="form-group">
            <label class="sr-only" for="period-date-from"><?php echo(Yii::t('ProfileModule.base', 'date from')); ?></label>
            <?php echo CHtml::textField('date-from', (isset($dateFrom) ? $dateFrom : ''), array('class' => 'form-control period-datetime-field', 'id' => 'period-date-from', 'placeholder' => Yii::t('ProfileModule.base', 'date from'))); ?>
        </div>
        <div class="form-group period-datetime-separator">-</div>
        <div class="form-group">
            <label class="sr-only" for="period-date-to"><?php echo(Yii::t('ProfileModule.base', 'date to')); ?></label>
            <?php echo CHtml::textField('date-to', '', array('class' => 'form-control period-datetime-field', 'id' => 'period-date-to', 'placeholder' => Yii::t('ProfileModule.base', 'date to'))); ?>
        </div>
        <?php if (isset($renderSelector)) { ?>
        <?php echo(CHtml::hiddenField('render-selector', $renderSelector)); ?>
        <?php } ?>
        <?php if (isset($renderCallback)) { ?>
        <?php echo(CHtml::hiddenField('render-callback', $renderCallback)); ?>
        <?php } ?>
    <?php echo CHtml::endForm(); ?>
</div>