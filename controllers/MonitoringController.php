<?php

namespace app\controllers;

use app\models\search\TerminalSearch;
use Symfony\Component\Console\Terminal;

class MonitoringController extends BaseController
{
    public function actionMonitor()
    {
        return $this->render('monitor');
    }

    public function actionTerminal()
    {
        $searchModel = new TerminalSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        $block = \Yii::$app->request->get('block');
        $terminal_id = \Yii::$app->request->get('terminal_id');
        if(!is_null($block) && $terminal_id){
            \app\models\Terminal::block($terminal_id,$block);
        }
        return $this->render('terminal', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUsers()
    {
        return $this->render('users');
    }

}
