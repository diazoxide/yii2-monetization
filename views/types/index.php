<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel diazoxide\yii2monetization\models\MonetizationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Types';
$this->params['breadcrumbs'][] = ['label' => 'Monetizations', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="monetization-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Type', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['attribute' => 'id', 'filter' => false],

            'name',

            [
                'class' => 'yii\grid\ActionColumn',
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
