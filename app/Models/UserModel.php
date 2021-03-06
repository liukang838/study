<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Created by PhpStorm.
 * User: liukang
 * Date: 2018/12/21
 * Time: 上午11:54
 */
class UserModel extends Authenticatable implements JWTSubject
{
    use SoftDeletes;
    use Notifiable;

    protected $connection = 'mysql';

    protected $table = 'users';

    protected $fillable = ['id', 'name', 'password', 'created_at', 'updated_at', 'deleted_at'];

    protected $hidden = ['deleted_at'];

    public $timestamps = true;

    protected static $_instance = [];

    public static function getInstance()
    {
        $class = get_called_class();
        if (empty(self::$_instance[$class])) {
            self::$_instance[$class] = new static();
        }
        return self::$_instance[$class];
    }

    /**
     * 通过账户和密码获取用户信息
     *
     * @param $name
     * @param $columns
     * @return mixed
     */
    public function getUserByName($name, $columns = ['*'])
    {
        return $this->where('username', $name)->first($columns);
    }

    /**
     * Get user info by phone
     *
     * @param $phone
     * @return mixed
     */
    public function getUserByPhone($phone)
    {
        return $this->where('phone', $phone)->first();
    }

    public function getUserByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

}
