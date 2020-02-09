<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Auth;
use App\User;
use App\Profile;
use Image;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;
use App\AdminCompany as Company;
use App\Accounts;
use App\Payment; 
use App\Ticket;
use App\Http\Requests\AddAmountRequest;
use App\Http\Requests\WithdrawAmountRequest;
use App\Http\Requests\PutAccountRequest;


class FinancesController extends Controller
{
    
   public $successStatus = 200;
   public $errorStatus = 400;

   public function __construct()
    {
        $this->middleware('auth');
    }


 

 public function index () {

         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $menuActiveItem['financies'] = 1;
         $accounts = Accounts::all(); 
         $payments = Payment::all();

 return response()->json(['payments' => $payments,  'accounts'=>$accounts, 'profile' => $profile, 'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus);

 }




public function getPayment () {

         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $menuActiveItem['financies'] = 1;
         $accounts = Accounts::all(); 
         $payments = Payment::all();

 return view('financies.add-payment')->with('accounts', $accounts)->with('profile',$profile)->with('payments', $payments);


}





public function putAccount(PutAccountRequest $request) {
 
         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $menuActiveItem['financies'] = 1;
         $company_id = intval($request->get('company_id'));
         $ammount = floatval($request->get('ammount'));
         $account_number =intval($request->get('account_number'));

        $account = Accounts::where('company_registry_id','=', $company_id)->first();
        $account->company_registry_id = $company_id;
        $account->account_number = $account_number;
        $account->balance += $ammount;
        $account->updated_id = $user_id;
        $account->updated_at =Carbon::now();
        $account->save();

$usercompany = Auth::user()->admincompany()->with('currency')->first();

    $parentcompany = $usercompany->parent()->first();
    $parentcompany->countnumber += 1;
    $parentcompany->save();

setlocale(LC_TIME, 'ru_RU.UTF-8');

    $date = Carbon::now()->formatLocalized("%d %B %Y");
    $summ = $ammount;

    switch ($usercompany->currency_id) {
      case '1':
        $lang = 'de';
        $curr = true;
        break;
      case '2':
        $lang = 'ru';
        $curr = true;
        break;
      case '3':
        $lang = 'ru';
        $curr = false;
        break;
      case '4':
        $lang = 'ru';
        $curr = false;
        break;
      case '5':
        $lang = 'en';
        $curr = true;
        break;
      
      default:
        $lang = 'ru';
        $curr = true;
        break;
    }

    $data = ['request' => ['summ' => $summ, 'curr' => $curr, 'lang' => $lang], 'cp' => $parentcompany, 'uc' => $usercompany, 'date' => $date];
     $pdf = PDF::loadView('reports.account', $data);

    //$pdf->save(storage_path().'account.pdf');
    $headers = array(
             // 'Content-Type: application/pdf',
              'Access-Control-Allow-Origin', '*'
            );

    $filename = time().Auth::user()->id.'.pdf';
    $path = storage_path('app/public/accounts/').$filename;
    $pdf->save($path);


return response()->json(['ammount' => $ammount, 'account_number'=>$account_number,'profile' => $profile, 'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus);

}  


 public function addPayment(AddAmountRequest $request) {

         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $menuActiveItem['financies'] = 1;
         $company_id = intval($request->get('company_id'));
         $ammount = floatval($request->get('ammount'));
         $pay_date = $request->get('pay_date');
         $comment = $request->get('comment');
         $type_commission = $request->get('type_commission'); 

         
         $commission_first_count = Company::where('commission_first', 'LIKE', '%' . $type_commission .'%')->count();

        $commission_business_count = Company::where('commission_business', 'LIKE', '%' . $type_commission .'%')->count();

        $commission_economy_count = Company::where('commission_economy', 'LIKE', '%' . $type_commission .'%')->count();

        $accnt = Accounts::where('company_registry_id', '=',  $company_id )->first();
        
        $account_number = $accnt->account_number;

      

        if ($commission_first_count > 0) {


        $commission_first = Company::where('commission_first', 'LIKE', '%' . $type_commission .'%')->first();
        

         $ticket = Ticket::where( 'company_registry_id', '=', $company_id )->first();
          $ticket->commission_fare = $commission_first;
          $ticket->save();	

         $new_ammount = $ammount + 
            $commission_first;


        $pay =  Payment::where('accounts_id', '=', $account_number)->first();

        $pay->accounts_id = $account_number;
        $pay->payment_date = Carbon::now();
        $pay->payment_summ = $new_ammount;
        $pay->comment =$comment;
        $pay->created_at =$user_id; 
        $pay->save();

   

       }



      if ($commission_business_count > 0) {


        $commission_business = Company::where('commission_business', 'LIKE', '%' . $type_commission .'%')->first();
        

         $ticket = Ticket::where( 'company_registry_id', '=', $company_id )->first();
          $ticket->commission_fare = $commission_business;
          $ticket->save();	

         $new_ammount = $ammount + 
            $commission_business;

       $pay =  Payment::where('accounts_id', '=', $account_number)->first();

        $pay->accounts_id = $account_number;
        $pay->payment_date = Carbon::now();
        $pay->payment_summ = $new_ammount;
        $pay->comment =$comment;
        $pay->created_at =$user_id; 
        $pay->save();

       }


      if ($commission_economy_count > 0) {


        $commission_economy = Company::where('commission_economy', 'LIKE', '%' . $type_commission .'%')->first();
        

         $ticket = Ticket::where( 'company_registry_id', '=', $company_id )->first();
          $ticket->commission_fare = $commission_economy;
          $ticket->save();	

         $new_ammount = $ammount + 
            $commission_economy;

       $pay = Payment::where('accounts_id', '=', $account_number)->first();

        $pay->accounts_id = $account_number;
        $pay->payment_date = Carbon::now();
        $pay->payment_summ = $new_ammount;
        $pay->comment =$comment;
        $pay->created_at =$user_id; 
        $pay->save();



   }    
       
     
 return redirect('financies'); 
 
   



 }





public function getCompanyInfo($id) {

         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $menuActiveItem['financies'] = 1;
         $company = Accounts::getCompanyInfo($id);


 return response()->json(['company' => $company, 'profile' => $profile, 'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus);


}



}