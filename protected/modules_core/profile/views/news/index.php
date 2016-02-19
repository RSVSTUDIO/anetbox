<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/profile/news.css'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/profile/news.js', CClientScript::POS_END); ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="networks-nav-container col-md-3">
                    <?php $this->widget('application.modules_core.profile.widgets.ProfileMenuNewsNetworksWidget', []); ?>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="news-section-table col-md-12" data-url="<?php echo(Yii::app()->createUrl('//profile/news/search', ['id' => $networkId])); ?>">
                            <?php echo($this->renderPartial('application.modules_core.profile.views.news.news-table', ['news' => $news])); ?>   
                        </div>
                        <div class="news-section-loader col-md-12 hidden"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->renderPartial('application.modules_core.profile.views._partials.show-news-modal', ['id' => 'showNewsModal']); ?>
<?php if (Yii::app()->user->isNewsAdmin()) { ?>
    <?php $this->renderPartial('application.modules_core.profile.views._partials.add-news-modal', ['id' => 'addNewsModal', 'networks' => $networks]); ?>
    <?php $this->renderPartial('application.modules_core.profile.views._partials.del-news-modal', ['id' => 'delNewsModal']); ?>
<?php } ?>