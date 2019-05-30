<?php

namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Houdunwang\Arr\Arr;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use ModelTree, AdminBuilder;

    protected $fillable = ['pid', 'name'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        /*$this->setParentColumn('pid');
        $this->setOrderColumn('sort');
        $this->setTitleColumn('name');*/
    }

    public static function getAllCate(){
        $result = Category::select('id', 'pid', 'name')->get()->toArray();
        $sort = new Arr();
        $sort_result = $sort->channelList($result, 0, " - ", 'id');

        $array = [];
        foreach ($sort_result as $item){

            $array[$item['id']] = $item['_html'].$item['name'];

        }
        return $array;
    }
}
