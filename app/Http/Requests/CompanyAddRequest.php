<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyAddRequest extends FormRequest
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
            'company_name' =>  'required',
            'legal_company_name' =>  'required',
            'post_address' =>  'required',
            'legal_address' => 'required',
            'city'=>  'required',
            'logo'=>'required|image|mimes:png,jpeg,jpg',
            'phone'=> 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'finance_mail' =>  'required|email',
            'report_mail' =>  'required |email',
            'fax' =>  'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'currency_company' =>  'required',
            'okud' =>  'required',
            'inn' =>  'required',
            'okonh' =>  'required',
            'сhecking_account' =>  'required',
            'bik' =>  'required',
            'kpp' =>'required',
            'status' =>  'required',
            //'residue_limit' =>  'required',
            'invoice_payment' =>  'required',
            'fees_avia' =>  'required',
            'correspondent_account'=>'required',
            'bank_name'=>'required',
        ];
    }


}
