<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\TypeProducts;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model common\models\ShopProduct */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="shop-product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'steam_id')->textInput(['maxlength' => true]) ?>

    <?php
    $types = TypeProducts::find()->all();
    // формируем массив, с ключем равным полю 'id' и значением равным полю 'name' 
        $items = ArrayHelper::map($types,'id','name');
        $params = [
            'prompt' => 'Выберите тип предмета'
        ];
    echo $form->field($model, 'type')->dropDownList($items,$params);
    ?>


    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'drop_percent')->textInput() ?>

    <?= $form->field($model, 'vip')->checkbox() ?>

    <?//= $form->field($model, 'count')->textInput() ?>

    <?= $form->field($model, 'file')->fileInput() ?>

    <div class="avatar_frame">
        <?php
           if(isset($model->photo) && file_exists( Yii::getAlias('@frontend').'/web/images/'.$model->photo))
            { 
                echo "<img alt='' style='margin-bottom: 20px; max-width: 300px;' src='/images/".$model->photo."' />";
            } 
            ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>