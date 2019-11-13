<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\widgets\ListView;
/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
$model_products = null;
if ($model->user_products) $model_products = json_decode($model->user_products);
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['id' => 'user_edit_form']); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'steam_name')->textInput(['maxlength' => true]) ?>

    <?//= $form->field($model, 'steam_hash')->textInput(['maxlength' => true]) ?>

    <?//= $form->field($model, 'jwt_token')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'avatar')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'balance')->textInput() ?>

    <?= $form->field($model, 'bonuses')->textInput() ?>

    <?= $form->field($model, 'trade_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vk_link')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'youtube_link')->textInput(['maxlength' => true]) ?>

    <?//= $form->field($model, 'user_products')->textInput(['maxlength' => true]) ?>

    <?//= $form->field($model, 'user_cases')->textInput(['maxlength' => true]) ?>

    <?//= $form->field($model, 'auth_key')->textInput(['maxlength' => true]) ?>

    <?//= $form->field($model, 'password_hash')->textInput(['maxlength' => true]) ?>

    <?//= $form->field($model, 'password_reset_token')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?//= $form->field($model, 'created_at')->textInput() ?>

    <?//= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success', 'id' => 'user_profile_submit']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php Pjax::begin(['enablePushState' => false]);?>
    <div id="case_products">

        <?php 
            if ($model->isNewRecord) $action_url = "create";
            else $action_url = "update?id=".$model->id;

            echo $this->render('/shop-product/_search', ['model' => $searchModel, 'action_url' => $action_url]); ?>

        <div class="row">
            <div class="col-lg-5">
                <h3>Товары магазина</h3>
                <div id="case_products_list">
                    <?= ListView::widget([
                                'dataProvider' => $dataProvider,
                                'itemOptions' => ['class' => 'item'],
                                'itemView' =>'/shop-product/_search_view_v2',
                                'viewParams' => ['model_products' => $model_products, 'name' =>'shop_products'],
                                
                            ]) ?>
                </div>
            </div>
            <div class="col-lg-1">
                <button id="move_product1"></button>
            </div>
            <div class="col-lg-1">
                <button id="move_product2"></button>
            </div>
            <div class="col-lg-5">
                <h3>Товары пользователя</h3>
                <div id="user_product_list">
                    <?php if ($user_products) {
                        foreach ($user_products as $product)
                           echo $this->render('/shop-product/_search_view_v2', ['model' => $product, 'name' =>'user_products']);
                    }
                    
                    ?>
                </div>
            </div>
        </div>


    </div>
    <?php Pjax::end(); ?>

</div>