<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ServiceType */

$this->title = Yii::t('app', 'Խմբագրել ծառայության տեսակը', [
    'nameAttribute' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ծառայության տեսակ'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Խմբագրել');
?>
<div class="service-type-update">

    <h1 class="page_title"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'images' => $images,
    ]) ?>

</div>
