<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model diazoxide\yii2monetization\models\Monetization */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="monetization-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->dropDownList(ArrayHelper::map(\dektrium\user\models\User::find()->all(), 'id', 'username'), [
        'prompt' => 'Select User'
    ]) ?>


    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'api_token_50onred	')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'note')->textInput(['maxlength' => 255]) ?>


    <?= $form->field($model, 'types_ids')->checkboxlist(ArrayHelper::map(\diazoxide\yii2monetization\models\Types::find()->all(), 'id', 'name'), ['separator' => '</br>']); ?>

    <?= $form->field($model, 'enabled')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
