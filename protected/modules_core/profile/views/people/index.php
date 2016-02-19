<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/profile/people.css'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/profile/people.js', CClientScript::POS_END); ?>
<?php $filterId = $this->filterId; ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="people-nav-container col-md-3">
                    <?php $this->widget('application.modules_core.profile.widgets.ProfileMenuPeopleWidget', []); ?>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="people-section-table col-md-12">
                            <?php echo($this->renderPartial('application.modules_core.profile.views.people.user-table', ['users' => $users, 'filterId' => $filterId])); ?>   
                        </div>
                        <div class="people-section-loader col-md-12 hidden"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->renderPartial('application.modules_core.profile.views._partials.ban-user-modal', ['id' => 'banUserModal']); ?>
<?php $this->renderPartial('application.modules_core.profile.views._partials.friend-user-modal', ['id' => 'friendUserModal']); ?>