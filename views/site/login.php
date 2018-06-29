<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
?>
<div class="site-login">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?= Html::encode($this->title) ?>
                    <!--<div class="row">
                        <?php /*echo Html::a(Yii::t('app','Facebook login'), Facebook::getFbLoginUrl(), ['class'=>'col-xs-10 col-xs-offset-1'])*/?>
                    </div>-->
                </div>
                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'options' => ['class' => 'form-horizontal'],
                    'fieldConfig' => [

                    ],
                ]); ?>

                <div class="col-xs-10 col-xs-offset-1">
                    <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
                </div>
                <div class="col-xs-10 col-xs-offset-1">
                    <?= $form->field($model, 'password')->passwordInput() ?>
                </div>
                <div class="col-xs-10 col-xs-offset-1">
                    <?= $form->field($model, 'rememberMe')->checkbox([]) ?>
                </div>

                <div class="form-group">
                    <div class="col-xs-offset-1 col-xs-10">
                        <?= Html::submitButton('Login', ['class' => 'btn btn-default form-control', 'name' => 'login-button']) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
