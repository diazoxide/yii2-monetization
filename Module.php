<?php

namespace diazoxide\yii2monetization;

use diazoxide\yii2monetization\models\Monetization;
use yii\helpers\ArrayHelper;

/**
 * monetization module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'diazoxide\yii2monetization\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

    /**
     * @param $user_id
     * @param bool $asArray
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getUserMonetizations($user_id, $asArray = false)
    {
        $model = Monetization::find()->where(['user_id' => $user_id]);
        if($asArray){
           return $model->asArray()->all();
        }
        return $model->all();
    }

    /**
     * @param $user_id
     * @return array
     */
    public static function getMonetizationsNav($user_id){
        return ArrayHelper::toArray(self::getUserMonetizations($user_id), [
            'diazoxide\yii2monetization\models\Monetization' => [
                'label' => 'name',
                'url' => function($model){
                    return $model->linkUrl;
                }
            ]
        ]);
    }
}
