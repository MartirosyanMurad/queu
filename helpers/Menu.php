<?php
/**
 * Created by PhpStorm.
 * User: Aram
 * Date: 12/18/2017
 * Time: 9:50 AM
 */

namespace app\helpers;
use app\models\Modules;
use Yii;
use yii\helpers\Html;

class Menu
{
    public static function getUserItems(){
        $userItems = [];
        if (Yii::$app->user->isGuest) {
            $userItems[] = ['label' => 'Մուտք', 'url' => ['/site/login']];
        }else{
            $userItems[]= ['label' => 'Ելք (' . Yii::$app->user->identity->username . ')', 'url' =>['/site/logout'], 'linkOptions' => ['data-method' => 'post']];
        }
        return $userItems;
    }
    public static function getMenu(){
        $menuItems = [];
        if (!Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => 'ՄԵՆՅՈՒ', 'url' => ['/site/menu'],
                'items' => [
                    ['label' => 'ԳՈՐԾԸՆԿԵՐՆԵՐ', 'url' => ['/partners/index']],
                    ['label' => 'ՀԱՇԻՎՆԵՐ', 'url' => ['/spaccounts/index']],
                    ['label' => 'ԲԱՆԿԱՅԻՆ ՀԱՇԻՎՆԵՐ', 'url' => ['/reference/index']],
                    ['label' => 'ՇՐՋԱՆԱՌՈՒԹՅՈՒՆ', 'url' => ['/documents/index'],
//                        'items' => [
//                            ['label' => 'ՓԱՍՏԱԹՂԹԵՐ', 'url' => ['/documents/index']],
//                        ]
                    ],
                    ['label' => 'ՆԱԽՆԱԿԱՆ ՄԱՆՑՈՐԴՆԵՐ', 'url' => ['/preliminary-balance']],
                    ['label' => 'ՔԱՂՎԱԾՔ ՀԱՇՎԻՑ', 'url' => ['/documents/qaxvacq']],
                    ['label' => 'ՇՐՋԱՆԱՅԻՆ ՏԵՂԵԿԱԳԻՐ', 'url' => ['/documents/texekagir']],
                ],
                'visible' => UserPermission::checkModuleAccess(Modules::ACCOUNTING),
            ];
            $menuItems[] = ['label' => 'ԲԱՂԱԴՐԻՉՆԵՐ', 'url' => ['#'],
                'items' => [
                    ['label' => 'ԲԱՆԿԵՐ', 'url' => ['/banks/index']],
                    ['label' => 'Փ/Թ-ի ՏԵՍԱԿՆԵՐ', 'url' => ['/types/index']],
                    ['label' => 'ԱԱՀ ՀԱՇՎԱՐԿԻ ՁԵՎ', 'url' => ['/aah-calculate-type/index']],
                    ['label' => 'ԴՐԱՄԱՐԿՂ', 'url' => ['/cash-register/index']],
                    ['label' => 'ԴՈՒՐՍ ԳՐՄԱՆ ԵՂԱՆԱԿ', 'url' => ['/durs-grum/index']],
                    ['label' => 'ԱՐԺՈՒՅԹԻ ՓՈԽԱՐԺԵՔ', 'url' => ['/kurs/index']],
                    ['label' => 'ՄԵԿՆԱԲԱՆՈՒԹՅՈՒՆՆԵՐ', 'url' => ['/notes/index']],
                    ['label' => 'ՊԱՀԵՍՏ', 'url' => ['/pahest/index']],
                    ['label' => 'ՉԱՓՄԱՆ ՄԻԱՎՈՐՆԵՐ', 'url' => ['/per-count/index']],
                    ['label' => 'ՊԱՇՏՈՆ', 'url' => ['/positions/index']],
                    ['label' => 'ԾԱՌԱՅՈՒԹՅԱՆ ՁԵՌՔ ԲԵՐՄԱՆ ՏԵՍԱԿ', 'url' => ['/service-take-type/index']],
                    ['label' => 'ԱՊՐ. ԱՌԱՔՄԱՆ ԵՂԱՆԱԿ', 'url' => ['/shipping-type/index']],
                ],

                'visible' => UserPermission::checkModuleAccess(Modules::ACCOUNTING),
            ];

            $menuItems[] = ['label' => 'ՓԱՍՏԱԹՂԹԵՐ', 'url' => ['#'],
                'items' => [
                    ['label' => 'ՀԻՇԱՐԱՐ ՕՐԴԵՐ', 'url' => ['/hisharar-order/index']],
                    ['label' => 'ՎՃԱՐՄԱՆ ՀԱՆՁՆԱՐԱՐԱԳԻՐ', 'url' => ['/assignment-of-payment/index']],
                    ['label' => 'ՍՏԱՑՎԱԾ ԾԱՌԱՅՈՒԹՅՈՒՆՆԵՐ', 'url' => ['/received-service/index']],
                    ['label' => 'ԵԼՔԻ ՕՐԴԵՐ', 'url' => ['/exit-order/index']],

                    ['label' => 'ՄՈՒՏՔԻ ՕՐԴԵՐ', 'url' => ['/entrence-order/index']],
                    ['label' => 'ՀԱՇԻՎ ԱՊՐԱՆՔԱԳԻՐ', 'url' => ['/hashiv-apranqagir/index']],

//                    ['label' => 'ՄՈՒՏՔԻ ՕՐԴԵՐ', 'url' => ['/entrence-order/index']],
                ],

                'visible' => UserPermission::checkModuleAccess(Modules::ACCOUNTING),
            ];
            $menuItems[]=['label' => 'ԿԱՐԳԱՎՈՐՈՒՄՆԵՐ', 'url' => ['/site/menu'],
                'items' => [
                    ['label' => 'ՕԳՏԱՏԵՐԵՐ', 'url' => ['/management/users/index']],
                    ['label' => 'ԴԵՐԵՐ', 'url' => ['/management/roles/index']],
                    ['label' => 'ԹՈՒՅՏՎՈՒԹՅՈՒՆՆԵՐ', 'url' => ['/management/permissions/index']],
                    ['label' => 'ՕԳՏԱՏԵՐԵՐԻ ԴԵՐԵՐ', 'url' => ['/management/user-roles/index']],
                    ['label' => 'ԲԱԺԻՆՆԵՐ', 'url' => ['/management/departments/index']],
                    ['label' => 'ՊԱՇՏՈՆՆԵՐ', 'url' => ['/management/positions/index']],
                ],
                'visible' => UserPermission::checkModuleAccess(Modules::MANAGEMENT),
            ];
        }
        return $menuItems;
    }

}