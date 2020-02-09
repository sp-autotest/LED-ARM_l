<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Flight;
use App\FlightPlace;
use App\Country;
use App\Aeroport;
use App\Schedule;
use App\City;
use App\Currency;
use Auth;
use App\Http\Requests\SearchFlightBlockRequest;
use App\Classes\FeesApply;
use App\Classes\CurrencyManager;

class SearchFligtsController extends Controller
{

    public $successStatus = 200;
    public $errorStatus = 400;

    public function search(Request $request){
        
        $this->middleware(['role_or_permission:search-avia.index']);

        $segments = [];
      foreach($request->all() as $k=>$v){

        if($v['type_flight'] == 3){ return response()->json(['segments' => [], 'fee' => []], $this->successStatus); }
        $charstype_flight = 'any';
        $type_flight = $v['type_flight'];
        $date = $v['date'];
        $from = $v['from_id'];
        $to = $v['to_id'];
        $fare = $v['fare_id'];
        $adult = $v['adult'];
        $child = $v['child'];
        $infant = $v['infant'];
        $passangers = $adult+$child+$infant;
        
        if($v['type_flight'] == 2){$charstype_flight = 'rt';}
        if($v['type_flight'] == 1){$charstype_flight = 'ow';}
        /*$date = '2019-05-23';
        $type_flight = '1';
        $from = '1';
        $to = '6';
        $fare = "2";
        $passangers = "3";*/

        $flightAr = Flight::with(['flightplaces', 'flightplaces.schedule','flightplaces.schedule.airline', 'flightplaces.farefamily'])
                ->where([
                    ['date_departure_at', '=', $date],
                    ['count_places', '>=', DB::raw("(count_places_reservation + $passangers)")]
                ])
                ->whereHas('flightplaces.farefamily', function($q) use ($fare, $from, $to) {
                    $q->where("fare_families_group","=", $fare);
                })
                ->whereHas('flightplaces.schedule', function($subquery) use ($from, $to){
                    $subquery->where([["departure_at","=", $from ],["arrival_at","=",$to]])
                            ->orWhereIn('flights', function($q) use ($from, $to)
                            {
                                
                                $flfrom = DB::table(with(new Schedule)->getTable())->select('flights')
                                  ->where([
                                        ["departure_at","=", $from],
                                        ['is_transplantation', '=', true],
                                        ]);
                                $q->select('flights')
                                      ->from(with(new Schedule)->getTable())
                                      ->where([
                                        ["arrival_at","=",$to],
                                        ['is_transplantation', '=', true],
                                        ])
                                      ->whereIn('flights', $flfrom)->limit(10)->get()->toArray()
                                      ;
                                     
                        });
                })
                ->get()->toArray();
                if(count($flightAr) < 1){ return response()->json(['error' => 400, 'message' => 'Flights not found'], $this->errorStatus); }
             foreach ($flightAr as $key => $value) {
                //
                $userCompany = Auth::user()->admincompany()->first();
                
                
                $fp_currency = $value['flightplaces']['currency_id'];

                $cityfrom = Aeroport::where('id' , '=' , $from)->first()->city()->first()->toArray();
                $cityto = Aeroport::where('id' , '=' , $to)->first()->city()->first()->toArray();
    
                

                $currencyFrom = Currency::where('id', '=', $fp_currency)->first();
                $currencyTo = $userCompany->currency()->first();
                
                
                $summ = floatval($flightAr[$key]['rt'])*($adult+$child);
                $summ = CurrencyManager::convert($summ,$currencyFrom->code_literal_iso_4217,$currencyTo->code_literal_iso_4217);
                //$summ2 = FeesApply::applyFee($summ, $params);

                $summow = floatval($flightAr[$key]['ow'])*($adult+$child);
                $summow = CurrencyManager::convert($summow,$currencyFrom->code_literal_iso_4217,$currencyTo->code_literal_iso_4217);

                //$summow2 = FeesApply::applyFee($summow, $params);


                $summi = floatval(($flightAr[$key]['infant_rt']))*$infant;
                $summi = CurrencyManager::convert($summi,$currencyFrom->code_literal_iso_4217,$currencyTo->code_literal_iso_4217);
                //$summi2 = FeesApply::applyFee($summi, $params);

                $summowi = floatval($flightAr[$key]['infant_ow'])*$infant;
                $summowi = CurrencyManager::convert($summowi,$currencyFrom->code_literal_iso_4217,$currencyTo->code_literal_iso_4217);
                //$summiow2 = FeesApply::applyFee($summowi, $params);

                $flightAr[$key]['rt'] = $summ;
                $flightAr[$key]['infant_rt'] = $summi;

                
                $flightAr[$key]['ow'] = $summow;
                $flightAr[$key]['infant_ow'] = $summowi;
               
             }
$segments[] = $flightAr;
}
    
    $return = [];
    $params = [
        ['type_flight', $type_flight],
        ['fare_families_id', $fare],

        ['departure_city', $cityfrom['id']],
        ['arrival_city', $cityto['id']],
    ];
    $return = $this->cartesian($segments);

        return response()->json(['segments' => $return, 'fee' => FeesApply::getFee($params)], $this->successStatus); 
     
    }


    function cartesian(&$input) {
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
    
}