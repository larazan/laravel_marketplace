<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
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
        $rules = [
			'name' => 'required|unique:brands,name',
			'slug' => 'unique:brands,slug,',
		];

		// if ($this->method() == 'POST') {
		// 	$rules['image'] = 'required|image|mimes:jpeg,png,jpg,gif|max:4096';
		// }

		return $rules;
    }
}
