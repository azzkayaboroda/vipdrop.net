<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TypeProducts */

$this->title = 'Create Type Products';
$this->params['breadcrumbs'][] = ['label' => 'Type Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="type-products-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
