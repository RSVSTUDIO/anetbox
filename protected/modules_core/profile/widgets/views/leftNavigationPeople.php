<!-- start: list-group navi for large devices -->
<div class="panel panel-default">
    <div class="panel-heading">
        <?php 
            echo(CHtml::telField('peoples-search', '', [
                'class' => 'form-control', 
                'placeholder' => 'Поиск',
                'data-url' => Yii::app()->createUrl('//profile/people/search', (empty($this->filterId) ? [] : ['filter' => $this->filterId]))
            ])); 
        ?>
    </div>
    <?php $items = $this->getItems('peoples'); ?>
    <div class="list-group">
        <?php foreach ($items as $item) : ?>
            <a href="<?php echo $item['url']; ?>"
               class="list-group-item <?php if ($item['isActive']): ?>active <?php endif; ?><?php if (isset($item['class'])) {echo $item['class'];} ?>">
                <?php echo $item['icon']; ?>
                <span><?php echo $item['label']; ?></span> 
            </a>
        <?php endforeach; ?>
    </div>
</div>
<!-- end: list-group navi for large devices -->