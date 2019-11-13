<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ShopProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bonus Shop';
//$this->params['breadcrumbs'][] = $this->title;
?>
<main id="main">
    <div class="bonus_shop_wrapper">
        <div class="container">
            <h1 class="title">BONUS SHOP</h1>
           
            <?= ListView::widget([
                    'dataProvider' => $dataProvider,
                    'options' => [
                        'class' => 'row center'
                    ],
                    'summary'=>'',
                    'itemView' =>'_element',
                    'itemOptions' => [
                        'tag' => false
                    ]
                ]) ?>
             
            
        </div>
    </div>
</main>