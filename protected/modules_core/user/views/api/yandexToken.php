<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/user/api.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/user/api/yandex-token.js', CClientScript::POS_END); ?>
<div class="container">
    <div class="row">
        <div class="col-md-12 panel panel-body">
            <div class="panel-body">
                <div class="row">                    
                    <div class="col-md-12">                        
                        <strong><?php echo(Yii::t('ProfileModule.base', 'Your token')); ?>:</strong> 
                        <code class="select-area-code">Loading...</code>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>