<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AirlineEditRequest extends FormRequest
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
            
             'code_tkp' =>  'required',  
             'aviacompany_name_ru' =>  'required',  
             'short_aviacompany_name_ru'  =>  'required',  
             'aviacompany_name_eng'  =>  'required',  
             'short_aviacompany_name_eng'  =>  'required',  
             'code_iata'  =>  'required',  
             'account_code_iata' =>  'required',   
             'account_code_tkp'  =>  'required|integer|min:1',  
             'city_id'  =>  'required|integer|min:1',  
             'date_begin_at'  =>  'required',  
             'date_end_at' =>  'required',  
        ];
    }
}
