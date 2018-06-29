<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ConfigurationViewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Կոնֆիգուրացիոն տեսքեր');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="configuration-views-index">

    <h1 class="page_title"><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Ստեղծել կոնֆիգուրացիոն տեսք'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'name',
            'view_type',
            'layout_type',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
