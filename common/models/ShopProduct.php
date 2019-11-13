<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "shop_product".
 *
 * @property int $id
 * @property string $name
 * @property string $steam_id
 * @property string $photo
 * @property int $type
 * @property int $price
 * @property int $drop_percent
 * @property int $vip
 * @property int $count
 * @property int $created_at
 * @property int $updated_at
 */
class ShopProduct extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shop_product';
    }

    public $file;

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
            [['name'], 'required'],
            [['type', 'price', 'vip', 'count', 'created_at', 'updated_at', 'owner_id'], 'integer'],
            [['name'], 'string', 'max' => 1000],
            [['drop_percent'], 'integer', 'min' => 1, 'max' => 100, 'message' => 'Неверный шанс выпада'], 
            [['steam_id', 'photo'], 'string', 'max' => 500],
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
            'owner_id' => 'Владелец',
            'steam_id' => 'Steam ID',
            'photo' => 'Photo',
            'type' => 'Type',
            'price' => 'Price',
            'drop_percent' => 'Drop Percent',
            'vip' => 'Vip',
            'count' => 'Count',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'file' => 'Фото',
        ];
    }

    public function change_owner($id)
    {
        $this->owner_id = $id;
        $this->save();
    }

    public function getType_name()
    {
         return $this->hasOne(TypeProducts::className(), ['id' => 'type']);
    }
    
    public function get_short_name()
    {
        $string = $this->name;
         if (strlen($string)>50) 
         {
            $string = strip_tags($string);
           	$string = substr($string, 0, 50);
           	$string = rtrim($string, "!,.-");
            $string = substr($string, 0, strrpos($string, ' '));
            $string.="… ";
         }

	   return $string;
    }
    
    public function get_Cases()
    {
      return  $cases = ShopCase::find()->where(['like', 'products_id', '"'.$this->id.'"'])->limit(3)->All();
    }
}