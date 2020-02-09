<?php

namespace App\Http\Controllers;

use App\Accounts;
use Illuminate\Http\Request;
use App\AdminCompany as Company;
use Auth;
use App\User;
use Image;
use View;
use Carbon\Carbon; 
use App\Profile;
use App\Currency;
use App\Airline;
use App\Mailing;
use App\MailingList;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\CompanyAddRequest;
use App\Http\Requests\CompanyEditRequest;
use DB; 

use Illuminate\Http\UploadedFile;

class CompanyController extends Controller
{
  public $successStatus = 200;
  
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index () {
      
        $this->middleware(['role_or_permission:administration.company-list']);
      
        $companies = Company::with(['currency', 'childs', 'parent', 'manager', 'feeplaces', 'ads', 'account', 'staff'])->get();
        $menuActiveItem['admin_companies'] = 1;
        return response()
                   ->json(['companies' => $companies], $this->successStatus)
                   ->header('Access-Control-Allow-Origin', '*');
       
    }

    public function getAirlines(){
      return response()->json(['airlines' => Airline::all()], $this->successStatus)->header('Access-Control-Allow-Origin', '*');
    }

    public function search(Request $request) {

        $query = $request->query;

        $company_search = Company::where('company_name', 'ilike', "%$query%")->with(['currency', 'childs', 'parent', 'feeplaces', 'ads', 'account', 'staff'])->get();

        $total = Company::where('company_name', 'ilike', "%$query%")->count();

       if ($total > 0) {
        return response()
                   ->json(['company_search' => $company_search, 'total' => $total, 'query' => $query], $this->successStatus)
                   ->header('Access-Control-Allow-Origin', '*');
       }else {
        return response()
                   ->json(['company_search' => $company_search, 'total' => $total, 'query' => $query], $this->successStatus)
                   ->header('Access-Control-Allow-Origin', '*');
       }  



    }

public function postCompanyEdit(Request $request) {
   // dd($request->currency_company);
  if(isset($request->finance_mail)){ $finance_mail =  $request->finance_mail;}

 
  $user = Auth::user();
  $user_id =  Auth::user()->id;

  if(isset($request->company_name)){ $logo_name = $request->company_name;}

 
  $company_id = intval($request->id);
  $company = Company::where( 'id', '=', $company_id )->first();
  $savedCompanyData = json_decode(json_encode($company->toArray()), true);

  $company = Company::where( 'id', '=', $company_id )->first();
  $company->id = $company_id;
    if(isset($request->company_name)){  $company->company_name = $request->company_name; }
    if(isset($request->legal_company_name)){  $company->legal_company_name = $request->legal_company_name; }
  
    if(isset($request->post_address)){ $company->post_address  = $request->post_address; } 
    if(isset($request->legal_address)){ $company->legal_address  = $request->legal_address; } 
    if(isset($request->city)){ $company->city  = $request->city; } 
    if(isset($request->phone)){ $company->phone  = $request->phone; } 
    if(isset($request->finance_mail)){ $company->finance_mail  = $request->finance_mail; } 
    if(isset($request->report_mail)){ $company->report_mail  = $request->report_mail; } 
    if(isset($request->fax)){ $company->fax  = $request->fax; } 
    if(isset($request->currency_id)){ $company->currency_id  = $request->currency_id; }
    if(isset($request->parent) && $request->parent != $company_id){ $company->parent  = $request->parent; }
    if(isset($request->okud)){ $company->okud  = $request->okud; } 
    if(isset($request->inn)){ $company->inn  = $request->inn; } 
    if(isset($request->okonh)){ $company->okonh  = $request->okonh; } 
    if(isset($request->bank_name)){ $company->bank_name  = $request->bank_name; } 
    if(isset($request->ogrn)){ $company->ogrn  = $request->ogrn; } 
    if(isset($request->kpp)){ $company->kpp  = $request->kpp; } 
    if(isset($request->сhecking_account)){ $company->сhecking_account  = $request->сhecking_account; } 
    if(isset($request->bik)){ $company->bik  = $request->bik; } 
    if(isset($request->correspondent_account)){ $company->correspondent_account  = $request->correspondent_account; } 
    if(isset($request->first_name)){ $company->first_name  = $request->first_name; } 
    if(isset($request->second_name)){ $company->second_name  = $request->second_name; } 
    if(isset($request->third_name)){ $company->third_name  = $request->third_name; } 
    if(isset($request->position)){ $company->position  = $request->position; } 
    if(isset($request->agreement)){ $company->agreement  = $request->agreement; } 
    if(isset($request->contract_number)){ $company->contract_number  = $request->contract_number; } 
    if(isset($request->contract_date)){ $company->contract_date  = $request->contract_date; } 
    if(isset($request->resident)){ $company->resident  = $request->resident; } 
    if(isset($request->commission_business)){ $company->commission_business  = $request->commission_business; } 
    if(isset($request->commission_first)){ $company->commission_first  = $request->commission_first; } 
    if(isset($request->commission_economy)){ $company->commission_economy  = $request->commission_economy; } 
    if(isset($request->status)){ $company->status  = $request->status; } 
    if(isset($request->limit)){ $company->limit  = $request->limit; } 
    if(isset($request->manager_id)){ $company->manager_id  = $request->manager_id; } 
    if(isset($request->residue_limit)){ $company->residue_limit  = $request->residue_limit; } 
    if(isset($request->invoice_payment)){ $company->invoice_payment  = $request->invoice_payment; } 
    if(isset($request->fees_avia)){ $company->fees_avia  = $request->fees_avia; } 
    if(isset($request->support_contacts)){ $company->support_contacts  = $request->support_contacts; } 

  //$company->created_id=$user_id; 
  $company->updated_id=$user_id;
  $company->updated_at =  Carbon::now();
  $company->save();


  event(new \App\Events\HistoryEvent($company, $savedCompanyData, "Редактирование компании" ));
    return response()
                   ->json(['company' => $company], $this->successStatus)
                   ->header('Access-Control-Allow-Origin', '*');
 }

public function postCompanyLogoChange($company_id, Request $request){
  $company = Company::where( 'id', '=', $company_id )->first();
  $savedCompanyData = json_decode(json_encode($company->toArray()), true);

  $image = $request->file('logo');
  $filename = /* $logo_name.*/ time() . '.' . $image->getClientOriginalExtension();
  Image::make($image)->resize(300, 300)->save( storage_path('app/public/companies/images/' . $filename )); 
  $company->logo  = $filename; 
}


