<?php
    if(isset($this->filterId) && $this->filterId == PeopleController::UserFilterFriends){
        $type = UserFriend::actionRemove;
        $text = [
            'title' => Yii::t('ProfileModule.people', 'Do you really want to remove friend?'),
            'submit' => Yii::t('ProfileModule.people', 'Remove friend')
        ];
    }else{
        $type = UserFriend::actionSend;
        $text = [
            'title' => Yii::t('ProfileModule.people', 'Do you really want to acquaintance?'),
            'submit' => Yii::t('ProfileModule.people', 'Acquaintance')
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
                <input type="hidden" class="user-friend-id" value="<?php echo(isset($userId) ? $userId : 0); ?>" data-type="<?php echo($type); ?>" data-url="<?php echo(Yii::app()->createUrl('//profile/people/friend', (empty($this->filterId) ? [] : ['filter' => $this->filterId]))); ?>"<?php echo(isset($reload) ? ' data-reload="' . $reload . '"' : ''); ?>>
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo(Yii::t('ProfileModule.base', 'Close')); ?></button>
                <button type="button" class="btn btn-primary user-friend"><?php echo($text['submit']); ?></button>
            </div>
        </div>
    </div>
</div>