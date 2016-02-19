<div class="modal fade" id="<?php echo($id); ?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo($id); ?>Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo(Yii::t('ProfileModule.base', 'Close')); ?>"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="<?php echo($id); ?>Label"><?php echo(Yii::t('ProfileModule.base', 'New news')); ?></h4>
            </div>
            <div class="modal-body">
                <?php echo CHtml::beginForm(array('/profile/news/add'), 'post'); ?>
                    <div class="form-group">
                        <label for="news-instrument-id" class="control-label"><?php echo(Yii::t('ProfileModule.base', 'Network')); ?>*:</label>
                        <?php echo CHtml::dropDownList("news[instrument_id]", "", $networks, array("class"=>"form-control", "id"=>"news-instrument-id")); ?>
                    </div>
                    <div class="form-group">
                        <label for="news-title" class="control-label"><?php echo(Yii::t('ProfileModule.base', 'Title')); ?>*:</label>
                        <?php echo CHtml::textField("news[title]", "", array("class"=>"form-control", "id"=>"news-title", "maxlength" => 100)); ?>
                    </div>
                    <div class="form-group">
                        <label for="news-short-text" class="control-label"><?php echo(Yii::t('ProfileModule.base', 'Short text')); ?>*:</label>
                        <?php echo CHtml::textArea("news[short_text]", "", array("class"=>"form-control", "id"=>"news-short-text", "rows" => 2, "maxlength" => 1000)); ?>
                    </div>
                    <div class="form-group">
                        <label for="news-full-text" class="control-label"><?php echo(Yii::t('ProfileModule.base', 'Full text')); ?>:</label>
                        <?php echo CHtml::textArea("news[full_text]", "", array("class"=>"form-control", "id"=>"news-full-text", "rows" => 6, "maxlength" => 20000)) ?>
                    </div>
                    <div class="form-group">
                        <label for="news-url" class="control-label"><?php echo(Yii::t('ProfileModule.base', 'URL')); ?>:</label>
                        <?php echo CHtml::textField("news[url]", "", array("class"=>"form-control", "id"=>"news-url", "maxlength" => 90)); ?>
                    </div>
                    <?php
                    echo CHtml::ajaxSubmitButton(Yii::t('ProfileModule.base', 'Add news'), array('/profile/news/add'), array(
                        'type' => 'POST',
                        'dataType' => 'json',
                        'success' => 'function(data){
                            funcDefault.loader(false);
                            
                            if(data) {
                                if(data.status==true) {
                                    $("#' . $id . '").modal("hide");
                                    window.location.href = data.url;
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
                <?php echo(CHtml::hiddenField('id', 0, ['id' => 'news-id'])); ?>
                <?php echo CHtml::endForm(); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo(Yii::t('ProfileModule.base', 'Close')); ?></button>
                <button type="button" class="btn btn-primary add-news"><?php echo(Yii::t('ProfileModule.base', 'Add news')); ?></button>
            </div>
        </div>
    </div>
</div>