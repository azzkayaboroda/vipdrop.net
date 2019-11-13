<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Pages */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<?php
// Страница ПРАВОВАЯ ИНФОРМАЦИЯ
if ($_GET['id'] == 2) {
    ?>
    <style>
        #weapon-marquee,
        #header {
            display: none !important;
        }
    </style>
    <main id="main" class="policy_latest_stamped_items">
        <div id="latest_stamped_items" class="latest_stamped_items" style="padding-bottom: 100px;">
            <div class="container">
                <h1 class="title"><span><?= $model->h1 ?></span></h1>
                <div class="breadcrumbs">
                    <div class="bread"><a href="#">НАЗАД</a></div>
                    <div class="bread"><a href="/">НА ГЛАВНУЮ</a></div>
                </div>
                <div class="text"><?= nl2br($model->text) ?></div>
            </div>
        </div>
    </main>
<?php
}
// Как было:
else {
    ?>
    <main id="main">
        <div id="latest_stamped_items" class="latest_stamped_items" style="padding-bottom: 100px;">
            <div class="container">
                <h1 class="title"><span><?= $model->h1 ?></span></h1>

                <div><?= nl2br($model->text) ?></div>
            </div>
        </div>
    </main>
<?php } ?>