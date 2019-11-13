<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CaseTemplate */

$this->title = 'Create Case Template';
$this->params['breadcrumbs'][] = ['label' => 'Case Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="case-template-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
