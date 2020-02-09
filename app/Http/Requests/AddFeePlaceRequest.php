<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddFeePlaceRequest extends FormRequest
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

               'date_start'=> 'required', 
               'date_stop'=>'required',
               'period_begin_at' => 'required',
               'airlines_id' =>'required',
               'arrival_city' =>'required',
               'type_flight' =>'required',
               'country_id_departure' =>'required',
               'country_id_arrival' =>'required',
            

        ];
    }
}
