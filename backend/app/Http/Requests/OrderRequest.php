<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class OrderRequest extends FormRequest
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
            'shipping_address' => 'required|string',
            'contact_no' => 'required|string',
            'shipping_method' => 'required|string',
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
            'shipping_address.required' => 'Shipping Address is required!',
            'contact_no.required' => 'Contact No is required!',
            'shipping_method.required' => 'Shipping MMethod is required!',
         ];
    }
    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(
            response()->json([
                'status' => false,
                'messages' => $validator->errors()->all()
            ], Response::HTTP_OK)
        );
    }
}
