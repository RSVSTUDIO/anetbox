<div class="modal fade" id="<?php echo($id); ?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo($id); ?>Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo(Yii::t('ProfileModule.base', 'Close')); ?>"><span aria-hidden="true">&times;</span></button>
                <h4 class="text-left modal-title" id="<?php echo($id); ?>Label"></h4>
            </div>
            <div class="modal-body">
                <div class="text-justify full-text img-width"></div>
            </div>
            <div class="modal-footer">
                <div class="text-left url-text"></div>
            </div>
        </div>
    </div>
</div>