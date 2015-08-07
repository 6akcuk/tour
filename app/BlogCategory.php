<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{

    protected $fillable = ['name'];

    public function posts() {
        return $this->hasMany('App\Post', 'category_id');
    }
}
