<table class="table sites-date-table">
    <thead>
        <tr>
            <td class="col-md-2 table-heading text-left disable-element"><?php echo(Yii::t('ProfileModule.base', 'Company')); ?></td>
            <td class="table-heading text-left"><?php echo(Yii::t('ProfileModule.base', 'Network')); ?></td>
            <td class="table-heading text-center">CTR</td>
            <td class="table-heading text-center disable-element"><?php echo(Yii::t('ProfileModule.base', 'Code', 2)); ?></td>
            <td class="table-heading text-center"><?php echo(Yii::t('ProfileModule.base', 'Earnings')); ?></td>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($networkCTR as $item) { ?>
        <tr>
            <td class="col-md-2 text-left disable-element">баннер</td>
            <td class="text-left"><?php echo($item['title']); ?></td>
            <td class="text-center"><?php echo($item['ctr']); ?>%</td>
            <td class="text-center disable-element">получить</td>
            <td class="text-center"><?php echo($item['earnings']); ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>