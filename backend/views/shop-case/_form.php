<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\CaseCategory;
use yii\helpers\ArrayHelper;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use common\models\CaseTemplate;
/* @var $this yii\web\View */
/* @var $model common\models\ShopCase */
/* @var $form yii\widgets\ActiveForm */

$model_products = null;
if ($model->products_id) $model_products = json_decode($model->products_id);
?>

<div class="shop-case-form">

    <?php $form = ActiveForm::begin(['id' => 'case_creator_form']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?php
    $categorys = CaseCategory::find()->all();
    // формируем массив, с ключем равным полю 'id' и значением равным полю 'name' 
    $items = ArrayHelper::map($categorys, 'id', 'name');
    $params = [
        'prompt' => 'Выберите категорию'
    ];
    echo $form->field($model, 'category_id')->dropDownList($items, $params);
    ?>

    <?= $form->field($model, 'file')->fileInput() ?>

    <div class="avatar_frame">
        <?php
        if (isset($model->image) && file_exists(Yii::getAlias('@frontend') . '/web/images/cases/' . $model->image)) {
            echo "<img alt='' style='margin-bottom: 20px; max-width: 300px;' src='/images/cases/" . $model->image . "' />";
        }
        ?>
    </div>

    <?php
    $items = [
        "dark-shadow" => 'Чёрный',
        "orenge-black-shadow" => 'Оранжевый',
        "dirty-shadow" => 'Грязный',
        "lightblue2-black-shadow" => 'Бирюзовый',
        "pink-shadow" => 'Розовый',
        "red-shadow" => 'Красный',
        'darkred-black-shadow' => 'Темно красный',
        "blue2-shadow" => 'Синий',
        "blue-black-shadow" => 'Темно синий',
        "dark-blue-shadow" => 'Темно-темно синий',
        "lightblue-black-shadow" => 'Светло синий',
    ];
    $params = [
        'prompt' => 'Выберите цвет подстветки кейса...'
    ];
    echo $form->field($model, 'color_light')->dropDownList($items, $params);
    ?>

    <?php
    $templates = CaseTemplate::find()->all();
    // формируем массив, с ключем равным полю 'id' и значением равным полю 'name' 
    $items = ArrayHelper::map($templates, 'id', 'name');
    $params = [
        'prompt' => 'Выберите шаблон оформления'
    ];
    echo $form->field($model, 'template_id')->dropDownList($items, $params);
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success', 'id' => 'submit_case_form']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php Pjax::begin(['enablePushState' => false]); ?>
    <div id="case_products">
        <h4>Товары для кейса</h4>
        <?php
        if ($model->isNewRecord) $action_url = "create";
        else $action_url = "update?id=" . $model->id;

        echo $this->render('/shop-product/_search', ['model' => $searchModel, 'action_url' => $action_url]); ?>

        <div id="case_products_list">
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemOptions' => ['class' => 'item'],
                'itemView' => '/shop-product/_search_view',
                'viewParams' => ['model_products' => $model_products],

            ]) ?>
        </div>

    </div>
    <?php Pjax::end(); ?>

</div>