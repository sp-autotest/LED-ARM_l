<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddTicketRequest extends FormRequest
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

            'ticket_number' =>  'required', 
            'rate_fare' =>  'required', 
            'tax_fare' =>  'required', 
            'summ_ticket' =>  'required', 
    
        ];
    }
}
