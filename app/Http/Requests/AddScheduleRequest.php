<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddScheduleRequest extends FormRequest
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
        
        'departure_at' =>  'required', 
        'arrival_at' =>  'required', 
        'airlines_id' =>  'required', 
        'period_begin_at' =>  'required', 
        'period_end_at' =>  'required', 
        'flights' =>  'required', 
        'bc_types_id' =>  'required', 
        'time_departure_at' =>  'required', 
        'time_arrival_at' =>  'required', 

        ];
    }
}



