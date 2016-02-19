<?php

if ($filterId == PeopleController::UserFilterFriends) {
    echo(CHtml::link(Yii::t('ProfileModule.people', 'remove friend'), null, [
        'class' => 'action-friend',
        'data-type' => UserFriend::actionRemove,
        'data-title' => Yii::t('ProfileModule.people', 'Do you really want to remove friend?'),
        'data-btn' => Yii::t('ProfileModule.people', 'Remove friend'),
    ]));
} else {
    if ($status === UserFriend::statusReceivedRequest) {
        echo(Yii::t('ProfileModule.people', 'you have received a request to friends from "{user}", {link1} or {link2}?', [
            '{user}' => $user,
            '{link1}' => CHtml::link(Yii::t('ProfileModule.people', 'confirm'), null, [
                'class' => 'action-friend',
                'data-type' => UserFriend::actionConfirm,
                'data-title' => Yii::t('ProfileModule.people', 'Do you really want to confirm request to friends?'),
                'data-btn' => Yii::t('ProfileModule.people', 'Confirm'),
            ]),
            '{link2}' => CHtml::link(Yii::t('ProfileModule.people', 'reject'), null, [
                'class' => 'action-friend',
                'data-type' => UserFriend::actionReject,
                'data-title' => Yii::t('ProfileModule.people', 'Do you really want to reject request to friends?'),
                'data-btn' => Yii::t('ProfileModule.people', 'Reject'),
            ])
        ]));
    } else if ($status === UserFriend::statusSentRequest) {
        echo(Yii::t('ProfileModule.people', 'you have sent a request to friends, {link}?', [
            '{link}' => CHtml::link(Yii::t('ProfileModule.people', 'revoke'), null, [
                'class' => 'action-friend',
                'data-type' => UserFriend::actionRevoke,
                'data-title' => Yii::t('ProfileModule.people', 'Do you really want to revoke request to friends?'),
                'data-btn' => Yii::t('ProfileModule.people', 'Revoke'),
            ])
        ]));
    } else if ($status === null) {
        echo(CHtml::link(Yii::t('ProfileModule.people', 'acquaintance'), null, [
            'class' => 'action-friend',
            'data-type' => UserFriend::actionSend,
            'data-title' => Yii::t('ProfileModule.people', 'Do you really want to acquaintance?'),
            'data-btn' => Yii::t('ProfileModule.people', 'Acquaintance'),
        ]));
    }
}