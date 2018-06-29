<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = 'Նոր օգտվող';
$this->params['breadcrumbs'][] = ['label' => 'Օգտվողներ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-create">

    <h1 class="page_title"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
