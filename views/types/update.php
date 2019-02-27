<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model diazoxide\yii2monetization\models\Monetization */

$this->title = 'Update Type: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Monetizations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="types-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
