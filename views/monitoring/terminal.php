<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\TerminalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Տերմինալներ');
?>
<div class="terminal-index">
    <?php \yii\widgets\Pjax::begin();?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'number',
            'last_ping',
            [
                'attribute'=>'is_blocked',
                'value'=>function($data){
                    return \app\models\Terminal::getConstList('block', $data->is_blocked);
                },
                'contentOptions'=>function($data){
                    if($data->is_blocked){
                        return ['style'=>'background-color:red; color:#fff'];
                    }
                    return [];
                },
                'filter'=> \app\models\Terminal::getConstList('block')
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {block}',
                'buttons' =>[
                    'view'=>function($url,$model){

                    },
                    'block'=>function($url,$model){
                        if($model->is_blocked){
                            $url = \yii\helpers\Url::to(['/monitoring/terminal', 'block'=>\app\models\Terminal::BLOCKED_FALSE,'terminal_id'=>$model->id]);
                            $icon = '<i class="glyphicon glyphicon-ok-circle"></i>';
                        }else{
                            $url = \yii\helpers\Url::to(['/monitoring/terminal', 'block'=>\app\models\Terminal::BLOCKED_TRUE,'terminal_id'=>$model->id]);
                            $icon = '<i class="glyphicon glyphicon-ban-circle"></i>';
                        }
                        return Html::a($icon,$url);
                    },
                ]
            ],
        ],
    ]); ?>
    <?php \yii\widgets\Pjax::end();?>
</div>
