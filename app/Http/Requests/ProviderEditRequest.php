<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProviderEditRequest extends FormRequest
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
            
            'name_ru'=>'required', 
           'name_full_ru'=>'required',   
           'name_eng'=>'required',   
           'name_full_eng'=>'required',    
           'date_begin_at'=>'required',    
           'date_end_at'=>'required',    


        ];
    }
}
