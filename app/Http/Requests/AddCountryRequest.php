<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddCountryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return  true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            
             'code_iso' => 'required', 
             'code_iata' => 'required', 
             'name_ru' => 'required', 
             'name_eng' => 'required', 
             'metropolis' => 'required', 
         

        ];
    }
}


   