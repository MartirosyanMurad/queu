<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Groups */

$this->title = 'Նոր խումբ';
$this->params['breadcrumbs'][] = ['label' => 'Խմբեր', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="groups-create">

    <h1 class="page_title"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
