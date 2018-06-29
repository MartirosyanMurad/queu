<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TerminalMonitorGroup */

$this->title = Yii::t('app', 'Ստեղծել Տերմինալ/մոնիտոր խումբ');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Տերմինալ/մոնիտոր խումբեր'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="terminal-monitor-group-create">

    <h1 class="page_title"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
