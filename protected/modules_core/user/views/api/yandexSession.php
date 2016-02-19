<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/user/api.js', CClientScript::POS_END); ?>
<div class="container">
    <div class="row">
        <div class="col-md-12 panel panel-body">
            <div class="panel-body">
                <div class="row">                    
                    <div class="col-md-12">                        
                        <strong><?php echo(Yii::t('ProfileModule.base', 'Session Key {id}', ['{id}' => 1])); ?>:</strong> 
                        <code class="select-area-code"><?php echo($sessionKey1); ?></code>
                    </div>
                </div>
                <div class="row">                    
                    <div class="col-md-12">                        
                        <strong><?php echo(Yii::t('ProfileModule.base', 'Session Key {id}', ['{id}' => 2])); ?>:</strong> 
                        <code class="select-area-code"><?php echo($sessionKey2); ?></code>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>