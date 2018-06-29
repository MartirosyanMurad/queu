<?php
/**
 * Created by PhpStorm.
 * User: Aram
 * Date: 3/20/2018
 * Time: 8:59 PM
 */

namespace app\helpers;


class Errors
{
    public static function getMessage($key){
        $messages=[
            'user_not_found'=>'Մուտքանունը կամ գաղտնաբառը սխալ է։'
        ];
        return $messages[$key];
    }
}