 public function show($id, Request $request) {
    return response()
           ->json(['company' => Company::where('id', '=', $id)->with(['currency', 'childs', 'parent', 'feeplaces', 'ads', 'account', 'staff'])->first()], $this->successStatus)
           ->header('Access-Control-Allow-Origin', '*');
 }


public  function AddCompanyMailing($company_id) {


   $user_id =  Auth::user()->id;

   $status = true;

   $type_mailing1 =1;
   $type_mailing2 =2;
   $type_mailing3 =3;
   $type_mailing4 =4;
   $type_mailing5 =5;
  // $type_mailing6 =6;


  // $admin_email = $_ENV['MAIL_FROM'];


 $data_mailing  = [
            [
                'status' => $status,
             //   'mail_list' =>  $mail_list1,
                'type_mailing'=>$type_mailing1,
                'created_id' =>$user_id,
                'updated_id' =>$user_id,
                'company_registry_id'=>$company_id,
                'created_at' => Carbon::now(),
              
            ],

            [
                'status' => $status,
            //    'mail_list' =>  $mail_list2,
                'type_mailing'=>$type_mailing2,
                'created_id' =>$user_id,
                'updated_id' =>$user_id,
                'company_registry_id'=>$company_id,
                'created_at' => Carbon::now(),
            ],

            [
                'status' => $status,
              //  'mail_list' => $mail_list3,
                'type_mailing'=>$type_mailing3,
                'created_id' =>$user_id,
                'updated_id' =>$user_id,
                'company_registry_id'=>$company_id,
                'created_at' => Carbon::now(),
            ],

            [
                'status' => $status,
             //   'mail_list' => $mail_list4,
                'type_mailing'=>$type_mailing4,
                'created_id' =>$user_id,
                'updated_id' =>$user_id,
                'company_registry_id'=>$company_id,
                'created_at' => Carbon::now(),
            ],

             [
                 'status' => $status,
               //  'mail_list' => $mail_list5,
                 'type_mailing'=>$type_mailing5,
                 'created_id' =>$user_id,
                 'updated_id' =>$user_id,
                 'company_registry_id'=>$company_id,
                 'created_at' => Carbon::now(),
             ]
            /* [
                 'status' => $status,
                // 'mail_list' => $mail_list6,
                 'type_mailing'=>$type_mailing6,
                 'created_id' =>$user_id,
                 'updated_id' =>$user_id,
                 'company_registry_id'=>$company_id,
                 'created_at' => Carbon::now(),
             ],*/
        ];

        Mailing::insert($data_mailing);

     //   $last_inserted_id = \DB::getPdo()->lastInsertId();


/*
for ($i= 0; $i<= $last_inserted_id; $i++) {


 $data_mailing_list  = [ 
             [
                'mailing_id'=>$i,
                'mail' =>  $admin_email,
                'created_id' =>$user_id,
                'updated_id' =>$user_id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
              ]
            
        ];

        MailingList::insert($data_mailing_list);

   }*/

 
}



