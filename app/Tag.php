<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['tag'];

    public function posts()
    {
        return $this->belongsToMany('App\Post');
    }

    public static function getTagsIdsList($_tags)
    {
        if (!is_array($_tags)) $_tags = explode(',', $_tags);

        $tags = [];
        foreach ($_tags as $tag)
        {
            $tag = trim(ucfirst(strtolower($tag)));

            if ($tag)
                $tags[] = Tag::firstOrCreate(['tag' => $tag])->id;
        }

        return $tags;
    }
}
