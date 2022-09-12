<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            "product_name" => "required|max:15|min:3",
        ];
    }
    public function messages()
    {
        return [
            'product_name.required' => __('اسم المنتج مطلوب'),
            'section_id.required' => __('يجب اختيار قسم'),
            'product_name.max'      => __('الأسم لا يجب أن يتعدي 15 حرف'),
            'product_name.min'      => __('الأسم لا يجب أن يقل عن  3 حرف'),
        ];
    }
}
