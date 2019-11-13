<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ShopProduct */

$this->title = 'Create Shop Product';
$this->params['breadcrumbs'][] = ['label' => 'Shop Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shop-product-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
