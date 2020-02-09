<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditBlockRequest extends FormRequest
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

             'count_places' => 'required', 
             'ow' => 'required', 
             'infant_ow' => 'required', 
             'rt' => 'required', 
             'infant_rt' => 'required', 
             'schedule_id' => 'required',
             'currency_id'=> 'required', 
             'fare_families_id' => 'required'
            //'infant' => 'required', 
           
        ];
    }
}
