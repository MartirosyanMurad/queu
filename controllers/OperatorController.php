<?php
/**
 * Created by PhpStorm.
 * User: Aram
 * Date: 5/9/2018
 * Time: 11:00 AM
 */

namespace app\controllers;


use app\helpers\Functions;
use app\models\Book;
use app\models\search\UsersSearch;
use app\models\Types;
use app\models\Users;

class OperatorController extends BaseController
{
    public function actionIndex(){
        $searchModel = new UsersSearch(['type_id'=>Types::SPASARKOX]);
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionViewUser($id,$date=null){
        $user = Users::findOne($id);
        if($date===null){
            $date = date('Y-m-d');
        }
        $book_times = Book::find()->where(['user_id'=>$user->id, 'date'=>$date])->asArray()->all();
        $model = new Book([
            'user_id'=>$id,
            'date'=>$date
        ]);
        if($model->load(\Yii::$app->request->post()) && $model->save()){
            \Yii::$app->session->setFlash('success','Գործողոությունն հաջողությամբ կատարվել է');
            return $this->refresh();
        }
        return $this->render('view-user',[
            'user' => $user,
            'model' => $model,
            'book_times'=>$book_times
        ]);
    }
    public function actionDeleteBook($id){
        if(\Yii::$app->request->isPost){
            $book = Book::findOne($id);
            $user_id  = $book->user_id;
            $date = $book->date;
            $book->delete();
            return $this->redirect(['view-user','id'=>$user_id,'date'=>$date]);
        }
    }
}