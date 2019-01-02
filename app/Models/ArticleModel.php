<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

/**
 * Created by PhpStorm.
 * User: liukang
 * Date: 2018/12/21
 * Time: 上午11:54
 */
class ArticleModel extends BaseModel
{
    use SoftDeletes;
    use Searchable;

    protected $connection = 'mysql';
    protected $table = 'article';


    public function findBy($id){
        return $this->find($id);
    }

    /**
     * 获取模型的索引名称.
     *
     * @return string
     */
    public function searchableAs()
    {
        return 'study';
    }

    /**
     * 得到该模型可索引数据的数组。
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();

        // 自定义数组数据...

        return $array;
    }
}