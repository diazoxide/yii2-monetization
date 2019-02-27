<?php

namespace diazoxide\yii2monetization\models;

use Yii;

/**
 * This is the model class for table "{{%monetization_conversion_actions}}".
 *
 * @property int $id
 * @property int $conversion_id
 * @property int $type_id
 * @property string $referral
 * @property string $sign_date
 */
class ConversionActions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%monetization_conversion_actions}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['conversion_id', 'type_id'], 'required'],
            [['conversion_id', 'type_id'], 'integer'],
            [['referral'], 'string', 'max' => 2083],
            [['sign_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'conversion_id' => 'Conversion ID',
            'type_id' => 'Type ID',
            'sign_date' => 'Sign Date',
        ];
    }

    public function getType()
    {
        return $this->hasOne(Types::className(), ['id' => 'type_id']);
    }

}
