<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class InvoiceRequest extends FormRequest
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
            "invoice_number" => "required",
            "invoice_Date" => "required",
            "Due_date" => "required",
            "Section" => "required",
            "product" => "required",
            "Amount_collection" => "required",
            "Amount_Commission" => "required",
            "Discount" => "required",
            "Rate_VAT" => "required",

        ];
    }
}
