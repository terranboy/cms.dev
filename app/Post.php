<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['title', 'excerpt', 'content', 'seo_title', 'seo_description', 'seo_keywords'];
    protected $guarded = ['id'];

}
