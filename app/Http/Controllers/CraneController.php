<?php

namespace App\Http\Controllers;

use Illuminate\Httpequest;

use Auth;
use App\User;
use App\Profile;
use View;
use Carbon\Carbon;
use App\Aeroport;
use App\City;
use App\Country;
use App\Currency;
use App\Order;
use App\Service;

use App\Company;
use App\Accounts;
use PDF;
use App\Passenger;
use App\Http\Requests\AirAvailabilityRequest;
use App\Http\Requests\AirTicketReservationRequest;
use App\Http\Requests\CancelBookingRequest;
use App\Http\Requests\readBookingRequest;
use App\Http\Requests\CreateBookingRequest;
use App\Http\Requests\CreateBookingRequest1;
use App\Http\Requests\CreateBookingRequest2;
use App\Http\Requests\newOrderRequest;
use App\Classes\FeesApply;

use Illuminate\Http\Request;
use ecursiveArrayIterator;
use ecursiveIteratorIterator;



class CraneController extends Controller
{
  public $successStatus = 200;
   
   public function __construct()
    {
        $this->middleware('auth');
    }




public function index() {

    $user = Auth::user();
    $user_id =  Auth::user()->id;
    $profile = Profile::where('user_id','=',$user_id)->first();
    $cities = City::all();
    $airoports = Aeroport::all();
    $companyUsers = User::where('company_id', Auth::user()->company_id)->get()->toArray();
    foreach ($companyUsers as $key => $value) {
      $usersIds[] = $value['id'];
    }
    $managers = Profile::whereIn('user_id', $usersIds)->get()->toArray();

return view('cranes.index')->with('profile',$profile)->with('managers', $managers)->with('cities', $cities)->with('airoports', $airoports);

}

public function CraneSoapSegments($segments, $tiketway, $directFlightsOnly = 'false'){
 
  $return = "";
  if($tiketway == "MULTI_DIRECTIONAL"){
    foreach ($segments as $key => $segment) {
      $return .= "
      <originDestinationInformationList>
         <dateOffset>0</dateOffset>
         <departureDateTime>".$segment['dateto']."</departureDateTime>
         <destinationLocation>     
          <locationCode>".$segment['cityto']['airport']['code_iata']."</locationCode>   
          <locationName>".$segment['cityto']['city']['code_iata']."</locationName>   
        </destinationLocation> 
         <directFlightsOnly>".$directFlightsOnly."</directFlightsOnly><flexibleFaresOnly>false</flexibleFaresOnly>
         <includeInterlineFlights>false</includeInterlineFlights>
         <openFlight>false</openFlight>
         <originLocation>    
          <locationCode>".$segment['cityfrom']['airport']['code_iata']."</locationCode>
         </originLocation> 
      </originDestinationInformationList>";     
    }
  }elseif($tiketway == "ROUND_TRIP"){
      $segment=$segments[0];
      $destinationlocationCode = $segment['cityto']['airport']['code_iata'];
      $destinationlocationName = $segment['cityto']['city']['code_iata'];
      $originlocationCode = $segment['cityfrom']['airport']['code_iata'];
      $originlocationName = $segment['cityfrom']['city']['code_iata'];
    $return .= "
      <originDestinationInformationList>
         <dateOffset>0</dateOffset>
         <departureDateTime>".$segment['dateto']."</departureDateTime>
         <destinationLocation>     
          <locationCode>".$destinationlocationCode."</locationCode>   
          <locationName>".$destinationlocationName."</locationName>   
        </destinationLocation> 
         <directFlightsOnly>".$directFlightsOnly."</directFlightsOnly><flexibleFaresOnly>false</flexibleFaresOnly>
         <includeInterlineFlights>false</includeInterlineFlights>
         <openFlight>false</openFlight>
         <originLocation>    
          <locationCode>".$originlocationCode."</locationCode>
         </originLocation> 
      </originDestinationInformationList>
      <originDestinationInformationList>
         <dateOffset>0</dateOffset>
         <departureDateTime>".$segment['datehere']."</departureDateTime>
         <destinationLocation>     
          <locationCode>".$originlocationCode."</locationCode>   
          <locationName>".$originlocationName."</locationName>   
        </destinationLocation> 
         <directFlightsOnly>".$directFlightsOnly."</directFlightsOnly><flexibleFaresOnly>false</flexibleFaresOnly>
         <includeInterlineFlights>false</includeInterlineFlights>
         <openFlight>false</openFlight>
         <originLocation>    
          <locationCode>".$destinationlocationCode."</locationCode>
         </originLocation> 
      </originDestinationInformationList>";
    
  }else{//ONE_WAY

    $segment=$segments[0];

    $departureDateTime = $segment['dateto'];
    $destinationlocationCode = $segment['cityto']['airport']['code_iata'];
    $destinationlocationName = $segment['cityto']['city']['code_iata'];
    $originlocationCode = $segment['cityfrom']['airport']['code_iata'];
    $originlocationName = $segment['cityfrom']['city']['code_iata'];

    $flexibleFaresOnly ="false";
    $includeInterlineFlights = "false";
    $openFlight ="false";

    $return .= "
      <originDestinationInformationList>
        <dateOffset>0</dateOffset>
        <departureDateTime>".$departureDateTime."</departureDateTime> 
        <destinationLocation>     
          <locationCode>".$destinationlocationCode."</locationCode>   
          <locationName>".$destinationlocationName."</locationName>   
        </destinationLocation> 
        <directFlightsOnly>".$directFlightsOnly."</directFlightsOnly>
        <flexibleFaresOnly>".$flexibleFaresOnly."</flexibleFaresOnly>
        <includeInterlineFlights>".$includeInterlineFlights."</includeInterlineFlights>   
        <openFlight>".$openFlight."</openFlight>              
        <originLocation>    
          <locationCode>".$originlocationCode."</locationCode>
        </originLocation> 
      </originDestinationInformationList>";
  }
  return $return;
}

public function CraneSoapClient(){
  return "<clientInformation>    
                     
            <clientIP>".$_ENV['CRANE_CLIENT_IP']."</clientIP>
            <member>".$_ENV['CRANE_MEMBER']."</member>
            <password>".$_ENV['CRANE_PASSWORD']."</password>
            <userName>".$_ENV['CRANE_USERNAME']."</userName>
            <preferredCurrency>TMT</preferredCurrency>  
          </clientInformation>";
}

public function getPassengers($request){
  $passengerTypeCode = 'ADLT';//$request->get('passengerTypeCode');
  $passengerQuantity = (int)1;//(int)$request->get('passengerQuantity');
  $return = "";
  if(isset($request->adultpeople) && $request->adultpeople != 0){
    $return .= "
      <passengerTypeQuantityList>
        <passengerType>
          <code>ADLT</code>
        </passengerType>
        <quantity>".$request->adultpeople."</quantity>
      </passengerTypeQuantityList>
    ";
  }
  if(isset($request->childrens) && $request->childrens != 0){
    $return .= "
      <passengerTypeQuantityList>
        <passengerType>
          <code>CHLD</code>
        </passengerType>
        <quantity>".$request->childrens."</quantity>
      </passengerTypeQuantityList>
    ";
  }
  if(isset($request->baby) && $request->baby != 0){
    $return .= "
      <passengerTypeQuantityList>
        <passengerType>
          <code>INFT</code>
        </passengerType>
        <quantity>".$request->baby."</quantity>
      </passengerTypeQuantityList>
    ";
  }
   
  return $return;
}
public function makeSOAPRequest($request){
    
  $flexibleFaresOnly ="false";
  $includeInterlineFlights = "false";
  $openFlight ="false";

  $tripType = $request->tiketway;
  $SOAPREQUEST = "
  <soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\" 
    xmlns:impl=\"http://impl.soap.ws.crane.hititcs.com/\">   
    <soapenv:Header/>   
    <soapenv:Body>      
      <impl:GetAirAvailability>   
        <AirAvailabilityRequest>".$this->CraneSoapClient()."
          ".$this->CraneSoapSegments($request->segments, $request->tiketway, $request->directflights)."
          <travelerInformation>".$this->getPassengers($request)."</travelerInformation>
          <tripType>".$tripType."</tripType>   
        </AirAvailabilityRequest>   
      </impl:GetAirAvailability>   
    </soapenv:Body>
  </soapenv:Envelope>" ;
return $SOAPREQUEST;
}

public function getAirAvailability(Request $request) {

$SOAPREQUEST = $this->makeSOAPRequest($request);

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://tua-stage.crane.aero/craneota/CraneOTAService?xsd=1",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => $SOAPREQUEST,  
  CURLOPT_HTTPHEADER => array(
    "Content-Type: text/xml",
    "Postman-Token: 8a7aae39-f152-4a17-b55c-8b9e931c298f",
    "cache-control: no-cache"
  ),
));

