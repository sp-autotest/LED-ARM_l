<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddServiceRequest extends FormRequest
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

      'order_id' =>  'required', 
      'service_id' =>  'required', 
      'type_flight' =>  'required', 
      'service_status' =>  'required', 
      'orders_system' =>  'required', 
      'summary_summ' =>  'required', 
      'segment_number' =>  'required', 
         


        ];
    }
}
