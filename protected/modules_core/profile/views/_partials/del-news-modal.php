<div class="modal fade" id="<?php echo($id); ?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo($id); ?>Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo(Yii::t('ProfileModule.base', 'Close')); ?>"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="<?php echo($id); ?>Label"><?php echo(Yii::t('ProfileModule.base', 'Do you really want to delete the news?')); ?></h4>
            </div>
            <div class="modal-footer">
                <input type="hidden" class="news-id" value="<?php echo(isset($newsId) ? $newsId : 0); ?>" data-url="<?php echo(Yii::app()->createUrl('//profile/news/delete')); ?>">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo(Yii::t('ProfileModule.base', 'Close')); ?></button>
                <button type="button" class="btn btn-primary news-delete"><?php echo(Yii::t('ProfileModule.base', 'Delete news')); ?></button>
            </div>
        </div>
    </div>
</div>