<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\_TerminalMonitorGroup */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Տերմինալների/Մոնիտորների խմբեր');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="terminal-monitor-group-index">

    <h1 class="page_title"><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Ստեղծել Տերմինալների/Մոնիտորների խումբ'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],


            'name',
            'key',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
