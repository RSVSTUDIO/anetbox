<?php if (!empty($referrals)) { ?>
<table class="table referral-date-table">
    <thead>
        <tr>
            <td class="col-md-5 text-left table-heading"><?php echo(Yii::t('ProfileModule.base', 'Site')); ?></td>
            <td class="text-center table-heading"><?php echo(Yii::t('ProfileModule.base', 'Counts')); ?></td>
            <td class="text-center table-heading"><?php echo(Yii::t('ProfileModule.base', 'Earnings')); ?></td>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($referrals as $item) { ?>
            <tr>
                <td class="text-left"><?php echo($item['url']); ?></td>
                <td class="text-center"><?php echo(empty($item['referrals']) ? '<small>N/A</small>' : '<strong>' . $item['referrals'] . $item['new_referrals'] . '</strong>'); ?></td>
                <td class="text-center"><?php echo(empty($item['earnings']) ? '<small>N/A</small>' : '<strong>' . Currency::model()->setString($item['earnings']) . '</strong>'); ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<?php } else { ?>
<h1 class="text-center"><?php echo(Yii::t('ProfileModule.base', 'Do not have a referral to display')); ?></h1>
<?php } ?>