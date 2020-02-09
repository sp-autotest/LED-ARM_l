<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AirAvailabilityRequest extends FormRequest
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
            
          /*   'dayOffset' =>  'required',  
             'departureDateTime' =>  'required', 
             'destinationlocationCode' =>  'required', 
             'destinationlocationName' => 'required',
           //  'flexibleFaresOnly'=>  'required', 
           //  'includeInterlineFlights'=>  'required', 
             'originlocationCode' =>  'required', 
             'passengerTypeCode' =>  'required', 
             'passengerQuantity' =>'required',
             'tripType' =>  'required', */


        ];
    }
}

