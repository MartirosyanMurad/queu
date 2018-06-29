<?php
/**
 * Created by PhpStorm.
 * User: Murad
 * Date: 3/9/2018
 * Time: 4:51 PM
 */

namespace app\controllers\api;


use app\models\ConfigurationViews;
use app\models\Monitor;
use app\models\Terminal;
use app\models\Tickets;

class MonitorController extends ApiBaseController
{
    public function actionGetConfig(){
        $monitor_id = \Yii::$app->request->post('id');
        return [
            'id'=> 1,
            'name'=> 'api_monitor',
            'config'=>Monitor::getConfig($monitor_id)
        ];
    }
    public function actionGetServices(){
        $terminal_id = \Yii::$app->request->post('id');
        $terminal_id = (int)$terminal_id;
        $parent = \Yii::$app->request->post('parent');
        if($parent===0){$parent=null;}
        return Terminal::getServices($terminal_id,$parent);
    }
    public function actionGetCalledTickets(){
        return Tickets::getCalledTickets();
    }
    public function actionIndex(){
        return [];
    }
    public function actionCheckId(){
        $monitor_id = \Yii::$app->request->post('monitor_id');
        $monitor = Monitor::findOne($monitor_id);
        if($monitor){
            return [
                'respcode'=>1
            ];
        }
        return [
            'respcode'=>0
        ];
    }
    public function actionGetList(){
        return Monitor::find()->all();
    }
}