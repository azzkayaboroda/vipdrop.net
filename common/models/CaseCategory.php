<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "case_category".
 *
 * @property int $id
 * @property string $name
 */
class CaseCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'case_category';
    }

    public $file;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['is_vip'], 'integer'],
            [['name'], 'string', 'max' => 1000],
            [['file'], 'file', 'extensions' => 'png, jpg', 'maxSize' => 502400, 'tooBig' => 'Файл слишком большой', 'checkExtensionByMimeType'=>false],
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
            'is_vip' => 'Vip категория',
            'file' => 'Значек категории'
        ];
    }

    public function getCases()
    {
        return $this->hasMany(ShopCase::className(), ['category_id' => 'id']);
    }
}