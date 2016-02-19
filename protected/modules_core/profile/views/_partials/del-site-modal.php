<div class="modal fade" id="<?php echo($id); ?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo($id); ?>Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo(Yii::t('ProfileModule.base', 'Close')); ?>"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="<?php echo($id); ?>Label"><?php echo(Yii::t('ProfileModule.base', 'Do you really want to delete the site?')); ?></h4>
            </div>
            <div class="modal-footer">
                <input type="hidden" class="site-id" value="<?php echo(isset($siteId) ? $siteId : 0); ?>" data-url="<?php echo(Yii::app()->createUrl('//profile/areas/delSite')); ?>"<?php echo(isset($reload) ? ' data-reload="' . $reload . '"' : ''); ?>>
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo(Yii::t('ProfileModule.base', 'Close')); ?></button>
                <button type="button" class="btn btn-primary site-delete"><?php echo(Yii::t('ProfileModule.base', 'Delete site')); ?></button>
            </div>
        </div>
    </div>
</div>