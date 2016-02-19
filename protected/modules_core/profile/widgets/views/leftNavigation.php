<?php
/**
 * Left Navigation by MenuWidget.
 */

$groups = $this->getItemGroups();
?>

<!-- start: list-group navi for large devices -->
<div class="panel panel-default">
    <ul class="tabs-networks navbar-default nav nav-tabs nav-justified">
    <?php foreach ($groups as $group) { ?>
        <?php if ($group['label'] != '') { ?>
            <li<?php echo($group['id'] == 'all_networks' ? ' class="active"' : ''); ?>><a class="tab-index" data-id="<?php echo $group['id']; ?>"><?php echo $group['label']; ?></a></li>
        <?php } ?>
    <?php } ?>
    </ul>
    
    <?php foreach ($groups as $group) { ?>
        <?php if ($group['label'] != '') { ?>
            <?php $items = $this->getItems($group['id']); ?>
            <div class="list-group <?php echo $group['id']; ?><?php echo($group['id'] == 'all_networks' ? ' show' : ''); ?>">
                <?php if (count($items) > 0) { ?>
                    <?php foreach ($items as $item) { ?>
                        <?php if (isset($item['type']) && $item['type'] === 'button') { ?>
                        <a class="list-group-item btn" <?php echo($item['options']); ?>>
                            <?php echo $item['icon']; ?>
                            <span><?php echo $item['label']; ?></span>
                        </a>
                        <?php } else { ?>
                        <a href="<?php echo $item['url']; ?>"
                           class="list-group-item <?php if ($item['isActive']): ?>active <?php endif; ?><?php if (isset($item['id'])) {echo $item['id'];} ?>">
                            <?php echo $item['icon']; ?>
                            <span><?php echo $item['label']; ?></span> 
                            <?php echo(isset($item['status']) ? $item['status'] : ''); ?>
                        </a>
                        <?php } ?>
                    <?php } ?>
                <?php } else { ?>
                    <h1 class="list-group-item text-center"><?php echo(Yii::t('ProfileModule.base', 'No networks')); ?></h1>
                <?php } ?>
            </div>
        <?php } ?>
    <?php } ?>
</div>
<!-- end: list-group navi for large devices -->

