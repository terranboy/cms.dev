<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['name'];
    protected $guarded = ['id'];

    public function child()
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('order', 'asc');
    }

    public static function getAllIdFromRoot ($root_id)
    {
        $cates = \App\Category::where(['parent_id' => $root_id])->get();
        $cate_ids = [ $root_id ];
        foreach ($cates as $cate) {
            $cate_ids[] = $cate->id;
        }
        return $cate_ids;
    }
}