//$data= $this->xml2array(curl_exec($curl), 1, 'airAvailability');
$responseCurl = curl_exec($curl);
$header = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
if($header == 503){return ['errors' => ['critical' => 'CRANE IS DOWN']];}
$resArr = $this->xml2array($responseCurl, 1, 'airAvailability');

$data = $this->recursiveFind($resArr, 'originDestinationInformationList');
curl_close($curl);

switch ($request->tiketway) {

  case 'ONE_WAY':
    if($data != false && isset($data[0]['originDestinationOptionsList'])){
      $flights = $this->extractFlights($data[0]['originDestinationOptionsList']);
      $pre = $this->makeFlights($flights, $request->all());
      }else{
        $pre = [];
      }
      $return['result'] = $pre;
    break;

  case 'ROUND_TRIP':
  if (is_array($data[0])) {
  # code...

      foreach ($data[0] as $key => $segment) {
        if (is_array($segment['originDestinationOptionsList']['originDestinationOptionList'])) {
          # code...
        
        foreach ($segment['originDestinationOptionsList']['originDestinationOptionList'] as $key1 => $value) {
          $segment['originDestinationOptionsList']['originDestinationOptionList'][$key1]['originData'] = $data[0];
          $segment['originDestinationOptionsList']['originDestinationOptionList'][$key1]['originSegment'] = $segment;
          }
        
       
        $segments[] = $segment['originDestinationOptionsList']['originDestinationOptionList'];
          }else{
            return response()->json(['error' => '400'], $this->successStatus)->header('Access-Control-Allow-Origin', '*');  
          }
      }
      }else{
        return response()->json(['error' => '400'], $this->successStatus)->header('Access-Control-Allow-Origin', '*');  
      }
      $return = [];
      $return['result'] = $segments;//[];
      //$return['result'] = $this->cartesian($segments);
      
  break;
  case 'MULTI_DIRECTIONAL':
    
  break;
  default:
    # code...
    break;
}

