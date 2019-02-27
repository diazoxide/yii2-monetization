<?php

namespace diazoxide\yii2monetization\models;

//use app\models\User;
use dektrium\user\models\User;
use voskobovich\behaviors\ManyToManyBehavior;

/**
 * This is the model class for table "{{%monetization}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $enabled
 * @property string $name
 * @property string $note
 * @property User $user
 * @property Types $types
 * @property string $accountUrl
 * @property string $api_token_50onred
 */
class Monetization extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%monetization}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // ManyToManyBehavior requirement
            [['types_ids'], 'each', 'rule' => ['integer']],

            [['user_id'], 'required'],
            [['user_id', 'enabled'], 'integer'],
            [['note', 'name', 'api_token_50onred'], 'string', 'max' => 255],
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => ManyToManyBehavior::className(),
                'relations' => [
                    'types_ids' => 'types',
                ],
            ],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'enabled' => 'Enabled',
            'note' => 'Note',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConversions()
    {
        return $this->hasMany(Conversion::className(), ['monetization_id' => 'id']);
    }


    /**
     * @return string
     */
    public function getLinkUrl()
    {
        return \yii\helpers\Url::to(['/monetization/default/view', 'id' => $this->id]);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getTypes()
    {
        return $this->hasMany(Types::className(), ['id' => 'type_id'])
            ->viaTable('{{%monetization_types_map}}', ['monetization_id' => 'id']);
    }
}