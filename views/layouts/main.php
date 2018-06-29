<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    if(!Yii::$app->user->isGuest ){
        if(Yii::$app->user->identity->type_id == \app\models\Types::ADMIN){
            $items = [
                ['label' => 'Օգտվողներ', 'url' => ['/users']],
                ['label' => 'Խմբեր', 'url' => ['/groups']],
                ['label' => 'Ծառայության տեսակներ', 'url' => ['/service-type']],
                [
                    'label' => 'Տերմինալ/Մոնիտոր', 'url' => ['#'],
                    'items' => [
                        ['label' => 'Կոնֆիգուրացիոն տեսքեր', 'url' => ['/configuration-views']],
                        ['label' => 'Տերմինալների գրանցում', 'url' => ['/terminal']],
                        ['label' => 'Մոնիտորների գրանցում', 'url' => ['/monitor']],
                        ['label' => 'Տերմինալ/Մոնիտոր խմբեր', 'url' => ['/t-m-groups']],
                    ]
                ],
                [
                    'label' => 'Մոնիտորինգ', 'url' => ['#'],
                    'items' => [
                        ['label' => 'Տերմինալներ', 'url' => ['/monitoring/terminal']],
                        ['label' => 'Մոնիտորներ', 'url' => ['/monitoring/monitor']],
                        ['label' => 'Հերթ սպասարկողներ', 'url' => ['/monitoring/users']],
                    ]
                ],
                ['label' => 'Օպերատոր', 'url' => ['/operator']],
                [
                    'label' => 'Հաշվետվություն', 'url' => ['#'],
                    'items' => [
                        ['label' => 'Օգտվողներ', 'url' => ['/report/by-user']],
                        ['label' => 'Ծառայություններ', 'url' => ['/report/by-service']],
                    ]
                ],

            ];
        }
        if(Yii::$app->user->identity->type_id == \app\models\Types::OPERATOR){
            $items=[['label' => 'Օպերատոր', 'url' => ['/operator']]];
        }
        $items[]=('<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>');
    }else{
        $items = [['label' => 'Մուտք', 'url' => ['/site/login']]];
    }

    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $items
    ]);
    NavBar::end();?>

    <div class="container-fluid">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
