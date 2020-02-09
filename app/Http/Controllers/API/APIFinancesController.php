<?php

namespace App\Http\Controllers\API;

use App\Currency;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;

use App\Profile;
use App\Classes\CurrencyManager as CM;
use Carbon\Carbon;
use App\AdminCompany as Company;
use App\Accounts;
use App\Payment; 
use DB;
use PDF;
use App\Bill;
use App\Http\Requests\AddAmountRequest;




class APIFinancesController extends Controller
{
    
   public $successStatus = 200;
   public $errorStatus = 400;


 

 public function index () {

         $user = Auth::user();
         $user_id =  Auth::id();
         $profile = Profile::where('user_id','=',$user_id)->first();
         $menuActiveItem['financies'] = 1;
         $company_balance  = DB::table('companies')
        ->join('accounts', 'accounts.company_registry_id', '=', 'companies.id')
        ->join('currencies','companies.currency_id', '=', 'currencies.id')
        ->select('accounts.balance as balance', 'companies.invoice_payment as invoice_payment', 'companies.residue_limit as company_limit',
          'companies.company_name as company_name',
          'currencies.name_ru as currency' )->get();

 foreach($company_balance as $cb){
         
         $company_name=$cb->company_name; 
         $balance=$cb->balance;
         $currency=$cb->currency;
         $company_limit=$cb->company_limit;

       
       }


 return response()->json(['company_balance' => $company_balance,'balance'=>$balance,'company_name'=>$company_name,'currency'=>$currency,'company_limit'=>$company_limit,'profile' => $profile, 'menuActiveItem' => $menuActiveItem, 'user' => $user ], $this->successStatus);

}



public function getPayment(Request $request) {
    $limit = (isset($request->limit))?$request->limit:10;
    $users = array_map(function($item){return $item['id'];}, Company::where('id', '=', Auth::user()->company_id)->first()->staff()->get()->toArray());
    $account = Accounts::where('company_registry_id', '=', Auth::user()->company_id )->with(['company'])->first();
    $account_number = $account->account_number;
    $payments = Payment::where('accounts_id', '=', $account_number)->orWhereIn('created_id', $users)->with(['account', 'account.company', 'manager'])->paginate($limit);
    return response()->json(['payments'=>$payments], $this->successStatus);
}


    public function getBills(Request $request) {
            $limit = (isset($request->limit))?$request->limit:10;
            $users = array_map(function($item){return $item['id'];}, Company::where('id', '=', Auth::user()->company_id)->first()->staff()->get()->toArray());
            $bills = Bill::where('company_id', '=', Auth::user()->company_id)->orWhereIn('created_id', $users)->with(['company', "created_by"])->paginate($limit);

    return response()->json(['bills'=>$bills], $this->successStatus);
    }


 public function makePayment(Request $request) {

         $user = Auth::user();
         $user_id = Auth::id();
         $profile = Profile::where('user_id','=',$user_id)->first();

         $company_id = intval($request->company_id);
         $ids = array_map(function ($item){return $item['id'];}, Company::where('parent', '=', Auth::user()->company_id)->get()->toArray());
         if(!in_array($company_id, $ids)){
             return response()->json(['status' => 'error', 'msg' => 'you have not access pay to this company'], $this->errorStatus);
         }
         $amount = floatval($request->amount);
         $currency = $request->currency_id;
         $pay_date = Carbon::now();
         $comment = $request->comment;
         $account = Accounts::where('company_registry_id','=',$company_id)->first();
         $account_number = $account->account_number;

         $currencyPayment = Currency::where('id', '=', $currency)->first();
         $currencyCompany = Company::where('id', '=', Auth::user()->company_id)->first()->currency()->first();

        $convertedAmount = CM::convert($amount, $currencyPayment->code_literal_iso_4217, $currencyCompany->code_literal_iso_4217);


        $pay = new Payment;
        $pay->accounts_id = $account_number;
        $pay->payment_date =$pay_date;
        $pay->payment_summ = $amount;
        $pay->comment = $comment;   
        $pay->created_id =$user_id;
        $pay->currency_id = $currency;
        $pay->updated_id =$user_id;
        $pay->created_at = Carbon::now(); 
        $pay->save();

       $pay_account = Accounts::where('company_registry_id','=',$company_id)->first();
       $pay_account->balance += $convertedAmount;
       $pay_account->save();

     
       
return response()->json(['ammount' => $amount, 'converted_amount' => $convertedAmount, 'account_number'=>$account_number,'payment' => $pay ,'profile' => $profile,  'user' => $user, ], $this->successStatus);
   
 }


public function getAccount() {

         $user = Auth::user();
         $user_id =  Auth::id();
         $profile = Profile::where('user_id','=',$user_id)->first();
         $menuActiveItem['financies'] = 1;
         $accounts = Accounts::paginate(10); 
         $payments = Payment::paginate(10);
         $companies = Company::paginate(10);

return response()->json(['accounts' => $accounts, 'payments'=>$payments,'companies'=>$companies,'profile' => $profile, 'menuActiveItem' => $menuActiveItem, 'user' => $user ], $this->successStatus);


}





public function putAccount(Request $request) {

         $user_id =  Auth::user()->id;

         $company_id = intval($request->company_id);
         $ammount = floatval($request->amount);

         $currency = Currency::where('id', $request->currency_id)->first();
      
     $company = Company::where('id','=',$company_id)->first();
    if($company->invoice_payment == false){
        return response()->json(['status' => 'error', 'message' => 'you have not access to generate bill'], $this->errorStatus)->header('Access-Control-Allow-Origin', '*');
    }
    setlocale(LC_TIME, 'ru_RU.UTF-8');
    $usercompany = Company::where('id', '=', Auth::user()->company_id)->first();
    $usercompany->countnumber = $usercompany->countnumber +1;
    $usercompany->save();
    $date = Carbon::now()->formatLocalized("%d %B %Y");
    $summ = $ammount;

    switch ($request->currency_id) {
      case '1':
        $lang = 'ru';
        $curr = false;
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
        $lang = 'ru';
        $curr = false;
        break;
      
      default:
        $lang = 'ru';
        $curr = true;
        break;
    }

    $data = ['request' => ['summ' => $summ, 'curr' => $curr, 'lang' => $lang], 'cp' => $company, 'uc' => $usercompany, 'currency' => $currency, 'date' => $date];
     $pdf = PDF::loadView('reports.account_bill', $data);


    $filename = time().Auth::user()->id.'.pdf';
    $path = storage_path('app/public/accounts/').$filename;
    $pdf->save($path);



    $bill = new Bill;
    $bill->invoice_date = Carbon::now();
    $bill->company_id =$company_id;
    $bill->invoice_amount = $ammount;
    $bill->currency_id = $request->currency_id;
    $bill->path = env("BACK_DOMAIN")."/storage/accounts/".$filename;
    $bill->created_id = $user_id;
    $bill->created_at = Carbon::now(); 
    $bill->save();


return response()->json(["bill"=>$bill, 'currency' => $currency ], $this->successStatus);
   

}  








}