$return['request'] = $request->all();
return response()->json(['data' => $return], $this->successStatus)->header('Access-Control-Allow-Origin', '*');   

}

public function cartesian(&$input) {
    $result = array();
    foreach ($input as $key => $values) {
        if (empty($values)) {
            continue;
        }
        if (empty($result)) {
            foreach($values as $value) {
                $result[] = array($key => $value);
            }
        }
        else {
          
            $append = array();

            foreach($result as &$product) {
                
                $product[$key] = array_shift($values);

                $copy = $product;

                foreach($values as $item) {
                    $copy[$key] = $item;
                    $append[] = $copy;
                }
                array_unshift($values, $product[$key]);
            }

            $result = array_merge($result, $append);
        }
    }

    return $result;
}

private function makeFlights($data, $request){
  
  foreach ($data as $key => $value) {
    $airportsAr[] = $value['arrivalAirport']['locationCode']['value'];
    $airportsAr[] = $value['departureAirport']['locationCode']['value'];
  }

  $airports = Aeroport::whereIn('code_iata', $airportsAr)->with(['city', 'city.country'])->get()->keyBy('code_iata')->toArray();
  
  $flightscount = 0;
  foreach ($data as $key => $value) {
    $tempFlightId = $flightscount;
    $flights[$tempFlightId]['departureAirport'] = $airports[$value['departureAirport']['locationCode']['value']];
    $flights[$tempFlightId]['arrivalAirport'] = $airports[$value['arrivalAirport']['locationCode']['value']];
    $flights[$tempFlightId]['departureDateTime'] = $value['departureDateTime'];
    $flights[$tempFlightId]['arrivalDateTime'] = $value['arrivalDateTime'];
    $flights[$tempFlightId]['bookingClasses'] = $this->filterClasses($value['availabilityFlightSegmentList']['bookingClassAvailabilityList'], $request['classflight'], $request, $value);
    $flights[$tempFlightId]['originData'] = $value;
    $flights[$tempFlightId]['flightNumber'] = $value['availabilityFlightSegmentList']['flightSegment']['airline']['code']['value'] . ' ' . $value['availabilityFlightSegmentList']['flightSegment']['flightNumber']['value'];
    if($flights[$tempFlightId]['bookingClasses'] === []){
      unset($flights[$tempFlightId]);
    }
    $flightscount++;
  }

  return $flights;
}

