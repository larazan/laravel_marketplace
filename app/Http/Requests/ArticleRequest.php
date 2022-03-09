<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
        $rules =  [
            'title' => 'required|unique:articles',
            'body' => 'string',
            'category_ids' => 'array|required|min:1',
            'tags_input' => 'string',
            // 'image' => 'mimes:jpeg,jpg,png,gif|required|max:200000'
        ];

        return $rules;
    }
}
