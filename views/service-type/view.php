<?php

use app\models\Groups;
use app\models\ServiceType;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ServiceType */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Service Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-type-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="row">
        <div class="col-md-3">
            <div class="row">
                <?php
                    foreach ($images as $file) {?>
                        <div class="col-md-12">
                            <img src="<?= \yii\helpers\Url::to([$file['url']])?>" class="img-responsive">
                            <div class="h6"></div>
                        </div>
                    <?php } ?>
            </div>
        </div>
            <div class="col-md-9">
                <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
        //            'id',
                    'name',

                    [
                        'attribute' => 'parent_id',
                        'value' => function($model){
                            if(!empty($model->parent_id)){
                               return ServiceType::getValueById($model->parent_id);
                            }
                        }
                    ],
                    'one_queu_time',
                    'queu_start_time',
                    'queu_end_time',
                    [
                        'attribute' => 'group_id',
                        'value' => function($model){
                            if(!empty($model->group_id)){
                                return Groups::getValueById($model->group_id);
                            }
                        }
                    ],
                    'service_letter',
                    'active_passive',
                ],
            ]) ?>
        </div>
    </div>
</div>
