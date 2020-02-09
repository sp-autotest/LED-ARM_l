<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\FlightPlace;
use App\FeePlace;
use Carbon\Carbon;
use App\Aeroport;
use App\Classes\FeesApply;
use App\Ticket;
use App\Passenger;
use App\Conversation;
use App\Message;
use App\Flight;
use App\Order;
use App\Service;
use App\User;
use App\AdminCompany;
use Auth;
use PDF;
use App\Classes\CurrencyManager;
use App\Mailing;
use App\MailingList;


class BookingController extends Controller
{
	public $successStatus = 200;
	public $errorStatus = '400';
    
    public function booking(Request $request){
    
        switch ($request->booking_system) {
    		case 'crane':
    			return $this->craneBooking($request);
    			break;
    		case 'block':
    			return $this->blockBooking($request);
    			break;
    		default:
    			return response()->json(['Error' => 'Can\'t find booking system: '.$request->booking_system], $this->errorStatus)->header('Access-Control-Allow-Origin', '*');   
    			break;
    	}
    }

    public function craneBooking($request){
$this->middleware(['permission:search-avia.booking']);  
        $passengersAr = $request->passengers;
    	$passengers = $this->makePassengers($passengersAr);
        $tikets = "";
        $order = "";
        /*$ratefare = $this->getRateFare($request->type_flight, $request->flight_places_id, false);
        
        $feesfare = $this->getFeesFare($request);
        $tikets = $this->makeTikets($request, $passengers, $feesfare, $ratefare);
        $order = $this->makeOrder($request, $passengers, $tikets);
        $services = $this->makeServices($request, $passengers, $tikets, $order);*/
        $crane = $this->fireCraneBooking($request, $passengers, $tikets, $order);
        return response()
                   ->json(['data' => $crane], $this->successStatus)
                   ->header('Access-Control-Allow-Origin', '*');
    }
    private function fireCraneBooking($request, $passengers, $tikets, $order){
        //Check passengers
        if(count($passengers) < 1){
            return response()
                   ->json(['Error' => 'Count of passengers must be > 0:'], $this->errorStatus)
                   ->header('Access-Control-Allow-Origin', '*'); 
        }

        $query = '
            <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:impl="http://impl.soap.ws.crane.hititcs.com/">
                <soapenv:Header/>
                <soapenv:Body>
                    <impl:CreateBooking>
                        <AirBookingRequest>
                        ';
                $query .= $this->CraneSoapClient(); //add clientInformation tag with info
                $query .= $this->CraneAirItinerary($request->flight_info);
                
                foreach ($passengers as $key => $value) {
                    $query .= $this->getBookingCraneMakePassenger($value);   
                }
                /*** КОНТАКТЫ - ДАННЫЕ КОМПАНИИ ПЛАТЕЛЬЩИКА  ***/
                $query .= $this->getBookingCraneClientContacts($request->contacts_info);
                $query .= "
                            <requestPurpose>MODIFY_PERMANENTLY</requestPurpose>
                        </AirBookingRequest>
                    </impl:CreateBooking>
                </soapenv:Body>
            </soapenv:Envelope>";

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://tua-stage.crane.aero/craneota/CraneOTAService?xsd=1",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => $query,  
          CURLOPT_HTTPHEADER => array(
            "Content-Type: text/xml",
            "Postman-Token: 8a7aae39-f152-4a17-b55c-8b9e931c298f",
            "cache-control: no-cache"
          ),
        ));
        $responseCurl = curl_exec($curl);
        $header = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
        if($header == 503){
            return response()->json(['Error' => 'FATAL: CRANE IS DOWN'], $this->errorStatus)->header('Access-Control-Allow-Origin', '*'); 
        }


        $resArr = $this->xml2array($responseCurl, 1, 'S:Envelope');


 $order = Order::where('id','=', $order_id)->first();
 $company_id = $order->company_registry_id;

   $mail_list = Mailing::where( 'company_registry_id', '=', $company_id )->first();

   foreach($mail_list as $mails){

   $mail_list_id = $mail_list->id;


  $mailing_emails = MailingList::where( 'mailing_id', '=', $mail_list_id )->get();

 
 foreach($mailing_emails as $mailing){
         
        
         $mailing_email = $mailing->mail;



\Mail::send('emails.service_add', $data, function($message) use ($user_email)


{
$message->from(env('MAIL_FROM'));
$message->to(env('MAIL_FROM'), env('MAIL_NAME'));
$message->to(env('MAIL_FROM'), env('MAIL_NAME'))->cc($user_email);
$message->subject('Новый сервис создан');
});

}
}

