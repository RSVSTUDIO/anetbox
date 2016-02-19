<?php if($news) { ?>
    <?php foreach($news as $item){ ?>
        <div class="row news-row" data-id="<?php echo($item->id); ?>">
            <div class="col-md-12 panel panel-body">
                <div class="panel-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <td class="col-md-10 table-heading"><?php echo($item->uinstrument->title); ?>: <?php echo(CHtml::link($item->title, ['//profile/news/show', 'id' => $item->id], ['class' => 'action-read-more'])); ?></td>
                                <td class="col-md-2">
                                    <div class="pull-right">                                        
                                        <?php if (Yii::app()->user->isNewsAdmin()) { ?>
                                            <?php
                                                echo(CHtml::link('<i class="fa fa-pencil"></i>', null, [
                                                    'class' => 'action-edit',
                                                    'data-url' => Yii::app()->createUrl('//profile/news/edit', ['id' => $item->id]),
                                                    'data-text-label' => Yii::t('ProfileModule.base', 'Editing news'),
                                                    'data-text-btn' => Yii::t('ProfileModule.base', 'Edit news'),
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
                                        <?php } ?>
                                    </div>
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="2" class="short-text img-width">
                                    <?php echo($item->short_text); ?>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>                            
                            <tr>
                                <td class="text-left">
                                    <?php if (!empty($item->url)) { ?>
                                        <?php echo(Yii::t('ProfileModule.base', 'URL')); ?>: <?php echo(CHtml::link(StringHelper::truncate($item->url, 50), $item->url, ['target' => '_blank'])); ?>
                                    <?php } ?>
                                </td>
                                <td class="text-right"><?php echo($item->created_at); ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    <?php } ?>
<?php } else { ?>
    <h2 class="text-center"><?php echo(Yii::t('ProfileModule.base', 'Do not have a news to display')); ?></h2>
<?php } ?>