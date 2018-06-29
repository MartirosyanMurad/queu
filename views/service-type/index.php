<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ServiceTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Ծառայության տեսակներ');
$this->params['breadcrumbs'][] = $this->title;
$buttons = [
    'createButton' => Html::a(Yii::t('app', 'Ստեղծել'), ['create','create'=>1], ['class' => 'btn btn-success btn_create']),
    'updateButton' => Html::a(Yii::t('app', 'Խմբագրել'), ['update','update'=>1], ['class' => 'btn btn-warning btn_update']),
    'deleteButton' => Html::a(Yii::t('app', 'Ջնջել'), ['delete','delete'=>1], ['class' => 'btn btn-danger btn_delete', 'method' => "get", 'data-confirm' => "Are you sure you want to delete this item?"]),
    'viewButton' => Html::a(Yii::t('app', 'Դիտել'), ['view','view'=>1], ['class' => 'btn btn-default btn_view']),
];
?>
<div class="service-type-index">

    <h1 class="page_title"><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p class="op_buttons">

        <?php
        $return = '';
        foreach ($buttons as $key => $button) {
            $return .= ' ' . $button;
        }
        echo $return;
        ?>
    </p>
    <?php
    echo \app\helpers\TreeRenderer::returnTree([
        'dataArray' => \app\models\ServiceType::find()->asArray()->all(),
        'checkbox' => false,
        'title_field' => 'name',
        'parent_field' => 'parent_id',
    ]);
    ?>
</div>