return $resArr;


}



    private function getBookingCraneClientContacts(){
        return  "<contactInfoList>
                <!-- Адрес клиента -->
                    <adress><!--  гражданство -->
                    <!-- Международный код страны -->
                        <countryCode>TR</countryCode>
                        <!-- ? -->
                        <formatted/>
                        <!-- Разрешение на работу с персональной информацией в маркейтинговых целях-->
                        <shareMarketInd/>
                    </adress>
                    <email>
                    <!-- Контактная информация (электронная почта)-->
                        <email>test@test.com</email>
                        <!-- ? -->
                        <markedForSendingRezInfo/>
                        <!--?-->
                        <preferred/>
                        <!-- Разрешение на работу с персональной информацией в маркейтинговых целях-->
                        <shareMarketInd/>
                    </email>
                    <!-- Имя клиента -->
                    <personName>
                        <givenName>BBB</givenName>
                        <!-- Разрешение на работу с персональной информацией в маркейтинговых целях-->
                        <shareMarketInd/>
                        <surname>TEST</surname>
                    </personName>
                    <!-- Контактная информация (номер телефона)-->
                    <phoneNumber>
                    <!-- Код региона-->
                        <areaCode>555</areaCode>
                        <!-- Код страны -->
                        <countryCode>+90</countryCode>
                        <!-- ?-->
                        <markedForSendingRezInfo/>
                        <!-- ?-->
                        <preferred/>
                        <!-- Разрешение на работу с персональной информацией в маркейтинговых целях-->
                        <shareMarketInd/>
                        <!-- Номер телефона без кода страны и региона -->
                        <subscriberNumber>4443322</subscriberNumber>
                    </phoneNumber>
                    <!-- Разрешение на работу с персональной информацией в маркейтинговых целях-->
                    <shareMarketInd/>
                    <!-- Использовать для фактурирования.
Точного аналога английского слова «invoice» в русском языке не существует. Наиболее близкий термин — «счет» или «счет-фактура».
Инвойсинг (англ. invoicing) — это процесс выставления счетов на оплату за уже поставленный товар, оказанную услугу (инвойсов). 
То есть отправляемый документ фактически является платежным, в условиях российского рынка такой тип сделок отсутствует. -->
                    <!--  <useForInvoicing/> -->
           
                </contactInfoList>";
    }
    private function getBookingCraneMakePassenger($passenger){
        return  "<airTravelerList>
                <!-- Сопровождение детей -->
                    <accompaniedByInfant/>
                    <!-- Дата рождения -->
                    <birthDate>1985-06-10</birthDate>
                    <!-- Пол -->
                    <gender>M</gender>
                    <!-- Нужны ли носилки, если специально не указано, то по умолчанию false -->
                    <!--   <hasStrecher/>  -->
                    <!-- Родители как сопровождающие -->
                                        <!-- <parentSequence/>-->
                    <!-- Тип пассажира -->
                    <passengerTypeCode>ADLT</passengerTypeCode>
                    <!-- Номер паспорта -->
                    <passportNumber>A-23422243</passportNumber>
                    <personName>
                    <!--Имя пассажира -->
                        <givenName>AAA</givenName>
                        <!-- Разрешение на работу с персональной информацией в маркейтинговых целях-->
                        <shareMarketInd/>
                        <!-- Фамилия пассажира-->
                        <surname>TEST</surname>
                    </personName>
                    <!-- Требуемое количество сидений-->
                    <!-- Всегда 1 -->
                    <requestedSeatCount>1</requestedSeatCount>
                    <!-- Разрешение на работу с персональной информацией в маркейтинговых целях-->
                    <shareMarketInd/>
                    <!-- Номер социального страхования -->
                    <socialSecurityNumber>123423433</socialSecurityNumber>
                    <!-- Отсутсвие сопровождения ребенка (актуально только для типа пассажира CHLD) -->
                    <!-- <unaccompaniedMinor/>-->
                    
                </airTravelerList>";
    }




    private function getBookingCraneSegment(){
        return "
        <flightSegment>
        <!-- Берется из AirAvailabilityResponse-->
            <arrivalAirport>
                <cityInfo>
                    <city>
                    <!-- Город прибытия (код аэропорта, наименование города прибытия)-->
                        <locationCode>ALA</locationCode>
                        <locationName>Almaty</locationName>
                        <!-- Указание языка, на котором написано название города-->
                        <locationNameLanguage>EN</locationNameLanguage>
                    </city>
                    <country>
                    <!-- Страна прибытия (код страны, наименование страны прибытия) -->
                        <locationCode>KZ</locationCode>
                        <locationName>Kazakhstan</locationName>
                        <!-- Указание языка, на котором написано название страны-->
                        <locationNameLanguage>EN</locationNameLanguage>
                        <!-- Код валюты-->
                        <currency>
                            <code>KZT</code>
                        </currency>
                    </country>
                </cityInfo>
                <!-- Нормативный контроль-->
                <codeContext>IATA</codeContext>
                <!-- Язык описания наименований в документе-->
                <language>EN</language>
                    <!-- Код аэропорта прибытия-->
                <locationCode>ALA</locationCode>
                <!-- Наименование аэропорта прибытия-->
                <locationName>Almaty</locationName>
            </arrivalAirport>
            <!-- Точное время прибытия рейса-->
            <arrivalDateTime>2019-02-22T12:00:00+05:00</arrivalDateTime>
            <!-- Информация об месте отправления-->
            <departureAirport>
                <cityInfo>
                    <city>
                    <!-- Город отправления (код аэропорта, наименование города отправления)-->
                        <locationCode>ASB</locationCode>
                        <locationName>Ashgabad</locationName>
                        <!-- Указание языка, на котором написано название города-->
                        <locationNameLanguage>EN</locationNameLanguage>
                    </city>
                    <country>
                    <!-- Страна отправления (код страны, наименование страны оправления) -->
                        <locationCode>TM</locationCode>
                        <locationName>Turkmenistan</locationName>
                        <!-- Указание языка, на котором написано название страны-->
                        <locationNameLanguage>EN</locationNameLanguage>
                        <!-- Код валюты-->
                        <currency>
                            <code>TMT</code>
                        </currency>
                    </country>
                </cityInfo>
                <!-- Нормативный контроль-->
                <codeContext>IATA</codeContext>
                <!-- Язык описания наименований в документе-->
                <language>EN</language>
                    <!-- Код аэропорта отправления-->
                <locationCode>ASB</locationCode>
                    <!-- Наименование аэропорта отправления -->
                <locationName>Ashgabat International</locationName>
            </departureAirport>
            <!-- Точное время отправления-->
            <departureDateTime>2019-02-22T08:10:00+05:00</departureDateTime>
            <!-- Тип самолета (например, B737-800 - тип самолета,16C/144Y - 2-х классная компановка,
                16 мест бизнесс-класса, 144 - эконом-класса)-->
            <equipment>
                <airEquipType>B737-800_16C/144Y</airEquipType>
                <!-- Смена самолета без смены номера - не предусмотрена-->
                <changeofGauge>false</changeofGauge>
            </equipment>
            <!-- ?-->
            <stopQuantity>0</stopQuantity>
            <!-- ?-->
            <accumulatedDuration/>
            <!-- Код авиакомпании по IATA-->
            <airline>
                <code>T5</code>
            </airline>
            <!-- Возможность совместной эксплуатации авиарейса двумя и более авиакомпаниями -->
            <codeshare>false</codeshare>
            <!-- ?-->
            <distance>0</distance>
            <!-- Номер рейса без кода авиакомпании (полный номер будет, например, T5 715)-->
            <flightNumber>717</flightNumber>
            <!-- Идентификационный код сегмента -->
            <flightSegmentID/>
            <!-- ?-->
            <flownMileageQty>0</flownMileageQty>
            <!-- ?-->
            <groundDuration/>
                <!-- Продолжительность рейса (в данном случае, 2 часа 55 минут) -->
            <journeyDuration>PT2H55M</journeyDuration>
            <!-- Повременный тариф -->
            <onTimeRate>0</onTimeRate>
            <!-- Если самолет перемещется внутри страны - DOMESTIC, иначе - INTERNATIONAL-->
            <sector>INTERNATIONAL</sector>
            <!-- Требование данных (·фамилия, имя (так, как они указаны в паспорте, который будет предъявляться в аэропортуво время регистрации);
                дата рождения; пол)-->
            <secureFlightDataRequired>false</secureFlightDataRequired>
            <!-- Тип билета. Если электронные, то E_TICKET, иначе - PAPER-->
            <ticketType>PAPER</ticketType>
            <!-- ?-->
            <trafficRestriction>
                <code/>
                <explanation/>
            </trafficRestriction>
        </flightSegment>";
    }

    private function getBookingCraneFare(){
        return "<!-- Берется из AirAvailabilityResponse-->
                                <fareInfo>
                                <!-- Код класс обслуживания -->
                                  <cabinClassCode>Y</cabinClassCode>
                                  <!-- Класс обслуживания -->
                                  <fareGroupName>ECONOMY</fareGroupName>
                                  <!-- Код тарифа -->
                                 <fareReferenceCode>HOW 6M43</fareReferenceCode>
                                 <!-- Идентификатор тарифа -->
                                 <fareReferenceID>8a64b3da1cf8942002dee8c274f4f9cf5e42a1e766827a2c489792c527dbd1c487df0730116205db3b83a84279fc29c84f2499566b7801330bd2c29b8aaff435</fareReferenceID>
                                  <!-- Название тарифа -->
                                                    <fareReferenceName>H6OW/USD </fareReferenceName>
                                                    <!-- Номер в последовательности участков траектории полёта -->
                                                    <flightSegmentSequence>1</flightSegmentSequence>
                                                    <!-- Код класса обслуживания, на который должен быть перебронирован рейса
                                                    по более низкому тарифу-->
                                                    <resBookDesigCode>H</resBookDesigCode>
                                </fareInfo>";
    }

    private function getBookingCraneClass(){
        return "<!-- Берется из AirAvailabilityResponse-->
                                <bookingClass>
                                    <!-- Класс обслуживания -->
                                     <cabin>ECONOMY</cabin>
                                     <!-- Код салона -->
                                     <resBookDesigCode>H</resBookDesigCode>
                                     <!-- Количество мест, доступных для резервирования -->
                                     <resBookDesigQuantity>121</resBookDesigQuantity>
                                </bookingClass>";
    }





    public function CraneAirItinerary(){
        $return = " 
        <airItinerary>
        <bookOriginDestinationOptions>
                <bookOriginDestinationOptionList>
                    <bookFlightSegmentList>
                    <!--Активный код, в данном случае, NN - продажа не завершена, нет подтверждения от авиакомпании. 
                    Подробнее, https://richmedia.sabre.com/Docs_Support/TrainingWorkbooks/EUru/Chapter9.pdf и 
                    https://www.slots-austria.com/jart/prj3/sca/uploads/data-uploads/downloads/e)%20miscellanious/overall/scr,%20sir%20quick%20guide.pdf-->
                        <actionCode>NN</actionCode>
                        <!--? -->
                        <addOnSegment/>
                        ".$this->getBookingCraneClass()."
                        ".$this->getBookingCraneFare()."
                        ".$this->getBookingCraneSegment()."
                        <sequenceNumber/>
                    </bookFlightSegmentList>
                </bookOriginDestinationOptionList>
            </bookOriginDestinationOptions>
        </airItinerary>";

        return $return;
    }



    public function CraneSoapClient(){
        return "<clientInformation>               
                    <clientIP>".$_ENV['CRANE_CLIENT_IP']."</clientIP>
                    <member>".$_ENV['CRANE_MEMBER']."</member>
                    <password>".$_ENV['CRANE_PASSWORD']."</password>
                    <userName>".$_ENV['CRANE_USERNAME']."</userName>
                </clientInformation>";
    }



    public function getRateFare($type_flight, $fp, $infant){
        
       // $fp = FlightPlace::find($flight_places_id);
        if($infant == true){
            if($type_flight == '1'){
                return $fp->ow;
            }
            elseif($type_flight == '2'){
                return $fp->rt;
            }
        }elseif($infant == false){
            if($type_flight == '1'){
                return $fp->infant_ow;
            }
            elseif($type_flight == '2'){
                return $fp->infant_rt;
            }
        }
        
    }




    public function getFeesFare($request, $summ){
        $params = [
            ['type_flight', $request->type_flight],
            ['fare_families_group', $request->fare_families_group],
            ['departure_city', $request->departure_city],
            ['arrival_city', $request->arrival_city],
            ['country_id_departure', $request->country_id_departure],
            ['country_id_arrival', $request->country_id_arrival],
        ];

        $params1 = [
            ['type_flight', '0'],
            ['fare_families_group', $request->fare_families_group],
            ['departure_city', $request->departure_city],
            ['arrival_city', $request->arrival_city],
            ['country_id_departure', $request->country_id_departure],
            ['country_id_arrival', $request->country_id_arrival],
        ];
        $fee = FeePlace::where($params)->orWhere($params1)->whereDate('period_begin_at', '<', Carbon::now())->whereDate('period_end_at', '>', Carbon::now())->orderBy('updated_at', 'desc')->first();

       // $fee = FeePlace::find(64);
        if($fee == null){return 0;}
        if($fee->type_fees_inscribed == '0'){
            $feesize = $summ * $fee->size_fees_inscribed / 100;
            $fullsumm = $summ + $feesize;
            if($fullsumm > $fee->max_fees_inscribed){
                return $summ + $fee->max_fees_inscribed;
            }elseif($fullsumm < $fee->min_fees_inscribed){
                return $summ + $fee->min_fees_inscribed;
            }else{
                return $fullsumm;
            }
            
        }elseif ($fee->type_fees_inscribed == '1') {
            //FIX fees
            if($fee->size_fees_inscribed > $fee->max_fees_inscribed){return $summ + $fee->max_fees_inscribed;
            }elseif($fee->size_fees_inscribed < $fee->min_fees_inscribed){
                return $summ + $fee->min_fees_inscribed;
            }else{
                return $summ + $fee->size_fees_inscribed;
            }
        }
    }



    public function blockBooking($request){
        $services = [];
       $this->middleware(['permission:search-avia.booking']);  
        $passengersAr = $request->passengers;
        $checkPayment = $this->checkPayment($request, $passengersAr);
        if($checkPayment['status'] == true){
              $passengers = $this->makePassengers($checkPayment['passengers']);
         
            foreach ($request->flight as $key => $segment) {
                # code...

                $flightplace = Flight::where('id', '=', $segment['flight_id'])->first()->flightplaces()->with('currency')->first();
                $userCurrency = Auth::user()->admincompany()->first()->currency()->first();
                //dd($flightplace->toArray());
        		
               // $ratefare = CurrencyManager::convert($this->getRateFare($request->type_flight, $flightplace, $flightplace->infant), $flightplace->currency->  code_literal_iso_4217, $userCurrency->code_literal_iso_4217 );
                
                $feesfare = $this->getFeesFare($request, $checkPayment['summ']);
                if(!isset($tikets)){$tikets = $this->makeTikets($request, $passengers, $feesfare, $flightplace);}

                if(!isset($order) || $order == null ||  empty($order)){
                    $order = $this->makeOrder($request, $passengers, $tikets, $feesfare);
                }else{
                    $this->appendToOrder($request, $passengers, $tikets, $feesfare, $order);
                }
               
                $services = array_merge($this->makeServices($request, $passengers, $tikets, $order, $segment, 2, $key), $services);

                $this->fireBooking($request->flight, $checkPayment, $order, $passengers);
            }
                foreach ($services as $service){

                        $ids[] = $service->flight_id;
                }


                $flights  = Flight::whereIn('id', $ids)->with([
                                'flightplaces',
                                'flightplaces.schedule',
                                'flightplaces.farefamily',
                                'flightplaces.currency',
                                'flightplaces.schedule.arrival',
                                'flightplaces.schedule.airline',
                                'flightplaces.schedule.departure',
                                'flightplaces.schedule.arrival.city',
                                'flightplaces.schedule.departure.city',
                           ])->get();

            $data = [

                'order' => $order,
                'service' =>$services,
                'passengers' =>$passengers,
                'flights' =>$flights,
                'company' => Auth::user()->admincompany()->with(['currency'])->first()->toArray()

            ];

            $mail_list = Mailing::where([[ 'company_registry_id', '=', Auth::user()->company_id], [ "type_mailing", '=', "2"], ['status', '=', true]])->get();


            foreach($mail_list as $mails){

                $mail_list_id = $mails->id;


                $mailing_emails = MailingList::where( 'mailing_id', '=', $mail_list_id )->get();


                foreach($mailing_emails as $mailing){


                    $mailing_email = $mailing->mail;

                    \Mail::send('emails.booking_add', $data, function($message) use ($mailing_email)
                    {
                        $message->from(env('MAIL_FROM'));
                        $message->to($mailing_email,$mailing_email);
                        $message->subject('Новое бронирование');
                    });

                }

            }



      return response()->json(['order' => $order, 'tikets' => $tikets, 'services' => $services, 'flights' => $flights], $this->successStatus)->header('Access-Control-Allow-Origin', '*');

        }else{
            return response()->json(['Error' => 'Check Payment Error', 'data' => $checkPayment], $this->errorStatus)->header('Access-Control-Allow-Origin', '*');   
        }
    }







    private function checkPayment($request, $passengersAr){
        $finalsumm = 0;

        $userCurrency = Auth::user()->admincompany()->first()->currency()->first();
        foreach ($request->flight as $key => $segment) {
            # code...
     
        $type_flight = $request->type_flight;
        $date = $request->date;
        $from = $request->from_id;
        $to = $request->to_id;
        $fare = $request->fare_id;
        $passangers = $request->passangers_count;

        $payment = $request->payment;
        
           
        

        $flightplace = Flight::where('id','=',  $segment['flight_id'] )->first()->flightplaces()->with('currency')->first()->toArray();

        $acompany = AdminCompany::where('id', '=', Auth::user()->company_id)->with('account')->first()->toArray();

        $cityfrom = Aeroport::find($from)->city()->first()->toArray();
        $cityto = Aeroport::find($to)->city()->first()->toArray();
    
        $params = [
                    ['type_flight', $type_flight],
                    ['fare_families_id', $fare],

                    ['departure_city', $cityfrom['id']],
                    ['arrival_city', $cityto['id']],
                ];
        if($type_flight == 1){
            /*
                ow & ow_infant
            */
                unset($summ);
                unset($summ2);
                unset($summi2);
                unset($summi);
            $summ = CurrencyManager::convert($flightplace['ow'], $flightplace['currency']['code_literal_iso_4217'], $userCurrency->code_literal_iso_4217 );
            $summ2 = FeesApply::applyFee($summ, $params);

            $summi = CurrencyManager::convert($flightplace['infant_ow'], $flightplace['currency']['code_literal_iso_4217'], $userCurrency->code_literal_iso_4217 );

            $summi2 = FeesApply::applyFee($summi, $params);
        }
        elseif($type_flight == 2){
            /*rt & rt_infant*/
            $summ = CurrencyManager::convert($flightplace['rt'], $flightplace['currency']['code_literal_iso_4217'], $userCurrency->code_literal_iso_4217 ) ;
            $summ2 = FeesApply::applyFee($summ, $params);


            $summi = CurrencyManager::convert($flightplace['infant_rt'], $flightplace['currency']['code_literal_iso_4217'], $userCurrency->code_literal_iso_4217 ) ;
            $summi2 = FeesApply::applyFee($summi, $params);
        }
        
        foreach ($passengersAr as $key => $value) {
            
            if($value['type_passengers'] == 1){
                $finalsumm += $summ2['summ'] + $summ2['fee'];

                $passengersAr[$key]['summ'][$segment['flight_id']] = $summ2;

            }
            elseif ($value['type_passengers'] == 2) {
                $finalsumm += $summ2['summ'] + $summ2['fee'];
                $passengersAr[$key]['summ'][$segment['flight_id']] = $summ2;
            }
            elseif ($value['type_passengers'] == 3) {
                $finalsumm += $summi2['summ'] + $summi2['fee'];
                $passengersAr[$key]['summ'][$segment['flight_id']] = $summi2;
            }else{return false;}
        }
   }
   $balance = ($acompany['limit'] == true)?$acompany['residue_limit'] + $acompany['account']['balance']: $acompany['account']['balance'];
        if($payment['type_payment'] == 'bill'){
            return ['status' => true, 'summ' => $finalsumm, 'passengers' => $passengersAr, 'type' => 'bill'];
        }
        elseif ($payment['type_payment'] == 'invoice') {
            if($balance >= $finalsumm){
                return ['status' => true, 'summ' => $finalsumm, 'passengers' => $passengersAr, 'type' => 'invoice'];
            }else{
                return ['status' => false, 'summ' => $finalsumm, 'passengers' => $passengersAr, 'type' => 'invoice'];
            }

        }else{
            return ['status' => false, 'type' => 'undefined'];
        }
       
        
    }

    private function fireBooking($flight, $pay, $order, $passengers){
       
        if($pay['type'] == 'invoice'){
            $ac = AdminCompany::where('id', '=', Auth::user()->company_id)->first()->account()->first();
            $ac->balance -= $pay['summ'];
            $ac->save();
        }elseif ($pay['type'] == 'bill') {
            # генерация PDF квитанции
        }else{
            return false;
        }
        //dd($pay);
        $order->order_summary = $pay['summ'];
        $order->save();
        foreach ($flight as $key => $value) {
            $f = Flight::where('id' , '=' , $value['flight_id'])->first();
            $f->count_places_reservation +=count($passengers);
            $f->save();
        }
       


    }


    private function checkPlaces($flight){
        $f = Flight::where('id' , '=' , $flight)->first();
        if($f->count_places_reservation < $f->count_places){
            return true;
        }
        else{ 
            return false;
        }
    }
    private function parseTikets($tikets, $need){
        foreach ($tikets as $key => $value) {
            if($value->passengers_id == $need){return $value;}
        }
    }
    private function makeServices($request, $passengers, $tikets, $order, $segment, $provider = 1, $segmentkey = 0){
      
                      
        $f = Flight::where('id' , '=' , $segment['flight_id'])->with(['flightplaces', 'flightplaces.schedule'])->first();

        $services = [];
        foreach ($passengers as $key => $value) {
            $s = new Service;
            $s->order_id = $order->id;
            $s->service_id =  301000 + $value['id'];
            $akl = array_key_last($f->flightplaces->schedule->toArray());
            $departure_at = $f->flightplaces->schedule[0]->departure_at;
            $arrival_at = $f->flightplaces->schedule[$akl]->arrival_at;

            $s->departure_at  = $departure_at;
            $s->arrival_at = $arrival_at;
            $s->departure_date = $f->date_departure_at;
            $s->provider_id = $provider;
            //arrival_date
            $s->type_flight = $request->type_flight;
            $s->segment_number = $segmentkey;
            $s->service_status = 6;
            $s->user_id = Auth::user()->id;
            $s->summary_summ = $this->parseTikets($tikets, $value['id'])->summ_ticket;
            $s->passenger_id = $value['id'];
            $s->fare_families_id = $request->fare_id;
            $s->updated_id = Auth::user()->id;
            $s->created_id = Auth::user()->id;
            $s->tickets_id = $this->parseTikets($tikets, $value['id'])->id;
            $s->booking_date = Carbon::now();
            $s->flight_id = $segment['flight_id'];
            //$s->save();
           // $s->service_id = '301000'.$s->id;
            $s->save();
            $services[] = $s;
            unset($s);
            

        }
        
        return $services;
    }

    private function makeOrder($request, $passengers, $tikets, $fee){
        $summary = 0;
        foreach ($tikets as $key => $value) {
            $summary + $value->summ_ticket;
        }

        $company = Auth::user()->company()->first();
        $o = new Order;
        $o->order_n = 0;
        $o->status = 1;
        $o->time_limit = 7200;
        $o->type_order = 1;
        $o->company_registry_id = $company->id;
        $o->user_id = Auth::user()->id;
        $o->order_summary = $summary;
        $o->order_currency = Auth::user()->admincompany()->first()->currency()->first()->id;
        $o->passengers = count($passengers);
        $o->services = 0;
        $payment = $request->payment;
        //dd($fee);
          if($payment['type_payment'] == 'bill'){ $typepay = 1;}
        elseif ($payment['type_payment'] == 'invoice') { $typepay = 0;}
       // $o->types_fees_fare = 
        $o->type_payment = $typepay;
        $o->comment = "";
        $o->updated_id = Auth::user()->id;
        $o->created_id = Auth::user()->id;
        $o->email = $request->contact_email;
        $o->phone = $request->contact_phone;
        //$o->conversation_id = 0;
        $o->save();
        $o->order_n = 10000 + $o->id;
        $o->save();
        return $o;
    }
    private function appendToOrder($request, $passengers, $tikets, $fee, Order $order){
        $summary = 0;
        foreach ($tikets as $key => $value) {
            $summary + $value->summ_ticket;
        }

        $company = Auth::user()->company()->first();
        $o = $order;
        $o->order_n = 0;
        $o->status = 1;
        $o->time_limit = 7200;
        $o->type_order = 1;
        $o->company_registry_id = $company->id;
        $o->user_id = Auth::user()->id;
        $o->order_summary = $summary;
        $o->order_currency = Auth::user()->admincompany()->first()->currency()->first()->id;
        $o->passengers = count($passengers);
        $o->services = 0;
        $payment = $request->payment;
        //dd($fee);
          if($payment['type_payment'] == 'bill'){ $typepay = 1;}
        elseif ($payment['type_payment'] == 'invoice') { $typepay = 0;}
       // $o->types_fees_fare = 
        $o->type_payment = $typepay;
        $o->comment = "";
        $o->updated_id = Auth::user()->id;
        $o->created_id = Auth::user()->id;
        $o->email = $request->contact_email;
        $o->phone = $request->contact_phone;
        //$o->conversation_id = 0;
        $o->save();
        $o->order_n = 10000 + $o->id;
        $o->save();
        return $o;
    }
    private function makePassengers($passengersAr){
     
    	$passengers = [];
    	foreach ($passengersAr as $key => $value) {
    		$passenger = new Passenger;
		    $passenger->name = $value['name'];
		    $passenger->surname = $value['surname'];
		    $passenger->country_id = $value['country_id'];
		    $passenger->sex_u = $value['sex_u'];
		    $passenger->type_documents = $value['type_documents'];
		    $passenger->type_passengers = $value['type_passengers'];
		    $passenger->passport_number = $value['passport_number'];
		    $passenger->date_birth_at = $value['date_birth_at'];
		    $passenger->expired = $value['expired'];
		    $passenger->save();
            $passenger = $passenger->toArray();
            $passenger['summ'] = $value['summ'];
		    $passengers[$passenger['id']] = $passenger;
		    unset($passenger);
    	}
       
    	return $passengers;
    }

    private function makeTikets($request, $passengers, $feesfare, $flightplace){
        $tickets = [];

       


        $userCurrency = Auth::user()->admincompany()->first()->currency()->first();

        foreach ($passengers as $key => $passenger) {
            if(($request->type_flight == '1' || $request->type_flight == 'ow')){
                $type_flight = 'ow';

            }elseif($request->type_flight == '2' || $request->type_flight == 'rt'){
                $type_flight = 'rt';
            }
            if($request->fare_id == 1){
                 $commission_fare = 'commission_business';
            }elseif($request->fare_id == 2){
                $commission_fare =  'commission_economy';
            }

           switch ($passenger['type_passengers']) {
                case '1':
                   $ratefare = CurrencyManager::convert($flightplace->$type_flight, $flightplace->currency->code_literal_iso_4217, $userCurrency->code_literal_iso_4217 );
                   break;
                case '2':
                   $ratefare = CurrencyManager::convert($flightplace->$type_flight, $flightplace->currency->code_literal_iso_4217, $userCurrency->code_literal_iso_4217 );
                   break;
                case '3':
                $type_flight = 'infant_'.$type_flight;
                $ratefare = CurrencyManager::convert($flightplace->$type_flight, $flightplace->currency->code_literal_iso_4217, $userCurrency->code_literal_iso_4217 );
                   
                   break;
               
               default:
                   $ratefare = $flightplace->ow;
                   break;
           }
           $company = Auth::user()->admincompany()->first();
            $ratefare = 0;
            $fee = 0;
        foreach ($passenger['summ'] as $p => $ps) {
           $ratefare += $ps['summ'];
           $fee += $ps['fee'];
        }
           $t = new Ticket;
           $t->ticket_number = 1000;
           $t->rate_fare =  $ratefare;
           $t->created_id = Auth::user()->id;
           $t->updated_id = Auth::user()->id;
           $t->summ_ticket = $ratefare + $fee; 
           $t->types_fees_fare =  $fee; 
           $t->passengers_id = $passenger['id'];
           $commission_summ = ( $ratefare + $fee)/100*$company->$commission_fare;
           $t->commission_fare = round($commission_summ, 2);
           $t->save();
           $t->ticket_number += $t->id;
           $t->save();
           $tickets[] = $t;
           unset($t);
        }
        return $tickets;
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


    public function writeout(Request $request)
    {
       
        $timenow = Carbon::now();
        $services = Service::where('service_id' , '=', $request->id)->with(['order', 'flight', 'passenger', 'flight.flightplaces', 'flight.flightplaces.schedule', 'flight.flightplaces.schedule.arrival', 'flight.flightplaces.schedule.arrival.city', 'flight.flightplaces.schedule.departure', 'flight.flightplaces.schedule.departure.city', 'ticket', 'fare'])->get();
        foreach ($services as $key => $service) {
            $service->service_status = 5;
            $service->save();
            $ticket = Ticket::where('id', '=', $service->tickets_id)->first();
            $ticket->writeout_date = $timenow;
            $ticket->save();
            if(empty($data['order']) || !isset($data['order'])){

                $data['order'] = $service->order()->first();

            }         
        }

        $services = $services->toArray();
            $data['writeout_date'] = $timenow->format('Y-m-d H:i:s');
            $data['company'] = Auth::user()->admincompany()->with(['ads'])->first()->toArray(); 
            $data['services'] = $services;
            //print_r($data['writeout_date']);
            $pdf = PDF::loadView('orders.eticket', $data);
            $filename = time().Auth::user()->id.'.pdf';
            $path = storage_path('app/public/tickets/').$filename;
            $pdf->save($path);
            $return = '/storage/tickets/'.$filename;
       
//$pdf->save(storage_path().'account.pdf');

        return $return;
    }  
}
