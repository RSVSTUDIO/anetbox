<div class="modal fade" id="<?php echo($id); ?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo($id); ?>Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo(Yii::t('ProfileModule.base', 'Close')); ?>"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="<?php echo($id); ?>Label"><?php echo(Yii::t('ProfileModule.base', 'Edit network', 1.5)); ?></h4>
            </div>
            <div class="modal-body">
                <?php echo CHtml::beginForm(array('/profile/areas/addNetwork'), 'post', ['class' => 'form-save-network']); ?>
                    <div class="form-group">
                        <label for="save-network-label" class="control-label"><?php echo(Yii::t('ProfileModule.base', 'Network')); ?>:</label>
                        <?php echo CHtml::textField(null, (isset($instrumentLabel) ? $instrumentLabel : 'none'), array('class' => 'form-control', 'id' => 'save-network-label', 'readonly' => true)); ?>
                    </div>
                    <div class="form-group">
                        <label for="save-network-login" class="control-label"><?php echo(Yii::t('ProfileModule.base', 'Login')); ?>:</label>
                        <?php echo CHtml::textField('network[login]', '', array('class'=>'form-control', 'id'=>'save-network-login')); ?>
                    </div>
                    <div class="form-group">
                        <label for="save-network-password" class="control-label"><?php echo(Yii::t('ProfileModule.base', 'Password')); ?>:</label>
                        <?php echo CHtml::textField('network[password]', '', array('class'=>'form-control', 'id'=>'save-network-password')); ?>
                    </div>
                    <div class="form-group helpNetworkBox"></div>
                    <?php
                    echo CHtml::ajaxSubmitButton(Yii::t('ProfileModule.base', 'Save network'), array('/profile/areas/addNetwork'), array(
                        'type' => 'POST',
                        'dataType' => 'json',
                        'success' => 'function(data){
                            funcDefault.loader(false);
                            
                            if(data) {
                                if(data.status==true) {
                                    $("#saveNetworkModal").modal("hide");
                                } else {
                                    if (data.errors != null && typeof data.errors == "object") {
                                        var html = "<ul>";
                                        $.each(data.errors, function(key, value){
                                            html += "<li>"+value+"</li>";
                                        });
                                        html += "</li>";

                                        funcDefault.error("#saveNetworkModal .modal-body", html);
                                    }
                                }
                            }
                        }'), array('class' => 'ajax-submit-button', 'style' => 'display:none;')
                    );
                    ?>
                    <?php echo(CHtml::hiddenField('network[instrument_id]', (isset($instrumentId) ? $instrumentId : 0), ['class' => 'save-network-id'])); ?>
                    <?php echo(CHtml::hiddenField('network[site_id]', (isset($siteId) ? $siteId : 0))); ?>
                <?php echo CHtml::endForm(); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo(Yii::t('ProfileModule.base', 'Close')); ?></button>
                <button type="button" class="btn btn-primary save-network"><?php echo(Yii::t('ProfileModule.base', 'Save network')); ?></button>
            </div>
        </div>
    </div>
</div>