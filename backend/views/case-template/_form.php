<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CaseTemplate */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="case-template-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'file1')->fileInput() ?>

    <div class="avatar_frame">
        <?php
           if(isset($model->shirt) && file_exists( Yii::getAlias('@frontend').'/web/images/cases/'.$model->shirt))
            { 
                echo "<img alt='' style='margin-bottom: 20px; max-width: 300px;' src='/images/cases/".$model->shirt."' />";
            } 
            ?>
    </div>

    <?= $form->field($model, 'file3')->fileInput() ?>

    <div class="avatar_frame">
        <?php
           if(isset($model->gun_shirt) && file_exists( Yii::getAlias('@frontend').'/web/images/cases/'.$model->gun_shirt))
            { 
                echo "<img alt='' style='margin-bottom: 20px; max-width: 300px;' src='/images/cases/".$model->gun_shirt."' />";
            } 
            ?>
    </div>

    <?= $form->field($model, 'file2')->fileInput() ?>

    <div class="avatar_frame">
        <?php
           if(isset($model->image) && file_exists( Yii::getAlias('@frontend').'/web/images/cases/'.$model->image))
            { 
                echo "<img alt='' style='margin-bottom: 20px; max-width: 300px;' src='/images/cases/".$model->image."' />";
            } 
            ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>