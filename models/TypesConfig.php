<?php

namespace diazoxide\yii2monetization\models;

use Yii;

/**
 * This is the model class for table "{{%monetization_types_config}}".
 *
 * @property int $id
 * @property int $monetization_id
 * @property string $type_id
 * @property string $price
 * @property Types $type
 * @property Monetization $monetization
 */
class TypesConfig extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%monetization_types_config}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['monetization_id', 'type_id'], 'required'],
            [['monetization_id'], 'integer'],
            [['type_id', 'price'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'monetization_id' => 'Monetization ID',
            'type_id' => 'Type ID',
            'price' => 'Price',
        ];
    }

    public function getMonetization()
    {
        return $this->hasOne(Monetization::className(), ['id' => 'monetization_id']);
    }

    public function getType()
    {
        return $this->hasOne(Types::className(), ['id' => 'type_id']);
    }

    public function getPriceFormatted($count, $decimals = 5){
        $price = $count * (double)$this->price;
        return '$' . number_format($price, $decimals);
    }
}
