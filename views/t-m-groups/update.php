<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TerminalMonitorGroup */

$this->title = Yii::t('app', 'Խմբագրել Տերմինալ/Մոնիտոր խումբը', [
    'nameAttribute' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Տերմինալ/Մոնիտոր խմբեր'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Խմբագրել');
?>
<div class="terminal-monitor-group-update">

    <h1 class="page_title"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
