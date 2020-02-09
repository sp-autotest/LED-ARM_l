<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BCTypeAddRequest extends FormRequest
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
            
        'name_eng' => 'required', 
        'name_ru' =>'required', 
        'aircraft_class_code' => 'required', 
        'ccp' =>'required', 

        ];
    }
}
