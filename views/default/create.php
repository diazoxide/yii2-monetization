<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model diazoxide\yii2monetization\models\Monetization */

$this->title = 'Create Monetization';
$this->params['breadcrumbs'][] = ['label' => 'Monetizations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="monetization-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
