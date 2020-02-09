<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use Image;
use View;
use Carbon\Carbon; 
use App\Profile;
use App\Mailing;
use App\MailingList;
use App\Order;


use  App\Http\Requests\MailingAddRequest;
use  App\Http\Requests\MailingEditRequest;
use  App\Http\Requests\CancelBookingRequest;

class MailingsController extends Controller
{
    
   public $successStatus = 200;


   public function __construct() {
        
        $this->middleware('auth');
    }



  public function index() {


         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $menuActiveItem['mailing'] = 1;
         $mailings = Mailing::all();


       return response()->json(['mailings' => $mailings, 'profile' => $profile, 'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus);

  }


  public function addMailing() {


         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $menuActiveItem['mailing'] = 1;
         $mailings = Mailing::all();
         $mailing_lists = MailingList::all();

       return response()->json(['mailings' => $mailings,'mailing_lists'=>$mailing_lists, 'profile' => $profile, 'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus);


  }  


public function postMailingAdd(MailingAddRequest $request) {
 

   $mailing = new Mailing;
   $mailing->status = $request->status;
   $mailing->mail_list = $request->mail_list;
   $mailing->created_id = $user_id;
   $mailing->created_at =Carbon::now(); 
   $mailing->save();



 return response()->json(['mailing' => $mailing, ], $this->successStatus);



}


public function getMailingEdit($id) {
 
   $user = Auth::user();
   $user_id =  Auth::user()->id;
   $profile = Profile::where('user_id','=',$user_id)->first();
   $mailing =  Mailing::findOrFail($id);
   $mailing_lists = MailingList::all();
  

return response()->json(['mailing' => $mailing, 'mailing_lists'=>$mailing_lists,'profile' => $profile, 'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus);




}


public function postCancelBooking (CancelBookingRequest $request) {

$bookingReferenceID = $request->get('bookingReferenceID');

$user = Auth::user();
$user_id =  Auth::user()->id;
$user_email = Auth::user()->email;

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://tua-stage.cCancelBookingrane.aero/craneota/CraneOTAService?xsd=1",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "
  <soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
  xmlns:impl=\"http://impl.soap.ws.crane.hititcs.com/\">   
  <soapenv:Header/>   
  <soapenv:Body>      
  <impl:>        
   <AirCancelBookingRequest>           

    <clientInformation>               
    <clientIP>".$_ENV['CRANE_CLIENT_IP']."</clientIP>
    <member>".$_ENV['CRANE_MEMBER']."</member>
    <password>".$_ENV['CRANE_PASSWORD']."</password>
    <userName>".$_ENV['CRANE_USERNAME']."</userName>
     <preferredCurrency>TMT</preferredCurrency>
    </clientInformation>

    <bookingReferenceID>               
    <ID>".$bookingReferenceID."</ID>            
    </bookingReferenceID>            
  <requestPurpose>VIEW_ONLY</requestPurpose> 
  </AirCancelBookingRequest>      
  </impl:CancelBooking> 
  </soapenv:Body></soapenv:Envelope>",
  
  CURLOPT_HTTPHEADER => array(
    "Content-Type: text/xml",
    "Postman-Token: a6865772-fe5d-460f-a037-09162a229205",
    "cache-control: no-cache"
  ),
));

$data= curl_exec($curl);
$responses  = json_encode($data);
curl_close($curl);


  $data = [

 
   'message' => "Бронирование № $bookingReferenceID"



];
 


\Mail::send('emails.mail_cancel_booking', $data, function($message)
{
$message->from(env('MAIL_FROM'));
$message->to($user_email, env('MAIL_NAME'));
$message->subject('Бронирование отменено');
});

return response()->json($response);


}



public function cancelOrder($id) {
 
  $user = Auth::user();
  $user_email = Auth::user()->email;


   $order =  Order::findOrFail($id);

   $order->delete();

    $data = [

 
   'message' => "Заказ № $id отменен"



];
 
\Mail::send('emails.mail_cancel_order', $data, function($message)
{
$message->from(env('MAIL_FROM'));
$message->to($user_email, env('MAIL_NAME'));
$message->subject('Заказ отменен');
});


  return redirect()->back(); 

}



public function postMailingEdit(MailingEditRequest $request) {
 
  

   $id = intval($request->get('id'));

   $mailing =  Mailing::findOrFail($id);;
   $mailing->status = $request->status;
   $mailing->mail_list = $request->mail_list;
   $mailing->created_id = $user_id;
   $mailing->created_at =Carbon::now(); 
   $mailing->save();



return response()->json(['mailing' => $mailing ], $this->successStatus);



}







}
