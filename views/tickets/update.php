<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Tickets */

$this->title = 'Update Tickets: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Tickets', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tickets-update">

    <h1 class="page_title"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
