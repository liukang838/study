<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Created by PhpStorm.
 * User: liukang
 * Date: 2018/12/21
 * Time: 上午11:54
 */
class BaseModel extends Model
{
    protected static $_instance = [];

    public static function getInstance(){
        $class = get_called_class();
        if(empty(self::$_instance[$class])){
            self::$_instance[$class] = new static();
        }
        return self::$_instance[$class];
    }

}