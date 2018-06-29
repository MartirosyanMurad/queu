<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ConfigurationViews */

$this->title = Yii::t('app', 'Խմբագրել կոնֆիգուրացիոն տեսքը', [
    'nameAttribute' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Կոնֆիգուրացիոն տեսքեր'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Խմբագրել');
?>
<div class="configuration-views-update">

    <h1 class="page_title"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'images' => $images,
    ]) ?>

</div>
