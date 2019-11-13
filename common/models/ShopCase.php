<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use Yii;
use common\models\ShopProduct;

/**
 * This is the model class for table "shop_case".
 *
 * @property int $id
 * @property string $name
 * @property string $image
 * @property int $price
 * @property int $category_id
 * @property string $products_id
 * @property int $created_at
 * @property int $updated_at
 */
class ShopCase extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shop_case';
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
            [['name', 'price', 'category_id', 'products_id', 'template_id'], 'required'],
            [['price', 'category_id', 'created_at', 'updated_at', 'template_id'], 'integer'],
            [['name', 'products_id'], 'string', 'max' => 1000],
            [['image', 'color_light'], 'string', 'max' => 500],
            [['file'], 'file', 'extensions' => 'png, jpg', 'maxSize' => 502400, 'tooBig' => 'Файл слишком большой', 'checkExtensionByMimeType' => false],
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
            'image' => 'Image',
            'price' => 'Price',
            'category_id' => 'Category ID',
            'products_id' => 'Products ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'color_light' => 'Цвет подсветки',
            'file' => 'Фото',
            'template_id' => 'Шаблон оформления'
        ];
    }

    public function getTemplate()
    {
        return $this->hasOne(CaseTemplate::className(), ['id' => 'template_id']);
    }

    public function first_product()
    {
        $producst_array = json_decode($this->products_id);
        $first_element = ShopProduct::findOne($producst_array[0]);
        return $first_element;
    }

    public function case_products()
    {
        $products_array = json_decode($this->products_id);
        $product_list = ShopProduct::find()->where(['id' => $products_array])->all();
        return $product_list;
    }

    public function get_short_name()
    {
        $string = $this->name;
        if (strlen($string) > 30) {
            $string = strip_tags($string);
            $string = substr($string, 0, 30);
            $string = rtrim($string, "!,.-");
            $string = substr($string, 0, strrpos($string, ' '));
            $string .= "… ";
        }

        return $string;
    }
}