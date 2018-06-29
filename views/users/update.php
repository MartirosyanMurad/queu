<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = 'Խմբագրել օգտվողին';
$this->params['breadcrumbs'][] = ['label' => 'Օգտվողներ', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Խմբագրել';
?>
<div class="users-update">

    <h1 class="page_title"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
