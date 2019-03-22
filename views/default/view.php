<?php

use kartik\daterange\DateRangePicker;
use yii\bootstrap\Alert;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model diazoxide\yii2monetization\models\Monetization */
/* @var $model diazoxide\yii2monetization\models\Monetization */
/* @var $conversionSearchModel diazoxide\yii2monetization\models\ConversionSearch */
/* @var $conversionDataProvider yii\data\ActiveDataProvider */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Monetizations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$monetizationModel = $model;

?>
<div class="monetization-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Yii::$app->user->can("updateMonetization") || Yii::$app->user->can("updateOwnMonetization", ['model' => $model]) ? Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) : "" ?>
        <?= Yii::$app->user->can("deleteMonetization") || Yii::$app->user->can("deleteOwnMonetization", ['model' => $model]) ? Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) : "" ?>
    </p>

    <?php
    $attributes = [
        [
            'label' => 'Status',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::tag('span',
                    $model->enabled ? "Enabled" : "Disabled",
                    ['class' => 'label label-' . ($model->enabled ? 'success' : 'danger')]);

            }
        ],
        'note',
    ];

    foreach ($model->types as $type) {

        $attributes[] = [
            'label' => $type->name,
            'format' => 'raw',
            'value' => function ($model) use ($type, $monetizationModel) {
                $str = '';
                if (Yii::$app->user->can('configMonetizationType')) {
                    $str .= Html::a('Config',
                            ['/monetization/types/config', 'id' => $type->id, 'monetization' => $monetizationModel->id],
                            ['class' => 'label label-primary']) . ' ';
                }
                /** @var \diazoxide\yii2monetization\models\Monetization $model */
                $count = $model->getConversions()->joinWith("actions", false, "INNER JOIN")->andWhere([\diazoxide\yii2monetization\models\ConversionActions::tableName() . ".type_id" => $type->id])->count();

                /** @var \diazoxide\yii2monetization\models\TypesConfig $config */
                $config = $type->getConfig($monetizationModel->id);
                $price = null;
                $str .= Html::tag('span', $count, ['class' => 'label label-warning']) . ' ';

                if ($config) {
                    if (!$config->price) {
                        return $str;
                    }
                    $price = $config->getPriceFormatted($count, 3);
                }

                if (Yii::$app->user->can('viewMonetizationAmount') || Yii::$app->user->can('viewOwnMonetizationAmount', ['model' => $monetizationModel])) {
                    if ($price) {
                        $str .= Html::tag('span', $price, ['class' => 'label label-success']);
                    }
                }

                return $str;

            }
        ];
    }

    echo DetailView::widget([
        'model' => $model,
        'attributes' => $attributes
    ]) ?>


    <?php
    $config = (array)$model->api_50onred;
    echo \diazoxide\yii2monetization\widgets\Mon_50onred::widget(reset($config));
    ?>

    <?php if (Yii::$app->user->can('viewMonetizationPixels') || Yii::$app->user->can('viewOwnMonetizationPixels', ['model' => $model])) foreach ($model->types as $type) {
        echo Html::tag("h4", $type->name . ' conversion link');
        echo Alert::widget([
            'options' => [
                'class' => 'alert-info',
            ],
            'closeButton' => false,
            'body' => Html::a(\yii\helpers\Url::to(['/monetization/default/conversion', 'monetization_id' => $model->primaryKey, 'type_id' => $type->id], true))
        ]);

    } ?>


    <h1>Conversions</h1>
    <?php
    $columns = [
        ['class' => 'yii\grid\SerialColumn'],

        [
            'attribute' => 'signDateRange',
            'filter' => DateRangePicker::widget([
                'model' => $conversionSearchModel,
                'attribute' => 'signDateRange',
                'convertFormat' => true,
                'pluginOptions' => [
                    'timePicker' => true,
                    'timePickerIncrement' => 30,
                    'locale' => [
                        'format' => 'Y-m-d H:i:s'
                    ]
                ]
            ]),
            'format' => 'raw',
            'value' => function ($model) {
                return Html::tag('span', Yii::$app->formatter->asRelativeTime($model->sign_date), ['class' => 'label label-default', 'data-toggle' => "tooltip", 'title' => $model->sign_date]);
            }
        ],
        [
            'attribute' => 'ip',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::tag('span', $model->ip, ['class' => 'label label-primary', 'data-toggle' => "tooltip", 'title' => $model->ip]);
            }
        ],

        [
            'attribute' => 'Location',
            'filter' => false,
            //'format' => 'raw',
            'value' => function ($model) {
                return $model->location->country;
            }
        ],

        [
            'label' => 'Os',
            'format' => 'raw',
            'value' => function ($model) {
                $result = new \WhichBrowser\Parser($model->user_agent);
                $class = isset($result->os->name) ? strtolower($result->os->name) : "unknown";
                return Html::a(Html::tag('i', '', ['data-toggle' => "tooltip", 'title' => $result->os->toString(), 'class' => 'fab fa-fw fa-' . strtolower($class)]));

            }
        ],

        [
            'label' => 'Browser',
            'format' => 'raw',
            'value' => function ($model) {
                $result = new \WhichBrowser\Parser($model->user_agent);
                $class = isset($result->browser->name) ? strtolower($result->browser->name) : "unknown";
                return Html::a(Html::tag('i', '', ['data-toggle' => "tooltip", 'title' => $result->browser->toString(), 'class' => 'fab fa-fw fa-' . $class]));

            }
        ],

        [
            'label' => 'Device',
            'format' => 'raw',
            'value' => function ($model) {
                $result = new \WhichBrowser\Parser($model->user_agent);
                return Html::a(Html::tag('i', '', ['data-toggle' => "tooltip", 'title' => $result->getType(), 'class' => 'fa fa-fw fa-' . strtolower($result->getType())]));
            }
        ]
    ];
    foreach ($model->types as $type) {

        $columns[] = [
            'label' => $type->name,
            'format' => 'raw',
            'value' => function ($model) use ($type, $monetizationModel) {
                $count = \diazoxide\yii2monetization\models\ConversionActions::find()->andWhere(['conversion_id' => $model->id, 'type_id' => $type->id])->count();

                $config = $type->getConfig($monetizationModel->id);
                $price = null;
                if ($config) {
                    if (!$config->price) {
                        return $count;
                    }
                    $price = $config->getPriceFormatted($count, 3);
                }

                $str = $count;
                if (Yii::$app->user->can('viewMonetizationAmount') || Yii::$app->user->can('viewOwnMonetizationAmount', ['model' => $monetizationModel])) {
                    if ($price)
                        $str .= ' - ' . $price;
                }
                return $str;
            }
        ];
    } ?>

    <?= GridView::widget([
        'dataProvider' => $conversionDataProvider,
        'filterModel' => $conversionSearchModel,
        'columns' => $columns,

    ]) ?>


</div>
