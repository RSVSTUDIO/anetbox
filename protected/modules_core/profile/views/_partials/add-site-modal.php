<div class="modal fade" id="<?php echo($id); ?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo($id); ?>Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo(Yii::t('ProfileModule.base', 'Close')); ?>"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="<?php echo($id); ?>Label"><?php echo(Yii::t('ProfileModule.base', 'New site')); ?></h4>
            </div>
            <div class="modal-body">
                <?php echo CHtml::beginForm(array('/profile/areas/addSite'), 'post'); ?>
                    <div class="form-group">
                        <label for="recipient-title" class="control-label"><?php echo(Yii::t('ProfileModule.base', 'Title')); ?>*:</label>
                        <?php echo CHtml::textField("UserSite[title]", "", array("class"=>"form-control", "id"=>"recipient-title")); ?>
                    </div>
                    <div class="form-group">
                        <label for="recipient-url" class="control-label"><?php echo(Yii::t('ProfileModule.base', 'URL')); ?>*:</label>
                        <?php echo CHtml::textField("UserSite[url]", "", array("class"=>"form-control", "id"=>"recipient-url")); ?>
                    </div>
                    <div class="form-group">
                        <label for="message-description" class="control-label"><?php echo(Yii::t('ProfileModule.base', 'Description')); ?>:</label>
                        <?php echo CHtml::textField("UserSite[description]", "", array("class"=>"form-control", "id"=>"recipient-description")) ?>
                    </div>
                    <?php
                    echo CHtml::ajaxSubmitButton(Yii::t('ProfileModule.base', 'Add site'), array('/profile/areas/addSite'), array(
                        'type' => 'POST',
                        'dataType' => 'json',
                        'success' => 'function(data){
                            funcDefault.loader(false);
                            
                            if(data) {
                                if(data.status==true) {
                                    if(typeof(funcProfileProfile) !== "undefined") {
                                        funcProfileProfile.add.success(data.site);
                                    } else {
                                        $("#' . $id . '").modal("hide");
                                        window.location.href = data.url;
                                    }
                                } else {
                                    if (data.errors != null && typeof data.errors == "object") {
                                        var html = "<ul>";
                                        $.each(data.errors, function(key, value){
                                            html += "<li>"+value+"</li>";
                                        });
                                        html += "</li>";

                                        funcDefault.error("#' . $id . ' .modal-body", html);
                                    }
                                }
                            }
                        }'), array('class' => 'ajax-submit-button', 'style' => 'display:none;')
                    );
                    ?>
                <?php echo CHtml::endForm(); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo(Yii::t('ProfileModule.base', 'Close')); ?></button>
                <button type="button" class="btn btn-primary add-site"><?php echo(Yii::t('ProfileModule.base', 'Add site')); ?></button>
            </div>
        </div>
    </div>
</div>