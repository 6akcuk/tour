<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PostsRequest extends Request
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
        switch ($this->method())
        {
            case 'POST':
            {
                return [
                    'title' => 'required',
                    'category_id' => 'required|exists:blog_categories,id',
                    'slug' => 'required',
                    'photo' => 'image|max:8192',
                    'body' => 'required'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'title' => 'required',
                    'category_id' => 'required|exists:blog_categories,id',
                    'slug' => 'required',
                    'photo' => 'sometimes|image|max:1024',
                    'body' => 'required'
                ];
            }
        }
    }
}
