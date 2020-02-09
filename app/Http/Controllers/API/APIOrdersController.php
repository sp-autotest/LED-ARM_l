<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Profile;
use View;
use Carbon\Carbon; 
use App\Order;
use App\AdminCompany as Company;
use App\Ticket;
use App\Passenger;
use App\Service;
use App\Currency;
use App\Country;
use App\City;
use App\FeePlace;
use App\TypeFee;
use App\BCType;   
use App\FareFamily;
use App\Aeroport;
use App\FlightPlace;
use App\Flight;
use App\Airline;
use App\Schedule;
use App\Provider as Prov;
use App\Accounts;
use PDF;
use App\ElectronicTicketsPicture as ETP;
use App\Mailing;
use App\MailingList;



class APIOrdersController extends Controller
{
  
   public $successStatus = 200;
   public $errorStatus = '400';


    public function index() {
      
      $clientIP = \Request::getClientIp(true);
      $user = Auth::user()->with(['admincompany', 'admincompany.currency']);
      $user_id =  Auth::user()->id;
      $user_email = Auth::user()->email;
      $profile = Profile::where('user_id','=',$user_id)->first();
        $menuActiveItem['orders'] = 1;
        $orders= Order::all()->with(['createdby', 'user', 'services', 'services.flight', 'services.flight.flightplaces', 'services.flight.flightplaces.schedule'])->orderBy('created_at')->get();
        $count_orders= Order::get()->count();

        $tickets = Ticket::all(); 
        $companies = Company::all(); 


       return response()->json(['companies' => $companies, 'profile' => $profile, 'menuActiveItem' => $menuActiveItem, 'tickets' => $tickets, 'user' => $user, 'profile' => $profile,'orders' => $orders ], $this->successStatus); 
  

    
    }



    public function search(Request $request) {



      $request->validate([

                'query' => 'required'


            ], [

                'query.required' => 'Запрос обязательный параметр'

            ]);



      $user = Auth::user();
      $user_id =  Auth::user()->id;
      $profile = Profile::where('user_id','=',$user_id)->first();
       

        $query = intval($request->get('query'));
        $companies = Company::all();
        $search_order = Order::where('order_n', 'LIKE', "%$query%")->groupBy('created_id')->groupBy('status')->groupBy('created_at')->groupBy('id')->paginate(10);

        $total = Order::where('order_n', 'LIKE', "%$query%")->count();

       if ($total > 0) {
        
        return view('orders.search')->with('search_order',$search_order)->with('total',$total)->with('profile',$profile)->with('companies', $companies)->with('query',$query);
     
       }
       

       else {


      return view('orders.nosearch')->with('search_order',$search_order)->with('total',$total)->with('profile',$profile)->with('query',$query);

       }  



    }

public function getAllOrders() {

         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $orders = Order::all();
         $menuActiveItem['orders'] = 1;
         $companies = Company::all(); 
         $feeplaces = FeePlace::all(); 
         $companies =  Company::all(); 
         $typefees =  TypeFee::all(); 
         $cities = City::all(); 
         $countries = Country::all(); 
         $airlines = Airline::all(); 
         $airoports = Aeroport::all(); 
         $farefamilies = FareFamily::all(); 
         $airports = Aeroport::all(); 
         $bc_types = BCType::all(); 
         $places= FlightPlace::all(); 
         $schedules =  Schedule::all(); 
         $airports = Aeroport::all(); 
         $bc_types = BCType::all(); 
         $currencies = Currency::all(); 
         $passengers = Passenger::all(); 
       

  return response()->json(['companies' => $companies, 'profile' => $profile, 'menuActiveItem' => $menuActiveItem,  'user' => $user, 'profile' => $profile,'orders'=>$orders, 'places' => $places, 'cities' => $cities, 'airoports' => $airoports, 'farefamilies' => $farefamilies, 'bc_types' => $bc_types, 'farefamilies' => $farefamilies, 'feeplaces' => $feeplaces, 'currencies' => $currencies, 'schedules'=>$schedules,'passengers' =>$passengers, 'airlines'=> $airlines    ], $this->successStatus); 


}
 

