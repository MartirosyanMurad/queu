<?php
namespace app\helpers;
use yii\bootstrap\Html;
use yii\helpers\Url;

class Functions {

    public static function pr ($obj){
        echo '<pre>';
        print_r($obj);
        echo '</pre>';
    }
    public static function isDevMode(){
        return $_SERVER['REMOTE_ADDR']=='91.196.37.135';
    }
    public static function adminDump($obj,$die=false){
        if(self::isDevMode()){
            self::pr($obj);
        }
        if($die) die;
    }
    public static function IncDate($date){
        return date('Y-m-d',strtotime('+1 day',$date));
    }

    public static function displayHashTagsList($hash_tags){
        array_splice($hash_tags, \Yii::$app->params['menu_tags_count']);
        echo '<div class = "container" id="hash_tags">';
        echo '<strong class="hashtags_label">'.\Yii::t('app','Այժմեական').'</strong> ';
        foreach($hash_tags as $hash_tag){
            if(is_null($hash_tag)){
                continue;
            }
            echo Html::a($hash_tag,Url::to('/tag/'.$hash_tag));
        }
        echo '</div>';
    }
    public static function getFullUrl(){
        return \Yii::$app->request->hostInfo . \Yii::$app->request->url;
    }
    public static function displayAdminBar($type){
        if(\Yii::$app->user->isGuest){
            return;
        }
        $items=[];
        $controller = \Yii::$app->controller->id;
        $action =  \Yii::$app->controller->action->id;
        if($type=='front'){
            $items[] = ['label'=> 'Admin','url'=>'/admin/'];
           if($controller=='posts' && $action=='view'){
               $post_id = \Yii::$app->controller->post_id;
               $items[] = ['label'=> 'Edit Post','url'=>Url::to(['/admin/posts/update', 'id'=>$post_id])];
           }
        }elseif($type='back'){
            $items[] = ['label'=> 'Haydzayn.am','url'=>'/'];
            if($controller=='posts' && $action=='update'){
                $post_id = \Yii::$app->controller->post_id;
                $items[] = ['label'=> 'View Post','url'=>Url::to(['/p/'.$post_id])];
            }
            $items[] = ['label'=> 'hy','url'=>'/hy/admin', 'active'=>\Yii::$app->language=='hy'];
            $items[] = ['label'=> 'ru','url'=>'/ru/admin', 'active'=>\Yii::$app->language=='ru'];
            $items[] = ['label'=> 'en','url'=>'/en/admin', 'active'=>\Yii::$app->language=='en'];
        }
        echo \app\helpers\Menu::widget([
            'options'=>[
                'id'=>'admin_bar'
            ],
            'items' =>$items
        ]);
    }
    public static function simpleCurl($params=[]){
        $post_url = $params['post_url'];
        $data = $params['data'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $post_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // execute and close
        $return = curl_exec($ch);
        curl_close($ch);
        return $return;
    }
    public static function checkIsset($variable, $array, $default = null) {
        if (isset($array[$variable]))
            return $array[$variable];
        return $default;
    }
}