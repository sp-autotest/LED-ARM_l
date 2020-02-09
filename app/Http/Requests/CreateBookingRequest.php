<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBookingRequest extends FormRequest
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
            
            
             'locationCodeCountryout'=>'required', 
             'locationCodeCityin' =>  'required', 
             'locationCodeCountryin'=>'required',
             'departureDateTimeout'=>  'required', 
             'currencyout' =>  'required', 
             'departureDateTimein' =>  'required', 
             'airEquipType'=>  'required', 
             'company_id' =>  'required', 
             'manager'=>  'required', 
             'phone' =>  'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
             'payway' =>  'required', 
             'gender' =>  'required', 
             'passengerTypeCode' =>  'required', 
             'birthDate' =>  'required', 
             'сountry_id'=>  'required', 
             'document' =>  'required', 
             'document_number' =>  'required', 
             'first_name' =>  'required', 
             'middle_name'=>  'required', 
             'surname' =>  'required', 
             'requestedSeatCount' =>  'required', 
             'subscriberNumber'=>  'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:6',
           
            



        ];
    }
}


