<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model diazoxide\yii2monetization\models\Monetization */

$this->title = 'Create Type';
$this->params['breadcrumbs'][] = ['label' => 'Monetizations', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => 'Types', 'url' => ['types/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="types-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
