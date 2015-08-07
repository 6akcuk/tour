<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Tag;

class TagsRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $tag = Tag::find($this->tags);

        switch ($this->method())
        {
            case 'PUT':
            case 'PATCH':
            {
                return ['tag' => 'required|unique:tags,tag,'. $tag->id];
            }
        }
    }
}
