<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchFlightBlockRequest extends FormRequest
{
  

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
             'date' =>  'required', 
             'from_id' =>  'required', 
             'to_id' =>  'required', 
             'fare_id' =>  'required', 
             'passangers_count' =>  'required', 
        ];
    }
}
