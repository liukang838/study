<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Created by PhpStorm.
 * User: liukang
 * Date: 2018/12/21
 * Time: 上午11:54
 */
class ArticleModel extends BaseModel
{
    use SoftDeletes;

    protected $connection = 'mysql';

    protected $table = 'article';

    protected $fillable=['content','sort','money','title','created_at','updated_at'];

    public $timestamps = true;

    public function findBy($id)
    {
        return $this->find($id);
    }

    public function add(array $data)
    {
        return $this->create($data);
    }

}