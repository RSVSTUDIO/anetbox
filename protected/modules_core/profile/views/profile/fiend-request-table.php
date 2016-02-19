<?php if (!empty($friendRequest)) { ?>
<table class="table incoming-requests" data-empty-text="<?php echo(Yii::t('ProfileModule.people', 'No incoming requests')); ?>">
    <?php foreach($friendRequest as $item){ ?>
    <tr class="user-row" data-id="<?php echo($item->user->id); ?>">
        <td class="col-md-10 text-left"><?php echo($item->user->displayName); ?></td>
        <td class="col-md-2 text-right"><?php
            echo(CHtml::link('', null, [
                'class' => 'fa fa-check text-success action-friend',
                'title' => Yii::t('ProfileModule.people', 'confirm'),
                'data-type' => UserFriend::actionConfirm,
                'data-title' => Yii::t('ProfileModule.people', 'Do you really want to confirm request to friends?'),
                'data-btn' => Yii::t('ProfileModule.people', 'Confirm'),
            ]));
            echo(CHtml::link('', null, [
                'class' => 'fa fa-remove text-danger action-friend margin-left',
                'title' => Yii::t('ProfileModule.people', 'reject'),
                'data-type' => UserFriend::actionReject,
                'data-title' => Yii::t('ProfileModule.people', 'Do you really want to reject request to friends?'),
                'data-btn' => Yii::t('ProfileModule.people', 'Reject'),
            ]));
        ?></td>
    </tr>
    <?php } ?>
</table>
<?php } else { ?>
<p class="text-center"><?php echo(Yii::t('ProfileModule.people', 'No incoming requests')); ?></p>
<?php } ?>