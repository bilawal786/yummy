<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
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
        return [
            'description' => ['nullable', 'string'],
            'status'      => ['required', 'numeric'],
            'image'       => 'image|mimes:jpeg,png,jpg|max:5098'
        ];
    }

    public function attributes()
    {
        return [
            'image'       => trans('validation.attributes.image'),
            'description' => trans('validation.attributes.description'),
            'status'      => trans('validation.attributes.status'),
        ];
    }

}
