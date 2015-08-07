<?php

namespace App\Http\Requests;

use App\BlogCategory;
use App\Http\Requests\Request;

class BlogCategoriesRequest extends Request
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
        $category = BlogCategory::find($this->categories);

        switch ($this->method())
        {
            case 'POST':
            {
                return ['name' => 'required|unique:blog_categories'];
            }
            case 'PUT':
            case 'PATCH':
            {
                return ['name' => 'required|unique:blog_categories,name,'. $category->id];
            }
        }
    }
}
