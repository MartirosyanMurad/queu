<?php

namespace app\controllers;



use app\helpers\Reports;
use yii\data\ArrayDataProvider;

class ReportController extends \yii\web\Controller
{
    public function actionByService($date=null)
    {
        if($date===null){
            $date = date('Y-m-d');
        }
        $provider = Reports::getReportByService($date);
        $dataProvider = new ArrayDataProvider([
            'allModels' => $provider,
            'sort' => [
                'attributes' => ['name','num_all','status3','status2'],
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->render('by-service',[
            'dataProvider' => $dataProvider,
            'date' => $date
        ]);
    }

    public function actionByUser($date=null)
    {
        if($date===null){
            $date = date('Y-m-d');
        }
        $provider = Reports::getReportByUser($date);
        $dataProvider = new ArrayDataProvider([
            'allModels' => $provider,
            'sort' => [
                'attributes' => ['name', 'num_all','status3','status2'],
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->render('by-user',[
            'dataProvider' => $dataProvider,
            'date' => $date
        ]);
    }
    public function actionViewUser($id,$date,$name)
    {
        $provider = Reports::getReportViewUser($id,$date);
        $dataProvider = new ArrayDataProvider([
            'allModels' => $provider,
            'sort' => [
                'attributes' => ['let_num', 'status','time','call_time'],
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->render('view-user',[
            'dataProvider' => $dataProvider,
            'name' => $name,
            'date' => $date

        ]);
    }
    public function actionViewService($id,$date,$name)
    {
        $provider = Reports::getReportViewService($id,$date);
        $dataProvider = new ArrayDataProvider([
            'allModels' => $provider,
            'sort' => [
                'attributes' => ['name','let_num', 'status','time','call_time'],
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->render('view-service',[
            'dataProvider' => $dataProvider,
            'name' => $name,
            'date' => $date

        ]);
    }
}


