<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/user/api.js', CClientScript::POS_END); ?>
<div class="container">
    <div class="row">
        <div class="col-md-12 panel panel-body">
            <div class="panel-body">
                <strong><?php echo(Yii::t('ProfileModule.base', 'Your access code')); ?>:</strong> 
                <code class="select-area-code"><?php echo($code); ?></code>
            </div>
        </div>
    </div>
</div>