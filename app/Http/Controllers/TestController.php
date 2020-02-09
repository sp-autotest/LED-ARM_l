<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Profile;
use App\Currency;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;
use App\Passenger;
use App\Payment;
use App\Accounts;
use DB;
use PDF;
use App\Bill;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Exports\BillsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\AddAmountRequest;
use App\Http\Requests\WithdrawAmountRequest;
use App\Http\Requests\PutAccountRequest;

use App\ReportCompany as Company;

use App\Aeroport;
use App\Http\Requests\CompanyExportRequest;
use  App\Http\Requests\CanceledStatusRequest;
use  App\Http\Requests\BCTypeAddRequest;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use App\BCType;
use App\Order;
use App\Ticket;
use App\Service;
use App\Schedule;
use App\Airline;
use App\Provider;
use App\City;
use App\TypeFee;

use App\Mailing;
use App\MailingList;


class TestController extends Controller
{
 public $successStatus = 200;
	
    public function __construct(\Maatwebsite\Excel\Exporter $excel)
    {
        $this->middleware('auth');
         $this->excel = $excel;
      
    }






public function index() {

    $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $menuActiveItem['mailing'] = 1;
         $mailings = Mailing::all();
         $mailing_lists = MailingList::all();
         $companies = Company::all();

       return response()->json(['mailings' => $mailings,'mailing_lists'=>$mailing_lists,'companies' => $companies, 'profile' => $profile, 'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus);       
         
}





public function DoTest() {

$count =Order::all(); 


foreach($count as $cnt) {
         
$time_limit =$cnt->time_limit;
$order_created_at= strtotime($cnt->created_at);
  
$expired_date =($time_limit + $order_created_at)+1800; 


$expired_order  = DB::table('orders')
        ->join('services', 'services.order_id', '=', 'orders.id')
        ->select('orders.*', 'services.*')->where('orders.time_limit', '=',$expired_date)->get(); 




 foreach($expired_order as $expired){
         
  echo $user_email=$expired->user_email; 
 echo  $service_id =$expired->service_id;
 echo $order_created_at= $expired->order_created_at;
        

}

}

}


}




