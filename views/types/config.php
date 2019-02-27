<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model diazoxide\yii2monetization\models\TypesConfig */

$this->title = 'Config Type: ' . $model->type->name;
$this->params['breadcrumbs'][] = ['label' => 'Monetizations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->monetization->name, 'url' => ['default/view', 'id' => $model->monetization_id]];
$this->params['breadcrumbs'][] = $model->type->name;
$this->params['breadcrumbs'][] = 'Config';
?>
<div class="types-config">

    <h1><?= Html::encode($this->title) ?></h1>


    <div class="monetization-form">

        <?php $form = ActiveForm::begin(); ?>


        <?= $form->field($model, 'price')->textInput(['type' => 'number','step'=>'any']) ?>



        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>



</div>
