<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ShopCase */

$this->title = 'Update Shop Case: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Shop Cases', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="shop-case-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
         'searchModel' => $searchModel,
        'dataProvider' => $dataProvider
    ]) ?>

</div>