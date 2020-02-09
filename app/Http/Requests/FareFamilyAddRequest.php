<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FareFamilyAddRequest extends FormRequest
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
            
               'code'=> 'required', 
               'name_eng'=>'required',
               'name_ru' => 'required',
               'luggage_adults' =>'required',
               'luggage_children' =>'required',
               'luggage_infants' =>'required',
               'max_stay' =>'required',
               'note_fare' =>'required',
               'fare_families_group' =>'required',
            
        ];
    }
}


