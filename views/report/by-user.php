<?php
/* @var $this yii\web\View */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\jui\DatePicker;
use kartik\export\ExportMenu;


//\app\helpers\Functions::pr($dataProvider);die;
?>
<h2 class="page-title">Ըստ օգտվողների</h2>

<div class="pull-right">
    <p>
    <form method="get" id="date_form">
        <input type="hidden"  name="id">

        <?= DatePicker::widget([
            'name' => 'date',
            'value' => Yii::$app->request->get('date'),
            'options'=>[
                'class'=>'form-control'
            ],
            'clientOptions'=>[
                'maxDate'=>0,
                'onSelect' => new \yii\web\JsExpression('function(){$("#date_form").submit()}')
            ]
        ])?>
    </form>
</p>
</div>

<?php
$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],
    'id',
    'name',
    'color',
    'publish_date',
    'status',
    ['class' => 'yii\grid\ActionColumn'],
];

$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],

    [
        'label' => 'Անուն Ազգանուն',
        'attribute' => 'name',

    ],
    [
        'label' => 'Ամբողջ կտրոնները',
        'attribute' => 'num_all',

    ],
    [
        'label' => 'Ավարտած կտրոնները',
        'attribute' => 'status2',

    ],
    [
        'label' => 'Չեղարկած կտրոնները',
        'attribute' => 'status3',

    ],
    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{view}',
        'buttons' => [

            //view button
            'view' => function ($url,$model) use ($date) {
                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['view-user','id'=>$model['call_user_id'],'name'=>$model['name'],'date'=>$date], [
                    'title' => Yii::t('app', 'View'),
                ]);
            },
        ],

    ],


];
// Renders a export dropdown menu
echo ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns
]);
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns

]); ?>
