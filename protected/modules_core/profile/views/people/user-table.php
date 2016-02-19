<?php foreach($users as $item){ ?>
<?php 
    $user = $item->user; 
    if($filterId == PeopleController::UserFilterBanned){
        $titleAction = Yii::t('ProfileModule.base', 'Unban user');
    }else{
        $titleAction = Yii::t('ProfileModule.base', 'Ban user');
    }
?>
    <div class="row user-row" data-id="<?php echo($item->user_id); ?>">
        <div class="col-md-12 panel panel-body">
            <div class="panel-body">
                <table class="table table-none-border">
                    <thead>
                        <tr>
                            <td class="col-md-3 table-heading user-friend-header"><?php echo(($item->friendStatus === UserFriend::statusAccepted) ? Yii::t('ProfileModule.people', 'friend') : ''); ?></td>
                            <td class="col-md-8 table-heading"><?php echo($user->displayName); ?></td>
                            <td class="col-md-1"><?php echo(CHtml::link('<i class="fa fa-remove"></i>', null, ['class' => 'pull-right action-ban', 'title' => $titleAction])); ?></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <?php echo($this->renderPartial('application.modules_core.profile.views._partials.user-photo', ['user' => $user])); ?> 
                            </td>
                            <td colspan="2">
                                <table  class="table">
                                    <tbody>                                
                                        <tr>
                                            <td><?php echo($user->email); ?></td>
                                            <td><?php echo($this->renderPartial('application.modules_core.profile.views.people.user-table-phone', ['item' => $item])); ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo(Yii::t('ProfileModule.people', 'site')); ?>:</td>
                                            <td><?php echo($this->renderPartial('application.modules_core.profile.views.people.user-table-site', ['user' => $user])); ?></td>
                                        </tr>
                                        <tr class="disable-element">
                                            <td>Куплю:</td>
                                            <td>площадку с трафиком от 2 тыс. уников</td>
                                        </tr>
                                        <tr class="disable-element">
                                            <td>Продам:</td>
                                            <td>новостной трафик до 1 руб.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">
                                <?php echo(CHtml::link(Yii::t('ProfileModule.people', 'write'), ['/profile/people/message', 'id' => $item->user_id])); ?>
                            </td>
                            <td class="text-left user-friend-link">
                                <?php if($filterId != PeopleController::UserFilterBanned){ ?>
                                    <?php echo($this->renderPartial('application.modules_core.profile.views.people.user-friend-link', ['status' => $item->friendStatus, 'filterId' => $filterId, 'user' => $user->displayName])); ?>
                                <?php } ?>
                            </td>
                            <td class="text-right disable-element">в список</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php } ?>