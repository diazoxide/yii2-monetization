<?php

namespace diazoxide\yii2monetization\models;

use Yii;

/**
 * This is the model class for table "{{%monetization_types}}".
 *
 * @property int $id
 * @property string $name
 * @property string $icon_class
 * @property int $limit
 * @property double $price
 */
class Types extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%monetization_types}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [

            [['name'], 'required'],
            [['name', 'icon_class'], 'string', 'max' => 255],
            [['limit'], 'integer'],
            [['price'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'icon_class' => 'Icon Class',
            'limit' => 'Limit',
            'price' => 'Price',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConfigs()
    {
        return $this->hasMany(TypesConfig::className(), ['type_id' => 'id']);
    }

    public function getConfig($monetization_id){
        return $this->getConfigs()->andFilterWhere(['monetization_id'=>$monetization_id])->one();
    }


}
