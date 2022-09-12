<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SectionRequest extends FormRequest
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
            "section_name" => "required|max:20|min:5|unique:sections,section_name,".request('id'),
        ];
    }
    public function messages()
    {
        return [
            'section_name.required'     => __('اسم القسم مطلوب'),
            'section_name.unique'     => __('اسم القسم موجود بالفعل'),
            'section_name.max'             => __('الأسم لا يجب أن يتعدي 20 حرف'),
            'section_name.min'             => __('الأسم لا يجب أن يقل عن  5 حرف'),
        ];
    }
}
