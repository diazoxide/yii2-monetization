<?php

namespace diazoxide\yii2monetization\models;

use Yii;

/**
 * This is the model class for table "{{%monetization_conversion}}".
 *
 * @property int $id
 * @property int $monetization_id
 * @property string $sign_date
 * @property string $ip
 * @property string $user_agent
 * @property string $note
 * @property Monetization $monetization
 * @property ConversionActions $actions
 */
class Conversion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%monetization_conversion}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['monetization_id', 'ip'], 'required'],
            [['monetization_id'], 'integer'],
            [['user_agent'], 'string', 'max' => 512],
            [['ip'], 'string', 'max' => 50],
            [['ip'], 'unique'],
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
            'monetization_id' => 'Monetization ID',
            'sign_date' => 'Sign Date',
            'user_agent' => 'User Agent',
        ];
    }

    public function getActions()
    {
        return $this->hasMany(ConversionActions::className(), ['conversion_id' => 'id']);
    }

    public function getMonetization()
    {
        return $this->hasOne(Monetization::className(), ['id' => 'monetization_id']);
    }

    public function getLocation()
    {
        $geoip = new \lysenkobv\GeoIP\GeoIP();
        return $geoip->ip($this->ip);
    }
}
