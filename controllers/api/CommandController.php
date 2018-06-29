<?php
/**
 * Created by PhpStorm.
 * User: Murad
 * Date: 3/9/2018
 * Time: 4:51 PM
 */

namespace app\controllers\api;


use app\models\Commands;
use app\models\TMCommands;

class CommandController extends ApiBaseController
{
    public function actionGetCommand(){
        $t_m_id = \Yii::$app->request->post('t_m_id');
        $type = \Yii::$app->request->post('type');
        return Commands::getCommandsList($t_m_id,$type);
    }
    public function actionSetCommandDone(){
        $id = \Yii::$app->request->post('id');
        return TMCommands::setDone($id);
    }
    public function actionIndex(){
//        $this->setInstance();
        die;
        return [];
    }
}