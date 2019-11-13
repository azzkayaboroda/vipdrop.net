<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "case_template".
 *
 * @property int $id
 * @property string $name
 * @property string $shirt
 * @property string $image
 */
class CaseTemplate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'case_template';
    }

    public $file1, $file2, $file3;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'shirt', 'image', 'gun_shirt'], 'string', 'max' => 100],
            [['file1', 'file2'], 'file', 'extensions' => 'png, jpg', 'maxSize' => 502400, 'tooBig' => 'Файл слишком большой', 'checkExtensionByMimeType'=>false],
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
            'shirt' => 'Shirt',
            'image' => 'Image',
            'file1' => 'Рубашка',
            'file2' => 'Графический элемент',
            'file3' => 'Рубашка для оружия'
        ];
    }
}