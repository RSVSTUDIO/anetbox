<?php
    if($this->filterId == PeopleController::UserFilterBanned){
        $url = Yii::app()->createUrl('//profile/people/unban');
        $text = [
            'title' => Yii::t('ProfileModule.base', 'Do you really want to unban the user?'),
            'submit' => Yii::t('ProfileModule.base', 'Unban user')
        ];
    }else{
        $url = Yii::app()->createUrl('//profile/people/ban');
        $text = [
            'title' => Yii::t('ProfileModule.base', 'Do you really want to ban the user?'),
            'submit' => Yii::t('ProfileModule.base', 'Ban user')
        ];
    }
?>
<div class="modal fade" id="<?php echo($id); ?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo($id); ?>Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo(Yii::t('ProfileModule.base', 'Close')); ?>"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="<?php echo($id); ?>Label"><?php echo($text['title']); ?></h4>
            </div>
            <div class="modal-footer">
                <input type="hidden" class="user-ban-id" value="<?php echo(isset($userId) ? $userId : 0); ?>" data-url="<?php echo($url); ?>"<?php echo(isset($reload) ? ' data-reload="' . $reload . '"' : ''); ?>>
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo(Yii::t('ProfileModule.base', 'Close')); ?></button>
                <button type="button" class="btn btn-primary user-ban"><?php echo($text['submit']); ?></button>
            </div>
        </div>
    </div>
</div>