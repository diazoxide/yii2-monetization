<?php

use yii\bootstrap\Tabs;

?>
<h3>Totals</h3>

<?= \yii\helpers\Html::tag('h4', 'Revenue: ' . $model->totals->revenue) ?>
<?= \yii\helpers\Html::tag('h4', 'Daus: ' . $model->totals->daus) ?>

<table class="table table-striped table-bordered">
    <?php foreach ($model->breakdown as $item): ?>


        <?php foreach ($item->geo as $key => $geo) : ?>

            <tr>

                <td><?= $key ?></td>

                <?php foreach ($geo as $type => $geoItem): ?>
                    <td><strong><?= $type ?></strong></td>
                    <td>Rev: <?= $geoItem->revenue ?></td>
                    <td>DAU: <?= $geoItem->daus ?></td>
                <?php endforeach; ?>


            </tr>

        <?php endforeach; ?>
    <?php endforeach; ?>

</table>