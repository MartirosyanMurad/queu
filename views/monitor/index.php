<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\MonitorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Մոնիտորների գրանցում');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="monitor-index">

    <h1 class="page_title"><?= Html::encode($this->title) ?></h1>
    <?php

    // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Ստեղծել մոնիտոր'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'number',
            [
                'attribute'=>'configuration_view_id',
                'value'=> function($data){
                    return \app\models\ConfigurationViews::getValueById($data->configuration_view_id);
                },
                'filter' => \app\models\ConfigurationViews::getList()
            ],
            [
                'attribute'=>'terminal_monitor_group_id',
                'value'=> function($data){
                    return \app\models\TerminalMonitorGroup::getValueById($data->terminal_monitor_group_id);
                },
                'filter' => \app\models\TerminalMonitorGroup::getList()
            ],


            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
