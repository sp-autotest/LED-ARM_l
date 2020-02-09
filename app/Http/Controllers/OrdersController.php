<?php

namespace App\Http\Controllers;

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
use App\Provider;
use App\Accounts;
use PDF;
use App\ElectronicTicketsPicture as ETP;
use  App\Http\Requests\SearchOrderRequest;
use  App\Http\Requests\AddOrderRequest;
use  App\Http\Requests\EditOrderRequest;
use  App\Http\Requests\AddTicketRequest;
use  App\Http\Requests\AddServiceRequest;
use  App\Http\Requests\CancelServiceRequest;
use  App\Http\Requests\AddPassengerRequest;
use  App\Http\Requests\AddBlockFinalRequest;



class OrdersController extends Controller
{
  
   public $successStatus = 200;
   public $errorStatus = 400;


    public function edit(Request $request)
    {
      $order = Order::where('id', '=', $request->id)->first();
      if(isset($request->type_payment)){$order->type_payment = $request->type_payment;} 
      if(isset($request->company_registry_id)){$order->company_registry_id = $request->company_registry_id;} 
      if(isset($request->user_id)){$order->user_id = $request->user_id;} 
      if(isset($request->comment)){$order->comment = $request->comment;} 
      $order->save();
      return $order;
    }
 public function index(Request $request)
    {
        $this->middleware(['permission:orders.index']);

        $clientIP = \Request::getClientIp(true);
        $user = User::where('id', '=',Auth::user()->id)->with(['admincompany', 'admincompany.childs', 'admincompany.currency'])->first();
        $user_id =  $user->id;
        $user_email = $user->email;
        $companyUsers = User::where('company_id', '=', Auth::user()->company_id)->get();
        $profile = Profile::where('user_id','=',$user_id)->first();
        $menuActiveItem['orders'] = 1;
        $limit = isset($request->limit)?$request->limit:10;
        
        if($user->hasPermissionTo('orders.see-all-orders', 'api')){
         
          $compan = Company::where('id', '=', Auth::user()->company_id)->with('childs')->select('id')->first()->toArray();
          $company_ids = $this->getChild($compan);
          $orders = Order::whereIn('company_registry_id', $company_ids)->with(['createdby', 'user', 'services',  'services.flight', 'services.flight.flightplaces', 'services.flight.flightplaces.schedule'])->orderBy('created_at')->paginate($limit);
          
        }elseif($user->hasPermissionTo('orders.see-your-orders', 'api')){
           $orders = Order::where('company_registry_id', '=', Auth::user()->company_id)->with(['createdby', 'user', 'services',  'services.flight', 'services.flight.flightplaces', 'services.flight.flightplaces.schedule'])->orderBy('created_at')->paginate($limit);
        }else{
          return response()->json(['error' => '403', 'status' => 'ERROR', 'type' => 'ACCESS'], $this->errorStatus)->header('Access-Control-Allow-Origin', '*');
        }

        $count_orders= Order::get()->count();

        $tickets = Ticket::all();
        $companies = Company::all();


       return response()->json(['companies' => $companies, 'companyusers' => $companyUsers, 'profile' => $profile, 'menuActiveItem' => $menuActiveItem, 'tickets' => $tickets, 'user' => $user, 'profile' => $profile,'orders'=>$orders ], $this->successStatus);
  

    
    }

    public function getChild($data){
      
      $ids[] = $data['id'];

      if(count($data['childs']) > 0){
       foreach ($data['childs'] as $key => $value) {
         $ids = array_merge($ids, $this->getChild($value));
       }
      }
      return $ids;
    }

