<?php
/**
 * TopNavigation by TopMenuWidget.
 *
 * @package humhub.widgets
 * @since 0.5 */
?>
<?php foreach ($this->getItems() as $item) : ?>
    <li class="visible-md visible-lg<?php echo ($item['isActive'] ? ' active' : ''); ?><?php echo ($item['isEmpty'] ? ' empty' : ''); ?> <?php
    if (isset($item['id'])) {
        echo $item['id'];
    }
    ?>">
        <a href="<?php echo $item['url']; ?>"  target="<?php echo $item['target']; ?>" >
            <?php echo $item['icon']; ?><br/>
            <?php echo $item['label']; ?>
        </a>
    </li>
<?php endforeach; ?>



<li class="dropdown visible-xs visible-sm">
    <a href="#" id="top-dropdown-menu" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-align-justify"></i><br>
        <?php echo Yii::t('base', 'Menu'); ?>
        <b class="caret"></b></a>
    <ul class="dropdown-menu pull-right">

        <?php foreach ($this->getItems() as $item) : ?>
            <li class="<?php echo ($item['isActive'] ? ' active' : ''); ?><?php echo ($item['isEmpty'] ? ' empty' : ''); ?>">
                <a href="<?php echo $item['url']; ?>"  target="<?php echo $item['target']; ?>" >
                    <?php //echo $item['icon'];   ?>
                    <?php echo $item['label']; ?>
                </a>
            </li>
        <?php endforeach; ?>

    </ul>
</li>
