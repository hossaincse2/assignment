<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

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
            'product_name' => 'required',
            'description' => 'required',
            'qty' => 'required',
            'unit' => 'required',
            'price' => 'required'
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'product_name.required' => 'Product name is required!',
            'product_name.description' => 'Description name is required!',
            'qty.required' => 'Quantity is required!',
            'unit.required' => 'Unit is required!',
            'price.required' => 'Price is required!'
        ];
    }
//    protected function failedValidation(Validator $validator) {
//        throw new HttpResponseException(
//            response()->json([
//                'status' => false,
//                'messages' => $validator->errors()->all()
//            ], 200)
//        );
//    }
}
