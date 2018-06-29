<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Monitor */

$this->title = Yii::t('app', 'Ստեղծել Մոնիտոր');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Մոնիտորներ'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="monitor-create">

    <h1 class="page_title"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
