<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CaseCategory */

$this->title = 'Update Case Category: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Case Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="case-category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
