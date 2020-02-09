<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditOrderRequest extends FormRequest
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
            
            'order_n' =>  'required', 
            'status' =>  'required', 
            'company_id' =>  'required', 
            'order_summary' =>  'required', 
            'order_currency' =>  'required', 
            'passengers' =>  'required', 
        ];
    }
}
