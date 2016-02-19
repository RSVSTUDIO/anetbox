<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/profile/networks.js', CClientScript::POS_END); ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="networks-nav-container col-md-3">
                    <?php $this->widget('application.modules_core.profile.widgets.ProfileMenuNetworksWidget', []); ?>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-12 panel panel-body network-section-info">
                            <div class="panel-body">
                                <?php if(!empty($network)){ ?>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <td class="col-md-3 table-heading"><?php echo(Yii::t('ProfileModule.base', 'Title')); ?></td>
                                            <td class="col-md-6 table-heading"><?php echo($network->title); ?></td>
                                            <?php if (in_array($network->id, $myNetworksIdis)) { ?>
                                                <td class="col-md-3 text-success"><?php echo(Yii::t('ProfileModule.base', 'Confirmed', 2)); ?></td>
                                            <?php } else { ?>
                                                <td class="col-md-3 text-danger"><?php echo(Yii::t('ProfileModule.base', 'Not confirmed', 2)); ?></td>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?php echo(Yii::t('ProfileModule.base', 'URL')); ?></td>
                                            <td colspan="3"><?php echo((empty($network->referral) ? $network->url : CHtml::link($network->url, $network->referral, ['target' => '_blank']))); ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo(Yii::t('ProfileModule.base', 'Categories network')); ?></td>
                                            <td colspan="3"><?php echo($network->getType()); ?></td>
                                        </tr>
                                        <?php if(!empty($uploadForm)){ ?>
                                        <tr>
                                            <td colspan="3"><?php echo($uploadForm); ?></td>
                                        </tr>
                                        <?php } ?>
                                        <?php if(!empty($authorizeUrl)){ ?>
                                        <tr>
                                            <td colspan="3"><?php echo($authorizeUrl); ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <?php } else { ?>
                                    <h1 class="text-center"><?php echo(Yii::t('ProfileModule.base', 'No added network to display')); ?></h1>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 panel panel-body network-section-company">
                            <div class="panel-body"> 
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <td class="col-md-4 table-heading"><?php echo(Yii::t('ProfileModule.base', 'Network sites')); ?></td>
                                            <td class="col-md-8"><?php echo($this->renderPartial('application.modules_core.profile.views._partials.period-date', [
                                                'urlArray' => ['/profile/networks/getCompanySites', 'id' => isset($network->id) ? $network->id : 0], 
                                                'renderSelector' => '.network-section-company .sites-date-table tbody'
                                            ])); ?></td>
                                        </tr>
                                    </thead>
                                </table>
                                <?php echo($this->renderPartial('application.modules_core.profile.views._partials.sites-data-table', ['site' => $site])); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 panel panel-body network-section-referrals">
                            <div class="panel-body"> 
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <td class="col-md-4 table-heading"><?php echo(Yii::t('ProfileModule.base', 'Referrals network')); ?></td>
                                            <td class="col-md-8"><?php echo($this->renderPartial('application.modules_core.profile.views._partials.period-date', [
                                                'urlArray' => ['/profile/networks/getNetworkReferrals', 'id' => isset($network->id) ? $network->id : 0], 
                                                'renderSelector' => '.network-section-referrals .referral-date-table tbody'
                                            ])); ?></td>
                                        </tr>
                                    </thead>
                                </table>
                                <?php echo($this->renderPartial('application.modules_core.profile.views._partials.referral-data-table', ['referrals' => $referrals])); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>