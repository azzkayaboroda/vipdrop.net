<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\HistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Histories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="history-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create History', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            [ 
                'attribute'=>'user_id',
                'label'=>'Пользователь',
                'content'=>function($data){
                    return $data->user->username;
                }
                
            ],
            [ 
                'attribute'=>'type',
                'content'=>function($data){
                    return $data->getType_name();
                },
                'filter'=>array(
                    1 =>"Вращение кейса", 
                    2 =>"Получение предмета",
                    3 =>"Продажа предмета",
                    4 => "Вывод в Steam"
                ),
            ],
            'case_id',
            'product_id',
            //'desc:ntext',
            'created_at:datetime',
            //'updated_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>