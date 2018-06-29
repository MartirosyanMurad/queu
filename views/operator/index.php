<?php

use app\models\Types;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\UsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="users-index">



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'fname',
            'lname',
            'mname',
            'username',
            'phone',
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view}',
                'buttons'=>[
                    'view'=> function($url,$data){
                        return Html::a('<i class="glyphicon glyphicon-eye-open"></i>',['view-user','id'=>$data->id]);
                    }
                ]
            ],
        ],
    ]); ?>
</div>