 public function getOrder($id) {

         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $order = Order::findOrFail($id);
         $menuActiveItem['orders'] = 1;
         $passenger_id = $order->passengers;
         $service_id = $order->services;  
         $contact_user = $order->user_id;
         $company_id = $order->company_registry_id; 
         $company =Company::where( 'id', '=',$company_id)->first();
         $service = Service::where('id','=',$service_id)->first();
         $schedule_id = $service->schedule_id;
         $passenger = Passenger::where('id','=',$passenger_id)->first();
         $ticket = Ticket::where('id','=',$passenger_id)->first();
         $total_tickets =Ticket::where('id','=',$passenger_id)->get()->count();
         $schedule =  Schedule::where( 'id', '=', $schedule_id)->first();
         $airlines_id = $schedule->airlines_id;
         $airline =Airline::where( 'id', '=',$airlines_id)->first();
         $city_id = $airline->city_id;
         $city =City::where( 'id', '=',$city_id)->first();
         $airoport = Aeroport::where('id','=', $city_id)->first();


  return response()->json(['company' => $company, 'profile' => $profile, 'menuActiveItem' => $menuActiveItem,  'user' => $user, 'profile' => $profile,'order'=>$order, 'ticket' => $ticket,  'airoport' => $airoport, 'total_tickets'=>$total_tickets, 'city' => $city, 'schedule'=>$schedule, 'service'=>'service','passenger' =>$passenger, ' $contact_id'=> $contact_user, 'airline'=> $airline    ], $this->successStatus); 



 }





public function postOrderAdd(Request $request) {

  

$request->validate([

                'payway' => 'required',

                'company_registry_id' => 'required'

            ], [

                'payway.required' => 'Способ оплаты обязательный',

                'company_registry_id.required' => 'ID компании обязательный '

            ]);





  $user = Auth::user();
  $user_id =  Auth::user()->id;
  $payway =intval($request->get('payway'));
  $company_id = intval($request->get('company_registry_id'));
  $user_email =  Auth::user()->email;



  
if ($payway == 0) {

$cp = Company::findOrFail($company_id);

$pdf = PDF::loadView('orders.account_bill',compact('cp'));

//$pdf->save(storage_path().'account.pdf');

 return $pdf->download('account_bill.pdf');

}

else {

$account = Accounts::where( 'company_registry_id', '=', $company_id )->first();
$account_current_balance = $account->balance;

$order = Order::where( 'company_registry_id', '=', $company_id )->first();
$order_current_balance = $order->order_summary;

$new_account_balance = $account_current_balance - $order_current_balance;
$account->balance =$new_account_balance;
$account->save();


}


  $passenger_id = intval($request->get('passenger_id'));
  $passenger = Passenger::where('id','=',$passenger_id)->first();
  $passenger->name = $request->get('name');
  $passenger->surname = $request->get('surname');
  $passenger->country_id = $request->get('country_id');
  $passenger->updated_at = Carbon::now();
  $passenger->sex_u = $request->get('sex_u');
  $passenger->user_id =$user_id;
  $passenger->type_documents = $request->get('type_documents');
  $passenger->type_passengers = $request->get('type_passengers');
  $passenger->passport_number = $request->get('passport_number');
  $passenger->save();
    

  $order = new Order;
  $order->order_n = intval($request->get('order_n'));
  $order->status = intval($request->get('status'));
  $order->company_registry_id = intval($request->get('company_registry_id'));
  $order->user_id = $user_id;
  $order->order_summary =  intval($request->get('order_summary'));
  $order->order_currency = intval($request->get('order_currency'));
  $order->passengers = intval($request->get('passenger_id'));
  $order->services = intval($request->get('services'));
  $order->time_limit = intval($request->get('time_limit'));
  $order->type_payment = intval($request->get('type_payment'));
  $order->email = $request->get('email');
  $order->phone = $request->get('phone');
  $order->comment = $request->get('comment');
  $order->conversation_id = intval($request->get('conversation_id'));
  $order->created_id=$user_id; 
  $order->updated_id=$user_id; 
  $order->created_at =  Carbon::now();
  $order->save();

$bookingReferenceID = $request->get('bookingReferenceID');

  $curl = curl_init();

  curl_setopt_array($curl, array(
  CURLOPT_URL => "https://tua-stage.crane.aero/craneota/CraneOTAService?xsd=1",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => 
  "<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:impl=\"http://impl.soap.ws.crane.hititcs.com/\">    <soapenv:Header/> 

        <soapenv:Body> 
        <impl:CreateBooking>        
         <AirBookingRequest>                

     <clientInformation>              
    <clientIP>".$_ENV['CRANE_CLIENT_IP']."</clientIP>
    <member>".$_ENV['CRANE_MEMBER']."</member>
    <password>".$_ENV['CRANE_PASSWORD']."</password>
    <userName>".$_ENV['CRANE_USERNAME']."</userName>            
    <preferredCurrency>TMT</preferredCurrency>            
    </clientInformation> 


       <airItinerary>                    

       <bookOriginDestinationOptions>                        

       <bookOriginDestinationOptionList>                            

       <bookFlightSegmentList>                                

       <actionCode>NN</actionCode>                                

       <addOnSegment/>                                

       <bookingClass>                                    

       <resBookDesigCode>C</resBookDesigCode>                                </bookingClass>                                

       <fareInfo>                                    

       <fareReferenceID>".$bookingReferenceID."</fareReferenceID>                                

       </fareInfo>                                

       <flightSegment>                                   
          <airItinerary>                    
          <bookOriginDestinationOptions>                        
          <bookOriginDestinationOptionList>                           
            <bookFlightSegmentList>                                
            <actionCode>NN</actionCode>                                
            <addOnSegment/>                                
            <bookingClass>                                    
            <cabin>BUSINESS</cabin>                                    
          <resBookDesigCode>C</resBookDesigCode>                                    
          <resBookDesigQuantity>10</resBookDesigQuantity>             
          </bookingClass>                                
          <fareInfo>                                    
          <cabinClassCode>C</cabinClassCode> 
          <fareGroupName>BUSINESS</fareGroupName>
          <fareReferenceCode>COW 43</fareReferenceCode>
          <fareReferenceID>5d140f6ef5857ba6be49ba88d7220668fc1584f655f7abc5dfa1e01742b2a83e5eeeb1968eea19aa45fcd8be699a0409fdfda6f494e6b9cac644a5c8895565f9</fareReferenceID>
          <fareReferenceName>C12OW</fareReferenceName>
          <flightSegmentSequence>1</flightSegmentSequence>
          <resBookDesigCode>C</resBookDesigCode>
          </fareInfo>                                

          <flightSegment>                                    
          <arrivalAirport>                                        
          <cityInfo>                                            
          <city>                                                
          <locationCode>ALA</locationCode>
          <locationName>Almaty</locationName>
          <locationNameLanguage>EN</locationNameLanguage>
          </city>                                            
          <country>                                               
          <locationCode>KZ</locationCode>\n                                               
          <locationName>Kazakhstan</locationName>\n                                                
          <locationNameLanguage>EN</locationNameLanguage>\n
           <currency>\n                                                    
           <code>KZT</code>\n                                              
           </currency>\n                                            
           </country>\n                                        
           </cityInfo>\n                                        
           <codeContext>IATA</codeContext>\n                             
           <language>EN</language>\n                                       
           <locationCode>ALA</locationCode>\n
           <locationName>Almaty</locationName>\n
           </arrivalAirport>\n                                    
           <arrivalDateTime>2019-03-18T00:45:00+05:00</arrivalDateTime>\n
            <departureAirport>\n                                       
             <cityInfo>\n                                            
             <city>\n                                                
             <locationCode>ASB</locationCode>\n                                                
             <locationName>Ashgabad</locationName>\n                                                
             <locationNameLanguage>EN</locationNameLanguage>\n                                            
             </city>\n                                            
             <country>\n                                                
             <locationCode>TM</locationCode>\n
             <locationName>Turkmenistan</locationName>\n
             <locationNameLanguage>EN</locationNameLanguage>\n                                                
              <currency>\n                                                    
              <code>TMT</code>\n                                                </currency>\n  
         </country>\n                                        
         </cityInfo>\n                                        
         <codeContext>IATA</codeContext>\n                                        
         <language>EN</language>\n  
         <locationCode>ASB</locationCode>\n
         <locationName>Ashgabat International</locationName>\n
         </departureAirport>\n                                   
          
         <departureDateTime>2019-03-17T21:00:00+05:00</departureDateTime>\n      
          <equipment>\n      

          <airEquipType>B737-800_16C/144Y</airEquipType>\n

          <changeofGauge>false</changeofGauge>\n

          </equipment>\n    

          <stopQuantity>0</stopQuantity>\n

           <accumulatedDuration/>\n 

            <airline>\n                                        
            <code>T5</code>\n                                    
            </airline>\n       

            <codeshare>false</codeshare>\n                                   
             <distance>0</distance>\n   

              <flightNumber>715</flightNumber>\n                                   
               <flightSegmentID/>\n   

               <flownMileageQty>0</flownMileageQty>\n                                    
               <groundDuration/>\n      

               <journeyDuration>PT2H55M</journeyDuration>\n                                    
               <onTimeRate>-1</onTimeRate>\n                                    
               <sector>INTERNATIONAL</sector>\n                                    
               <secureFlightDataRequired>false</secureFlightDataRequired>\n                                    
               <ticketType>PAPER</ticketType>\n 
                <trafficRestriction>\n
                <code/>\n  
                 <explanation/>\n    
                  </trafficRestriction>\n                                
                  </flightSegment>\n                                

                  <sequenceNumber/>\n                            

                  </bookFlightSegmentList>\n                        
                  </bookOriginDestinationOptionList>\n                   
                  </bookOriginDestinationOptions>\n                
                  </airItinerary>\n         

                <airTravelerList>\n                   
                <accompaniedByInfant/>\n                    
                <birthDate>1985-06-10</birthDate>\n                   
                <gender>M</gender>\n                   
                <hasStrecher/>\n                   
                <parentSequence/>\n 
                <passengerTypeCode>ADLT</passengerTypeCode>\n 
                <passportNumber>A-23422243</passportNumber>\n
                <personName>\n                        
                <givenName>AAA</givenName>\n                        
                <shareMarketInd/>\n                        
                <surname>TEST</surname>\n
                 </personName>\n                    
               <requestedSeatCount>1</requestedSeatCount>\n
                <shareMarketInd/>\n                   
                <socialSecurityNumber>123423433</socialSecurityNumber>\n    
                <unaccompaniedMinor/>\n  
                </airTravelerList>\n                
                 <contactInfoList>\n                   
                <adress>\n                        
                 <countryCode>TR</countryCode>\n
                <formatted/>\n                        
                <shareMarketInd/>\n                   
                </adress>\n                    
                <email>\n                        
                <email>test@test.com</email>\n   
                <markedForSendingRezInfo/>\n
                 <preferred/>\n                       
                <shareMarketInd/>\n                    
                </email>\n      


           <personName>\n                        
           <givenName>BBB</givenName>\n                        
            <shareMarketInd/>\n                        
            <surname>TEST</surname>\n 
            </personName>\n                    
            <phoneNumber>\n                        
            <areaCode>555</areaCode>\n                        
            <countryCode>+90</countryCode>\n                        
            <markedForSendingRezInfo/>\n                        
            <preferred/>\n                        
            <shareMarketInd/>\n                        
            <subscriberNumber>4443322</subscriberNumber>\n                    
               </phoneNumber>\n                    
              <shareMarketInd/>\n                    
              <useForInvoicing/>\n                
              </contactInfoList>\n                
           <requestPurpose>MODIFY_PERMANENTLY</requestPurpose>\n 
             
             <specialRequestDetails>\n                    
             <otherServiceInformationList>\n                        
             <otherServiceInformationList>\n                            
           <airTravelerSequence>0</airTravelerSequence>\n 
           <code>OSI</code>\n                            
              <explanation>CTCB 90 555 4443322</explanation>\n
              <flightSegmentSequence>0</flightSegmentSequence>\n</otherServiceInformationList>\n                        
             <otherServiceInformationList>\n 
            <airTravelerSequence>0</airTravelerSequence>\n
           <code>OSI</code>\n                            
           <explanation>CTCETEST@TEST.COM</explanation>\n
          <flightSegmentSequence>0</flightSegmentSequence>\n  
         </otherServiceInformationList>\n 
        </otherServiceInformationList>\n
       </specialRequestDetails>\n 
      </AirBookingRequest>\n        
     </impl:CreateBooking>\n    
     </soapenv:Body>\n
   </soapenv:Envelope>",

  CURLOPT_HTTPHEADER => array(
    "Content-Type: text/xml",
    "Postman-Token: 9dc66f5e-e834-417d-ae49-248bf47cfd78",
    "cache-control: no-cache"
  ),
));

$data= curl_exec($curl);
$responses  = json_encode($data);
curl_close($curl);
$user = Auth::user();
$user_id =  Auth::user()->id;
$profile = Profile::where('user_id','=',$user_id)->first();

///return response()->json($response);
return view('cranes.createbooking')->with('responses',json_decode($responses,true))->with('profile',$profile);

  
 $data = [

  'order_n' => intval($request->get('order_n')),
  'status' =>intval($request->get('status')), 
  'company_id'=> intval($request->get('company_registry_id')), 
  'user_id'  => $uid, 
  'order_summary' => intval($request->get('order_summary')), 
  'order_currency' => intval($request->get('order_currency')), 
  'passengers' => intval($request->get('passenger_id')), 
  'services' => intval($request->get('services')), 
  'time_limit'  => intval($request->get('time_limit')), 
   'type_payment' => intval($request->get('type_payment')), 
  'email'  => $request->get('email'), 
  'phone' => $request->get('phone'), 
  'conversation_id'  => intval($request->get('conversation_id')),
  'comment'  => $request->get('comment')
 

];

  $mail_count =Mailing::where( 'company_registry_id', '=', $company_id )->count();
  
  if ($mail_count > 0) {

  
  $mail_list = Mailing::where([[ 'company_registry_id', '=', Auth::user()->company_id], [ "type_mailing", '=', 6], ['status', '=', true]])->get();


   foreach($mail_list as $mails){

   $mail_list_id = $mail_list->id;


  $mailing_emails = MailingList::where( 'mailing_id', '=', $mail_list_id )->get();

 
  foreach($mailing_emails as $mailing){
         
        
         $mailing_email = $mailing->mail;
  
 $data = [

  'order_n' => intval($request->get('order_n')),
  'status' =>intval($request->get('status')), 
  'company_id'=> intval($request->get('company_registry_id')), 
  'user_id'  => $uid, 
  'order_summary' => intval($request->get('order_summary')), 
  'order_currency' => intval($request->get('order_currency')), 
  'passengers' => intval($request->get('passenger_id')), 
  'services' => intval($request->get('services')), 
  'time_limit'  => intval($request->get('time_limit')), 
   'type_payment' => intval($request->get('type_payment')), 
  'email'  => $request->get('email'), 
  'phone' => $request->get('phone'), 
  'conversation_id'  => intval($request->get('conversation_id')),
  'comment'  => $request->get('comment')
];



\Mail::send('emails.order_add', $data, function($message) use ($user_email,$mailing_email)
{
$message->from(env('MAIL_FROM'));
$message->to($user_email)->cc(env('MAIL_FROM'), env('MAIL_NAME'));
$message->subject('Новый заказ создан');
});

}

}


}

  

}





public function postCancelBooking (Request $request) {

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
 


\Mail::send('emails.mail_cancel_booking', $data, function($message) use ($user_email)

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
   $order =Order::where('id','=',$id)->first();
   $order->status = 0;
   $order->save(); 

    $data = [

 
   'message' => "Заказ № $id отменен"



];
 


\Mail::send('emails.mail_cancel_order', $data, function($message) use ($user_email)
{
$message->from(env('MAIL_FROM'));
$message->to($user_email)->cc(env('MAIL_FROM'), env('MAIL_NAME'));
$message->subject('Заказ отменен');
});


  return redirect()->back(); 

}



 public function getTicket($id) {

         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $ticket = Ticket::findOrFail($id);
         $menuActiveItem['orders'] = 1;

         $companies = Company::all();  
         $services = Service::all(); 
         $passengers = Passenger::paginate(10); 
         $providers = Prov::paginate(10); 
         $typefees =  TypeFee::paginate(10); 

 return response()->json(['companies' => $companies, 'profile' => $profile, 'menuActiveItem' => $menuActiveItem,  'user' => $user, 'profile' => $profile,'services'=>$services, 'passengers'=>$passengers,'typefees'=>$typefees,'ticket'=>$ticket,'providers' =>$providers], $this->successStatus);


}




 public function getCancelService($id) {
         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $service = Service::findOrFail($id);
         $menuActiveItem['orders'] = 1;
         $companies = Company::all();  

  return response()->json(['companies' => $companies, 'profile' => $profile, 'menuActiveItem' => $menuActiveItem,  'user' => $user, 'profile' => $profile,'service'=>$service ], $this->successStatus); 

 }



public function postCancelService(Request $request) {


$user = Auth::user();
$user_id =  Auth::user()->id;
$user_email = Auth::user()->email;
$profile = Profile::where('user_id','=',$user_id)->first();
$service_id = intval($request->get('service_id'));

$service_count =Service::where('id','=',$service_id)->count();
  
if ($service_count > 0) {

$service = Service::where('id','=',$service_id)->first();
$service->service_status = 0;
$service->save();  


  $service =Service::where('id','=',$service_id)->first(); 
 $order_id = $service->order_id;

$service = Service::where('id','=',$service_id)->first();

$service_id = $service->service_id;

 $data = [

  'service_id' => $service_id

];

 $order = Order::where('id','=', $order_id)->first();
 $company_id = $order->company_registry_id;

  $mail_list = Mailing::where([[ 'company_registry_id', '=', Auth::user()->company_id], [ "type_mailing", '=', 3], ['status', '=', true]])->get();



   foreach($mail_list as $mails){

    $mail_list_id = $mails->id;


    $mailing_emails = MailingList::where( 'mailing_id', '=', $mail_list_id )->get();

 
 foreach($mailing_emails as $mailing){
         
        
         $mailing_email = $mailing->mail;

\Mail::send('emails.cancel_order_service', $data, function($message) use ($mailing_email)
{
$message->from(env('MAIL_FROM'));
$message->to($mailing_email)->cc(env('MAIL_FROM'), env('MAIL_NAME'));
$message->subject('Запрос на отмену услуги');
});

}

}
  
}

    return response()->json(['service' =>$service ], $this->successStatus);


}




public function postDoneCancelService(Request $request) {
         
$user = Auth::user();
$user_id =  Auth::user()->id;
$user_email = Auth::user()->email;
$profile = Profile::where('user_id','=',$user_id)->first();
$service_id = intval($request->get('service_id'));
$service_count =Service::where('id','=',$service_id)->count();
  
if ($service_count > 0) {

$service = Service::where('id','=',$service_id)->first();
$service->service_status = 0;
$service->save();  


$service = Service::where('id','=',$service_id)->first();

$service_id = $service->service_id;

 $data = [

  'service_id' => $service_id

];

$service =Service::where('id','=',$service_id)->first(); 
$order_id = $service->order_id;

 $order = Order::where('id','=', $order_id)->first();
 $company_id = $order->company_registry_id;


  $mail_list = Mailing::where([[ 'company_registry_id', '=', Auth::user()->company_id], [ "type_mailing", '=',4], ['status', '=', true]])->get();



   foreach($mail_list as $mails){

   $mail_list_id = $mail_list->id;


  $mailing_emails = MailingList::where( 'mailing_id', '=', $mail_list_id )->get();

 
 foreach($mailing_emails as $mailing){
         
        
         $mailing_email = $mailing->mail;

\Mail::send('emails.canceled_order_service', $data, function($message) use ($mailing_email)
{
$message->from(env('MAIL_FROM'));
$message->to($mailing_email)->cc(env('MAIL_FROM'), env('MAIL_NAME'));
$message->subject('Запрос на отмену услуги');
});

}

}
 
} 


}



public function getBlock($id) {
        $user = Auth::user();
        $user_id =  Auth::user()->id;
        $profile = Profile::where('user_id','=',$user_id)->first();
        $place= FlightPlace::findOrFail($id);
        $schedules =  Schedule::all(); 
        $airports = Aeroport::all(); 
        $bc_types = BCType::all(); 
        $cities = City::all(); 
        $feesplaces = FeePlace::all(); 
        $airlines = Airline::all(); 
        $farefamilies = FareFamily::all(); 
        $currencies = Currency::all(); 
        $menuActiveItem['orders'] = 1;

    


     return response()->json(['currencies' => $currencies, 'profile' => $profile, 'menuActiveItem' => $menuActiveItem,  'user' => $user, 'profile' => $profile,'airports'=>$airports, 'place' => $place, 'cities' => $cities, 'farefamilies' => $farefamilies, 'bc_types' => $bc_types, 'feesplaces' => $feesplaces, 'currencies' => $currencies, 'schedules'=>$schedules, 'airlines'=> $airlines    ], $this->successStatus); 


    }




 public function getService($id) {
 	     $user = Auth::user();
         $user_id =  Auth::id();
         $profile = Profile::where('user_id','=',$user_id)->first();
         $service = Service::findOrFail($id);
         $menuActiveItem['orders'] = 1;
         $companies = Company::all(); 

 return response()->json(['companies' => $companies, 'profile' => $profile, 'menuActiveItem' => $menuActiveItem,  'user' => $user, 'profile' => $profile,'service'=>$service ], $this->successStatus);

 }



 public function getServiceExchange($id) {

         $order = Order::where('id', '=', $id)->first();



 return response()->json(['order' => $order], $this->successStatus);


 }


 public function postEditServiceExchange(Request $request) {

  $user = Auth::user();
  $user_id =  Auth::id();
  $user_email =  Auth::user()->email;
  $menuActiveItem['orders'] = 1;
  $profile = Profile::where('user_id','=',$user_id)->first();
           
  $passenger_id = intval($request->get('passenger_id'));
  $passenger = Passenger::where('id','=',$passenger_id)->first();
  $passenger->name = $request->get('name');
  $passenger->surname = $request->get('surname');

  $passenger->country_id = $request->get('country_id');
  $passenger->updated_at = Carbon::now();
  $passenger->sex_u = $request->get('sex_u');

  $passenger->country_id = $request->get('country_id');
  $passenger->updated_at = Carbon::now();
  $passenger->sex_u = $request->get('name');

  $passenger->user_id =$user_id;
  $passenger->type_documents =$request->get('type_documents');
  $passenger->type_passengers =$request->get('type_passengers');
  $passenger->passport_number =$request->get('passport_number');
  $passenger->save();
  $order_n = intval($request->get('order_n'));  
  $order = Order::where('order_n','=', $order_n)->first();
  $order->order_n = intval($request->get('order_n'));
  $order->status = intval($request->get('status'));
  $order->gds_ticket = $request->get('gds_ticket'); 
  $order->company_registry_id = intval($request->get('company_id'));
  $order->user_id = $user_id; 
  $order->order_summary =  $request->get('order_summary');
  $order->order_currency = intval($request->get('order_currency'));
  $order->passengers = intval($request->get('passenger_id'));
  $order->services = intval($request->get('services'));
  $order->time_limit = intval($request->get('time_limit'));
  $order->type_payment = intval($request->get('type_payment'));
  $order->email = $request->get('email');
  $order->phone = $request->get('phone');
  $order->order_n = $request->get('order_n');
  $order->comment = $request->get('comment');
  $order->conversation_id =intval($request->get('conversation_id'));
  $order->created_id=$user_id; 
  $order->updated_id=$user_id; 
  $order->updated_at =  Carbon::now();
  $order->save();

  $ticket_id = intval($request->get('ticket_id'));
  $ticket =  Ticket::where('id','=',$ticket_id)->first();
  $ticket->ticket_number= intval($request->get('ticket_number'));
  $ticket->rate_fare = $request->get('rate_fare');
  $ticket->tax_fare = $request->get('tax_fare');
  $ticket->types_fees_id =  intval($request->get('types_fees_id'));
  $ticket->summ_ticket =  $request->get('summ_ticket');
  $ticket->passengers_id = intval($request->get('passengers_id'));
  $ticket->types_fees_fare = $request->get('types_fees_fare');
  $ticket->created_id=$user_id; 
  $ticket->updated_id=$user_id; 
  $ticket->updated_at =  Carbon::now();
  $ticket->save();

  $service_id = intval($request->get('service_id'));
  $service =  Service::where('id','=',$service_id)->first();
  $service->departure_at = $request->get('departure_at');
  $service->arrival_at =$request->get('arrival_at'); 

  $service->airlines_id = intval($request->get('airlines_id'));
  $service->service_fare_families_id = intval($request->get('fare_families_id'));
  $service->service_fare_families_crane = $request->get('fare_families_crane');
  $service->service_status =  $request->get('status');
  $service->service_schedule_id =  intval($request->get('schedule_id'));
  $service->updated_at ==  Carbon::now();
  $service->segment_number =  intval($request->get('segment_number'));
  $service->summary_summ =  $request->get('summary_summ');
  $service->created_id=$user_id; 
  $service->updated_id=$user_id; 
  $service->save();

   $schedule_id = intval($request->get('schedule_id'));
   $schedule =  Schedule::where( 'id', '=', $schedule_id)->first();
   $schedule->departure_at = $request->get('departure_at');
   $schedule->arrival_at = $request->get('arrival_at');
   $schedule->is_transplantation = $request->get('is_transplantation');
   $schedule->flight_duration = $request->get('flight_duration');
   $schedule->monday = $request->get('monday');
   $schedule->tuesday =  $request->get('tuesday');
   $schedule->wednesday =  $request->get('wednesday');
   $schedule->thursday =  $request->get('thursday');
   $schedule->friday =  $request->get('friday');
   $schedule->saturday =  $request->get('saturday');
   $schedule->sunday =  $request->get('sunday');
   $schedule->airlines_id = intval($request->get('airlines_id'));
   $schedule->created_id=$user_id; 
   $schedule->updated_id=$user_id; 
   $schedule->created_at =  Carbon::now();
   $schedule->period_begin_at = $request->get('period_begin_at');
   $schedule->period_end_at = $request->get('period_end_at');
   $schedule->flights = $request->get('flights');
   $schedule->leg = $request->get('leg');
   $schedule->bc_types_id =intval($request->get('bc_types_id'));
   $schedule->time_departure_at =$request->get('$request->time_departure_at');
   $schedule->time_arrival_at =  $request->get('$request->time_arrival_at');
   $schedule->next_day = $request->get('$request->next_day');
   $schedule->save();



  $providers = Prov::all(); 
  $companies = Company::all(); 



 $data = [

   'order_n' => $request->get('order_n'),
   'bookingReferenceID' => $request->get('bookingReferenceID')  

];
 

\Mail::send('emails.service_exchange', $data, function($message) use ($user_email)

{
$message->from(env('MAIL_FROM'));
$message->to($user_email)->cc(env('MAIL_FROM'), env('MAIL_NAME'));
$message->subject('Обмен услуг совершен');
});


 


 return response()->json(['companies' => $companies, 'profile' => $profile, 'menuActiveItem' => $menuActiveItem,  'user' => $user, 'profile' => $profile,'order'=>$order, 'passenger'=>$passenger,'ticket'=>$ticket, 'providers'=> $providers, 'schedule'=> 
   $schedule, 'service'=>$service ], $this->successStatus);


 }


public function postEditOrder(Request $request) {
  
  $user = Auth::user();
  $user_id =  Auth::id();
  $profile = Profile::where('user_id','=',$user_id)->first();
           

  $order_id = intval($request->get('order_id'));
  $order = Order::where('id','=',$order_id)->first();
  $order->order_n = intval($request->get('order_n'));
  $order->status = intval($request->get('status'));
  $order->user_id = $user_id; 
  $order->created_id=$user_id; 
  $order->updated_id=$user_id; 
  $order->updated_at =  Carbon::now();
  $order->save();



  $service_id = intval($request->get('service_id'));
  $service =  Service::where('id','=',$service_id)->first();
  $service->pnr =$request->get('pnr'); 
  $service->time_limit = intval($request->get('time_limit'));
  $service->updated_at =  Carbon::now();
  $service->created_id=$user_id; 
  $service->updated_id=$user_id; 
  $service->save();


  $ticket_id = intval($request->get('ticket_id'));
  $ticket =  Ticket::where('id','=',$ticket_id)->first();
  $ticket->ticket_number= intval($request->get('ticket_number'));
  $ticket->rate_fare = $request->get('rate_fare');
  $ticket->tax_fare = $request->get('tax_fare');
  $ticket->type_fees_fare = $request->get('type_fees_fare');
  $ticket->created_id=$user_id; 
  $ticket->updated_id=$user_id; 
  $ticket->updated_at =  Carbon::now();
  $ticket->save();


 return response()->json([ 'profile' => $profile, 'user' => $user, 'profile' => $profile,'order'=>$order, 'ticket'=>$ticket, 'service'=>$service ], $this->successStatus);


 }




public function postExchangedStatus(Request $request) {


$status = 4;
$service_id = intval($request->get('service_id'));
$service = Service::where('id','=',$service_id)->first();
$service->service_status = $status;
$service->save();

}



public function postBlockedStatus(Request $request) {

       

$status = 3;
$service_id = intval($request->get('service_id'));
$service = Service::where('id','=',$service_id)->first();
$service->service_status = $status;
$service->save();

}


public function postInworkStatus(Request $request) {



$status = 6;
$service_id = intval($request->get('service_id'));
$service = Service::where('id','=',$service_id)->first();
$service->service_status = $status;
$service->save();

}



public function postIssuedStatus(Request $request){



$status = 5;
$service_id = intval($request->get('service_id'));
$service = Service::where('id','=',$service_id)->first();
$service->service_status = $status;
$service->save();

}







public function postIssuedBlockStatus(StatusRequest $request){


$status = 7;
$service_id = intval($request->get('service_id'));
$service = Service::where('id','=',$service_id)->first();
$service->service_status = $status;
$service->save();

}




public function postElemenatedStatus(Request $request){


$request->validate([

                'service_id' => 'required'

            ], [


                'service_id.required' => 'Service ID обязательный '

            ]);


$status = 0;
$service_id = intval($request->get('service_id'));
$service = Service::where('id','=',$service_id)->first();
$service->service_status = $status;
$service->save();

}





public function postCanceledStatus(Request $request){

$request->validate([

             

                'service_id' => 'required'

            ], [


                'service_id.required' => 'Service ID обязательный '

            ]);




$status = 0;
$service_id = intval($request->get('service_id'));
$service = Service::where('id','=',$service_id)->first();
$service->service_status = $status;
$service->save();

}







 public function getAllServices() {
         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $services = Service::all();
         $menuActiveItem['orders'] = 1;
         $companies = Company::all(); 
         $farefamilies = FareFamily::all();
         $typefees =  TypeFee::all();

 return response()->json(['companies' => $companies, 'profile' => $profile, 'menuActiveItem' => $menuActiveItem,  'user' => $user, 'profile' => $profile,'services'=>$services,'farefamilies'=>$farefamilies, 'typefees'=>$typefees ], $this->successStatus);

 }


public function addService() {

    $user = Auth::user();
    $user_id =  Auth::user()->id;
    $profile = Profile::where('user_id','=',$user_id)->first();
    $menuActiveItem['orders'] = 1;
    $companies = Company::all(); 
    $cities = City::all();
    $services = Service::all();
    $airoports = Aeroport::all();
    $farefamilies = FareFamily::all();
    $typefees =  TypeFee::all();
    $companyUsers = User::where('company_id', Auth::user()->company_id)->get()->toArray();
    foreach ($companyUsers as $key => $value) {
      $usersIds[] = $value['id'];
    }
    $managers = Profile::whereIn('user_id', $usersIds)->get()->toArray();

 return response()->json(['companies' => $companies, 'profile' => $profile, 'menuActiveItem' => $menuActiveItem,  'user' => $user, 'profile' => $profile,'services'=>$services,'cities' =>$cities,'airoports'=> $airoports, '$companyUsers'=>$companyUsers,'$managers'=> $managers, 'farefamilies'=>$farefamilies, 'typefees'=>$typefees ], $this->successStatus);

}





public function edit(Request $request){
  $order = Order::where('id' , $request->id)->first();
  if(isset($request->email)){$order->email = $request->email ;}
  if(isset($request->phone)){$order->phone = $request->phone ;}
  if(isset($request->comment)){$order->comment = $request->comment ;}
  if(isset($request->time_limit)){$order->time_limit = $request->time_limit ;}
  if(isset($request->type_payment)){$order->type_payment = $request->type_payment;} 
  if(isset($request->company_registry_id)){$order->company_registry_id = $request->company_registry_id;} 
  if(isset($request->user_id)){$order->user_id = $request->user_id;}  
  $order->save();
  return response()->json(['order' => $order], $this->successStatus)->header('Access-Control-Allow-Origin', '*');
}




public function setstatus(Request $request)
{
$user = Auth::user();
 $order = Order::where('id', '=', $request->id)->first();
 if(isset($request->status)){
  if($request->status == 1){
        $this->middleware(['role_or_permission:orders.open-order']);
  }
   if($request->status == 2){
        $this->middleware(['role_or_permission:orders.close-order']);
  }
  $order->status = $request->status ;

}
 $order->save();
  return response()->json(['order' => $order], $this->successStatus)->header('Access-Control-Allow-Origin', '*');
}

public function getFees() {

         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $feesplaces = FeePlace::all();
         $menuActiveItem['orders'] = 1;
         $typefees =  TypeFee::all();
         $cities = City::all();
         $airlines = Airline::all();
         $airports = Aeroport::all();
         $farefamilies = FareFamily::all();


return response()->json(['feesplaces' => $feesplaces, 'profile' => $profile, 'menuActiveItem' => $menuActiveItem, 'typefees' => $typefees, 'cities' => $cities, 'airlines' => $airlines,  'farefamilies' => $farefamilies, 'airports' => $airports], $this->successStatus); 


}

public function postBlockFinal(Request $request) {
  $user = Auth::user();
  $user_id =  Auth::user()->id;
  $user_email = Auth::user()->email;
  $passenger_id = intval($request->get('passenger_id'));
  $passenger = Passenger::where('id','=',$passenger_id)->first();
  $passenger->name = $request->get('name');
  $passenger->surname = $request->get('surname');
  $passenger->country_id = $request->get('country_id');
  $passenger->updated_at = Carbon::now();
  $passenger->sex_u = $request->get('sex_u');
  $passenger->user_id =$user_id;
  $passenger->type_documents =$request->get('type_documents');
  $passenger->type_passengers =$request->get('type_passengers');
  $passenger->passport_number =$request->get('passport_number');
  $passenger->save();

  $service_id = intval($request->get('service_id'));
  $service =  Service::where('id','=',$service_id)->first();
  $service->order_id= intval($request->get('order_id'));
  $service->service_id = intval($request->get('service_id'));
  $service->departure_at = intval($request->get('departure_at'));
  $service->arrival_at = $request->get('arrival_at');
  $service->type_flight= intval($request->get('type_flight'));
  $service->orders_system = intval($request->get('orders_system'));
  $service->service_status =intval($request->get('service_status'));
  $service->booking_date = $request->get('booking_date');
  $service->summary_summ =$request->get('summary_summ');
  $service->passenger_id =$request->get('passenger_id');
  $service->pnr =$request->get('pnr');
  $service->provider_id =intval($request->get('provider_id'));
  $service->segment_number =intval($request->get('segment_number'));
  $service->schedule_id =intval($request->get('schedule_id'));
  
  $service->fare_families_id =intval($request->get('fare_families_id'));
  
  $service->airlines_id =intval($request->get('airlines_id'));
  $service->baggage_allowance =$request->get('baggage_allowance');
  $service->type_bc_id =intval($request->get('type_bc_id'));
  $service->tickets_id =intval($request->get('tickets_id'));
  $service->fare_families_crane =$request->get('fare_families_crane');
  $service->user_id=$user_id; 
  $service->created_id=$user_id; 
  $service->updated_id=$user_id; 
  $service->created_at =Carbon::now();
  $service->save();



    $data = [

  'passenger_name'=>$request->get('name'),
  'passenger_surname' => $request->get('surname'),
  'passenger_sex' => $request->get('sex_u'),
  'service_id' => $request->get('service_id'),
  'service_summary_summ' =>$request->get('summary_summ')


  ];



\Mail::send('emails.block_fin', $data, function($message) use ($user_email)
{
$message->from(env('MAIL_FROM'));
$message->to(env('MAIL_FROM'), env('MAIL_NAME'))->cc($user_email);
$message->subject('Новый заказ закончен');
});


  return redirect('blocks');

}

public function GenerateTicket(Request $request){
    	 $user = Auth::user();
       $user_id =  Auth::user()->id;
      $user_email = Auth::user()->email;
    	$name = $request->image_position;
    	$file = $request->file('file');

    	$ext = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
 

  $ticket_id = intval($request->get('ticket_id'));
  $ticket =  Ticket::where('id','=',$ticket_id)->first();
  $ticket_number = $ticket->ticket_number;
  $rate_fare = $ticket->rate_fare;
  $types_fees_fare = $ticket->types_fees_fare;
  $tax_fare = $ticket->tax_fare;
  $types_fees_id =$ticket->types_fees_id;
  $summ_ticket = $rate_fare + $tax_fare; 

  $passenger_id = intval($request->get('passenger_id'));
  $passenger = Passenger::where('id','=',$passenger_id)->first();
  $passenger_name = $passenger->name; 
  $surname = $passenger->surname; 
  $patronymic = $passenger->patronymic;
  $type_documents = $passenger->type_documents; 
  $type_passengers=$passenger->type_passengers;
  $passport_number =$passenger->passport_number;
  $type_passengers = $passenger->type_passengers;


  $bookingReferenceID = $request->get('bookingReferenceID');


  $service_pnr = $request->get('service_pnr');

  $service_id = intval($request->get('service_id'));

  $service =  Service::where('id','=',$service_id)->first();

  $departure_at = $service->departure_at;
 
  $arrival_at = $service->arrival_at; 


  $airlines_id = $service->airlines_id;

  $service_fare_families_id = $service->fare_families_id;

  $service_fare_families_crane = $service->fare_families_crane;
  
  $service_status = $service->status;

  $service_schedule_id = $service->schedule_id;

  $register_date = $service->created_at;

  $segment_number = $service->segment_number;

  $summary_summ = $service->summary_summ;

  $company_id = intval($request->get('company_id'));

   $etp = ETP::where('company_id','=',$company_id)->first();
   $etp_name =$etp->name; 
   $etp_status = $etp->status;
   $company_id = $etp->company_id;
  
  $airline = Airline::where('airlines_id','=',$airlines_id)->first();
  $short_aviacompany_name_ru = $airline->short_aviacompany_name_ru;

  $city = City::where('name','=',$departure_at)->first();
  $city_name =$city->name; 
    

      $path = '/storage'.substr($file->storeAs('public/advertising/electronic_tickets_pictures', $etp_name.'.'.$ext), 6, 1024);
      ETP::where('name', $etp_name)->delete();
      $return = ETP::create(['name' => $etp_name, 'path' => $path, 'status' => true, 'created_id' => Auth::id(), 'updated_id' => Auth::id()]);
    	
 $data = [

  'ticket_number' => $ticket_number,
  'rate_fare' =>$rate_fare, 
  'tax_fare'=> $tax_fare, 
  'passenger_name'  => $passenger_name, 
  'summ_ticket' => $summ_ticket, 
  'surname' =>   $surname , 
  'types_fees_fare' => $types_fees_fare,
  'type_documents' =>$type_documents,
  'passport_number'=>$passport_number,
  'type_passengers'=>$type_passengers,
  'departure_at' => $departure_at,
  'arrival_at' => $arrival_at, 
  'service_pnr'=>$service_pnr,
  'service_status' => $service_status,
  'register_date' =>  $register_date,
  'segment_number' => $segment_number,
  'summary_summ' =>   $summary_summ,
  'path'=> $path
];
 


\Mail::send('emails.new_ticket', $data, function($message) use ($user_email)
{
$message->from(env('MAIL_FROM'));
$message->to($user_email)->cc(env('MAIL_FROM'), env('MAIL_NAME'));
$message->subject('Новый билет создан');
});




  $curl = curl_init();

  curl_setopt_array($curl, array(
  CURLOPT_URL => "https://tua-stage.crane.aero/craneota/CraneOTAService?xsd=1",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => 
  "<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:impl=\"http://impl.soap.ws.crane.hititcs.com/\">    <soapenv:Header/> 

        <soapenv:Body> 
        <impl:CreateBooking>        
         <AirBookingRequest>                

     <clientInformation>              
    <clientIP>".$_ENV['CRANE_CLIENT_IP']."</clientIP>
    <member>".$_ENV['CRANE_MEMBER']."</member>
    <password>".$_ENV['CRANE_PASSWORD']."</password>
    <userName>".$_ENV['CRANE_USERNAME']."</userName>            
    <preferredCurrency>TMT</preferredCurrency>            
    </clientInformation> 


       <airItinerary>                    

       <bookOriginDestinationOptions>                        

       <bookOriginDestinationOptionList>                            

       <bookFlightSegmentList>                                

       <actionCode>NN</actionCode>                                

       <addOnSegment/>                                

       <bookingClass>                                    

       <resBookDesigCode>C</resBookDesigCode>                                </bookingClass>                                

       <fareInfo>                                    

       <fareReferenceID>".$bookingReferenceID."</fareReferenceID>                                

       </fareInfo>                                

       <flightSegment>                                   
          <airItinerary>                    
          <bookOriginDestinationOptions>                        
          <bookOriginDestinationOptionList>                           
            <bookFlightSegmentList>                                
            <actionCode>NN</actionCode>                                
            <addOnSegment/>                                
            <bookingClass>                                    
            <cabin>BUSINESS</cabin>                                    
          <resBookDesigCode>C</resBookDesigCode>                                    
          <resBookDesigQuantity>10</resBookDesigQuantity>             
          </bookingClass>                                
          <fareInfo>                                    
          <cabinClassCode>C</cabinClassCode> 
          <fareGroupName>BUSINESS</fareGroupName>
          <fareReferenceCode>COW 43</fareReferenceCode>
          <fareReferenceID>5d140f6ef5857ba6be49ba88d7220668fc1584f655f7abc5dfa1e01742b2a83e5eeeb1968eea19aa45fcd8be699a0409fdfda6f494e6b9cac644a5c8895565f9</fareReferenceID>
          <fareReferenceName>C12OW</fareReferenceName>
          <flightSegmentSequence>1</flightSegmentSequence>
          <resBookDesigCode>C</resBookDesigCode>
          </fareInfo>                                

          <flightSegment>                                    
          <arrivalAirport>                                        
          <cityInfo>                                            
          <city>                                                
          <locationCode>ALA</locationCode>
          <locationName>Almaty</locationName>
          <locationNameLanguage>EN</locationNameLanguage>
          </city>                                            
          <country>                                               
          <locationCode>KZ</locationCode>\n                                               
          <locationName>Kazakhstan</locationName>\n                                                
          <locationNameLanguage>EN</locationNameLanguage>\n
           <currency>\n                                                    
           <code>KZT</code>\n                                              
           </currency>\n                                            
           </country>\n                                        
           </cityInfo>\n                                        
           <codeContext>IATA</codeContext>\n                             
           <language>EN</language>\n                                       
           <locationCode>ALA</locationCode>\n
           <locationName>Almaty</locationName>\n
           </arrivalAirport>\n                                    
           <arrivalDateTime>2019-03-18T00:45:00+05:00</arrivalDateTime>\n
            <departureAirport>\n                                       
             <cityInfo>\n                                            
             <city>\n                                                
             <locationCode>ASB</locationCode>\n                                                
             <locationName>Ashgabad</locationName>\n                                                
             <locationNameLanguage>EN</locationNameLanguage>\n                                            
             </city>\n                                            
             <country>\n                                                
             <locationCode>TM</locationCode>\n
             <locationName>Turkmenistan</locationName>\n
             <locationNameLanguage>EN</locationNameLanguage>\n                                                
              <currency>\n                                                    
              <code>TMT</code>\n                                                </currency>\n  
         </country>\n                                        
         </cityInfo>\n                                        
         <codeContext>IATA</codeContext>\n                                        
         <language>EN</language>\n  
         <locationCode>ASB</locationCode>\n
         <locationName>Ashgabat International</locationName>\n
         </departureAirport>\n                                   
          
         <departureDateTime>2019-03-17T21:00:00+05:00</departureDateTime>\n      
          <equipment>\n      

          <airEquipType>B737-800_16C/144Y</airEquipType>\n

          <changeofGauge>false</changeofGauge>\n

          </equipment>\n    

          <stopQuantity>0</stopQuantity>\n

           <accumulatedDuration/>\n 

            <airline>\n                                        
            <code>T5</code>\n                                    
            </airline>\n       

            <codeshare>false</codeshare>\n                                   
             <distance>0</distance>\n   

              <flightNumber>715</flightNumber>\n                                   
               <flightSegmentID/>\n   

               <flownMileageQty>0</flownMileageQty>\n                                    
               <groundDuration/>\n      

               <journeyDuration>PT2H55M</journeyDuration>\n                                    
               <onTimeRate>-1</onTimeRate>\n                                    
               <sector>INTERNATIONAL</sector>\n                                    
               <secureFlightDataRequired>false</secureFlightDataRequired>\n                                    
               <ticketType>PAPER</ticketType>\n 
                <trafficRestriction>\n
                <code/>\n  
                 <explanation/>\n    
                  </trafficRestriction>\n                                
                  </flightSegment>\n                                

                  <sequenceNumber/>\n                            

                  </bookFlightSegmentList>\n                        
                  </bookOriginDestinationOptionList>\n                   
                  </bookOriginDestinationOptions>\n                
                  </airItinerary>\n         

                <airTravelerList>\n                   
                <accompaniedByInfant/>\n                    
                <birthDate>1985-06-10</birthDate>\n                   
                <gender>M</gender>\n                   
                <hasStrecher/>\n                   
                <parentSequence/>\n 
                <passengerTypeCode>ADLT</passengerTypeCode>\n 
                <passportNumber>A-23422243</passportNumber>\n
                <personName>\n                        
                <givenName>AAA</givenName>\n                        
                <shareMarketInd/>\n                        
                <surname>TEST</surname>\n
                 </personName>\n                    
               <requestedSeatCount>1</requestedSeatCount>\n
                <shareMarketInd/>\n                   
                <socialSecurityNumber>123423433</socialSecurityNumber>\n    
                <unaccompaniedMinor/>\n  
                </airTravelerList>\n                
                 <contactInfoList>\n                   
                <adress>\n                        
                 <countryCode>TR</countryCode>\n
                <formatted/>\n                        
                <shareMarketInd/>\n                   
                </adress>\n                    
                <email>\n                        
                <email>test@test.com</email>\n   
                <markedForSendingRezInfo/>\n
                 <preferred/>\n                       
                <shareMarketInd/>\n                    
                </email>\n      


           <personName>\n                        
           <givenName>BBB</givenName>\n                        
            <shareMarketInd/>\n                        
            <surname>TEST</surname>\n 
            </personName>\n                    
            <phoneNumber>\n                        
            <areaCode>555</areaCode>\n                        
            <countryCode>+90</countryCode>\n                        
            <markedForSendingRezInfo/>\n                        
            <preferred/>\n                        
            <shareMarketInd/>\n                        
            <subscriberNumber>4443322</subscriberNumber>\n                    
               </phoneNumber>\n                    
              <shareMarketInd/>\n                    
              <useForInvoicing/>\n                
              </contactInfoList>\n                
           <requestPurpose>MODIFY_PERMANENTLY</requestPurpose>\n 
             
             <specialRequestDetails>\n                    
             <otherServiceInformationList>\n                        
             <otherServiceInformationList>\n                            
           <airTravelerSequence>0</airTravelerSequence>\n 
           <code>OSI</code>\n                            
              <explanation>CTCB 90 555 4443322</explanation>\n
              <flightSegmentSequence>0</flightSegmentSequence>\n</otherServiceInformationList>\n                        
             <otherServiceInformationList>\n 
            <airTravelerSequence>0</airTravelerSequence>\n
           <code>OSI</code>\n                            
           <explanation>CTCETEST@TEST.COM</explanation>\n
          <flightSegmentSequence>0</flightSegmentSequence>\n  
         </otherServiceInformationList>\n 
        </otherServiceInformationList>\n
       </specialRequestDetails>\n 
      </AirBookingRequest>\n        
     </impl:CreateBooking>\n    
     </soapenv:Body>\n
   </soapenv:Envelope>",

  CURLOPT_HTTPHEADER => array(
    "Content-Type: text/xml",
    "Postman-Token: 9dc66f5e-e834-417d-ae49-248bf47cfd78",
    "cache-control: no-cache"
  ),
));

$data= curl_exec($curl);
$responses  = json_encode($data);
curl_close($curl);

 
  $pdf = PDF::loadView('orders.eticket', $data);

  $pdf->save(storage_path().'eticket.pdf');

  

}






public function postAddPassanger(Request $request) {

  $user = Auth::user();
  $user_id =  Auth::id();
  $passenger_id = intval($request->get('passenger_id'));
  $passenger = Passenger::where('id','=',$passenger_id)->first();
  $passenger->name = $request->get('name');
  $passenger->surname = $request->get('surname');
  $passenger->patronymic = $request->get('patronymic');
  $passenger->country_id = $request->get('country_id');
  $passenger->updated_at = Carbon::now();
  $passenger->sex_u = $request->get('sex_u');
  $passenger->user_id =$user_id;
  $passenger->type_documents =$request->get('type_documents');
  $passenger->type_passengers =$request->get('type_passengers');
  $passenger->passport_number =$request->get('passport_number');
  $passenger->save();


}



public function postTicketAdd(Request $request) {
    
  $user = Auth::user();
  $user_id =  Auth::user()->id;
  $user_email  =  Auth::user()->email;
  $ticket =  new Ticket;
  $ticket->ticket_number= intval($request->get('ticket_number'));
  $ticket->rate_fare = $request->get('rate_fare');
  $ticket->tax_fare = $request->get('tax_fare');
  $ticket->types_fees_id =  intval($request->get('types_fees_id'));
  $ticket->summ_ticket =  $request->get('summ_ticket');
  $ticket->passengers_id = intval($request->get('passengers_id'));
  $ticket->types_fees_fare = $request->get('types_fees_fare');
  $ticket->created_id=$user_id; 
  $ticket->updated_id=$user_id; 
  $ticket->created_at =  Carbon::now();
  $ticket->save();

  
 $data = [

  'ticket_number' => intval($request->get('ticket_number')),
  'rate_fare' =>$request->get('rate_fare'), 
  'tax_fare'=> $request->get('tax_fare'), 
  'user_id'  => $user_id, 
  'types_fees_id' => intval($request->get('types_fees_id')), 
  'summ_ticket' => intval($request->get('summ_ticket')), 
  'passengers_id' => intval($request->get('passengers_id')), 
  'types_fees_fare' => intval($request->get('types_fees_fare'))
 

];
 

\Mail::send('emails.ticket_add', $data, function($message) use ($user_email)
{
$message->from(env('MAIL_FROM'));
$message->to($user_email)->cc(env('MAIL_FROM'), env('MAIL_NAME'));
$message->subject('Новый билет создан');
});



 }






public function postServiceAdd(Request $request) {
    
  $user = Auth::user();
  $user_id =  Auth::user()->id;
  $user_email = Auth::user()->email;

  $service = new Service;
  $service->order_id= intval($request->get('order_id'));
  $service->service_id = intval($request->get('service_id'));
  $service->departure_at = intval($request->get('departure_at'));
 
  $service->arrival_at = $request->get('arrival_at');
  $service->type_flight= intval($request->get('type_flight'));
  $service->orders_system = intval($request->get('orders_system'));
  $service->service_status = intval($request->get('service_status'));

  $service->booking_date = $request->get('booking_date');

  $service->summary_summ =$request->get('summary_summ');
  
  $service->passenger_id =$request->get('passenger_id');

  $service->pnr =$request->get('pnr');

  $service->provider_id =intval($request->get('provider_id'));

  $service->segment_number =intval($request->get('segment_number'));

  $service->schedule_id =intval($request->get('schedule_id'));
  
  $service->fare_families_id =intval($request->get('fare_families_id'));
  
  $service->airlines_id =intval($request->get('airlines_id'));
  $service->baggage_allowance =$request->get('baggage_allowance');
  $service->type_bc_id =intval($request->get('type_bc_id'));
  $service->tickets_id =intval($request->get('tickets_id'));
  $service->fare_families_crane =$request->get('fare_families_crane');
  $service->user_id=$user_id; 
  $service->created_id=$user_id; 
  $service->updated_id=$user_id; 
  $service->created_at =  Carbon::now();
  $service->save();

 $last_id = $service->id;


 $service =Service::where('id','=',$last_id)->first(); 
 $order_id = $service->order_id;

 $order = Order::where('id','=', $order_id)->first();
 $company_id = $order->company_registry_id;

 $data = [

  'order_id' => intval($request->get('order_id')),
  'service_id' =>$request->get('service_id'), 
  'departure_at'=> $request->get('departure_at'), 
  'user_id'  => $user_id, 
  'arrival_at' => intval($request->get('arrival_at')), 
  'pnr' => intval($request->get('pnr')), 
  'provider_id' => intval($request->get('provider_id')), 
   'segment_number' => intval($request->get('segment_number')), 
  'schedule_id' => intval($request->get('schedule_id')), 
  'fare_families_id' => intval($request->get('fare_families_id')),

  'airlines_id' => intval($request->get('airlines_id')), 
   'baggage_allowance' => intval($request->get('baggage_allowance')), 
  'type_bc_id' => intval($request->get('type_bc_id')), 
  'fare_families_crane' => intval($request->get('fare_families_crane'))


];



  $mail_list = Mailing::where([[ 'company_registry_id', '=', Auth::user()->company_id], [ "type_mailing", '=', 6], ['status', '=', true]])->get();


   foreach($mail_list as $mails){

   $mail_list_id = $mail_list->id;


  $mailing_emails = MailingList::where( 'mailing_id', '=', $mail_list_id )->get();

 
 foreach($mailing_emails as $mailing){
         
        
         $mailing_email = $mailing->mail;



\Mail::send('emails.service_add', $data, function($message) use ($mailing_email)


{

$message->from(env('MAIL_FROM'));
$message->to($mailing_email)->cc(env('MAIL_FROM'), env('MAIL_NAME'));
$message->subject('Новый сервис создан');
});

}

}

}





}