private function filterClasses($data, $class, $request, $fullresponse){
  $return = [];
  foreach ($data as $key => $value) {
    if($value['bookingClass']['cabin']['value'] == $class)
    {
     
      $type_flight = 0;
      $cityfrom = '';
      $cityto = '';

      if($request['tiketway'] == 'ONE_WAY'){
        $type_flight = 1;
        $cityfrom = $request['segments'][0]['cityfrom']['city']['id'];
        $cityto = $request['segments'][0]['cityto']['city']['id'];
        $country_id_departure = $request['segments'][0]['cityfrom']['country']['id'];
        $country_id_arrival = $request['segments'][0]['cityto']['country']['id'];
      }
      if($request['tiketway'] == 'ROUND_TRIP'){$type_flight = 2;}

      
      $params = [
        ['type_flight', $type_flight],
        ['fare_families_group', $request['classflight']],
        ['departure_city', $cityfrom],
        ['arrival_city', $cityto],
        ['country_id_departure', $country_id_departure],
        ['country_id_arrival', $country_id_arrival],
         ];
      $fee = FeesApply::applyFee( $value['fareDisplayInfos']['fareDisplayInfoList']['pricingInfoList']['totalFare']['amount']['value']['value'], $params);
      $value['fareDisplayInfos']['fareDisplayInfoList']['pricingInfoList']['totalFare']['amount']['value']['value'] = ($fee != false)?$fee:$value['fareDisplayInfos']['fareDisplayInfoList']['pricingInfoList']['totalFare']['amount']['value']['value'];

      $return[] = $value;
    }

    
  }
  usort($return, array('App\Http\Controllers\CraneController' , 'bookingSortPrices'));
  
 // dd($return[0]);
  return $return;
}

private static function bookingSortPrices($a, $b) {
        if ($a['fareDisplayInfos']['fareDisplayInfoList']['pricingInfoList']['totalFare']['amount']['value']['value'] == $b['fareDisplayInfos']['fareDisplayInfoList']['pricingInfoList']['totalFare']['amount']['value']['value']) {
                return 0;
        }
        return ($a['fareDisplayInfos']['fareDisplayInfoList']['pricingInfoList']['totalFare']['amount']['value']['value'] < $b['fareDisplayInfos']['fareDisplayInfoList']['pricingInfoList']['totalFare']['amount']['value']['value']) ? -1 : 1;
}


