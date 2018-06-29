<?php

use yii\grid\GridView;
use kartik\export\ExportMenu;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ըստ ծառայությունների'), 'url' => ['by-service','date'=>$date]];
?>

    <h2 class="page-title"><?= $name?></h2>


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
        'label' => 'Կտրոնը',
        'attribute' => 'let_num',

    ],
    [
        'label' => 'Վերցրած ժամ',
        'attribute' => 'time',

    ],
    [
        'label' => 'Կանչված ժամ',
        'attribute' => 'call_time',

    ],

    [
        'label' => 'Կարգավիճակ',
        'attribute' => 'status',
        'value'=> function($data){
            return \app\models\Tickets::getStatus($data['status']);
        },

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
    'columns' => $gridColumns,

]); ?>