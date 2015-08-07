<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    protected $fillable = ['title', 'category_id', 'author_id', 'slug', 'photo', 'body'];

    public function category()
    {
        return $this->belongsTo('App\BlogCategory');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }
}
