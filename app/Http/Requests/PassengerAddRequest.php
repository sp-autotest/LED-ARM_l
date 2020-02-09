<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PassengerAddRequest extends FormRequest
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
            
           'name'=>'required', 
           'surname'=>'required',   
           'country_id'=>'required',   
           'sex_u'=>'required',    
           'type_documents'=>'required',          
           'date_birth_at'=>'required', 
           'expired'=>'required',   

        ];
    }
}
