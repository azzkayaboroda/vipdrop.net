<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CaseCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="case-category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'file')->fileInput() ?>

    <div class="avatar_frame">
        <?php
           if(isset($model->image) && file_exists( Yii::getAlias('@frontend').'/web/images/cases/'.$model->image))
            { 
                echo "<img alt='' style='margin-bottom: 20px; max-width: 300px;' src='/images/cases/".$model->image."' />";
            } 
            ?>
    </div>

    <?= $form->field($model, 'is_vip')->checkbox(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>