 public  function postCompanyAdd(Request $request) {
       
        $this->middleware(['role_or_permission:administration.company-create']);

  $user = Auth::user();
  $user_id =  Auth::user()->id;
  $logo_name = $request->company_name;
  $company = new Company;
  $company->company_name = $request->company_name; 
  $company->legal_company_name = $request->legal_company_name; 
  $company->post_address  = $request->post_address; 
  $company->legal_address = $request->legal_address; 
  $company->city = $request->city; 
  $company->phone  = $request->phone; 
  $company->finance_mail = $request->finance_mail; 
  $company->report_mail = $request->report_mail; 
  $company->fax  = $request->fax; 
  $company->currency_id  = $request->currency_id; 
 
  $company->parent  = $request->parent; 
  $company->okud  = $request->okud; 
  $company->inn  = $request->inn; 
  $company->kpp  = $request->kpp; 
  $company->okonh  = $request->okonh; 
  $company->bank_name  = $request->bank_name; 
  $company->ogrn  = $request->ogrn; 
  $company->сhecking_account  = $request->сhecking_account; 
  $company->bik  = $request->bik; 
  $company->correspondent_account  = $request->correspondent_account; 
  $company->first_name  = $request->first_name; 
  $company->second_name  = $request->second_name; 
  $company->third_name  = $request->third_name; 
  $company->position  = $request->position; 
  $company->agreement  = $request->agreement; 
  $company->contract_number  = $request->contract_number; 
  $company->contract_date  =  $request->contract_date; 
  $company->resident  = $request->resident; 
  $company->commission_business = $request->commission_business;
  $company->commission_first  = $request->commission_first; 
  $company->commission_economy  = $request->commission_economy; 
  $company->status  = $request->status; 
  $company->limit  = $request->limit; 
  $company->residue_limit  = $request->residue_limit; 
  $company->invoice_payment  = $request->invoice_payment; 
  $company->manager_id  = $request->manager_id; 
  $company->fees_avia  = $request->fees_avia; 
  $company->support_contacts  = $request->support_contacts; 
  $company->updated_id  = Auth::user()->id; 
  $company->created_id  = Auth::user()->id; 
  $company->save();
  $account = new Accounts;
  $account->company_registry_id = $company->id;
  $account->account_number = "0";
  $account->balance = 0;
  $account->created_id = Auth::user()->id;
  $account->updated_id = Auth::user()->id;
  $account->save();
 $last_id = $company->id;
  event(new \App\Events\HistoryEvent($company, [], "Создание компании" ));
 $this->AddCompanyMailing($last_id);

$finance_mail = $request->finance_mail;
  
 $data = [


 'company_name' => $request->get('company_name'),
 'legal_company_name' => $request->get('legal_company_name'),
 'post_address' => $request->get('post_address'),
 'legal_address' => $request->get('legal_address'),
 'city' => $request->get('city'),
 'phone' => $request->get('phone'),
 'finance_mail' => $request->get('finance_mail'),
 'report_mail' => $request->get('report_mail'),
 'fax' => $request->get('fax'),
 'currency_company' => $request->get('currency_company'),
 //'logo' => $filename,
 'parent' => $request->get('parent'),
 'okud' => $request->get('okud'),
 'inn' => $request->get('inn'),
 'kpp' => $request->get('kpp'),
 'okonh' => $request->get('okonh'),
 'bank_name' => $request->get('bank_name'),
 'ogrn' => $request->get('ogrn'),
 'сhecking_account' => $request->get('сhecking_account'),
 'bik' => $request->get('bik'),
 'correspondent_account' => $request->get('correspondent_account'),
 'first_name' => $request->get('first_name'),
 'second_name' => $request->get('second_name'),
 'third_name' => $request->get('third_name'),
 'position' => $request->get('position'),
 'agreement' => $request->get('agreement'),
 'contract_number' => $request->get('contract_number'),
 'contract_date' => $request->get('contract_date'), 
 'resident' => $request->get('resident'),
 'commission_business' => $request->get('commission_business'),
 'commission_first' => $request->get('commission_first'),
 'commission_economy' => $request->get('commission_economy'),
 'status' => $request->get('status'),
 'limit' => $request->get('limit'),
 'residue_limit' => $request->get('residue_limit'),
 'invoice_payment' => $request->get('invoice_payment'),
 'fees_avia' => $request->get('fees_avia'),
 'support_contacts' => $request->get('support_contacts')
];
 


\Mail::send('emails.company_add', $data, function($message) use ($finance_mail)
{
$message->from(env('MAIL_FROM'));

$message->to($finance_mail);
$message->subject('Новая компания создана');
});


   return response()
                   ->json(['company' => $company, 'account' => $account], $this->successStatus)
                   ->header('Access-Control-Allow-Origin', '*');
 
  }
 


}


  