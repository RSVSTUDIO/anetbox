<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/profile/areas.js', CClientScript::POS_END); ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="areas-nav-container col-md-3">
                    <?php $this->widget('application.modules_core.profile.widgets.ProfileMenuAreaWidget', []); ?>
                </div>
                <div class="col-md-9">
                    <div class="modal-content areas-section-site">
                        <div class="modal-header">
                            <h4><?php echo(Yii::t('ProfileModule.base', 'New site')); ?></h4>
                        </div>
                        <div class="modal-body">
                            <?php echo CHtml::beginForm(array('/profile/areas/addSite'), 'post'); ?>
                                <div class="form-group">
                                    <label for="site-title" class="control-label"><?php echo(Yii::t('ProfileModule.base', 'Title')); ?>*:</label>
                                    <?php echo CHtml::textField("UserSite[title]", "", array("class"=>"form-control", "id"=>"site-title")); ?>
                                </div>
                                <div class="form-group">
                                    <label for="site-description" class="control-label"><?php echo(Yii::t('ProfileModule.base', 'Description')); ?>:</label>
                                    <?php echo CHtml::textField("UserSite[description]", "", array("class"=>"form-control", "id"=>"site-description")) ?>
                                </div>
                                <div class="form-group">
                                    <label for="site-url" class="control-label"><?php echo(Yii::t('ProfileModule.base', 'URL')); ?>*:</label>
                                    <?php echo CHtml::textField("UserSite[url]", "", array("class"=>"form-control", "id"=>"site-url")); ?>
                                </div>
                                <?php
                                echo CHtml::ajaxSubmitButton(Yii::t('ProfileModule.base', 'Add site'), array('/profile/areas/addSite'), array(
                                    'type' => 'POST',
                                    'dataType' => 'json',
                                    'success' => 'function(data){
                                        funcDefault.loader(false);

                                        if(data) {
                                            if(data.status==true) {
                                                window.location.href = data.url;
                                            } else {
                                                if (data.errors != null && typeof data.errors == "object") {
                                                    var html = "<ul>";
                                                    $.each(data.errors, function(key, value){
                                                        html += "<li>"+value+"</li>";
                                                    });
                                                    html += "</li>";

                                                    funcDefault.error(".areas-section-site .modal-body", html);
                                                }
                                            }
                                        }
                                    }'), array('class' => 'ajax-submit-button', 'style' => 'display:none;')
                                );
                                ?>
                            <?php echo CHtml::endForm(); ?>
                        </div>
                        <div class="modal-footer">
                            <a class="btn btn-default pull-left" href="<?php echo(Yii::app()->createUrl('//profile/areas', [])); ?>"><?php echo(Yii::t('ProfileModule.base', 'Close')); ?></a>
                            <button type="button" class="btn btn-primary pull-left add-site"><?php echo(Yii::t('ProfileModule.base', 'Add site')); ?></button>
                        </div>
                    </div>                   
                </div>
            </div>
        </div>
    </div>
</div>