<?php
    $assetPrefix = Yii::app()->assetManager->publish(dirname(__FILE__) . '/../js', true, 0, defined('YII_DEBUG'));
    Yii::app()->clientScript->registerScriptFile($assetPrefix . '/driversNetworkFileUpload.js', CClientScript::POS_END);
?>
<?php
    echo(CHtml::beginForm($urlArray, 'post', [
        'class' => 'form-horizontal form-upload-driver-file'
    ]));
?>
    <div class="form-group">
        <label class="col-sm-4 control-label" for="upload-driver-file"><?php echo($title); ?></label>
        <div class="col-sm-8">            
            <?php echo(CHtml::fileField('upload-driver-file')); ?>
        </div>
    </div>
<?php echo(CHtml::endForm()); ?>