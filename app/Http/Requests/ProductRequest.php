<?php

namespace App\Http\Requests;

use App\Rules\IniAmount;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
            'description'  => 'nullable|string|max:1000',
            'hdispoa'  => 'required',
            'hdispob'  => 'required',
            'unit_price'   => ['required', new IniAmount],
        ];
    }

    public function attributes()
    {
        return [
            'location_id' => trans('validation.attributes.location_id'),
        ];
    }

}
