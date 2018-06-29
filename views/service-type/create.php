<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ServiceType */

$this->title = Yii::t('app', 'Ստեղծել ծառայության տեսակ');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ծառայության տեսակ'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-type-create">

    <h1 class="page_title"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
