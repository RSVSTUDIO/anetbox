<?php if (!empty($site)) { ?>
<table class="table sites-date-table">
    <thead>
        <tr>
            <td class="col-md-2 text-left table-heading"><?php echo(Yii::t('ProfileModule.base', 'Site')); ?></td>
            <td class="text-center table-heading"><?php echo(Yii::t('ProfileModule.base', 'Pages')); ?></td>
            <td class="text-center table-heading"><?php echo(Yii::t('ProfileModule.base', 'Visitors')); ?></td>
            <td class="text-center table-heading"><?php echo(Yii::t('ProfileModule.base', 'Views')); ?></td>
            <td class="text-center table-heading"><?php echo(Yii::t('ProfileModule.base', 'Clicks')); ?></td>
            <td class="text-center table-heading"><?php echo(Yii::t('ProfileModule.base', 'Actions')); ?></td>
            <td class="text-center table-heading"><?php echo(Yii::t('ProfileModule.base', 'Earnings')); ?></td>
            <td class="text-center table-heading"><?php echo(Yii::t('ProfileModule.base', 'Total')); ?></td>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($site as $item) { ?>
            <tr>
                <td class="text-left"><?php echo(CHtml::encode($item['url'])); ?></td>
                <td class="text-center"><?php echo(empty($item['pages']) ? '<small>N/A</small>' : '<strong>' . $item['pages'] . '</strong>'); ?></td>
                <td class="text-center"><?php echo(empty($item['users']) ? '<small>N/A</small>' : '<strong>' . $item['users'] . '</strong>'); ?></td>
                <td class="text-center"><?php echo(empty($item['views']) ? '<small>N/A</small>' : '<strong>' . $item['views'] . '</strong>'); ?></td>
                <td class="text-center"><?php echo(empty($item['clicks']) ? '<small>N/A</small>' : '<strong>' . $item['clicks'] . '</strong>'); ?></td>
                <td class="text-center"><?php echo(empty($item['actions']) ? '<small>N/A</small>' : '<strong>' . $item['actions'] . '</strong>'); ?></td>
                <td class="text-center"><?php echo(empty($item['earnings']) ? '<small>N/A</small>' : '<strong>' . Currency::model()->setString($item['earnings']) . '</strong>'); ?></td>
                <td class="text-center"><?php echo(empty($item['total']) ? '<small>N/A</small>' : '<strong>' . $item['total'] . '</strong>'); ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<?php } else { ?>
<h1 class="text-center"><?php echo(Yii::t('ProfileModule.base', 'Do not have a site to display')); ?></h1>
<?php } ?>