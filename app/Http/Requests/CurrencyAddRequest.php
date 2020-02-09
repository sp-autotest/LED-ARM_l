<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CurrencyAddRequest extends FormRequest
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
           'name_eng'=>'required', 
           'name_ru'=>'required',   
           'code_literal_iso_4217'=>'required',   
           'code_numeric_iso_4217'=>'required',   
        ];
    }
}
