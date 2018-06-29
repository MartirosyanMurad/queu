<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Terminal */

$this->title = Yii::t('app', 'Խմբագրել տերմինալը', [
    'nameAttribute' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Տերմինալներ'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->number]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Խմբագրել');
?>
<div class="terminal-update">

    <h1 class="page_title"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
