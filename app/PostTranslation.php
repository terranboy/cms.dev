<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['title', 'excerpt', 'content', 'seo_title', 'seo_description', 'seo_keywords'];

}
