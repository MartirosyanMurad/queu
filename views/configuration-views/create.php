<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ConfigurationViews */

$this->title = Yii::t('app', 'Ստեղծել կոնֆիգուրացիոն տեսք');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Կոնֆիգուրացիոն տեսքեր'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="configuration-views-create">

    <h1 class="page_title"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