private function extractFlights($data){
  $fullflights = $this->recursiveFind($data, 'originDestinationOptionList');
  $flights = $this->recursiveFindByChild($fullflights, 'availabilityFlightSegmentList');
  return $flights;
}

public function recursiveFind(array $haystack, $needle)
{
  if($haystack == null){return false;}
    $iterator  = new \RecursiveArrayIterator($haystack);
    $recursive = new \RecursiveIteratorIterator(
        $iterator,
        \RecursiveIteratorIterator::SELF_FIRST
    );
    $return = false;
    foreach ($recursive as $key => $value) {
        if ($key === $needle) {
          $return[] = $value;
        }
    }
    return $return;
}

public function recursiveFindByChild($haystack, $needle)
{
  if($haystack == null){return false;}
    $iterator  = new \RecursiveArrayIterator($haystack);
    $recursive = new \RecursiveIteratorIterator(
        $iterator,
        \RecursiveIteratorIterator::SELF_FIRST
    );
    $return = false;
    foreach ($recursive as $key => $value) {
        if (isset($value[$needle])) {
          $return[] = $value;
        }
    }
    return $return;
}

public function xml2array($contents, $get_attributes=1, $priority = 'tag') { 

    if(!$contents) return array(); 

    if(!function_exists('xml_parser_create')) { 
        //print "'xml_parser_create()' function not found!"; 
        return array(); 
    } 

    //Get the XML parser of PHP - PHP must have this module for the parser to work 
    $parser = xml_parser_create(''); 
    xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8"); # http://minutillo.com/steve/weblog/2004/6/17/php-xml-and-character-encodings-a-tale-of-sadness-rage-and-data-loss 
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0); 
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1); 
    xml_parse_into_struct($parser, trim($contents), $xml_values); 
    xml_parser_free($parser); 

    if(!$xml_values) return;//Hmm... 

    //Initializations 
    $xml_array = array(); 
    $parents = array(); 
    $opened_tags = array(); 
    $arr = array(); 

    $current = &$xml_array; //Refference 

    //Go through the tags. 
    $repeated_tag_index = array();//Multiple tags with same name will be turned into an array 
    foreach($xml_values as $data) { 
        unset($attributes,$value);//Remove existing values, or there will be trouble 

        //This command will extract these variables into the foreach scope 
        // tag(string), type(string), level(int), attributes(array). 
        extract($data);//We could use the array by itself, but this cooler. 

        $result = array(); 
        $attributes_data = array(); 
         
        if(isset($value)) { 
            if($priority == 'tag') $result = $value; 
            else $result['value'] = $value; //Put the value in a assoc array if we are in the 'Attribute' mode
        } 

        //Set the attributes too. 
        if(isset($attributes) and $get_attributes) { 
            foreach($attributes as $attr => $val) { 
                if($priority == 'tag') $attributes_data[$attr] = $val; 
                else $result['attr'][$attr] = $val; //Set all the attributes in a array called 'attr' 
            } 
        } 

        //See tag status and do the needed. 
        if($type == "open") {//The starting of the tag '<tag>' 
            $parent[$level-1] = &$current; 
            if(!is_array($current) or (!in_array($tag, array_keys($current)))) { //Insert New tag 
                $current[$tag] = $result; 
                if($attributes_data) $current[$tag. '_attr'] = $attributes_data; 
                $repeated_tag_index[$tag.'_'.$level] = 1; 

                $current = &$current[$tag]; 

            } else { //There was another element with the same tag name 

                if(isset($current[$tag][0])) {//If there is a 0th element it is already an array 
                    $current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result; 
                    $repeated_tag_index[$tag.'_'.$level]++; 
                } else {//This section will make the value an array if multiple tags with the same name appear together
                    $current[$tag] = array($current[$tag],$result);//This will combine the existing item and the new item together to make an array
                    $repeated_tag_index[$tag.'_'.$level] = 2; 
                     
                    if(isset($current[$tag.'_attr'])) { //The attribute of the last(0th) tag must be moved as well
                        $current[$tag]['0_attr'] = $current[$tag.'_attr']; 
                        unset($current[$tag.'_attr']); 
                    } 

                } 
                $last_item_index = $repeated_tag_index[$tag.'_'.$level]-1; 
                $current = &$current[$tag][$last_item_index]; 
            } 

        } elseif($type == "complete") { //Tags that ends in 1 line '<tag />' 
            //See if the key is already taken. 
            if(!isset($current[$tag])) { //New Key 
                $current[$tag] = $result; 
                $repeated_tag_index[$tag.'_'.$level] = 1; 
                if($priority == 'tag' and $attributes_data) $current[$tag. '_attr'] = $attributes_data; 

            } else { //If taken, put all things inside a list(array) 
                if(isset($current[$tag][0]) and is_array($current[$tag])) {//If it is already an array...

                    // ...push the new element into that array. 
                    $current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result; 
                     
                    if($priority == 'tag' and $get_attributes and $attributes_data) { 
                        $current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data; 
                    } 
                    $repeated_tag_index[$tag.'_'.$level]++; 

                } else { //If it is not an array... 
                    $current[$tag] = array($current[$tag],$result); //...Make it an array using using the existing value and the new value
                    $repeated_tag_index[$tag.'_'.$level] = 1; 
                    if($priority == 'tag' and $get_attributes) { 
                        if(isset($current[$tag.'_attr'])) { //The attribute of the last(0th) tag must be moved as well
                             
                            $current[$tag]['0_attr'] = $current[$tag.'_attr']; 
                            unset($current[$tag.'_attr']); 
                        } 
                         
                        if($attributes_data) { 
                            $current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data; 
                        } 
                    } 
                    $repeated_tag_index[$tag.'_'.$level]++; //0 and 1 index is already taken 
                } 
            } 

        } elseif($type == 'close') { //End of tag '</tag>' 
            $current = &$parent[$level-1]; 
        } 
    } 
     
    return($xml_array); 
}  

