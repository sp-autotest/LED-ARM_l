<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProviderAccountEditRequest extends FormRequest
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
           
         'providers_id'=>'required', 
         'ordering_p'=>'required', 
         'adding'=>'required', 
         'ordering_a'=>'required', 
         'login_a'=>'required', 
         'login_b'=>'required', 
        ];
    }
}
