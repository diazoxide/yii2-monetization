<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model diazoxide\yii2monetization\models\Monetization */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="monetization-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'limit')->textInput(['type' => 'number']) ?>


    <?= $form->field($model, 'price')->textInput(['type' => 'number','step'=>'any']) ?>

    <?= $form->field($model, 'icon_class')->textInput() ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
