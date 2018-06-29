<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Terminal */

$this->title = Yii::t('app', 'ՍՏեղծել տերմինալ');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Տերմինալներ'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="terminal-create">

    <h1 class="page_title"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