public function getAirTicketReservation () {

$user = Auth::user();
$user_id =  Auth::user()->id;
$profile = Profile::where('user_id','=',$user_id)->first();


return view('cranes.airticketreservation')->with('profile',$profile);

}




public function getCancelBooking() {

$user = Auth::user();
$user_id =  Auth::user()->id;
$profile = Profile::where('user_id','=',$user_id)->first();


return view('cranes.cancelbooking')->with('profile',$profile);

}


public function getReadBooking() {

$user = Auth::user();
$user_id =  Auth::user()->id;
$profile = Profile::where('user_id','=',$user_id)->first();
return view('cranes.readbooking')->with('profile',$profile);

}




public function getCreateBooking(Request $request) {

$user = Auth::user();
$user_id =  Auth::user()->id;
$profile = Profile::where('user_id','=',$user_id)->first();
$countries = Country::all();
$usersIds = [];
$companyUsers = User::where('company_id', Auth::user()->company_id)->get()->toArray();
foreach ($companyUsers as $key => $value) {
  $usersIds[] = $value['id'];
}
$airoports = Aeroport::all();
$currencies =Currency::all();
$managers = Profile::whereIn('user_id', $usersIds)->get()->toArray();
$companies = Company::all();


return view('cranes.getcreatebooking')->with('profile',$profile)->with('countries', $countries)->with('airoports', $airoports)->with('currencies', $currencies)->with('managers', $managers)->with('companies', $companies);


}





