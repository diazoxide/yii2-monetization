<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel diazoxide\yii2monetization\models\MonetizationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Monetizations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="monetization-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Monetization', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'attribute' => 'user_id',
                'value' => 'user.username'
            ],

            [
                'attribute' => 'enabled',
                'filter' => [0 => 'No', 1 => 'Yes'],
                'value' => function ($model) {
                    $a = [0 => 'No', 1 => 'Yes'];
                    return $a[$model->enabled];
                }
            ],
            'note',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update}',
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
