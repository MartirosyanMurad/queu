<?php

namespace app\models;


use app\helpers\Functions;
use app\models\Users;
use Yii;
use yii\base\Model;

class PasswordForm extends Model
{
    public $oldpass;
    public $newpass;
    public $repeatnewpass;

    public function rules(){
        return [
            [['oldpass','newpass','repeatnewpass'],'required'],
            [['oldpass','findPasswords'],'safe'],
            ['repeatnewpass','compare','compareAttribute'=>'newpass'],
        ];
    }

    public function oldPasswordsIsValide()
    {
        if(Yii::$app->security->validatePassword($this->oldpass,$this->password_hash)) {
           return true;
        }else{
            Yii::$app->session->setFlash('error','Old password is incorrect');
            return false;
        }
    }

    public function attributeLabels(){
        return [
            'oldpass'=>'Old Password',
            'newpass'=>'New Password',
            'repeatnewpass'=>'Confirm Password',
        ];
    }

}
