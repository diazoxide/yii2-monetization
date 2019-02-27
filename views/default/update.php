<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model diazoxide\yii2monetization\models\Monetization */

$this->title = 'Update Monetization: ' . $model->user->username;
$this->params['breadcrumbs'][] = ['label' => 'Monetizations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user->username, 'url' => ['view', 'id' => $model->primaryKey]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="monetization-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
