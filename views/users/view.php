<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Օգտվողներ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="row">
        <div class="col-md-3">
            <img src="<?= \yii\helpers\Url::to([$model->image])?>" class="img-responsive">
            <div class="text-center user_display_name">
                <?= $model->displayName?>
            </div>
        </div>
        <div class="col-md-9">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
//            'id',
//            'image',
                    'type.name',
                    'queue_type',
                    'email:email',
                    'phone',
                    'groups_id',
//            'password_hash',
                ],
            ]) ?>
        </div>
    </div>



</div>
