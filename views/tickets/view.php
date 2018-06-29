<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Tickets */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tickets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tickets-view">

    <h1 class="page_title"><?= Html::encode($this->title) ?></h1>

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

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'letter',
            'number',
            'queu_count',
            'kanchi_date',
            'kanchi_time',
            'terminal_id',
            'service_type_id',
            'status',
            'date',
            'call_user_id',
            'call_time',
            'book_id',
        ],
    ]) ?>

</div>
