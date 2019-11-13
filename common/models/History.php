<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use Yii;

/**
 * This is the model class for table "history".
 *
 * @property int $id
 * @property int $user_id
 * @property int $type
 * @property int $case_id
 * @property int $product_id
 * @property string $desc
 * @property int $created_id
 * @property int $updated_id
 */
class History extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'history';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'type'], 'required'],
            [['user_id', 'type', 'case_id', 'product_id', 'created_at', 'updated_at'], 'integer'],
            [['desc'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'type' => 'Type',
            'case_id' => 'Case ID',
            'product_id' => 'Product ID',
            'desc' => 'Desc',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getProduct()
    {
        return $this->hasOne(ShopProduct::className(), ['id' => 'product_id']);
    }

    public function getCase()
    {
        return $this->hasOne(ShopCase::className(), ['id' => 'case_id']);
    }

    public function getType_name()
    {
        switch ($this->type) {
            case 1:
                $type_name = "Вращение кейса";
                break;
            case 2:
                $type_name = "Получение предмета";
                break;
            case 3:
                $type_name = "Продажа предмета";
                break;
            case 4:
                $type_name = "Вывод в Steam";
                break;
        }
        return $type_name;
    }

    public function Head_lenta()
    {
        $last_wins = History::find()->where('type = 2 AND case_id IS NOT NULL')->orderby(['id' => SORT_DESC])->limit(16)->all();
        return $last_wins;
    }
}
