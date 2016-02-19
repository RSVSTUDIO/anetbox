<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/profile/areas.css'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/profile/areas.js', CClientScript::POS_END); ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="areas-nav-container col-md-3">
                    <?php $this->widget('application.modules_core.profile.widgets.ProfileMenuAreaWidget', []); ?>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-12 panel panel-body areas-section-site">
                            <div class="panel-body"> 
                                <?php if (!empty($site)) { ?>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <td class="col-md-3 table-heading"><?php echo(Yii::t('ProfileModule.base', 'Title')); ?></td>
                                                <td class="col-md-9 table-heading"><?php echo($site->title); ?></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><?php echo(Yii::t('ProfileModule.base', 'URL')); ?></td>
                                                <td><?php echo($site->url); ?></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo(Yii::t('ProfileModule.base', 'Description')); ?></td>
                                                <td><?php echo($site->description); ?></td>
                                            </tr>
                                            <tr>
                                                <?php if (empty($site->code)) { ?>
                                                    <td class="text-danger"><?php echo(Yii::t('ProfileModule.base', 'Not confirmed', 1)); ?></td>
                                                <?php } else { ?>
                                                    <td class="text-success"><?php echo(Yii::t('ProfileModule.base', 'Confirmed', 1)); ?></td>
                                                <?php } ?>
                                                <td>
                                                    <div class="form-group">
                                                        <textarea class="form-control code-textarea" rows="8" readonly="readonly"><?php echo(CHtml::encode($site->getScript())); ?></textarea>
                                                    </div>
                                                    <?php if (empty($site->code)) { ?>
                                                    <a class="btn btn-primary code-comfirm pull-left" data-id="<?php echo($site->id); ?>" data-url="<?php echo(Yii::app()->createUrl('//profile/areas/confirm')); ?>"><?php echo(Yii::t('ProfileModule.base', 'confirm')); ?></a>
                                                    <?php } ?>
                                                    <i title="<?php echo(Yii::t('ProfileModule.base', 'Delete site')); ?>" class="fa fa-close right action-delete pull-right" data-toggle="modal" data-target="#delSiteModal"></i>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                <?php } else { ?>
                                    <h1 class="text-center"><?php echo(Yii::t('ProfileModule.base', 'Do not have a site to display')); ?></h1>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <?php if (!empty($site)) { ?>
                    <div class="row">
                        <div class="col-md-12 panel panel-body areas-section-networks">
                            <div class="panel-body">
                                <?php if (count($instrumentsDropDown) > 0) { ?>
                                    <?php echo CHtml::beginForm(array('/profile/areas/addNetwork'), 'post', ['class' => 'form-add-network']); ?>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <td class="col-md-3 table-heading"><?php echo(Yii::t('ProfileModule.base', 'Networks')); ?> </td>
                                                <td class="col-md-9"><small><?php echo(Yii::t('ProfileModule.base', 'Add a new network for this site')); ?></small></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <?php echo(CHtml::dropDownList('network[instrument_id]', '', $instrumentsDropDown, ['class' => 'form-control', 'id' => 'network_instrument_id', 'data-url' => Yii::app()->createUrl('//profile/areas/getNetworkData')])); ?>
                                                </td>
                                                <td class="form-inline">
                                                    <div class="form-group<?php echo ((isset($networkData['login']) && $networkData['login'] === false) ? ' hidden' : ''); ?>">
                                                        <label class="sr-only labelNetworkLogin" for="network-login"><?php echo(isset($networkData['login']) ? $networkData['login'] : Yii::t('ProfileModule.base', 'Login')); ?></label>
                                                        <?php echo CHtml::textField('network[login]', '', array('class' => 'form-control', 'id' => 'network-login', 'placeholder' => (isset($networkData['login']) ? $networkData['login'] : Yii::t('ProfileModule.base', 'Login')))); ?>
                                                    </div>
                                                    <div class="form-group<?php echo ((isset($networkData['password']) && $networkData['password'] === false) ? ' hidden' : ''); ?>">
                                                        <label class="sr-only labelNetworkPassword" for="network-password"><?php echo(isset($networkData['password']) ? $networkData['password'] : Yii::t('ProfileModule.base', 'Password')); ?></label>
                                                        <?php echo CHtml::textField('network[password]', '', array('class' => 'form-control', 'id' => 'network-password', 'placeholder' => (isset($networkData['password']) ? $networkData['password'] : Yii::t('ProfileModule.base', 'Password')))); ?>
                                                    </div>
                                                    <?php
                                                    echo CHtml::ajaxSubmitButton(Yii::t('ProfileModule.base', 'Add'), array('/profile/areas/addNetwork'), array(
                                                        'type' => 'POST',
                                                        'dataType' => 'json',
                                                        'success' => 'function(data){
                                                            funcDefault.loader(false);

                                                            if(data) {
                                                                if(data.status==true) {
                                                                    window.location.href = data.url;
                                                                } else {
                                                                    if (data.errors != null && typeof data.errors == "object") {
                                                                        $.each(data.errors, function(key, value){
                                                                            $(".areas-section-networks .form-add-network .form-control#network-" + key).addClass("error");
                                                                        });

                                                                        funcDefault.keyup.error();
                                                                    }
                                                                }
                                                            }
                                                        }'), array('class' => 'ajax-submit-button', 'style' => 'display:none;')
                                                    );
                                                    ?>
                                                    <?php echo(CHtml::hiddenField('network[site_id]', $site->id)); ?>
                                                    <button type="submit" class="btn btn-primary add-network"><?php echo(Yii::t('ProfileModule.base', 'Add')); ?></button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="helpNetworkBox"><?php echo(isset($networkData['url']) ? $networkData['url'] : ''); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <?php echo CHtml::endForm(); ?>
                                <?php } else { ?>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <td class="col-md-3 table-heading"><?php echo(Yii::t('ProfileModule.base', 'Networks')); ?> </td>
                                                <td class="col-md-9"></td>
                                            </tr>
                                        </thead>
                                    </table>
                                <?php } ?>
                                <?php if (!empty($siteInstruments)) { ?>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <td class="col-md-4 table-heading"><?php echo(Yii::t('ProfileModule.base', 'Title')); ?></td>
                                            <td class="col-md-7 table-heading"><?php echo(Yii::t('ProfileModule.base', 'Type')); ?></td>
                                            <td class="col-md-1 table-heading"></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($siteInstruments as $item) { ?>
                                        <tr>
                                            <td><?php echo($item['title']); ?></td>
                                            <td><?php echo(isset($item['type']) ? $item['type'] : ''); ?></td>
                                            <td class="text-center">
                                                <?php
                                                    echo(CHtml::link('<i class="fa fa-pencil"></i>', null, [
                                                        'class' => 'action-edit',
                                                        'data-id' => $item['id'],
                                                        'data-network' => $item['title'],
                                                        'data-url' => Yii::app()->createUrl('//profile/areas/getNetworkData'),
                                                        'title' => Yii::t('ProfileModule.base', 'Edit')
                                                    ]));
                                                ?>
                                                &nbsp;
                                                <?php 
                                                    echo(CHtml::link('<i class="fa fa-remove"></i>', null, [
                                                        'class' => 'action-delete', 
                                                        'data-id' => $item['id'], 
                                                        'title' => Yii::t('ProfileModule.base', 'Delete')
                                                    ])); 
                                                ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 panel panel-body areas-section-company">
                            <div class="panel-body"> 
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <td class="col-md-4 table-heading"><?php echo(Yii::t('ProfileModule.base', 'Campaign area')); ?></td>
                                            <td class="col-md-8"><?php echo($this->renderPartial('application.modules_core.profile.views._partials.period-date', [
                                                'urlArray' => ['/profile/areas/getCompanyCTR', 'id' => isset($site->id) ? $site->id  : 0], 
                                                'renderSelector' => '.areas-section-company .sites-date-table tbody', 
                                                'renderCallback' => 'funcProfileAreas.render.companyAreas'
                                            ])); ?></td>
                                        </tr>
                                    </thead>
                                </table>
                                <?php echo($this->renderPartial('application.modules_core.profile.views.areas.areas-company-table', ['networkCTR' => $networkCTR])); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 panel panel-body network-section-company disable-element">
                            <div class="panel-body"> 
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <td class="col-md-4 table-heading">Счетчики на площадке</td>
                                            <td class="col-md-8"><?php echo($this->renderPartial('application.modules_core.profile.views._partials.period-date', [
                                                'urlArray' => ['/profile/areas/show', 'id' => isset($site->id) ? $site->id  : 0]
                                            ])); ?></td>
                                        </tr>
                                    </thead>
                                </table>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <td class="col-md-3 table-heading">Название</td>
                                            <td class="table-heading">Посетители</td>
                                            <td class="table-heading">Страницы</td>
                                            <td class="table-heading">Коды</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>LI</td>
                                            <td></td>
                                            <td></td>
                                            <td>получить</td>
                                        </tr>
                                        <tr>
                                            <td>Rambler</td>
                                            <td></td>
                                            <td></td>
                                            <td>получить</td>
                                        </tr>
                                        <tr>
                                            <td>Mail.ru</td>
                                            <td></td>
                                            <td></td>
                                            <td>получить</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->renderPartial('application.modules_core.profile.views._partials.del-site-modal', ['id' => 'delSiteModal', 'siteId' => (isset($site->id) ? $site->id : 0), 'reload' => Yii::app()->createUrl('//profile/areas')]); ?>
<?php $this->renderPartial('application.modules_core.profile.views._partials.del-network-modal', ['id' => 'delNetworkModal', 'siteId' => (isset($site->id) ? $site->id : 0)]); ?>
<?php $this->renderPartial('application.modules_core.profile.views._partials.save-network-modal', ['id' => 'saveNetworkModal', 'siteId' => (isset($site->id) ? $site->id : 0), 'reload' => Yii::app()->createUrl('//profile/areas')]); ?>
<?php $this->renderPartial('application.modules_core.profile.views._partials.add-site-modal', ['id' => 'addSiteModal', 'reload' => Yii::app()->createUrl('//profile/areas')]); ?>