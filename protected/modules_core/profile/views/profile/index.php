<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/profile/profile.css'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/profile/profile.js', CClientScript::POS_END); ?>
<div class="container profile-section">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="profile-sidebar-container col-md-3">
                    <div class="panel panel-default profile-section-contact">
                        <div class="panel-heading"><?php echo(Yii::t('ProfileModule.people', 'My acquaintances')); ?></div>
                        <div class="panel-body">                            
                            <?php echo($this->renderPartial('application.modules_core.profile.views.profile.fiend-request-table', ['friendRequest' => $friendRequest])); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-12 panel panel-body  profile-section-info">
                            <div class="row">
                                <div class="col-md-3">
                                    <?php echo($this->renderPartial('application.modules_core.profile.views._partials.user-photo', ['user' => $user])); ?>
                                </div>
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-12 edit-col">
                                            <?php echo CHtml::link('',array('//user/account/edit'),array("class"=>"glyphicon glyphicon-pencil")); ?>
                                            <?php echo CHtml::encode($user->displayName); ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 edit-col">
                                            <?php echo CHtml::link('',array('//user/account/changeEmail'),array("class"=>"glyphicon glyphicon-pencil")); ?>
                                            <?php echo CHtml::encode($user->email); ?>
                                        </div>
                                    </div>
                                    <?php if ($user->getProfile()->phone_private || $user->getProfile()->phone_work || $user->getProfile()->mobile) { ?>
                                        <?php if ($user->getProfile()->phone_private) { ?>
                                        <div class="row">
                                            <div class="col-md-12 edit-col">
                                                <?php echo CHtml::link('',array('//user/account/edit'),array("class"=>"glyphicon glyphicon-pencil")); ?>
                                                <?php echo(Yii::t('UserModule.models_Profile', 'Phone Private') . ': ' . CHtml::encode($user->getProfile()->phone_private)); ?>
                                            </div>
                                        </div>
                                        <?php } ?>
                                        <?php if ($user->getProfile()->phone_work) { ?>
                                        <div class="row">
                                            <div class="col-md-12 edit-col">
                                                <?php echo CHtml::link('',array('//user/account/edit'),array("class"=>"glyphicon glyphicon-pencil")); ?>
                                                <?php echo(Yii::t('UserModule.models_Profile', 'Phone Work') . ': ' . CHtml::encode($user->getProfile()->phone_work)); ?>
                                            </div>
                                        </div>
                                        <?php } ?>
                                        <?php if ($user->getProfile()->mobile) { ?>
                                        <div class="row">
                                            <div class="col-md-12 edit-col">
                                                <?php echo CHtml::link('',array('//user/account/edit'),array("class"=>"glyphicon glyphicon-pencil")); ?>
                                                <?php echo(Yii::t('UserModule.models_Profile', 'Mobile') . ': ' . CHtml::encode($user->getProfile()->mobile)); ?>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if ($user->getProfile()->company || $user->getProfile()->company_site) { ?>
                                        <?php if ($user->getProfile()->company) { ?>
                                        <div class="row">
                                            <div class="col-md-12 edit-col">
                                                <?php echo CHtml::link('',array('//user/account/edit'),array("class"=>"glyphicon glyphicon-pencil")); ?>
                                                <?php echo(Yii::t('UserModule.models_Profile', 'Company') . ': ' . CHtml::encode($user->getProfile()->company)); ?>
                                            </div>
                                        </div>
                                        <?php } ?>
                                        <?php if ($user->getProfile()->company) { ?>
                                        <div class="row">
                                            <div class="col-md-12 edit-col">
                                                <?php echo CHtml::link('',array('//user/account/edit'),array("class"=>"glyphicon glyphicon-pencil")); ?>
                                                <?php echo(Yii::t('UserModule.models_Profile', 'Company Site') . ': <a target="_blank" href="' . $user->getProfile()->company_site . '">' . CHtml::encode($user->getProfile()->company_site) . '</a>'); ?>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if ($user->getProfile()->about) { ?>
                                    <div class="row">
                                        <div class="col-md-12 edit-col">
                                            <?php echo CHtml::link('',array('//user/account/edit'),array("class"=>"glyphicon glyphicon-pencil")); ?>
                                            <?php echo(CHtml::encode($user->getProfile()->about)); ?>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 panel panel-body  profile-section-account">
                            <div class="panel-heading"><?php echo(Yii::t('ProfileModule.base', 'My account')); ?></div>
                            <div class="panel-body">                            
                                <table class="table">
                                    <tr>
                                        <td class="col-md-2"><?php echo(Yii::t('ProfileModule.base', 'Login')); ?>:</td>
                                        <td class="col-md-10">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo CHtml::encode($user->username); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-2"><?php echo(Yii::t('ProfileModule.base', 'Password')); ?>:</td>
                                        <td class="col-md-10 edit-col"><?php echo CHtml::link('',array('//user/account/changePassword'),array("class"=>"glyphicon glyphicon-pencil")); ?> ******** </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 panel panel-body profile-section-areas">
                            <div class="panel-body">                            
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <td class="col-md-2 table-heading"><?php echo(Yii::t('ProfileModule.base', 'My sites')); ?></td>
                                            <td class="col-md-2 table-heading"><?php echo(Yii::t('ProfileModule.base', 'URL')); ?></td>
                                            <td class="col-md-8 table-heading"><?php echo(Yii::t('ProfileModule.base', 'Description')); ?></td>
                                            <td></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($site as $item) { ?>
                                        <tr class="area-row <?php echo(($item->active === 'y') ? 'success' : 'warning'); ?>" data-id="<?php echo($item->id); ?>">
                                            <td class="col-md-2"><?php echo(CHtml::encode($item->title)); ?></td>
                                            <td class="col-md-2"><?php echo(CHtml::encode($item->url)); ?></td>
                                            <td class="col-md-8"><?php echo(CHtml::encode($item->description)); ?></td>
                                            <td><i class="fa fa-close action-delete"></i></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addSiteModal">
                                    <i class="fa fa-plus"></i>
                                    <?php echo(Yii::t('ProfileModule.base', 'Add site')); ?>                      
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->renderPartial('application.modules_core.profile.views._partials.add-site-modal', ['id' => 'addSiteModal']); ?>
<?php $this->renderPartial('application.modules_core.profile.views._partials.del-site-modal', ['id' => 'delSiteModal']); ?>
<?php $this->renderPartial('application.modules_core.profile.views._partials.friend-user-modal', ['id' => 'friendUserModal']); ?>