<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/profile/cabinet.css'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/profile/cabinet.js', CClientScript::POS_END); ?>
<div class="container cabinet-section">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="cabinet-sidebar-container col-md-3">
                    <div class="panel panel-default cabinet-section-widgets">
                        <div class="panel-heading"><?php echo(Yii::t('ProfileModule.base', 'Panel of widgets')); ?></div>
                        <div class="panel-body">                            
                            <table class="table">
                                <tr>
                                    <td class="scroll-anchor" data-anchor=".cabinet-section-areas"><?php echo(Yii::t('ProfileModule.base', 'Advertisement')); ?></td>
                                </tr>
                                <tr>
                                    <td class="scroll-anchor" data-anchor=".cabinet-section-referrals"><?php echo(Yii::t('ProfileModule.base', 'Referrals')); ?></td>
                                </tr>
                                <tr>
                                    <td class="disable-element">Ссылки</td>
                                </tr>
                                <tr>
                                    <td class="disable-element">Покупка переходов</td>
                                </tr>
                                <tr>
                                    <td class="disable-element">Обменный траф</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-12 panel panel-body cabinet-section-areas">
                            <div class="panel-body">                            
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <td class="col-md-4 table-heading"><?php echo(Yii::t('ProfileModule.base', 'Advertisement')); ?></td>
                                            <td class="col-md-8"><?php echo($this->renderPartial('application.modules_core.profile.views._partials.period-date', [
                                                'urlArray' => ['/profile/cabinet/getSites'], 
                                                'renderSelector' => '.cabinet-section-areas .sites-date-table tbody'
                                            ])); ?></td>
                                        </tr>
                                    </thead>
                                </table>
                                <?php echo($this->renderPartial('application.modules_core.profile.views._partials.sites-data-table', ['site' => $site])); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 panel panel-body cabinet-section-referrals">
                            <div class="panel-body">                            
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <td class="col-md-4 table-heading"><?php echo(Yii::t('ProfileModule.base', 'Referrals')); ?></td>
                                            <td class="col-md-8"><?php echo($this->renderPartial('application.modules_core.profile.views._partials.period-date', [
                                                'urlArray' => ['/profile/cabinet/getReferrals'], 
                                                'renderSelector' => '.cabinet-section-referrals .referral-date-table tbody'
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