    public function search(SearchOrderRequest $request) {
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
         $companies = Company::paginate(10); 
         $feeplaces = FeePlace::paginate(10);
         $companies =  Company::paginate(10);
         $typefees =  TypeFee::paginate(10);
         $cities = City::paginate(10);
         $service = Service::paginate(10);
         $countries = Country::paginate(10);
         $airlines = Airline::paginate(10);
         $airoports = Aeroport::paginate(10);
         $farefamilies = FareFamily::paginate(10);
         $airports = Aeroport::paginate(10);
         $bc_types = BCType::paginate(10);
         $places = FlightPlace::paginate(10);
         $schedules =  Schedule::paginate(10);
         $airports = Aeroport::paginate(10);
         $currencies = Currency::paginate(10);
         $passengers = Passenger::paginate(10);
   

        

  return response()->json(['companies' => $companies, 'profile' => $profile, 'menuActiveItem' => $menuActiveItem,  'user' => $user, 'profile' => $profile,'order'=>$order, 'places' => $places, 'cities' => $cities, 'airoports' => $airoports, 'farefamilies' => $farefamilies, 'bc_types' => $bc_types, 'farefamilies' => $farefamilies, 'feeplaces' => $feeplaces, 'currencies' => $currencies, 'schedules'=>$schedules, 'services'=>'services','passengers' =>$passengers, 'airlines'=> $airlines    ], $this->successStatus); 


 }


public function cancelOrder (CancelServiceRequest $request) {

$pnr = $request->get('pnr');
$bookingReferenceID = $request->get('bookingReferenceID');
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

   <fareReferenceID>".$bookingReferenceID."</fareReferenceID>            
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
$user = Auth::user();
$user_id =  Auth::user()->id;

$profile = Profile::where('user_id','=',$user_id)->first();
$order = Order::where('pnr','=',$pnr)->first();
$order->status = 1;
$order->user_id=$user_id; 
$order->created_id=$user_id; 
$order->updated_id=$user_id; 
$order->updated_at =  Carbon::now();
$order->save();

return redirect('orders');


}





public function postOrderAdd(AddOrderRequest $request) {
    
  $user = Auth::user();
  $user_id =  Auth::user()->id;
  $payway =intval($request->get('payway'));
  $company_id = intval($request->get('company_registry_id'));
  
if ($payway == 0) {

$cp = Company::findOrFail($company_id);

$pdf = PDF::loadView('orders.bill_account',compact('cp'));

//$pdf->save(storage_path().'account.pdf');

 return $pdf->download('bill_account.pdf');

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
  $passenger->sex_u = $request->get('name');
  $passenger->user_id =$user_id;
  $passenger->type_documents =$request->get('type_documents');
  $passenger->type_passengers =$request->get('type_passengers');
  $passenger->passport_number =$request->get('passport_number');
  $passenger->save();
    

  $order = new Order;
  $order->order_n = intval($request->get('order_n'));
  $order->status = intval($request->get('status'));
  $order->company_registry_id = intval($request->get('company_registry_id'));
  $order->user_id = $uid; 
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
 


\Mail::send('emails.order_add', $data, function($message)
{
$message->from(env('MAIL_FROM'));
$message->to(env('MAIL_FROM'), env('MAIL_NAME'));
//$message->to(env('MAIL_FROM'), env('MAIL_NAME'))->cc($user_email);
$message->subject('Новый заказ создан');
});


  return redirect('orders');

 }



public function getServiceExchange() {
         $user = Auth::user();
         $user_id =  Auth::id();
         $profile = Profile::where('user_id','=',$user_id)->first();
         $service = Service::all();
         $menuActiveItem['orders'] = 1;
         $companies = Company::all();
         $passengers = Passenger::all(); 
         $providers = Provider::all();
         $typefees =  TypeFee::all();

 return response()->json(['companies' => $companies, 'profile' => $profile, 'menuActiveItem' => $menuActiveItem,  'user' => $user, 'profile' => $profile,'service'=>$service, 'passengers'=>$passengers,'typefees'=>$typefees,'providers' =>$providers], $this->successStatus);




}



 public function getTicket($id) {
         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $ticket = Ticket::findOrFail($id);
         $menuActiveItem['orders'] = 1;
         $companies = Company::all(); 

  return response()->json(['companies' => $companies, 'profile' => $profile, 'menuActiveItem' => $menuActiveItem,  'user' => $user, 'profile' => $profile,'ticket'=>$ticket ], $this->successStatus); 

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
    $cities = City::all();
    $airoports = Aeroport::all();
    $farefamilies = FareFamily::all();
    $typefees =  TypeFee::all();
    $companyUsers = User::where('company_id', Auth::user()->company_id)->get()->toArray();
    foreach ($companyUsers as $key => $value) {
      $usersIds[] = $value['id'];
    }
    $managers = Profile::whereIn('user_id', $usersIds)->get()->toArray();

 return response()->json(['companies' => $companies, 'profile' => $profile, 'menuActiveItem' => $menuActiveItem,  'user' => $user, 'profile' => $profile,'services'=>$services,'cities' =>$cities,'airoports'=>$airports, '$companyUsers'=>$companyUsers,'$managers'=> $managers, 'farefamilies'=>$farefamilies, 'typefees'=>$typefees ], $this->successStatus);

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

public function postBlockFinal(AddBlockFinalRequest $request) {
 


  $user = Auth::user();
  $user_id =  Auth::user()->id;

   $place = new FlightPlace;
   $place->count_places = intval($request->get('count_places'));
   $place->ow = intval($request->get('ow'));
   $place->infant_ow = intval($request->get('infant_ow'));
   $place->created_id=$user_id; 
   $place->updated_id=$user_id; 
   $place->created_at =  Carbon::now();
   $place->rt = intval($request->get('rt'));
   $place->infant_rt = intval($request->get('infant_rt'));
   $place->infant_ow = intval($request->get('infant_ow'));
   $place->schedule_id = $request->get('schedule_id');
   $place->currency_id = intval($request->get('currency_id'));
   $place->fare_families_id = intval($request->get('fare_families_id'));
   $place->infant = intval($request->get('infant'));
 
   $place->save();


   $schedule_id = $request->get('schedule_id');

   $schedule =  Schedule::where( 'id', '=', $schedule_id)->first();
   $schedule->monday = $request->get('monday');
   $schedule->tuesday = $request->get('tuesday');
   $schedule->wednesday = $request->get('wednesday');
   $schedule->friday = $request->get('friday');
   $schedule->saturday = $request->get('saturday');
   $schedule->sunday = $request->get('sunday');
   $schedule->airlines_id = intval($request->get('airlines_id'));
   $schedule->updated_id=$user_id; 
   $schedule->updated_at =  Carbon::now();
   $schedule->save();


  $passenger_id = intval($request->get('passenger_id'));
  $passenger = Passenger::where('id','=',$passenger_id)->first();
  $passenger->name = $request->get('name');
  $passenger->surname = $request->get('surname');
  $passenger->country_id = $request->get('country_id');
  $passenger->updated_at = Carbon::now();
  $passenger->sex_u = $request->get('name');
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

  $service->departure_date = $request->get('departure_date');

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



  $data = [

  'count_places' => $request->get('count_places'),
  'ow' => $request->get('ow'), 
  'infant_ow'=> $request->get('infant_ow'), 
  'rt'  => $request->get('rt'), 
  'infant_rt' => $request->get('infant_rt'), 
  'schedule_id' => $request->get('schedule_id'), 
  'currency_id'  => $request->get('currency_id'), 
  'fare_families_id' => $request->get('fare_families_id')
 // 'infant'  => $request->get('infant')
];
 


\Mail::send('emails.block_fin', $data, function($message)
{
$message->from(env('MAIL_FROM'));
$message->to(env('MAIL_FROM'), env('MAIL_NAME'));
//$message->to(env('MAIL_FROM'), env('MAIL_NAME'))->cc($user_email);
$message->subject('Новый заказ закончен');
});


  return redirect('blocks');

}

public function GenerateTicket(Request $request){
    	
    	$name = $request->image_position;
    	$file = $request->file('file');

    	$ext = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
 

  $ticket_id = intval($request->get('ticket_id'));
  $ticket =  Ticket::where('id','=',$ticket_id)->first();
  $ticket_number = $ticket->ticket_number;
  $rate_fare = $ticket->rate_fare;
  $tax_fare = $ticket->tax_fare;
  $$types_fees_id =$ticket->types_fees_id;
  

  $passenger_id = intval($request->get('passenger_id'));
  $passenger = Passenger::where('id','=',$passenger_id)->first();
  $passenger_name = $passenger->name; 
  $surname = $passenger->surname; 
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

  $departure_date = $service->departure_date;

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
  'departure_date' => $departure_date,
  'service_pnr'=>$service_pnr,
  'service_status' => $service_status,
  'register_date' =>  $register_date,
  'segment_number' => $segment_number,
  'summary_summ' =>   $summary_summ,
  'path'=> $path

 

];
 
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

  return redirect('orders');
  

    }





public function postExchangedStatus(ExchangedStatusRequest $request) {

$status = intval($request->get('status'));
$service_id = intval($request->get('service_id'));
$service = Service::where('id','=',$service_id)->first();
$service->service_status = $status;
$service->save();

}



public function postBlockedStatus(BlockedStatusRequest $request) {

$status = intval($request->get('status'));
$service_id = intval($request->get('service_id'));
$service = Service::where('id','=',$service_id)->first();
$service->service_status = $status;
$service->save();

}


public function postInworkStatus(InworkStatusRequest $request) {

$status = intval($request->get('status'));
$service_id = intval($request->get('service_id'));
$service = Service::where('id','=',$service_id)->first();
$service->service_status = $status;
$service->save();

}



public function postIssuedStatus(IssuedStatusRequest $request){

$status = intval($request->get('status'));
$service_id = intval($request->get('service_id'));
$service = Service::where('id','=',$service_id)->first();
$service->service_status = $status;
$service->save();

}






public function postIssuedBlockStatus(IssuedBlockStatusRequest $request){

$status = intval($request->get('status'));
$service_id = intval($request->get('service_id'));
$service = Service::where('id','=',$service_id)->first();
$service->service_status = $status;
$service->save();

}




public function postElemenatedStatus(ElemenatedStatus $request){

$status = intval($request->get('status'));
$service_id = intval($request->get('service_id'));
$service = Service::where('id','=',$service_id)->first();
$service->service_status = $status;
$service->save();

}





public function postCanceledStatus(CanceledStatusRequest $request){

$status = intval($request->get('status'));
$service_id = intval($request->get('service_id'));
$service = Service::where('id','=',$service_id)->first();
$service->service_status = $status;
$service->save();

}




public function postAddPassanger(AddPassengerRequest $request) {

  $passenger_id = intval($request->get('passenger_id'));
  $passenger = Passenger::where('id','=',$passenger_id)->first();
  $passenger->name = $request->get('name');
  $passenger->surname = $request->get('surname');
  $passenger->country_id = $request->get('country_id');
  $passenger->updated_at = Carbon::now();
  $passenger->sex_u = $request->get('name');
  $passenger->user_id =$user_id;
  $passenger->type_documents =$request->get('type_documents');
  $passenger->type_passengers =$request->get('type_passengers');
  $passenger->passport_number =$request->get('passport_number');
  $passenger->save();


}



public function postTicketAdd(AddTicketRequest $request) {
    
  $user = Auth::user();
  $user_id =  Auth::user()->id;
  
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
 


\Mail::send('emails.ticket_add', $data, function($message)
{
$message->from(env('MAIL_FROM'));
$message->to(env('MAIL_FROM'), env('MAIL_NAME'));
//$message->to(env('MAIL_FROM'), env('MAIL_NAME'))->cc($user_email);
$message->subject('Новый билет создан');
});


  return redirect('orders');

 }


public function postServiceAdd(AddServiceRequest $request) {
    
  $user = Auth::user();
  $user_id =  Auth::user()->id;
  
  $service = new Service;
  $service->order_id= intval($request->get('order_id'));
  $service->service_id = intval($request->get('service_id'));
  $service->departure_at = intval($request->get('departure_at'));
 
  $service->arrival_at = $request->get('arrival_at');
  $service->type_flight= intval($request->get('type_flight'));

  $service->departure_date = $request->get('departure_date');

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
 


\Mail::send('emails.service_add', $data, function($message)
{
$message->from(env('MAIL_FROM'));
$message->to(env('MAIL_FROM'), env('MAIL_NAME'));
//$message->to(env('MAIL_FROM'), env('MAIL_NAME'))->cc($user_email);
$message->subject('Новый сервис создан');
});


  return redirect('orders');

 }





}
