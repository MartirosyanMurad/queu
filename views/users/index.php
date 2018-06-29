<?php

use app\models\Types;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\UsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Օգտվողներ';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="users-index">

    <h1 class="page_title"><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Ստեղծել օգտվող', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

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
            [
                'attribute'=>'type_id',
                'value'=> 'type.name',
                'filter' => Html::activeDropDownList($searchModel,'type_id', Types::getList(),['prompt'=>'', 'class'=>'form-control'])
            ],
            'queue_type',
//            'image',
            'email:email',
            'phone',
            'groups_id',
            //'password_hash',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