public function postAirTicketReservation (AirTicketReservationRequest $request) {
  
$bookingReferenceID = $request->get('bookingReferenceID');

$curl = curl_init();
$companyUserf = Auth::user()->admincompany()->first();
$currencyUserf = $companyUserf->currency()->first();
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://tua-stage.crane.aero/craneota/CraneOTAService?xsd=1",
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
    
    <impl:TicketReservation>        

     <AirTicketReservationRequest>        

           <clientInformation>               
           <clientIP>".$_ENV['CRANE_CLIENT_IP']."</clientIP>
           <member>".$_ENV['CRANE_MEMBER']."</member>
           <password>".$_ENV['CRANE_PASSWORD']."</password>
           <userName>".$_ENV['CRANE_USERNAME']."</userName>  
           <preferredCurrency>".$currencyUserf->code_literal_iso_4217."</preferredCurrency>
           </clientInformation>            

          <bookingReferenceID> 
         <ID>".$bookingReferenceID."</ID>              
          </bookingReferenceID> 
           <requestPurpose>VIEW_ONLY</requestPurpose>         
           </AirTicketReservationRequest>      
           </impl:TicketReservation>  
           </soapenv:Body>
           </soapenv:Envelope>",



  CURLOPT_HTTPHEADER => array(
    "Content-Type: text/xml",
    "Postman-Token: 025e0d39-0c07-45bc-a288-97175e6cedc0",
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
return view('cranes.getairticketreservation')->with('responses',json_decode($responses,true))->with('profile',$profile);

}



public function postCancelBooking (CancelBookingRequest $request) {

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
$user = Auth::user();
$user_id =  Auth::user()->id;

$profile = Profile::where('user_id','=',$user_id)->first();

///return response()->json($response);
return view('cranes.cancelbooking')->with('responses',json_decode($responses,true))->with('profile',$profile);


}



public function postReadBooking(ReadBookingRequest $request){

$bookingReferenceID = $request->get('bookingReferenceID');
$surname = $request->get('surname');

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://tua-stage.crane.aero/craneota/CraneOTAService?xsd=1",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
 CURLOPT_POSTFIELDS => "<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:impl=\"http://impl.soap.ws.crane.hititcs.com/\">

     <soapenv:Header/>  

      <soapenv:Body>   

       <impl:ReadBooking>  

        <AirBookingReadRequest>           

      <clientInformation>              
    <clientIP>".$_ENV['CRANE_CLIENT_IP']."</clientIP>
    <member>".$_ENV['CRANE_MEMBER']."</member>
    <password>".$_ENV['CRANE_PASSWORD']."</password>
    <userName>".$_ENV['CRANE_USERNAME']."</userName>            
    <preferredCurrency>TMT</preferredCurrency>            
    </clientInformation> 


     <bookingReferenceID>             

   <ID>0R4STA</ID>           
    </bookingReferenceID>          
      <passenger>            
      <shareMarketInd/>
      <surname>TEST</surname>       
   </passenger>        
  </AirBookingReadRequest>   
  </impl:ReadBooking>  
   </soapenv:Body>
   </soapenv:Envelope>",
   
  CURLOPT_HTTPHEADER => array(
    "Content-Type: text/xml",
    "Postman-Token: f3439a4c-c985-4605-986c-43cd20113a47",
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
return view('cranes.getreadbooking')->with('responses',json_decode($responses,true))->with('profile',$profile);

}

public function postNewOrder (Request $request) {

        $uid=intval($request->get('user_id'));
      
        $order = new Order;
        $order->date_v = $request->get('date_v');
        $order->user_id = $uid;
        $order->order_n = $request->get('order_n');
        $order->status = $request->get('status');
        $order->company_registry_id = $request->get('company_registry_id');
        $order->order_summary = $request->get('order_summary');
        $order->order_currency = $request->get('order_currency');
        $order->passengers = $request->get('passengers');
        $order->services = $request->get('services');
        $order->time_limit = $request->get('time_limit');
        $order->type_payment = $request->get('type_payment');
        $order->contact = $request->get('contact');
        $order->comment = $request->get('comment');
        $order->created_id= $request->get('created_id');
        $order->created_at = Carbon::now();
        $order->save();


        $service = new Service;
        $service->order_id = $request->get('order_id');
        $service->user_id = $uid;
        $service->departure_at = $request->get('departure_at');
        $service->arrival_at = $request->get('arrival_at');
        $service->type_flight = $request->get('type_flight');
        $service->departure_date = $request->get('departure_date');
        $service->arrival_date = $request->get('arrival_date');
        $service->service_status = $request->get('service_status');
        $service->orders_system = $request->get('orders_system');
        $service->booking_date = $request->get('booking_date');
        $service->discharge_date = $request->get('discharge_date');
        $service->summary_summ = $request->get('summary_summ');
        $service->passenger_id = $request->get('passenger_id');
        $service->pnr = $request->get('pnr');
        $service->provider_id = $request->get('provider_id');
        $service->segment_number = $request->get('segment_number');
        $service->schedule_id = $request->get('schedule_id');
        $service->fare_families_id = $request->get('fare_families_id');
        $service->airlines_id = $request->get('airlines_id');
        $service->baggage_allowance = $request->get('baggage_allowance');
        $service->type_bc_id = $request->get('type_bc_id');
        $service->terminal_departure = $request->get('terminal_departure');
        $service->terminal_arrival = $request->get('terminal_arrival');
        $service->baggage_allowance = $request->get('baggage_allowance'); 
        $service->created_id= $request->get('created_id');
        $service->created_at = Carbon::now();
        $service->save();


}



public function postCreateBooking (CreateBookingRequest $request) {


$locationCodeCityout =$request->get('locationCodeCityout');
$locationCodeCountryout =$request->get('locationCodeCountryout');
$departureDateTimeout =$request->get('departureDateTimeout');
$locationCodeCountryin= $request->get('locationCodeCountryin');
$departureDateTimein= $request->get('departureDateTimein');
$flexibleFaresOnly ="false";
$includeInterlineFlights = "false";
$openFlight ="false";
$currencyout =$request->get('currencyout');
$company_id =intval($request->get('company_id'));
$manager =$request->get('manager');
$phone =$request->get('phone');
$payway =intval($request->get('payway'));
$gender =$request->get('gender');
$user_id = intval($request->get('user_id'));
$passengerTypeCode =$request->get('passengerTypeCode');
$passengerCode =$request->get('passengerCode');
$passengerQuantity=(int)$request->get('passengerQuantity');
$birthDate=intval($request->get('birthDate')); 
$passengerCode =$request->get('passengerCode');
$сountry_id=intval($request->get('сountry_id'));
$document=$request->get('document'); 
$document_number=intval($request->get('document_number')); 
$first_name =$request->get('first_name');
$middle_name =$request->get('middle_name');
$surname =$request->get('surname');
$clientemail =$request->get('clientemail');
$requestedSeatCount=(int)$request->get('requestedSeatCount');
$subscriberNumber=$request->get('subscriberNumber'); 
$name = $first_name."".$middle_name;




if ($payway == 0) {

$cp = Company::findOrFail($company_id);

$pdf = PDF::loadView('reports.account',compact('cp'));

//$pdf->save(storage_path().'account.pdf');

 return $pdf->download('account.pdf');

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

  $passenger = new Passenger;
  $passenger->name = $name; 
  $passenger->surname = $surname; 
  $passenger->date_birth_at  = $birthDate; 
  $passenger->passport_number =$document_number;
  $passenger->country_id = $сountry_id; 
  $passenger->user_id = $user_id; 
  $passenger->date_end_at = Carbon::now();
  $passenger->created_at =  Carbon::now();
  $passenger->save();



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

       <fareReferenceID>5d140f6ef5857ba6be49ba88d7220668fc1584f655f7abc5dfa1e01742b2a83e5eeeb1968eea19aa45fcd8be699a0409fdfda6f494e6b9cac644a5c8895565f9</fareReferenceID>                                

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

}






	




}
