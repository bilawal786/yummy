<?php
/**
 * Created by PhpStorm.
 * User: dipok
 * Date: 18/4/20
 * Time: 8:59 PM
 */

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
{
    protected $id;
    public function __construct($id = null)
    {
        parent::__construct();
        if (isset($id)) {
            $this->id = $id;
        }
    }

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
        if ($this->id) {
            return [
                'items'           => ['json'],
                'delivery_charge' => ['numeric'],
                'mobile'          => ['regex:/^([0-9\s\-\+\(\)]*)$/'],
                'address'         => ['string'],
                'shop_id'         => ['required'],
            ];
        } else {
            return [
                'items'           => ['required', 'json'],
                'delivery_charge' => ['required', 'numeric'],
                'mobile'          => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/'],
                'address'         => ['required', 'string'],
                'shop_id'         => ['required'],
                'lat'             => ['required'],
                'long'            => ['required'],
                'total'           => ['required'],
            ];
        }
    }
}
