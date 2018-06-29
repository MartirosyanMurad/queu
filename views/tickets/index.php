<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\Tickets */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tickets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tickets-index">

    <h1 class="page_title"><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tickets', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'letter',
            'number',
            [
                'attribute'=>'service_type_id',
                'value'=>'serviceType.name',
                'filter'=>\yii\helpers\ArrayHelper::map(\app\models\ServiceType::find()->all(),'id','name')
            ],

            //'status',
            'date',
            //'call_user_id',
            //'call_time',
            //'book_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
