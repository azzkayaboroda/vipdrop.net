<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ShopCase */

$this->title = 'Create Shop Case';
$this->params['breadcrumbs'][] = ['label' => 'Shop Cases', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shop-case-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider
    ]) ?>

</div>